<?php

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\admin\CategoryController;
use Illuminate\Support\Facades\Route;

Route::resources([
    'categories' => CategoryController::class,
    'authors'=> AuthorController::class,
    'books'=> BookController ::class
]); 