<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AppController extends Controller
{

    /**
     * Loads application index view
     *
     * @return View
     */
    public function index(): View
    {
        return view('app');
    }
}
