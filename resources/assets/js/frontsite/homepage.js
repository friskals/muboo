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
            appendedMusic = '';
            for (i = 0; i < musics.length; i++) {
                appendedMusic += '<div class="row mb-1"><a href="https://www.youtube.com/watch?v=' + musics[i].external_music_id + '"><i class="bx bxl-youtube text-danger"></i><small class="text-dark fw-semibold ml-2" id="searchMusicTitle">' + musics[i].title + '</small></a></div>'
            }
            modal.find('.music').html(" ");
            modal.find('.music').append(appendedMusic)
        },
        error: function () {
            console.log("Does not work");
        }
    });

})


$('#addMusic').submit(function (e) {
    e.preventDefault();
    var modal = $(this)
    musicTitle = modal.find('#chosenMusic').val()
    token = modal.find('#token').val()
    musicBookdId = modal.find('#musicBookdId').val()

    $.ajax({
        url: '/book/music/',
        type: 'POST',
        beforeSend: function (jqXHR, settings) {
            jqXHR.setRequestHeader('X-CSRF-Token', token);
        },
        data: {
            'book_id': musicBookdId,
            'external_music_id': 'abc',
            'title': musicTitle
        },
        success: function (response) {
            if (!response.data.displayed) {
                alert('music already added previously')
                return;
            }
            $.ajax({
                url: '/book/music/' + response.data.music_id,
                type: 'GET',
                success: function (response) {
                    music = response.data
                    newRecommendation = '<div class="row mb-1"><a href="https://www.youtube.com/watch?v=' + music.external_music_id + '"><i class="bx bxl-youtube text-danger"></i><small class="text-dark fw-semibold ml-2" id="searchMusicTitle">' + music.title + '</small></a></div>'
                    $('.music').append(newRecommendation)
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


$('#searchSong').submit(function (e) {
    e.preventDefault();
    var modal = $(this)
    musicTitle = modal.find("#musicTitle").val()

    $.ajax({
        url: '/music/search?q=' + musicTitle,
        type: 'GET',
        success: function (data) {
            musics = data.data

            musicSearched = '<div class="col mb-4 mt-4"> <small class="text-dark fw-semibold">Result</small></div><div class="div-row" >'

            for (i = 0; i < musics.length; i++) {
                musicSearched += '<div class="row mb-1"><form id="pickMusic" class="mb-3">  <input type="hidden" id="musicId" name="musicId" value="' + musics[i].id + '"/> <a href="https://www.youtube.com/watch?v=' + musics[i].id + '"><i class="bx bxl-youtube text-danger"></i> <small class="text-dark fw-semibold ml-2" id="searchMusicTitle">' + musics[i].title + '</small></a><button  onclick="pickMusic()" class="btn btn-primary btn-sm float-sm-end">Pick</button> </form></div>'
            }

            musicSearched += '</div>'

            $("#searchedSong").html(" ");

            $("#searchedSong").append(musicSearched)

        },
        error: function (e) {
            console.log(e);
        }

    })
})

$('#pickMusic').submit(function (e) {
    //stiill don't work
    console.log("yoo  ooo ooo");
    e.preventDefault();

})

/**
 * Clear element at shown music modal
 */
 $('#showMusic').on('shown.bs.modal', function () {
    var modal = $(this)
    modal.find("#searchedSong").html(" ");
    $("#musicTitle").val("")
});