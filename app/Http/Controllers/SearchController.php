<?php

namespace App\Http\Controllers;

use Auth;
use View;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // обязательно наличие авторизации
        $this->middleware('auth');
    }

    /**
     * Осуществляет поиск репов на github и выводит результат
     *
     * @param \Illuminate\Http\Request запрос
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        dd(Auth::user()->token);

        $query = trim($request->get('q'));
        $page = $request->get('page') ? $request->get('page') : 1;
        $per_page = 25;
        $page_link = '/search?q=' . urlencode($query);

        if (!is_null($query) && strlen($query)>0) {
            // инициализируем curl
            $ch = curl_init("https://api.github.com/search/repositories?q=" . urlencode($query)
                . '&page=' . $page . '&per_page=' . $per_page);
            // настройка User-Agent
            curl_setopt($ch, CURLOPT_USERAGENT,
                'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
            // возвращаем результат в переменную, а не в браузер
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // переаем в заголовке информацию об авторизации пользователя
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authentication: token ' . Auth::user()->token));
            // результат вызова поместим в $output
            if ($output = curl_exec($ch)) {
                // если запрос прошел успешно и без ошибок
                // преобразуем результат из JSON в объект
                $outobj = json_decode($output);
                // если это объект
                if (is_object($outobj)) {
                    // если у объекта есть свойства total_count и items
                    if (property_exists($outobj, 'total_count') &&
                        property_exists($outobj, 'items')) {
                        // выдерним свойства в отдельные переменные, чтобы передать в шаблон
                        // всего найдено
                        $git_total_count = $outobj->total_count;
                        // массив найденных репов
                        $git_items = $outobj->items;
                        // всего страниц
                        $git_total_pages = ceil($git_total_count/$per_page);
                    }
                }
            }
            // закрываем curl и освобождаем ресурсы
            curl_close($ch);
        }

        return view('search', compact('git_total_count', 'git_items', 'page',
            'git_total_pages', 'page_link'));
    }
}
