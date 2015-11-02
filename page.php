<?php get_header(); ?>
<div class="row">
	<div class="large-12 columns">
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();

				the_title( '<h1>', '</h1>' );
				the_content();
				edit_post_link( 'Edit Page', '<p>', '</p>' );
			}
		}
		?>
	</div>
</div>
<?php get_footer();

