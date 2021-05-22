<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index()
    {
        $business = Business::first();
        return $business == null ? view('business.create') : view('business.edit', compact('business'));
    }
}
