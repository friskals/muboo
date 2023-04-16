@extends('frontsite/navbarLayout')

@section('title', 'Cards basic   - UI elements')

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/masonry/masonry.js')}}"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>
$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)  
  var bookId = button.data('book-id')
  var modal = $(this)
  modal.find('.modal-title').text(bookId)
  modal.find('.modal-body input').val(bookId)

  $.ajax({
        type: 'get',
        url: "/book/"+bookId,
        success: function(data) {
            book = data.book
            reviews =  data.reviews

            modal.find('.modal-title').text(book.title)
            modal.find('.excerpts').text(book.excerpts)
            appendedReviews = '';
            for(i = 0 ; i < reviews.length; i++){
                appendedReviews+='<figure class="mt-2 small"><blockquote class="blockquote"><small class="text-dark">'+reviews[i].content+'</small></blockquote><figcaption class="blockquote-footer" style="text-align:right">'+reviews[i].reviewer+'</figcaption></figure>'

            }
            modal.find('.reviews').html(" ");
            modal.find('.reviews').append(appendedReviews) 
        },
        error: function() {
            console.log("Does not work");
        }
    });

})

$('#addReview').submit(function(e){
    e.preventDefault();
    var modal = $(this)
    bookId = modal.find('#bookdId').val()
    contentType = modal.find('#contentType').val()
    content = modal.find('#content').val() 
    token = modal.find('#token').val()
    // return;

    $.ajax({
        url: '/content',
        type: 'POST',
        beforeSend: function (jqXHR, settings) { 
            jqXHR.setRequestHeader('X-CSRF-Token', token);
        },
        data: {
            'book_id':bookId,
            'type':contentType,
            'content':content,
        },
        success:function(data){
            $.ajax({
                url: '/content/'+ data.content_id,
                type: 'GET',
                beforeSend: function (jqXHR, settings) { 
                    jqXHR.setRequestHeader('X-CSRF-Token', token);
                },
                success:function(response){ 
                    newReview ='<figure class="mt-2 small"><blockquote class="blockquote"><small class="text-dark">'+response.data.content+'</small></blockquote><figcaption class="blockquote-footer" style="text-align:right">'+response.data.reviewer+'</figcaption></figure>'                    
                    $(".reviews").prepend(newReview);
                    $("#content").val("") 
                },
                error: function(e) {
                    console.log(e);
                }

            }) 
        },
        error: function(e) {
                    console.log(e);
        }

    })
})
</script>

@endsection


@section('content')
<h4 class="fw-bold py-3 mb-4">What's new?</h4>
 @foreach ($books as $book)
    <div class="row mb-3">
        <div class="col-sm-3"></div>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100">
                <img class="card-img-top" src="{{asset('assets/img/elements/2.jpg')}}" alt="Card image cap" />
                <div class="card-body">
                    <h5 class="card-title">{{$book->title}}</h5>
                    <a href="" class="card-text" data-toggle="modal" data-target="#exampleModal" data-book-id="{{$book->id}}" 
                        style="color: #000000;text-decoration: none;"> 
                    {{$book->excerpts}}
                    </a>
                </div>
          
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       <div class="row-mb-3">
                        <p class="excerpts"></p>                        
                       </div>
                       <div class="row-mb-3">
                        <span>Thought....</span>
                        <p class="reviews"></p>
                       </div>
                    </div>
                    <div class="modal-footer">
                        <form  id="addReview">
                            <input type="hidden" id="bookdId" name="book_id" value="{{$book->id}}">
                            <input type="hidden" id="contentType" name="type" value="REVIEW">
                            <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                            <textarea id="content" cols="40" rows="1" style="outline: none; border:none;" placeholder="What's your thougth?"></textarea>
                            <button type="submit" class="btn btn-primary">Post</button>
                        </form>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
 @endforeach
@endsection
