<?php
add_action( 'wp_enqueue_scripts', 'sfbap1_enqueue_styles', 10);
add_action( 'admin_enqueue_scripts', 'sfbap1_admin_enqueue_styles', 10);

function sfbap1_enqueue_styles() {
	
		wp_enqueue_script('jquery');
		
		wp_register_script( 'sfbap1_jquery', plugin_dir_url( __FILE__ ) . '../bower_components/jquery/dist/jquery.min.js', array( 'jquery' ) );
		wp_register_script( 'sfbap1_codebird', plugin_dir_url( __FILE__ ) . '../bower_components/codebird-js/codebird.js', array( 'jquery' ) );
		wp_register_script( 'sfbap1_doT', plugin_dir_url( __FILE__ ) . '../bower_components/doT/doT.min.js', array( 'jquery' ) );
		wp_register_script( 'sfbap1_moment', plugin_dir_url( __FILE__ ) . '../bower_components/moment/min/moment.min.js', array( 'jquery' ) );
		wp_register_script( 'sfbap1_fr', plugin_dir_url( __FILE__ ) . '../bower_components/moment/locale/fr.js', array( 'jquery' ) );
		wp_register_script( 'sfbap1_socialfeed', plugin_dir_url( __FILE__ ) . '../bower_components/social-feed/js/jquery.socialfeed.js', array( 'jquery' ));
		wp_register_style( 'sfbap1_socialfeed_style', plugin_dir_url( __FILE__ )  . '../bower_components/social-feed/css/jquery.socialfeed.css', false, '1.0.0' );

		wp_enqueue_style( 'sfbap1_jquery');
		wp_enqueue_style( 'sfbap1_socialfeed_style');
		wp_enqueue_style( 'sfbap1_fontawesome_style');
   		wp_enqueue_script( 'sfbap1_codebird');
   		wp_enqueue_script( 'sfbap1_doT');
   		wp_enqueue_script( 'sfbap1_moment');
   		wp_enqueue_script( 'sfbap1_fr');
   		wp_enqueue_script( 'sfbap1_socialfeed');



   			wp_register_script( 'sfbap1_en', plugin_dir_url( __FILE__ ) . '../bower_components/moment/locale/en-ca.js', array( 'jquery' ) );
	   		wp_enqueue_script( 'sfbap1_en');
		
			wp_register_script( 'sfbap1_ar', plugin_dir_url( __FILE__ ) . '../bower_components/moment/locale/ar.js', array( 'jquery' ) );
	   		wp_enqueue_script( 'sfbap1_ar');
			wp_register_script( 'sfbap1_bn', plugin_dir_url( __FILE__ ) . '../bower_components/moment/locale/bn.js', array( 'jquery' ) );
	   		wp_enqueue_script( 'sfbap1_bn');
				
			wp_register_script( 'sfbap1-cs', plugin_dir_url( __FILE__ ) . '../bower_components/moment/locale/cs.js', array( 'jquery' ) );
	   		wp_enqueue_script( 'sfbap1-cs');
			wp_register_script( 'sfbap1-da', plugin_dir_url( __FILE__ ) . '../bower_components/moment/locale/da.js', array( 'jquery' ) );
	   		wp_enqueue_script( 'sfbap1-da');
			wp_register_script( 'sfbap1-nl', plugin_dir_url( __FILE__ ) . '../bower_components/moment/locale/nl.js', array( 'jquery' ) );
	   		wp_enqueue_script( 'sfbap1-nl');
			wp_register_script( 'sfbap1-fr', plugin_dir_url( __FILE__ ) . '../bower_components/moment/locale/fr.js', array( 'jquery' ) );
	   		wp_enqueue_script( 'sfbap1-fr');
			wp_register_script( 'sfbap1-de', plugin_dir_url( __FILE__ ) . '../bower_components/moment/locale/de.js', array( 'jquery' ) );
	   		wp_enqueue_script( 'sfbap1-de');
			wp_register_script( 'sfbap1-it', plugin_dir_url( __FILE__ ) . '../bower_components/moment/locale/it.js', array( 'jquery' ) );
	   		wp_enqueue_script( 'sfbap1-it');
			wp_register_script( 'sfbap1-ja', plugin_dir_url( __FILE__ ) . '../bower_components/moment/locale/ja.js', array( 'jquery' ) );
	   		wp_enqueue_script( 'sfbap1-ja');
			wp_register_script( 'sfbap1-ko', plugin_dir_url( __FILE__ ) . '../bower_components/moment/locale/ko.js', array( 'jquery' ) );
	   		wp_enqueue_script( 'sfbap1-ko');
			wp_register_script( 'sfbap1-pt', plugin_dir_url( __FILE__ ) . '../bower_components/moment/locale/pt.js', array( 'jquery' ) );
	   		wp_enqueue_script( 'sfbap1-pt');
			wp_register_script( 'sfbap1-ru', plugin_dir_url( __FILE__ ) . '../bower_components/moment/locale/ru.js', array( 'jquery' ) );
	   		wp_enqueue_script( 'sfbap1-ru');
			wp_register_script( 'sfbap1-es', plugin_dir_url( __FILE__ ) . '../bower_components/moment/locale/es.js', array( 'jquery' ) );
	   		wp_enqueue_script( 'sfbap1-es');
			wp_register_script( 'sfbap1-tr', plugin_dir_url( __FILE__ ) . '../bower_components/moment/locale/tr.js', array( 'jquery' ) );
	   		wp_enqueue_script( 'sfbap1-tr');
			wp_register_script( 'sfbap1-uk', plugin_dir_url( __FILE__ ) . '../bower_components/moment/locale/uk.js', array( 'jquery' ) );
	   		wp_enqueue_script( 'sfbap1-uk');

}


function sfbap1_admin_enqueue_styles() {
	
		wp_enqueue_script('jquery');
		wp_register_script( 'sfbap1_script', plugin_dir_url( __FILE__ ) . '../js/sfbap1-script.js', array( 'jquery' ) );
		wp_enqueue_script( 'sfbap1_script');
		
}