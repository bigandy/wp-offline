<?php get_header(); ?>
<div class="row">
	<div class="large-12 columns">
		<?php
		if ( have_posts() ) {
			?>
			<article>
				<?php
				while ( have_posts() ) {
					the_post();
					the_title( '<h1>', '</h1>' );
					?>
					<ul class="list--inline">
						<li>Posted on <time datetime="<?php echo esc_attr( get_the_time( 'c' ) ); ?>"><?php echo the_time( 'd/m/Y' ); ?></time></li>
						<li>By <?php the_author_posts_link(); ?></li>
						<li>In <?php the_category( ', ' ); ?></li>
					</ul>
					<?php
					the_content();
					edit_post_link( 'Edit Post', '<p>', '</p>' );
				}
				?>
			</article>
			<?php
		}
		?>
	</div>
</div>
<?php get_footer();

