<?php

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\admin\CategoryController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'web'], function () {
    Route::group(['middleware' => 'admin'], function(){
        Route::post('books/filter-book', [BookController::class, 'filter'])->name('books.filter');
        Route::put('books/update-status', [BookController::class, 'updateStatus'])->name('books.update.status');
        Route::resources([
            'categories' => CategoryController::class,
            'authors' => AuthorController::class,
            'books' => BookController::class
        ]); 
    });
}); 