import 'bootstrap';
import AOS from 'aos';
import 'owl.carousel';
import './js/scripttotop';
import './scss/main.scss';


console.log('I amasasas');

//AOS animation
AOS.init({
    once: true, 
});

jQuery(document).ready(function($) {
    //owl-carousel
    $(".owl-carousel-full").owlCarousel({
        margin: 20,
        items: 4,
        nav: false,
        loop: true,
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },
            768: {
                items: 2
            },
            992: {
                items: 3
            },
            1000: {
                items: 3,
            },
            1200: {
                items: 4
            }
        }
    });

     // Добавляем обработчики событий для пользовательских кнопок
     $('.custom-nav-hit-product .prev').click(function() {
        $('.owl-carousel').trigger('prev.owl.carousel');
    });

    $('.custom-nav-hit-product .next').click(function() {
        $('.owl-carousel').trigger('next.owl.carousel');
    });

    //Add ajax loader for product card
    // https://gist.github.com/bagerathan/2b57e7413bfdd09afa04c7be8c6a617f
      $('body').on('adding_to_cart', function (e, btn, data) {
        btn.closest('.product-card').find('.custom-ajax-loader').fadeIn();
    });

    $('body').on('added_to_cart', function (e, response_fragments, response_cart_hash, btn) {
        btn.closest('.product-card').find('.custom-ajax-loader').fadeOut();
    });
});


//Одинаковая высота для каждой карточки в карусели
function setEqualHeight() {
    var maxHeight = 0;
    $('.owl-carousel .product-card-item').css('height', 'auto');
    
    $('.owl-carousel .product-card-item').each(function(){
        var thisHeight = $(this).outerHeight();
        if (thisHeight > maxHeight) {
            maxHeight = thisHeight;
        }
    });
    
    $('.owl-carousel .product-card-item').css('height', maxHeight + 'px');
}

$(window).on('load', setEqualHeight);
$('.owl-carousel').on('initialized.owl.carousel', setEqualHeight);
$(window).resize(setEqualHeight);


