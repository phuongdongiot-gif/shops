<?php
/**
 * Template part for displaying posts
 *
 * @package shopping
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('mb-10'); ?>>
	<header class="entry-header mb-4">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title text-4xl font-bold mb-2">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title text-2xl font-bold mb-2"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="hover:text-primary">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta text-sm text-gray-500">
				<?php
				$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
				printf( $time_string,
					esc_attr( get_the_date( DATE_W3C ) ),
					esc_html( get_the_date() )
				);
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php get_the_post_thumbnail( null, 'large', array( 'class' => 'w-full h-auto mb-4 rounded' ) ); ?>

	<div class="entry-content text-gray-700 leading-relaxed">
		<?php
		if ( is_singular() ) :
			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'shopping' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
		else :
			the_excerpt();
		endif;

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'shopping' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
