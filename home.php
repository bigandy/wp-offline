<?php get_header(); ?>
<div class="row">
	<div class="large-12 columns">
		<?php
		if ( have_posts() ) {
			?>
			<section>
				<h1>Blog</h1>
				<?php
				while ( have_posts() ) {
					the_post();
					$permalink = get_permalink();
					?>
					<article>
						<a href="<?php echo esc_url( $permalink ); ?>">
							<?php the_title( '<h2>', '</h2>' ); ?>
						</a>
						<ul class="list--inline">
							<li>Posted on <time datetime="<?php echo esc_attr( get_the_time( 'c' ) ); ?>"><?php echo the_time( 'd/m/Y' ); ?></time></li>
							<li>By <?php the_author_posts_link(); ?></li>
							<li>In <?php the_category( ', ' ); ?></li>
						</ul>
						<?php
						the_excerpt();

						?>
					</article>
					<?php
				}
				?>
			</section>
			<?php
		}
		?>
	</div>
</div>
<?php get_footer();

