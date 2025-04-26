jQuery(document).ready(function($){
	detectIE();
    
    $('#mastmenu .menu-item > a').click(function() {
        $('body').removeClass('site-navigation-active');
        $('.main-navigation.active').removeClass('active');
        $('.menu-toggle.active').removeClass('active');
    });

    $('.section-video .play-button').click(function() {
        $(this).next('.img').addClass('hidden');
        $('#about-video').addClass('open');
    });
    $("a[href^='#']").click(function(e) {
        e.preventDefault();
        
        var position = $($(this).attr("href")).offset().top;

        $("body, html").animate({
            scrollTop: position
        }, 1500 );
    });

    $('.articles-slider').owlCarousel({
        loop:true,
        items:1,
        nav: true,
        dots: false
    });

    $('.testimonials-items').owlCarousel({
        loop:true,
        items:1,
        nav: false,
        dots: true
    });
    $('.service-slider').owlCarousel({
        loop:true,
        responsiveClass:true,
        nav: true,
        dots: false,
        responsive:{
            0:{
                items:1
            },
			480:{
                items:2
            },
            768:{
                items:3
            },
            1200:{
                items:4
            },
			1600:{
                items:5
            }
        }
    });
})
function detectIE() {
    var ua = window.navigator.userAgent;

    var msie = ua.indexOf('MSIE ');
    if (msie > 0) {
        // IE 10 or older => return version number
        var ieV = parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
        document.querySelector('body').className += ' explorer';
    }

    var trident = ua.indexOf('Trident/');
    if (trident > 0) {
        // IE 11 => return version number
        var rv = ua.indexOf('rv:');
        var ieV = parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
        document.querySelector('body').className += ' explorer';
    }

    var edge = ua.indexOf('Edge/');
    if (edge > 0) {
       // IE 12 (aka Edge) => return version number
       var ieV = parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
        document.querySelector('body').className += ' explorer';
    }

    // other browser
    return false;
}