<?php
/**
 * The main template file
 */

get_header();
?>

	<main id="primary" class="site-main flex-1 container mx-auto px-6 py-12 lg:py-20">
		<div class="max-w-4xl mx-auto">

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) :
				?>
				<header class="mb-12">
					<h1 class="page-title text-4xl font-heading font-bold text-dark"><?php single_post_title(); ?></h1>
				</header>
				<?php
			endif;

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('mb-16 bg-white p-8 rounded-2xl shadow-sm border border-gray-100'); ?>>
					<div class="space-y-6">
						<header class="entry-header">
							<?php
							if ( is_singular() ) :
								the_title( '<h1 class="entry-title text-3xl font-heading font-bold text-dark">', '</h1>' );
							else :
								the_title( '<h2 class="entry-title text-3xl font-heading font-bold text-dark hover:text-primary transition-colors"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
							endif;
							?>
						</header><!-- .entry-header -->
						<div class="entry-content prose prose-lg prose-indigo max-w-none text-body">
							<?php
							the_content(
								sprintf(
									wp_kses(
										/* translators: %s: Name of current post. Only visible to screen readers */
										__( 'Continue reading<span class="sr-only"> "%s"</span>', 'shopping' ),
										array(
											'span' => array(
												'class' => array(),
											),
										)
									),
									wp_kses_post( get_the_title() )
								)
							);
							?>
						</div><!-- .entry-content -->
					</div>
				</article><!-- #post-<?php the_ID(); ?> -->
				<?php

			endwhile;

			the_posts_navigation(array(
                'prev_text' => '<span class="px-4 py-2 bg-secondary text-primary rounded-md font-semibold hover:bg-primary hover:text-white transition-colors">&larr; Older posts</span>',
                'next_text' => '<span class="px-4 py-2 bg-secondary text-primary rounded-md font-semibold hover:bg-primary hover:text-white transition-colors">Newer posts &rarr;</span>'
            ));

		else :
			?>
			<section class="no-results not-found bg-white p-12 rounded-2xl shadow-sm border border-gray-100 text-center">
				<header class="page-header mb-6">
					<h1 class="page-title text-3xl font-heading font-bold text-dark"><?php esc_html_e( 'Nothing Found', 'shopping' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p class="text-body text-lg mb-8"><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'shopping' ); ?></p>
					<div class="max-w-md mx-auto">
                        <?php get_search_form(); ?>
                    </div>
				</div><!-- .page-content -->
			</section><!-- .no-results -->
			<?php
		endif;
		?>

		</div><!-- .max-w-4xl -->
	</main><!-- #primary -->

<?php
get_footer();
