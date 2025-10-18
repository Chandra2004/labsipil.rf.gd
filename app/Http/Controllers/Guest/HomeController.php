<?php

namespace TheFramework\Http\Controllers\Guest;

use Exception;
use TheFramework\App\View;
use TheFramework\Helpers\Helper;
use TheFramework\Http\Controllers\Controller;
use TheFramework\Models\Core\NewsModel;

class HomeController extends Controller
{
    private $newsModel;

    public function __construct()
    {
        $this->newsModel = new NewsModel();
    }

    public function Welcome()
    {
        $notification = Helper::get_flash('notification');
        $news = $this->newsModel->query()->orderBy('created_at', 'DESC')->limit(6)->get();
        return View::render('Guest.pages.welcome', [
            'notification' => $notification,
            'title' => 'Welcome | Lab Praktikum Teknik Sipil',
            'news' => $news
        ]);
    }

    public function News($page = 1)
    {
        $notification = Helper::get_flash('notification');
        $news = $this
            ->newsModel
            ->query()
            ->paginate(12, $page);

        if ($page > $news['last_page']) {
            return Helper::redirectToNotFound();
        }

        return View::render('Guest.pages.news', [
            'notification' => $notification,
            'title' => 'News | Lab Praktikum Teknik Sipil',
            'news' => $news
        ]);
    }

    public function DetailNews($slug, $uid)
    {
        $notification = Helper::get_flash('notification');
        $item = $this->newsModel
            ->query()
            ->select([
                'news.*',
                'users.full_name AS author_name'
            ])
            ->table('news')
            ->join('users', 'news.author', '=', 'users.uid')
            ->where('news.slug', '=', $slug)
            ->orWhere('news.uid', '=', $uid)
            ->first();

        return View::render('Guest.pages.detail-news', [
            'notification' => $notification,
            'title' => $item['title'] . ' | Lab Praktikum Teknik Sipil',
            'item' => $item
        ]);
    }
}
