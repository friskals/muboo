<?php

use App\Http\Controllers\admin\CategoryController;
use Illuminate\Support\Facades\Route;

Route::resources([
    'categories' => CategoryController::class
]);