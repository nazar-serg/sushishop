import 'bootstrap';
import AOS from 'aos';
import 'owl.carousel';
import './js/scripttotop';
import './scss/main.scss';


console.log('I amasasas');

//AOS animation
AOS.init({
    once: true, // Анимация срабатывает только один раз
});

jQuery(document).ready(function($) {
    //owl-carousel
    $(".owl-carousel-full").owlCarousel({
        margin: 20,
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
                items: 4
            }
        }
    });
});