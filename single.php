<?php
/**
 * The template for displaying all single posts
 *
 * @package shopping
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto px-4 py-6 lg:py-10">
	<div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
		
		<!-- Cột Nội dung chính -->
		<div class="lg:w-2/3 xl:w-[72%]">
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', get_post_type() );

				the_post_navigation(
					array(
						'prev_text' => '<span class="nav-subtitle text-sm text-gray-500 uppercase tracking-wider">' . esc_html__( 'Bài trước:', 'shopping' ) . '</span> <span class="nav-title block font-bold text-primary mt-1">%title</span>',
						'next_text' => '<span class="nav-subtitle text-sm text-gray-500 uppercase tracking-wider">' . esc_html__( 'Bài sau:', 'shopping' ) . '</span> <span class="nav-title block font-bold text-primary mt-1">%title</span>',
					)
				);

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>
		</div>

		<!-- Cột Tin Tức Liên Quan (Sidebar) -->
		<aside class="lg:w-1/3 xl:w-[28%]">
			<div class="sticky top-28">
				<div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
					<h3 class="text-lg font-heading font-bold text-dark mb-5 flex items-center gap-2 uppercase tracking-wide border-b border-gray-100 pb-3">
						<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
						Tin tức liên quan
					</h3>
					
					<div class="space-y-6">
						<?php
						$categories = get_the_category();
						if ( $categories ) {
							$category_ids = array();
							foreach( $categories as $individual_category ) {
								$category_ids[] = $individual_category->term_id;
							}
							
							$args = array(
								'category__in'     => $category_ids,
								'post__not_in'     => array( get_the_ID() ),
								'posts_per_page'   => 5, // Hiển thị 5 bài
								'ignore_sticky_posts' => 1
							);
							
							$related_query = new WP_Query( $args );
							
							if( $related_query->have_posts() ) {
								while( $related_query->have_posts() ) {
									$related_query->the_post();
									?>
									<article class="group flex gap-3 items-start">
										<a href="<?php the_permalink(); ?>" class="shrink-0 w-20 h-20 rounded-lg overflow-hidden shadow-sm relative">
											<?php if ( has_post_thumbnail() ) : ?>
												<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-500' ) ); ?>
											<?php else: ?>
												<div class="w-full h-full bg-gray-200 flex items-center justify-center">
													<svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
												</div>
											<?php endif; ?>
											<div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors"></div>
										</a>
										<div class="flex-1 min-w-0">
											<h4 class="font-semibold text-sm leading-snug mb-1.5">
												<a href="<?php the_permalink(); ?>" class="text-gray-800 hover:text-primary transition-colors line-clamp-2">
													<?php the_title(); ?>
												</a>
											</h4>
											<div class="text-[12px] text-gray-400 font-medium flex items-center gap-1">
												<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
												<?php echo get_the_date(); ?>
											</div>
										</div>
									</article>
									<?php
								}
								wp_reset_postdata();
							} else {
								echo '<p class="text-sm text-gray-500 italic">Không có tin tức liên quan nào.</p>';
							}
						}
						?>
					</div>
				</div>
			</div>
		</aside>

	</div>
</main><!-- #main -->

<?php
get_footer();
