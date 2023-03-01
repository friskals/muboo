<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralPageController extends Controller
{
    public function returnPage401()
    {
        return "You are unauhtorized";
    }
}
