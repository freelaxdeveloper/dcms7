<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Redirect;

class HomeController
{
    public function index(Request $request, string $name)
    {
        Redirect::location('/testw', ['eeeeeeee']);
//        dd(['HomeController', Redirect::toRoute('test', ['ololo'])]);
//        dd(['HomeController', $request->user()]);
//        dd(['HomeController', $request->route()]);

        $doc = new \document();

        $listing = new \listing;

        $post = $listing->post();
        $post->title = __('Посмотреть анкету');
        $post->icon('ank_view');

        $listing->display();

        $doc->ret(__('Вернуться'), './');


//        return view('test');
    }
}