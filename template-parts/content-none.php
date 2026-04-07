<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package shopping
 */

?>

<section class="no-results not-found">
	<header class="page-header mb-6">
		<h1 class="page-title text-3xl font-bold"><?php esc_html_e( 'Nothing Found', 'shopping' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content text-gray-700">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :

			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'shopping' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);

		elseif ( is_search() ) :
			?>

			<p class="mb-6"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'shopping' ); ?></p>
			<?php
			get_search_form();

		else :
			?>

			<p class="mb-6"><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'shopping' ); ?></p>
			<?php
			get_search_form();

		endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
