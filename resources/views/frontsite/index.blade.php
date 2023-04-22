@extends('frontsite/navbarLayout')

@section('title', 'Cards basic - UI elements')

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="{{ asset('assets/js/frontsite/homepage.js') }}"></script>
@endsection


@section('content')
    <h4 class="fw-bold py-3 mb-4">What's new?</h4>
    @foreach ($books as $book)
        <div class="row mb-3">
            <div class="col-sm-3"></div>
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <img class="card-img-top" src="{{ asset('assets/img/elements/2.jpg') }}" alt="Card image cap" />
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <a href="" class="card-text" data-toggle="modal" data-target="#bookReviews"
                            data-book-id="{{ $book->id }}" style="color: #000000;text-decoration: none;">
                            {{ $book->excerpts }}
                        </a>
                        <a href="" class="card-text" data-toggle="modal" data-target="#recommendedSong"
                            data-book-id="{{ $book->id }}">
                            Song
                        </a>
                    </div>

                    <!--Start Book Review -->
                    <div class="modal fade" id="bookReviews" tabindex="-1" role="dialog"
                        aria-labelledby="bookReviewsLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="bookReviewsLabel">Best song for this</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row-mb-3">
                                        <p class="excerpts"></p>
                                    </div>
                                    <div class="row-mb-3">
                                        <small class="text-dark fw-semibold">Thought....</small>
                                        <p class="reviews"></p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <form id="addReview">
                                        <input type="hidden" id="bookdId" name="book_id" value="{{ $book->id }}">
                                        <input type="hidden" id="contentType" name="type" value="REVIEW">
                                        <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                                        <textarea id="content" cols="40" rows="1" style="outline: none; border:none;"
                                            placeholder="What's your thougth?"></textarea>
                                        <button type="submit" class="btn btn-primary">Post</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Start Book Review -->

                    <!-- Start Recommended Song -->
                    <div class="modal fade" id="recommendedSong" tabindex="-1" role="dialog"
                        aria-labelledby="recommendedSongLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="recommendedSongLabel">Best music for this book</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row-mb-3">
                                        <p class="music"></p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <form id="addMusic">
                                        <input type="hidden" id="musicBookdId" name="book_id" value="{{ $book->id }}">
                                        <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                                        <input type="text" placeholder="add your fav!"
                                            style="outline: none; border:none;" id="chosenMusic" name="song"
                                            data-toggle="modal" data-target="#showMusic" />
                                        <button type="submit" class="btn btn-primary">Post</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Recommended Song -->

                    <!-- Modal searched song -->
                    <div class="modal fade" id="showMusic" role="dialog" aria-labelledby="showMusicLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Choose your music!</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card-body">
                                        <form id="searchSong">
                                            <div class="input-group">
                                                <input type="text" id="musicTitle" name="music_title"
                                                    class="form-control" placeholder="Your music title" required>
                                                <input type="hidden" id="token" name="_token"
                                                    value="{{ csrf_token() }}">
                                                <button type="submit" class="btn btn-outline-primary">Search</button>
                                            </div>
                                        </form>
                                        <div class="row mt-1" id="searchedSong">
                                            <!-- Element will be inserted by ajax -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end of modal searched song -->

                </div>
            </div>
        </div>
    @endforeach
@endsection
