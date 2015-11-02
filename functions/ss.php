<?php
function wpo_theme_enque_scripts() {
	$build = esc_html( TEMPLATEURI ) . 'build/js/';

	wp_register_script( 'main', $build . 'script.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'main' );

	wp_enqueue_script( 'jquery' );

	$stylesheet_uri = get_stylesheet_uri();

	// to clear the cache you must use a number greater than 1.
	// $stylesheet_uri = add_query_arg( array( 'v' => 1 ), $stylesheet_uri );

	wp_register_style( 'main', $stylesheet_uri );
	wp_enqueue_style( 'main' );
}
add_action( 'wp_enqueue_scripts', 'wpo_theme_enque_scripts' );

/* remove version numbers from end of css and js files
* http://wordpress.org/support/topic/get-rid-of-ver-on-the-end-of-cssjs-files#post-1892166
*/
function wpo_remove_cssjs_ver( $src ) {
	if ( strpos( $src, '?ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}
add_filter( 'style_loader_src', 'wpo_remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'wpo_remove_cssjs_ver', 10, 2 );


