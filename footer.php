		<?php wp_footer(); ?>
		<?php
		if ( ! is_user_logged_in() ) {
			?>
			<script>
				if('serviceWorker' in navigator) {
					navigator.serviceWorker.register( '<?php echo HOMEURL; ?>serviceWorker.js', { scope: '<?php echo HOMEURL; ?>' })
						.then(function(registration) {
							console.log('Service Worker Registered');
						});

					navigator.serviceWorker.ready.then(function(registration) {
						console.log('Service Worker Ready');
					});
				}
			</script>
			<?php
		}
		?>

	</body>
	</html>
