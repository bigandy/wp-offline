<?php
function wpo_add_serviceworker_in_root() {
	$urls = '';
	$posts_args = [
		'posts_per_page'	=> -100,
		'post_type'			=> [
			'post',
			'page'
		]
	];

	$posts_loop = new WP_Query( $posts_args );
	if ( $posts_loop->have_posts() ) {
		while ( $posts_loop->have_posts() ) {
			$posts_loop->the_post();
			$urls .= "'" . get_the_permalink() . "',";
		}
	}
	wp_reset_postdata();

	$data = "
importScripts('" . HOMEURL . "cache-polyfill.js');

var cacheName = 'offline-cache-v6';

// https://ponyfoo.com/articles/serviceworker-revolution
self.addEventListener('activate', function activator (event) {
	event.waitUntil(
		caches.keys().then(function (keys) {
			return Promise.all(keys
				.filter(function (key) {
					return key.indexOf(cacheName) !== 0;
				})
				.map(function (key) {
					return caches.delete(key);
				})
			);
		})
	);
});

self.addEventListener('install', function(e) {
  e.waitUntil(
	caches.open(cacheName).then(function(cache) {
	  return cache.addAll([
		'/',
		'" . get_stylesheet_uri() . "',
		'" . HOMEURL . "wp-includes/js/jquery/jquery.js',
		'" . HOMEURL . "wp-includes/js/jquery/jquery-migrate.min.js',
		'" . TEMPLATEURI . "build/js/script.min.js',
		" . $urls . "
	  ]).then(function() {
		return self.skipWaiting();
	  });
	})
  );
});

self.addEventListener('activate', function(event) {
  event.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', function(event) {
  console.log(event.request.url);

  event.respondWith(
	caches.match(event.request).then(function(response) {
	  return response || fetch(event.request);
	})
  );
});
	";

	file_put_contents( 'serviceWorker.js', $data );
}
add_action( 'init', 'wpo_add_serviceworker_in_root' );
