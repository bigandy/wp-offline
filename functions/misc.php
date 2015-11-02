<?php
if ( ! function_exists( 'wpo_preit' ) ) {
	function wpo_preit( $obj, $echo = true ) {
		if ( $echo ) {
			echo '<pre>' . esc_html( print_r( $obj, true ) ) . '</pre>';
		} else {
			return '<pre>' . esc_html( print_r( $obj, true ) ) . '</pre>';
		}
	}
}

if ( ! function_exists( 'wpo_silent' ) ) {
	function wpo_silent( $obj ) {
		echo '<pre style="display: none;">' . esc_html( print_r( $obj, true ) ) . '</pre>';
	}
}

/**
 * To avoid php notices for missing indexes
 * @param  string  			$key     		the key of the meta
 * @param  array 			$custom  		the entire custom object with get_post_custom
 * @param  boolean 			$all     		whether to include ALL, or just one singular
 * @param  string  			$default 		what the value should be returned in case there's no index like that
 * @return mixed           					whatever the custom holds
 */
if ( ! function_exists( 'wpo_custom' ) ) {
	function wpo_custom( $key, $custom, $all = false, $default = '' ) {
		return is_array( $custom ) ? ( array_key_exists( $key, $custom ) ) ? ( $all ) ? $custom[ $key ] : $custom[ $key ][0] : $default : $default;
	}
}


/*
 * Define Constants for use in theme
 */
if ( ! function_exists( 'wpo_init_constants' ) ) {
	function wpo_init_constants() {
		$theme_mods = get_theme_mods();

		if ( ! defined( 'TEMPLATEURI' ) ) {
			define( 'TEMPLATEURI', trailingslashit( get_stylesheet_directory_uri() ) );
		}

		if ( ! defined( 'HOMEURL' ) ) {
			define( 'HOMEURL', trailingslashit( get_home_url() ) );
		}

		if ( ! defined( 'THEMECOLOR' ) ) {
			if ( ! empty( $theme_mods['wpo_theme_color'] ) ) {
				$meta_color = $theme_mods['wpo_theme_color'];;
			} else {
				$meta_color = '#000000';
			}

			define( 'THEMECOLOR', $meta_color );
		}

		if ( ! defined( 'HEADERCOLOR' ) ) {
			if ( ! empty( $theme_mods['wpo_header_color'] ) ) {
				$meta_color = $theme_mods['wpo_header_color'];
			} else {
				$meta_color = '#000000';
			}

			define( 'HEADERCOLOR', $meta_color );
		}
	}
	add_action( 'init', 'wpo_init_constants' );
}


// Set theme-color meta value
if ( ! function_exists( 'wpo_header_theme_color' ) ) {
	function wpo_header_theme_color() {
		echo '<meta name="theme-color" content="' . esc_attr( THEMECOLOR ) . '">';
	}
	add_action( 'wp_head', 'wpo_header_theme_color' );
}


// This fixes the broken floating wordpress admin menu that you get when window < 600px
if ( ! function_exists( 'wpo_admin_mobile_menu_fix' ) && is_user_logged_in() ) {
	function wpo_admin_mobile_menu_fix() {
		echo '<style>@media (max-width: 600px) { #wpadminbar { position: fixed; } }</style>';
	}
	add_action( 'wp_head', 'wpo_admin_mobile_menu_fix' );
}

/* Removes emoji script and styling that was added in release of WordPress 4.2 */
if ( ! function_exists( 'wpo_remove_emojis' ) ) {
	function wpo_remove_emojis() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	}
	add_action( 'init', 'wpo_remove_emojis' );
}

if ( ! function_exists( 'wpo_add_title_tag' ) ) {
	function wpo_add_title_tag() {
		add_theme_support( 'title-tag' );
	}
	add_action( 'after_setup_theme', 'wpo_add_title_tag' );
}

if ( ! function_exists( 'wpo_remove_wp_version' ) ) {
	function wpo_remove_wp_version() {
		remove_action( 'wp_head', 'wp_generator' );
	}
	add_action( 'init', 'wpo_remove_wp_version' );
}
