<?php

namespace App\Http\Controllers;

use App\Models\CustomPage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FrontendController extends Controller
{

    /**
     * Loads application index view
     *
     * @return View
     */
    public function index(): View
    {
        return view('frontend.index');
    }

    public function booking(): View
    {
        return view('frontend.pages.booking');
    }

    public function bookingW2(): View
    {
        return view('frontend.pages.booking-w2');
    }

    /**
     * Repair tracking
     *
     * @return     View  ( description_of_the_return_value )
     */
    public function track(): View
    {
        return view('frontend.pages.track');
    }

    public function pageReadBySlug(Request $request)
    {
        $page = CustomPage::where('slug', $request->read)->where('status', true)->first();
        if (!$page) {
            return redirect('/');
        }
        return view('frontend.pages.custom-page', compact('page'));
    }
}
