<?php

namespace TheFramework\App;

abstract class Model
{
    protected $table;
    protected $primaryKey = 'id';
    protected $db;
    protected $builder;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->builder = new QueryBuilder($this->db);

        if (empty($this->table)) {
            // Jika nama table belum diisi, otomatis ambil dari nama class
            $class = (new \ReflectionClass($this))->getShortName();
            $this->table = strtolower(preg_replace('/Model$/', '', $class));
        }
    }

    /**
     * Akses QueryBuilder langsung
     */
    public function query(): QueryBuilder
    {
        return (new QueryBuilder(Database::getInstance()))->table($this->table);
    }


    /**
     * Ambil semua data
     */
    public function all()
    {
        return $this->query()->get();
    }

    /**
     * Cari berdasarkan primary key
     */
    public function find($id)
    {
        return $this->query()
            ->where($this->primaryKey, '=', $id)
            ->get()[0] ?? null;
    }

    /**
     * Where sederhana (key-value)
     */
    public function where($column, $value)
    {
        return $this->query()
            ->where($column, '=', $value)
            ->get();
    }

    /**
     * Insert data baru
     */
    public function insert(array $data)
    {
        return $this->query()->insert($data);
    }

    /**
     * Update data berdasarkan primary key
     */
    public function update(array $data, $id)
    {
        return $this->query()
            ->where($this->primaryKey, '=', $id)
            ->update($data);
    }

    /**
     * Hapus data berdasarkan primary key
     */
    public function delete($id)
    {
        return $this->query()
            ->where($this->primaryKey, '=', $id)
            ->delete();
    }

    /**
     * Shortcut pagination dari model
     */
    public function paginate(int $perPage = 10, int $page = 1)
    {
        return $this->query()->paginate($perPage, $page);
    }
}
