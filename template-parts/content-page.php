<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package shopping
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header mb-6">
		<?php the_title( '<h1 class="entry-title text-4xl font-bold">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<?php get_the_post_thumbnail( null, 'large', array( 'class' => 'w-full h-auto mb-6 rounded' ) ); ?>

	<div class="entry-content text-gray-700 leading-relaxed">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'shopping' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
