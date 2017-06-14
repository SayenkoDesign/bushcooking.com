(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-73280214-1', 'auto');

jQuery(function() {
    $('#primary-nav').attr({
        'class': 'dropdown menu',
        'data-dropdown-menu': true
    }).find('ul').attr({
        'class': 'submenu menu vertical',
        'data-submenu': true
    });

    $('#primary-mobile-nav').attr({
        'class': 'vertical menu hide-for-medium',
        'data-accordion-menu': true
    }).find('ul').attr({
        'class': 'menu vertical nested',
        'data-submenu': true
    });
    
    jQuery(document).foundation();

    jQuery(document).ready(function(){
        jQuery('.slick').slick({
            infinite: true,
            speed: 500,
            fade: true,
            cssEase: 'linear'
        });
    });

    jQuery('.stars .star').hover(function() {
        jQuery(this).children('i.fa').removeClass('fa-star-o').addClass('fa-star');
        jQuery(this).prevAll('.star').children('i.fa').removeClass('fa-star-o').addClass('fa-star');
        jQuery(this).nextAll('.star').children('i.fa').removeClass('fa-star').addClass('fa-star-o');
    });

    jQuery('.stars').mouseleave(function(){
        var rating = jQuery('#comments input[type=radio]:checked').val();
        if(!rating) {
            $(this).find('.fa.fa-star').removeClass('fa-star').addClass('fa-star-o');
        } else {
            $(this).find('.fa.fa-star').removeClass('fa-star').addClass('fa-star-o');
            $(this).find('.star:lt(' + rating + ') .fa').removeClass('fa-star-o').addClass('fa-star');
        }
    });

    jQuery('.stars .star').on('click', function() {
        jQuery(this).children('i.fa').removeClass('fa-star-o').addClass('fa-star');
        jQuery(this).prevAll('.star').children('i.fa').removeClass('fa-star-o').addClass('fa-star');
        jQuery(this).nextAll('.star').children('i.fa').removeClass('fa-star').addClass('fa-star-o');
    });

    jQuery(window).scroll(function (event) {
        var scroll = $(window).scrollTop();
        var sticky_container = jQuery('#top-bar-container');
        if(scroll > 0) {
            sticky_container.addClass('shrink');
        } else {
            sticky_container.removeClass('shrink');
        }
    });

    jQuery('p:empty, ul.tabs > p').remove();

    jQuery('#recipe-instructions .switch-input').on('change', function(){
        jQuery(this).parent('div').parent('div').next('div').children('.switch-text').toggleClass('strike');
    });

    jQuery("#sponsored-ad").stick_in_parent({
        offset_top: 64,
        recalc_every: 1
    });
});