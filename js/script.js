/**
 * File script.js.
 *
 * Major script.
 */

( function( $ ) {
    $('.widget-area input[type="search"]').attr('placeholder', 'Search...');

    // Global search
    var toggleButton = $( '.header-search-toggle' );

    if ( toggleButton.length ) {
        toggleButton.on("click", function(){
            $( '.header-search-form' ).slideToggle();
        });
    }

    $('.header-mobile-menu .mobile-menu-toggle').on('click', function () {
        $('.header-mobile-menu').toggleClass('fixed');
        $('.main-navigation').toggleClass('show');
    });

    function postOrdering () {
        var $section1 = [0, 1, 2];
        var $section2 = [3, 4, 5];
        var $section3 = [6, 7, 8];
        var $section4 = [9, 10, 11];
        // Ordering posts
        $('#main .post').each(function (i, v) {
            if ($section1.includes(i)) {
                $(v).appendTo('#post-section-1');
            }

            if ($section2.includes(i)) {
                $(v).appendTo('#post-section-2');
            }

            if ($section3.includes(i)) {
                $(v).appendTo('#post-section-3');
            }

            if ($section4.includes(i)) {
                $(v).appendTo('#post-section-4');
            }
        });
    }
    postOrdering();

    function showPosts() {
        $('#post-section-1').show();
        $('#post-section-2').hide();
        $('#post-section-3').hide();
        $('#post-section-4').hide();
    }
    showPosts();

    function initializeShowPagination() {
        $('.beauty-studio-pagination .prev.page-numbers').hide();
        $('.beauty-studio-pagination .next.page-numbers').show();
        $('.beauty-studio-pagination .page-numbers[data-page="1"]').addClass('current');
    }
    initializeShowPagination();

    function paginationHandlers() {
        // Pagination handlers
        $('.beauty-studio-pagination .page-numbers').on('click', function (e) {
            e.preventDefault();
            var $currentPage = $('.beauty-studio-current-page').val();
            var $pageNumber  = $(this).attr('data-page');
            var ajaxUrl      = $('.beauty-studio-admin-ajax-url').val();

            if (isNaN($currentPage)) {
                return false;
            }

            if ($(this).hasClass('current')) {
                return false;
            }

            if ($pageNumber === 'next') {
                $pageNumber = parseInt($('.beauty-studio-current-page').val()) + 1;
            }

            if ($pageNumber === 'back') {
                $pageNumber = parseInt($('.beauty-studio-current-page').val()) - 1;
            }

            if ($pageNumber <= 0 || isNaN($pageNumber)) {
                $pageNumber = 0;
            }

            $.ajax({
                // url: ajaxUrl + '?action=beauty_studio_pagination_handlers',
                url: ajaxUrl + '?action=beauty_studio_show_pagination',
                data: {
                    paged: $pageNumber
                },
                dataType: 'json',
                method: 'POST',
                success: function (res) {
                    if (parseInt($pageNumber) === 1) {
                        $('#post-section-2').fadeOut(500);
                        $('#post-section-3').fadeOut(500);
                        $('#post-section-4').fadeOut(500);
                        $('#post-section-1').fadeIn(3000);
                    } else if (parseInt($pageNumber) === 2) {
                        $('#post-section-1').fadeOut(500);
                        $('#post-section-3').fadeOut(500);
                        $('#post-section-4').fadeOut(500);
                        $('#post-section-2').fadeIn(3000);
                    }  else if (parseInt($pageNumber) === 3) {
                        $('#post-section-1').fadeOut(500);
                        $('#post-section-2').fadeOut(500);
                        $('#post-section-4').fadeOut(500);
                        $('#post-section-3').fadeIn(3000);
                    }  else if (parseInt($pageNumber) === 4) {
                        $('#post-section-1').fadeOut(500);
                        $('#post-section-2').fadeOut(500);
                        $('#post-section-3').fadeOut(500);
                        $('#post-section-4').fadeIn(3000);
                    }

                    $('#beauty-studio-list .beauty-studio-pagination').remove();
                    $('#beauty-studio-list').append(res.contents);
                    $('.beauty-studio-current-page').val($pageNumber);
                    $('.beauty-studio-pagination .page-numbers[data-page="'+ $pageNumber +'"]').addClass('current');

                    if (parseInt($pageNumber) > 1) {
                        $('.beauty-studio-pagination .prev.page-numbers').show();
                    } else {
                        $('.beauty-studio-pagination .prev.page-numbers').hide();
                    }

                    if (parseInt($pageNumber) < 4) {
                        $('.beauty-studio-pagination .next.page-numbers').show();
                    } else {
                        $('.beauty-studio-pagination .next.page-numbers').hide();
                    }
                    paginationHandlers();
                }
            });
        });
    }
    paginationHandlers()
} )( jQuery );