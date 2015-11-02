<?php
get_header();
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

if ( is_category() ) {
	$title = single_cat_title( 'Posts in Category ', false );
} elseif ( is_author() ) {
	$title = 'Posts by ' . get_the_author();
} else {
	$title = get_the_title();
}
?>
<div class="row">
	<div class="large-12 columns">
		<?php
		if ( have_posts() ) {
			?>
			<section>
				<h1><?php echo $title; ?></h1>
				<?php


				while ( have_posts() ) {
					the_post();
					$permalink = get_permalink();

					$cat_list_args = array(
						'style' 	=> 'list',
						'title_li' 	=> false,
						'exclude'	=> '1', // exclude 'uncategoried' category
					);
					?>
					<article>
						<a href="<?php echo esc_url( $permalink ); ?>">
							<?php the_title( '<h2>', '</h2>' ); ?>
						</a>
						<ul class="list--inline article__meta">
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

