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
});