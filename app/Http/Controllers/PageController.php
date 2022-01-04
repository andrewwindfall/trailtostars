<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Page;
use App\Models\StargazingSite;

use Auth;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function home()
    {
       $sites = StargazingSite::all();
       return view('welcome', compact('sites'));
    }

    public function page($slug, Request $request)
    {
      $slug = strtolower($slug);
      $page = Page::where('slug',$slug)->first();

      if($page == null)
      {
        $rand = Page::inRandomOrder()->get()->take(6);
        return view('errors.404')->with('pages', $rand);
      }

      $view = view('templates.page')->with('page', $page);

      return $view;
    }




}
