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
});