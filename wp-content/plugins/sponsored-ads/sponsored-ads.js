if(sponsored_ads.id) {
    (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: sponsored_ads.id,
        enable_page_level_ads: true
    });
}


jQuery(function() {
    jQuery('.sponsored-ad.ad').each(function(){
        var ad = jQuery(this);
        ad.attr('viewed', 'false');

        // on load
        var sponsor;
        var id;
        ga('send', 'event', 'sponsor', 'impression', sponsor, id, {
            nonInteraction: true
        });

        // on view
        jQuery(window).scroll(function(){
            if(ad.attr('viewed') == "true") {
                return;
            }

            var scrollTop = jQuery(document).scrollTop();
            var scrollBottom = scrollTop + jQuery(window).height();
            var adBottom = ad.offset().top + ad.innerHeight();

            if(adBottom < scrollBottom) {
                ad.attr('viewed', 'true');
                ga('send', 'event', 'sponsor', 'view', sponsor, id, {
                    nonInteraction: true
                });
            }
        });

        // on click
        jQuery(this).find('a').on("click", function(){
            ga('send', {
                hitType: 'event',
                eventCategory: 'sponsor',
                eventAction: 'click',
                eventLabel: sponsor,
                eventValue: 1,
                transport: 'beacon'
            });
        });
    });
});