/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */
var gdrts_rating_core;

;(function($, window, document, undefined) {
    gdrts_rating_core = {
        storage: {
            uid: 1,
            did: 1
        },
        init: function() {
            $(".gdrts-rating-block, .gdrts-rating-list").each(function(){
                gdrts_rating_core.common.process(this);
            });

            $(".gdrts-dynamic-block").each(function(){
                gdrts_rating_core.dynamic.process(this);
            });

            gdrts_rating_core.common.methods();
        },
        live: function() {
            $(document).on("click", ".gdrts-toggle-distribution", function(e){
                e.preventDefault();

                var open = $(this).hasClass("gdrts-toggle-open");

                if (open) {
                    $(this).removeClass("gdrts-toggle-open");
                    $(this).html($(this).data("show"));

                    $(".gdrts-rating-distribution", $(this).closest(".gdrts-rating-block")).slideUp();
                } else {
                    $(this).addClass("gdrts-toggle-open");
                    $(this).html($(this).data("hide"));

                    $(".gdrts-rating-distribution", $(this).closest(".gdrts-rating-block")).slideDown();
                }
            });
        },
        dynamic: {
            process: function(el) {
                var data = JSON.parse($('.gdrts-rating-data', $(el)).html());

                data.did = gdrts_rating_core.storage.did;

                $(el).attr("id", "gdrts-dynamic-id-" + gdrts_rating_core.storage.did)
                     .addClass("gdrts-dynamic-loading");

                gdrts_rating_core.storage.did++;

                var args = {
                    todo: "dynamic",
                    did: data.did,
                    meta: data
                };

                gdrts_rating_core.remote.call(args, gdrts_rating_core.dynamic.load, gdrts_rating_core.remote.error);
            },
            load: function(json) {
                var obj = $(json.render).hide();

                $("#gdrts-dynamic-id-" + json.did).fadeOut(150, function(){
                    $(this).replaceWith(obj);

                    obj.fadeIn(300, function(){
                        gdrts_rating_core.common.process(this);

                        if ($(this).hasClass("gdrts-method-stars-rating")) {
                            gdrts_rating_core.stars_rating_single.process($(".gdrts-stars-rating", this));
                        }
                    });
                });
            }
        },
        common: {
            process: function(el) {
                var data = JSON.parse($('.gdrts-rating-data', $(el)).html());

                data.uid = gdrts_rating_core.storage.uid;

                $(el).attr("id", "gdrts-unique-id-" + gdrts_rating_core.storage.uid)
                     .data("rating", data);

                gdrts_rating_core.storage.uid++;
            },
            methods: function() {
                gdrts_rating_core.stars_rating_single.init();
                gdrts_rating_core.stars_rating_list.init();
            },
            style: function(key, obj) {
                var base = ".gdrts-with-font.gdrts-font-" + obj.font + ".gdrts-stars-length-" + obj.length,
                    rule = base + " .gdrts-stars-empty::before, " + 
                           base + " .gdrts-stars-active::before, " + 
                           base + " .gdrts-stars-current::before { " +
                           "content: \"" + obj.content + "\"; }";

                $("<style type=\"text/css\">\r\n" + rule + "\r\n\r\n</style>").appendTo("head");
            }
        },
        remote: {
            url: function() {
                return gdrts_rating_data.url + "?action=" + gdrts_rating_data.handler;
            },
            call: function(args, callback, callerror) {
                $.ajax({
                    url: this.url(),
                    type: "post",
                    dataType: "json",
                    data:  {
                        req: JSON.stringify(args)
                    },
                    success: callback,
                    error: callerror
                });
            },
            error: function(jqXhr, textStatus, errorThrown) {
                if (jqXhr.status === 0) {
                    alert('No internet connection, please verify network settings.');
                } else if (jqXhr.status === 404) {
                    alert('Error 404: Requested page not found.');
                } else if (jqXhr.status === 500) {
                    alert('Error 500: Internal Server Error.');
                } else if (textStatus === 'timeout') {
                    alert('Request timed out.');
                } else if (textStatus === 'abort') {
                    alert('Request aborted.');
                } else {
                    alert('Uncaught Error: ' + errorThrown);
                }
            }
        },
        stars_rating_single: {
            _b: function(el) {
                return $(el).closest(".gdrts-rating-block.gdrts-method-stars-rating");
            },
            _d: function(el) {
                return this._b(el).data("rating");
            },
            init: function() {
                $(".gdrts-rating-block .gdrts-stars-rating").each(function(){
                    gdrts_rating_core.stars_rating_single.process(this);
                });
            },
            call: function(el, rating) {
                var data = this._d(el),
                    args = {
                        todo: "vote",
                        method: "stars-rating",
                        item: data.item.item_id,
                        nonce: data.item.nonce,
                        render: data.render,
                        uid: data.uid,
                        meta: {
                            value: rating,
                            max: data.stars.max
                        }
                    };

                gdrts_rating_core.remote.call(args, gdrts_rating_core.stars_rating_single.voted, gdrts_rating_core.remote.error);
            },
            voted: function(json) {
                var obj = $(json.render).hide();

                $("#gdrts-unique-id-" + json.uid).fadeOut(150, function(){
                    $(this).replaceWith(obj);

                    obj.fadeIn(300, function(){
                        gdrts_rating_core.common.process(this);
                        gdrts_rating_core.stars_rating_single.process($(".gdrts-stars-rating", this));
                    });
                });
            },
            process: function(el) {
                var data = gdrts_rating_core.stars_rating_single._d(el).stars,
                    labels = gdrts_rating_core.stars_rating_single._d(el).labels;

                if ($(el).hasClass("gdrts-with-font")) {
                    var key = data.name + data.max,
                        obj = {font: data.name, 
                               length: data.max, 
                               content: Array(data.max + 1).join(data.char)};

                    gdrts_rating_core.common.style(key, obj);
                }

                if ($(el).hasClass("gdrts-state-active")) {
                    $(".gdrts-stars-empty", el).mouseleave(function(e){
                        if ($(this).hasClass("gdrts-vote-saving")) return;

                        $(el).data("selected", 0).attr("title", "");
                        $(".gdrts-stars-active", this).width(0);
                    });

                    $(".gdrts-stars-empty", el).mousemove(function(e){
                        if ($(this).hasClass("gdrts-vote-saving")) return;

                        var offset = $(this).offset(),
                            width = $(this).width(),
                            star = width / data.max,
                            res = data.resolution,
                            step = res * (star / 100),
                            x = e.pageX - offset.left,
                            parts = Math.ceil(x / step),
                            current = parseFloat((parts * (res / 100)).toFixed(2)),
                            lid = Math.ceil(current * 1),
                            label = labels[lid - 1],
                            active = parts * step;

                        $(el).data("selected", current).attr("title", current + ": " + label);
                        $(".gdrts-stars-active", this).width(active);
                    });

                    $(".gdrts-stars-empty", el).click(function(e){
                        e.preventDefault();

                        if ($(this).hasClass("gdrts-vote-saving")) return;

                        var rating = $(el).data("selected");

                        $(this).addClass("gdrts-vote-saving");

                        gdrts_rating_core.stars_rating_single._b(this).addClass("gdrts-vote-saving");

                        gdrts_rating_core.stars_rating_single.call(el, rating);
                    });
                }

                if (data.responsive) {
                    $(window).bind("load resize orientationchange", {el: el, data: data}, gdrts_rating_core.stars_shared.responsive);

                    gdrts_rating_core.stars_shared._r({el: el, data: data});
                }
            }
        },
        stars_rating_list: {
            _b: function(el) {
                return $(el).closest(".gdrts-rating-list.gdrts-method-stars-rating");
            },
            _d: function(el) {
                return this._b(el).data("rating");
            },
            init: function() {
                $(".gdrts-rating-list .gdrts-stars-rating").each(function(){
                    gdrts_rating_core.stars_rating_list.process(this);
                });
            },
            process: function(el) {
                var data = gdrts_rating_core.stars_rating_list._d(el).stars;

                if ($(el).hasClass("gdrts-with-font")) {
                    var key = data.name + data.max,
                        obj = {font: data.name, 
                               length: data.max, 
                               content: Array(data.max + 1).join(data.char)};

                    gdrts_rating_core.common.style(key, obj);
                }

                if (data.responsive) {
                    $(window).bind("load resize orientationchange", {el: el, data: data}, gdrts_rating_core.stars_shared.responsive);

                    gdrts_rating_core.stars_shared._r({el: el, data: data});
                }
            }
        },
        stars_shared: {
            responsive: function(e) {
                gdrts_rating_core.stars_shared._r(e.data);
            },
            _r: function(input) {
                var el = input.el,
                    available = $(el).parent().width(),
                    new_size = Math.floor(available / input.data.max);

                new_size = new_size > input.data.size ? input.data.size : new_size;

                if (input.data.type === "font") {
                    $(".gdrts-stars-empty", el).css("font-size", new_size + "px").css("line-height", new_size + "px");
                    $(el).css("line-height", new_size + "px").css("height", new_size + "px");
                } else if (input.data.type === "image") {
                    $(".gdrts-stars-empty, .gdrts-stars-active, .gdrts-stars-current", el).css("background-size", new_size + "px");
                    $(el).css("height", new_size + "px").css("width", input.data.max * new_size + "px");
                }
            }
        }
    };

    gdrts_rating_core.init();
    gdrts_rating_core.live();
})(jQuery, window, document);
