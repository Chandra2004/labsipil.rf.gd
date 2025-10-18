<?php

namespace TheFramework\App;

class QueryBuilder
{
    private $db;
    private $table;
    private $columns = "*";
    private $wherePairs = [];

    private $limit;
    private $offset;

    private $wheres = [];
    private $searches = [];
    private $joins = [];
    private $groupBy = [];
    private $orderBy = [];
    private $bindings = [];
    private $withRelations = [];

    /** @var Model */
    private $model;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    public function table(string $table)
    {
        $this->table = $table;
        return $this;
    }

    public function select($columns = "*")
    {
        $this->columns = is_array($columns) ? implode(", ", $columns) : $columns;
        return $this;
    }

    /* -------------------------------
    WHERE
    --------------------------------*/
    public function where(string $column, string $operator, $value)
    {
        $param = ":where_" . count($this->bindings);

        $this->wheres[] = (strpos($column, '.') !== false)
            ? "$column $operator $param"
            : "`$column` $operator $param";

        $this->bindings[$param] = $value;

        if ($operator === '=' && strpos($column, '.') === false) {
            $this->wherePairs[$column] = $value;
        }

        return $this;
    }

    public function filter(string $column, $value)
    {
        return $this->where($column, '=', $value);
    }

    /* -------------------------------
    SEARCH
    --------------------------------*/
    public function search(array $columns, string $keyword)
    {
        if (!$keyword) return $this;

        $likeClauses = [];
        foreach ($columns as $i => $col) {
            $param = ":search_" . (count($this->bindings) + $i);
            $likeClauses[] = "`$col` LIKE $param";
            $this->bindings[$param] = "%$keyword%";
        }

        $this->searches[] = "(" . implode(" OR ", $likeClauses) . ")";
        return $this;
    }

    /* -------------------------------
    JOIN
    --------------------------------*/
    public function join(string $table, string $first, string $operator, string $second, string $type = 'INNER')
    {
        $type = strtoupper($type);
        if (!in_array($type, ['INNER', 'LEFT', 'RIGHT'])) $type = 'INNER';
        $this->joins[] = "$type JOIN $table ON $first $operator $second";
        return $this;
    }

    /* -------------------------------
    GROUP BY / ORDER BY
    --------------------------------*/
    public function groupBy($columns)
    {
        $this->groupBy = is_array($columns) ? $columns : [$columns];
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC')
    {
        $dir = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $this->orderBy[] = "$column $dir";
        return $this;
    }

    public function orderByRaw(string $expression)
{
    $this->orderBy[] = $expression;
    return $this;
}


    /* -------------------------------
    SQL Builder
    --------------------------------*/
    public function toSql(): string
    {
        $sql = "SELECT {$this->columns} FROM {$this->table}";

        if (!empty($this->joins)) {
            $sql .= " " . implode(" ", $this->joins);
        }

        $conditions = [];

        if (!empty($this->wheres)) {
            $conditions[] = implode(" AND ", $this->wheres);
        }

        if (!empty($this->searches)) {
            $conditions[] = implode(" AND ", $this->searches);
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        if (!empty($this->groupBy)) {
            $sql .= " GROUP BY " . implode(", ", $this->groupBy);
        }

        if (!empty($this->orderBy)) {
            $sql .= " ORDER BY " . implode(", ", $this->orderBy);
        }

        if (!is_null($this->limit)) {
            $sql .= " LIMIT {$this->limit}";
            if (!is_null($this->offset) && $this->offset > 0) {
                $sql .= " OFFSET {$this->offset}";
            }
        }

        return $sql;
    }

    /* -------------------------------
    EXECUTION
    --------------------------------*/
    public function get()
    {
        $sql = $this->toSql();
        $this->db->query($sql);

        foreach ($this->bindings as $param => $value) {
            $this->db->bind($param, $value);
        }

        $results = $this->db->resultSet();

        if ($this->model) {
            return $this->model->loadRelations($results, $this->withRelations);
        }

        return $results;
    }

    public function first()
    {
        $results = $this->limit(1)->get();
        return $results[0] ?? null;
    }

    public function insert(array $data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update(array $data)
    {
        if (empty($this->wherePairs)) {
            throw new \InvalidArgumentException("Update tanpa WHERE dilarang");
        }
        return $this->db->update($this->table, $data, $this->wherePairs);
    }

    public function delete()
    {
        if (empty($this->wherePairs)) {
            throw new \InvalidArgumentException("Delete tanpa WHERE dilarang");
        }
        return $this->db->delete($this->table, $this->wherePairs);
    }

    /* -------------------------------
    PAGINATION
    --------------------------------*/
    public function paginate(int $perPage = 10, int $page = 1): array
    {
        $offset = ($page - 1) * $perPage;

        $sql = $this->toSql() . " LIMIT :limit OFFSET :offset";
        $this->db->query($sql);

        foreach ($this->bindings as $param => $value) {
            $this->db->bind($param, $value);
        }

        $this->db->bind(':limit', $perPage);
        $this->db->bind(':offset', $offset);

        $data = $this->db->resultSet();

        $countSql = "SELECT COUNT(*) as total FROM ({$this->toSql()}) as sub";
        $this->db->query($countSql);
        foreach ($this->bindings as $param => $value) {
            $this->db->bind($param, $value);
        }
        $total = $this->db->single()['total'];

        // eager load juga
        if ($this->model) {
            $data = $this->model->loadRelations($data, $this->withRelations);
        }

        return [
            'data' => $data,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => (int) ceil($total / $perPage),
        ];
    }

    public function count(): int
    {
        $sql = "SELECT COUNT(*) as total FROM ({$this->toSql()}) as sub";
        $this->db->query($sql);

        foreach ($this->bindings as $param => $value) {
            $this->db->bind($param, $value);
        }

        $result = $this->db->single();
        return (int) ($result['total'] ?? 0);
    }

    /* -------------------------------
    EXTRA HELPERS
    --------------------------------*/
    public function whereRaw(string $condition, array $bindings = [])
    {
        foreach ($bindings as $i => $value) {
            $key = ':raw' . count($this->bindings);
            $condition = preg_replace('/\?/', $key, $condition, 1);
            $this->bindings[$key] = $value;
        }

        $this->wheres[] = $condition;
        return $this;
    }

    public function orWhere(string $column, string $operator, $value)
    {
        $param = ":where_" . count($this->bindings);
        $condition = (strpos($column, '.') !== false)
            ? "$column $operator $param"
            : "`$column` $operator $param";

        $this->bindings[$param] = $value;

        if (!empty($this->wheres)) {
            $last = array_pop($this->wheres);
            $this->wheres[] = "($last OR $condition)";
        } else {
            $this->wheres[] = $condition;
        }

        return $this;
    }

    public function limit(int $limit, int $offset = 0)
    {
        $this->limit = $limit;
        $this->offset = $offset;
        return $this;
    }

    /* -------------------------------
    EAGER LOADING
    --------------------------------*/
    public function with(array $relations)
    {
        $this->withRelations = $relations;

        if ($this->model) {
            $this->model->with($relations);
        }

        return $this;
    }

    public function all()
    {
        return $this->get();
    }

    public function map(callable $callback): array
{
    $results = $this->get();
    return array_map($callback, $results);
}
}
