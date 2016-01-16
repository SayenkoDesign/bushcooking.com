/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */
var gdrts_admin_core;

;(function($, window, document, undefined) {
    gdrts_admin_core = {
        storage: {
            url: "",
            recalc: {
                active: false,
                stop: false,
                total: 0,
                current: 0,
                pages: 0,
                step: 25,
                settings: []
            }
        },
        init: function() {
            if (gdrts_data.page === "ratings") {
                gdrts_admin_core.dialogs.ratings();
                gdrts_admin_core.ratings.init();
            }

            if (gdrts_data.page === "log") {
                gdrts_admin_core.dialogs.votes();
                gdrts_admin_core.votes.init();
            }

            if (gdrts_data.page === "tools") {
                gdrts_admin_core.dialogs.votes();
                gdrts_admin_core.tools.init();
            }
        },
        dialogs: {
            classes: function(extra) {
                var cls = "wp-dialog d4p-dialog gdrts-modal-dialog";

                if (extra !== "") {
                    cls+= " " + extra;
                }

                return cls;
            },
            defaults: function() {
                return {
                    width: 480,
                    height: "auto",
                    minHeight: 24,
                    autoOpen: false,
                    resizable: false,
                    modal: true,
                    closeOnEscape: false,
                    zIndex: 300000
                };
            },
            votes: function() {
                var dlg_delete = $.extend({}, gdrts_admin_core.dialogs.defaults(), {
                    dialogClass: gdrts_admin_core.dialogs.classes("gdrts-dialog-hidex"),
                    buttons: {
                        OK: function() {
                            $(".d4p-content-right form").submit();
                        },
                        Cancel: function() {
                            $("#gdrts-dialog-log-delete").wpdialog("close");
                        }
                    }
                }), dlg_remove = $.extend({}, gdrts_admin_core.dialogs.defaults(), {
                    dialogClass: gdrts_admin_core.dialogs.classes("gdrts-dialog-hidex"),
                    buttons: {
                        OK: function() {
                            $(".d4p-content-right form").submit();
                        },
                        Cancel: function() {
                            $("#gdrts-dialog-log-remove").wpdialog("close");
                        }
                    }
                }), dlg_delete_single = $.extend({}, gdrts_admin_core.dialogs.defaults(), {
                    dialogClass: gdrts_admin_core.dialogs.classes("gdrts-dialog-hidex"),
                    buttons: {
                        OK: function() {
                            window.location.href = gdrts_admin_core.storage.url;
                        },
                        Cancel: function() {
                            $("#gdrts-dialog-log-delete-single").wpdialog("close");
                        }
                    }
                }), dlg_remove_single = $.extend({}, gdrts_admin_core.dialogs.defaults(), {
                    dialogClass: gdrts_admin_core.dialogs.classes("gdrts-dialog-hidex"),
                    buttons: {
                        OK: function() {
                            window.location.href = gdrts_admin_core.storage.url;
                        },
                        Cancel: function() {
                            $("#gdrts-dialog-log-remove-single").wpdialog("close");
                        }
                    }
                });

                $("#gdrts-dialog-log-delete").wpdialog(dlg_delete);
                $("#gdrts-dialog-log-remove").wpdialog(dlg_remove);
                $("#gdrts-dialog-log-delete-single").wpdialog(dlg_delete_single);
                $("#gdrts-dialog-log-remove-single").wpdialog(dlg_remove_single);
            },
            ratings: function() {
                var dlg_delete = $.extend({}, gdrts_admin_core.dialogs.defaults(), {
                    dialogClass: gdrts_admin_core.dialogs.classes("gdrts-dialog-hidex"),
                    buttons: {
                        OK: function() {
                            $(".d4p-content-right form").submit();
                        },
                        Cancel: function() {
                            $("#gdrts-dialog-ratings-delete").wpdialog("close");
                        }
                    }
                }), dlg_clear = $.extend({}, gdrts_admin_core.dialogs.defaults(), {
                    dialogClass: gdrts_admin_core.dialogs.classes("gdrts-dialog-hidex"),
                    buttons: {
                        OK: function() {
                            $(".d4p-content-right form").submit();
                        },
                        Cancel: function() {
                            $("#gdrts-dialog-ratings-clear").wpdialog("close");
                        }
                    }
                }), dlg_clear_single = $.extend({}, gdrts_admin_core.dialogs.defaults(), {
                    dialogClass: gdrts_admin_core.dialogs.classes("gdrts-dialog-hidex"),
                    buttons: {
                        OK: function() {
                            window.location.href = gdrts_admin_core.storage.url;
                        },
                        Cancel: function() {
                            $("#gdrts-dialog-ratings-clear-single").wpdialog("close");
                        }
                    }
                }), dlg_delete_single = $.extend({}, gdrts_admin_core.dialogs.defaults(), {
                    dialogClass: gdrts_admin_core.dialogs.classes("gdrts-dialog-hidex"),
                    buttons: {
                        OK: function() {
                            window.location.href = gdrts_admin_core.storage.url;
                        },
                        Cancel: function() {
                            $("#gdrts-dialog-ratings-delete-single").wpdialog("close");
                        }
                    }
                });

                $("#gdrts-dialog-ratings-delete").wpdialog(dlg_delete);
                $("#gdrts-dialog-ratings-clear").wpdialog(dlg_clear);
                $("#gdrts-dialog-ratings-clear-single").wpdialog(dlg_clear_single);
                $("#gdrts-dialog-ratings-delete-single").wpdialog(dlg_delete_single);
            }
        },
        votes: {
            init: function() {
                $(".gdrts-action-delete-entry").click(function(e){
                    e.preventDefault();

                    gdrts_admin_core.storage.url = $(this).attr("href");

                    $("#gdrts-dialog-log-delete-single").wpdialog("open");
                });

                $(".gdrts-action-remove-entry").click(function(e){
                    e.preventDefault();

                    gdrts_admin_core.storage.url = $(this).attr("href");

                    $("#gdrts-dialog-log-remove-single").wpdialog("open");
                });

                $("#doaction").click(function(e) {
                    e.preventDefault();

                    if ($("#bulk-action-selector-top").val() === "delete") {
                        $("#gdrts-dialog-log-delete").wpdialog("open");
                    } else if ($("#bulk-action-selector-top").val() === "remove") {
                        $("#gdrts-dialog-log-remove").wpdialog("open");
                    }
                });

                $("#doaction2").click(function(e) {
                    e.preventDefault();

                    if ($("#bulk-action-selector-bottom").val() === "delete") {
                        $("#gdrts-dialog-log-delete").wpdialog("open");
                    } else if ($("#bulk-action-selector-bottom").val() === "remove") {
                        $("#gdrts-dialog-log-remove").wpdialog("open");
                    }
                });
            }
        },
        ratings: {
            init: function() {
                $("#gdrts-ratings-submit").click(function(e){
                    $("#bulk-action-selector-top, #bulk-action-selector-bottom").val(-1);
                });

                $(".gdrts-action-clear-ratings").click(function(e){
                    e.preventDefault();

                    gdrts_admin_core.storage.url = $(this).attr("href");

                    $("#gdrts-dialog-ratings-clear-single").wpdialog("open");
                });

                $(".gdrts-action-delete-ratings").click(function(e){
                    e.preventDefault();

                    gdrts_admin_core.storage.url = $(this).attr("href");

                    $("#gdrts-dialog-ratings-delete-single").wpdialog("open");
                });

                $("#doaction2").click(function(e) {
                    e.preventDefault();

                    if ($("#bulk-action-selector-bottom").val() !== "-1") {
                        if ($("#bulk-action-selector-bottom").val() === "delete") {
                            $("#gdrts-dialog-ratings-delete").wpdialog("open");
                        } else {
                            $("#gdrts-dialog-ratings-clear").wpdialog("open");
                        }
                    }
                });

                $("#doaction").click(function(e) {
                    e.preventDefault();

                    if ($("#bulk-action-selector-top").val() !== "-1") {
                        if ($("#bulk-action-selector-top").val() === "delete") {
                            $("#gdrts-dialog-ratings-delete").wpdialog("open");
                        } else {
                            $("#gdrts-dialog-ratings-clear").wpdialog("open");
                        }
                    }
                });
            }
        },
        tools: {
            init: function() {
                if (gdrts_data.panel === "export") {
                    gdrts_admin_core.tools.export();
                }

                if (gdrts_data.panel === "recalc") {
                    gdrts_admin_core.tools.recalc();
                }
            },
            export: function() {
                $("#gdrts-tool-export").click(function(e){
                    e.preventDefault();

                    window.location = $("#gdrts-export-url").val();
                });
            },
            recalc: function() {
                $("#gdrts-tool-recalc").click(function(e){
                    if (gdrts_admin_core.storage.recalc.active) {
                        gdrts_admin_core.recalculation.stop();
                    } else {
                        var s = $(".gdrts-recalc-filter:checked"), settings = [];

                        if (s.length === 0) {
                            alert(gdrts_data.dialog_nothing);
                        } else {
                            $.each(s, function(idx, el){
                                settings.push($(el).val());
                            });

                            gdrts_admin_core.recalculation.start(settings);
                        }
                    }
                });
            }
        },
        recalculation: {
            start: function(settings) {
                gdrts_admin_core.storage.recalc.active = true;
                gdrts_admin_core.storage.recalc.settings = settings;

                $("#gdrts-tool-recalc").val(gdrts_data.button_stop);
                $("#gdrts-recalc-intro").slideUp();
                $("#gdrts-recalc-process").slideDown();

                gdrts_admin_core.recalculation._call({ operation: "start" }, gdrts_admin_core.recalculation.callback_start);
            },
            stop: function() {
                gdrts_admin_core.storage.recalc.stop = true;

                $("#gdrts-tool-recalc").attr("disabled", true);
            },
            callback_start: function(json) {
                gdrts_admin_core.storage.recalc.total = json.objects;
                gdrts_admin_core.storage.recalc.pages = Math.ceil(json.objects / gdrts_admin_core.storage.recalc.step);

                gdrts_admin_core.recalculation._write(json.message);

                gdrts_admin_core.recalculation.run();
            },
            callback_stop: function(json) {
                gdrts_admin_core.storage.recalc.active = false;
                gdrts_admin_core.recalculation._write(json.message);
            },
            callback_process: function(json) {
                if (gdrts_admin_core.storage.recalc.stop) {
                    gdrts_admin_core.recalculation._call({ operation: "stop" }, gdrts_admin_core.recalculation.callback_stop);
                } else {
                    gdrts_admin_core.storage.recalc.current++;

                    gdrts_admin_core.recalculation._write(json.message);

                    if (gdrts_admin_core.storage.recalc.current < gdrts_admin_core.storage.recalc.pages) {
                        gdrts_admin_core.recalculation.run();
                    } else {
                        gdrts_admin_core.recalculation.stop();
                        gdrts_admin_core.recalculation._call({ operation: "stop" }, gdrts_admin_core.recalculation.callback_stop);
                    }
                }
            },
            run: function() {
                var data = {
                    operation: "run",
                    total: gdrts_admin_core.storage.recalc.total,
                    current: gdrts_admin_core.storage.recalc.current,
                    step: gdrts_admin_core.storage.recalc.step,
                    settings: gdrts_admin_core.storage.recalc.settings
                };

                gdrts_admin_core.recalculation._call(data, gdrts_admin_core.recalculation.callback_process);
            },
            _write: function(message) {
                $("#gdrts-recalc-progress pre").append(message + "\r\n");
            },
            _call: function(data, callback) {
                $.ajax({
                    url: ajaxurl + "?action=gdrts_tools_recalc&_ajax_nonce=" + gdrts_data.nonce,
                    type: "post", dataType: "json", data: data, success: callback
                });
            }
        }
    };

    gdrts_admin_core.init();
})(jQuery, window, document);
