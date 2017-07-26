<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SyncController extends Controller
{
    public function index(Request $request)
    {
    	$request->session()->flash('warning', 'Sincronización en proceso de desarrollo');
    	return redirect()->back();
    }
}
