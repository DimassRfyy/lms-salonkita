<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolicyController extends Controller
{
    /**
     * Display Terms and Conditions page.
     */
    public function terms()
    {
        return view('pages.policies.terms');
    }

    /**
     * Display Privacy Policy page.
     */
    public function privacy()
    {
        return view('pages.policies.privacy');
    }

    /**
     * Display Refund and Cancellation Policy page.
     */
    public function refund()
    {
        return view('pages.policies.refund');
    }
}
