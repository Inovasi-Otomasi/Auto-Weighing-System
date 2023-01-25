<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SetupController extends Controller
{
    //
    public function index()
    {
        $data = [
            'title' => 'Setup',
            'breadcrumb' => 'List'
        ];
        return view('setup.index', $data);
    }
    public function sku()
    {
        $data = [
            'title' => 'SKU',
            'breadcrumb' => 'List'
        ];
        return view('setup.sku', $data);
    }
}
