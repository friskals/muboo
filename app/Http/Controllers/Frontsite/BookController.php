<?php

namespace App\Http\Controllers\Frontsite;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Content;
use App\Models\User;

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

    public function show($id)
    {
        $book = Book::findOrFail($id);

        $reviews = Content::where([
            'book_id' => $book->id,
            'type' => 'REVIEW'
        ])->latest()->limit(5)->get();

        $userIds = $reviews->pluck('user_id');

        $users = User::select('id','name')->whereIn('id', $userIds)->get();

        foreach ($reviews as $review) {
            $user = $users->firstWhere('id', $review->user_id);

            if($user){
                $review->reviewer = $user->name;
            }
        }
        return response()->json([
            'success' => true,
            'book' => $book,
            'reviews' => $reviews
        ]);
    }
}
