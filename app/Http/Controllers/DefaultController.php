<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DefaultController extends Controller
{
    public function index()
    {


        return Inertia::render('Categories/Index', [
        ]); // 'null' by default if not set
    }

}
