<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaxSummaryController extends Controller
{
    public function index()
    {
        return view('tax_summary');
    }
}
