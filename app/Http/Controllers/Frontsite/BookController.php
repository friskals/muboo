<?php

namespace App\Http\Controllers\Frontsite;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Http\Request;

class BookController extends Controller
{
    const NUMBER_OF_ITEM_PER_PAGE = 5;

    public function index(){
        $books = Book::published()->paginate(self::NUMBER_OF_ITEM_PER_PAGE);

        return view('frontsite.index',[
            'isMenu' => true,
            'isNavbar' => false,
            'books' => $books
        ]);
    }
}
