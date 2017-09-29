/* global YoastSEO */
var config = require( "./config/config.js" );
var helper = require( "./helper.js" );
var collect = require( "./collect/collect.js" );
var replaceVars = require( "./replacevars.js" );

var analysisTimeout = 0;

var App = function(){

    YoastSEO.app.registerPlugin(config.pluginName, {status: 'ready'});

    YoastSEO.app.registerModification('content', collect.append.bind(collect), config.pluginName);

    this.bindListeners();
};

App.prototype.bindListeners = function(){

    if(helper.acf_version >= 5){
        var _self = this;
        acf.add_action('ready', function () {
            _self.replaceVars = replaceVars.createReplaceVars(collect);
            acf.add_action('change remove append sortstop', _self.maybeRefresh);
            acf.add_action('change remove append sortstop', replaceVars.updateReplaceVars.bind(_self, collect, _self.replaceVars));
        });
    }else{
        var fieldSelectors = config.fieldSelectors.slice(0);

        // Ignore Wysiwyg fields because they trigger a refresh in Yoast SEO itself
        fieldSelectors = _.without(fieldSelectors, 'textarea[id^=wysiwyg-acf]');

        var _self = this;

        jQuery(document).on('acf/setup_fields', function(){
            this.replaceVars = replaceVars.createReplaceVars(collect);
            var fields = jQuery('#post-body, #edittag').find(fieldSelectors.join(','));
            //This would cause faster updates while typing
            //fields.on('change input', _self.maybeRefresh.bind(_self) );
            fields.on('change', _self.maybeRefresh.bind(_self) );
            fields.on('change', replaceVars.updateReplaceVars.bind(_self, collect, _self.replaceVars));

            // Do not ignore Wysiwyg fields for the purpose of Replace Vars.
            jQuery('textarea[id^=wysiwyg-acf]').on('change', replaceVars.updateReplaceVars.bind(_self, collect, _self.replaceVars));
            if (YoastSEO.wp._tinyMCEHelper) {
                jQuery('textarea[id^=wysiwyg-acf]').each( function () {
                    YoastSEO.wp._tinyMCEHelper.addEventHandler(this.id, [ 'input', 'change', 'cut', 'paste' ],
                        replaceVars.updateReplaceVars.bind(_self, collect, _self.replaceVars));
                });
            }


            //Also refresh on media close as attachment data might have changed
            wp.media.frame.on('close', _self.maybeRefresh.bind(_self) );
        });
    }

}

App.prototype.maybeRefresh = function(){

    if ( analysisTimeout ) {
        window.clearTimeout(analysisTimeout);
    }

    analysisTimeout = window.setTimeout( function() {

        if(config.debug){
            console.log('Recalculate...' + new Date() + '(Internal)');
        }

        YoastSEO.app.pluginReloaded(config.pluginName);
    }, config.refreshRate );

};

module.exports = App;
