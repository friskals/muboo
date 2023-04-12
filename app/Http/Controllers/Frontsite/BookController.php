<?php

namespace App\Http\Controllers\Frontsite;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(){

        return view('frontsite.index',[
            'isMenu' => true,
            'isNavbar' => false
        ]);
    }
}
