<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\TaskServiceInterface;

class HomeController extends Controller
{
    public function index() {
        return view('home');
    }
}
