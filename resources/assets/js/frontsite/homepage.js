$('#bookReviews').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var bookId = button.data('book-id')
    var modal = $(this)
    modal.find('.modal-title').text(bookId)
    modal.find('.modal-body input').val(bookId)

    $.ajax({
        type: 'get',
        url: "/book/" + bookId,
        success: function (data) {
            book = data.book
            reviews = data.reviews

            modal.find('.modal-title').text(book.title)
            modal.find('.excerpts').text(book.excerpts)
            appendedReviews = '';
            for (i = 0; i < reviews.length; i++) {
                appendedReviews += '<figure class="mt-2 small"><blockquote class="blockquote"><small class="text-dark">' + reviews[i].content + '</small></blockquote><figcaption class="blockquote-footer" style="text-align:right">' + reviews[i].reviewer + '</figcaption></figure>'

            }
            modal.find('.reviews').html(" ");
            modal.find('.reviews').append(appendedReviews)
        },
        error: function () {
            console.log("Does not work");
        }
    });

})

$('#addReview').submit(function (e) {
    e.preventDefault();
    var modal = $(this)
    bookId = modal.find('#bookdId').val()
    contentType = modal.find('#contentType').val()
    content = modal.find('#content').val()
    token = modal.find('#token').val()

    $.ajax({
        url: '/content',
        type: 'POST',
        beforeSend: function (jqXHR, settings) {
            jqXHR.setRequestHeader('X-CSRF-Token', token);
        },
        data: {
            'book_id': bookId,
            'type': contentType,
            'content': content
        },
        success: function (data) {
            $.ajax({
                url: '/content/' + data.content_id,
                type: 'GET',
                beforeSend: function (jqXHR, settings) {
                    jqXHR.setRequestHeader('X-CSRF-Token', token);
                },
                success: function (response) {
                    newReview = '<figure class="mt-2 small"><blockquote class="blockquote"><small class="text-dark">' + response.data.content + '</small></blockquote><figcaption class="blockquote-footer" style="text-align:right">' + response.data.reviewer + '</figcaption></figure>'
                    $(".reviews").prepend(newReview);
                    $("#content").val("")
                },
                error: function (e) {
                    console.log(e);
                }

            })
        },
        error: function (e) {
            console.log(e);
        }

    })
})

$('#recommendedSong').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var bookId = button.data('book-id')
    var modal = $(this)
    token = modal.find('#token').val()

    $.ajax({
        type: 'POST',
        url: 'book/' + bookId + '/music',
        beforeSend: function (jqXHR, settings) {
            jqXHR.setRequestHeader('X-CSRF-Token', token);
        },
        data: {
            'limit': 5
        },
        success: function (data) {
            musics = data.data
            console.log(musics)
            appendedMusic = '';
            for (i = 0; i < musics.length; i++) {
                appendedMusic+='<a href="https://www.youtube.com/watch?v='+musics[i].external_music_id+'" style="color: #000000;text-decoration: none;"><i class="bx bxl-youtube"></i></a><small class="text-dark fw-semibold ml-1">'+musics[i].title+'</small>'
            }
            modal.find('.music').html(" ");
            modal.find('.music').append(appendedMusic)
        },
        error: function () {
            console.log("Does not work");
        }
    });

})

