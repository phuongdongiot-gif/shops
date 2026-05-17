<?php
/**
 * The template for displaying archive pages
 *
 * @package shopping
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto px-4 py-4 md:py-12">

	<?php if ( have_posts() ) : ?>

		<header class="page-header mb-10 border-b border-gray-100 pb-6 text-center">
			<?php
			the_archive_title( '<h1 class="page-title text-3xl md:text-4xl font-heading font-extrabold mb-4 uppercase text-dark tracking-tight">', '</h1>' );
			the_archive_description( '<div class="archive-description text-gray-500 max-w-2xl mx-auto">', '</div>' );
			?>
		</header>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php
			/* Start the Loop */
			$post_count = 0;
			while ( have_posts() ) :
				the_post();
				$post_count++;
				$is_hero = ( $post_count === 1 && ! is_paged() ); // Bài đầu tiên của trang 1 sẽ là Hero

				get_template_part( 'template-parts/content', get_post_type(), array( 'is_hero' => $is_hero ) );

				<!-- Controls -->
				<button id="archive-carousel-prev" aria-label="Previous Slide" class="hidden md:flex absolute top-1/2 left-6 -translate-y-1/2 w-12 h-12 bg-white/20 backdrop-blur-md rounded-full items-center justify-center text-white hover:bg-white hover:text-gray-900 transition-all opacity-0 group-hover:opacity-100 disabled:opacity-50 disabled:cursor-not-allowed">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
				</button>
				<button id="archive-carousel-next" aria-label="Next Slide" class="hidden md:flex absolute top-1/2 right-6 -translate-y-1/2 w-12 h-12 bg-white/20 backdrop-blur-md rounded-full items-center justify-center text-white hover:bg-white hover:text-gray-900 transition-all opacity-0 group-hover:opacity-100 disabled:opacity-50 disabled:cursor-not-allowed">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
				</button>
				
				<!-- Indicators -->
				<div class="absolute bottom-4 md:bottom-6 left-1/2 -translate-x-1/2 flex gap-1.5 md:gap-2" id="archive-carousel-indicators">
					<?php for($i = 0; $i < $carousel_query->post_count; $i++) { ?>
						<button aria-label="Go to slide <?php echo $i; ?>" class="w-2 h-2 md:w-2.5 md:h-2.5 rounded-full bg-white/40 hover:bg-white transition-all duration-300" data-index="<?php echo $i; ?>"></button>
					<?php } ?>
				</div>
			</div>

			<script>
				document.addEventListener('DOMContentLoaded', function() {
					const inner = document.getElementById('archive-carousel-inner');
					if(!inner) return;
					const prev = document.getElementById('archive-carousel-prev');
					const next = document.getElementById('archive-carousel-next');
					const indicators = document.querySelectorAll('#archive-carousel-indicators button');
					let currentIndex = 0;
					const total = inner.children.length;
					let interval;

					function updateIndicators() {
						indicators.forEach((btn, idx) => {
							if(idx === currentIndex) {
								btn.classList.remove('bg-white/40');
								btn.classList.add('bg-white', 'w-4', 'md:w-6');
							} else {
								btn.classList.add('bg-white/40');
								btn.classList.remove('bg-white', 'w-4', 'md:w-6');
							}
						});
					}

					function showSlide(index) {
						if (index < 0) index = total - 1;
						if (index >= total) index = 0;
						currentIndex = index;
						inner.style.transform = `translateX(-${currentIndex * 100}%)`;
						updateIndicators();
					}

					if(prev && next) {
						prev.addEventListener('click', () => { showSlide(currentIndex - 1); resetInterval(); });
						next.addEventListener('click', () => { showSlide(currentIndex + 1); resetInterval(); });
					}
					
					indicators.forEach(btn => {
						btn.addEventListener('click', (e) => {
							showSlide(parseInt(e.target.dataset.index));
							resetInterval();
						});
					});

					// Swipe support for mobile
					let startX = 0;
					let endX = 0;
					inner.addEventListener('touchstart', e => {
						startX = e.changedTouches[0].screenX;
					}, {passive: true});

					inner.addEventListener('touchend', e => {
						endX = e.changedTouches[0].screenX;
						if (startX - endX > 50) {
							showSlide(currentIndex + 1);
							resetInterval();
						} else if (endX - startX > 50) {
							showSlide(currentIndex - 1);
							resetInterval();
						}
					}, {passive: true});

					function startInterval() {
						interval = setInterval(() => { showSlide(currentIndex + 1); }, 5000);
					}
					function resetInterval() {
						clearInterval(interval);
						startInterval();
					}
					
					updateIndicators();
					startInterval();
				});
			</script>
		<?php endif; ?>

		<!-- Collapse Grouped by Categories -->
		<?php
		// Group posts in the current main query by category
		$posts_by_category = array();
		
		while ( have_posts() ) {
			the_post();
			
			$cats = get_the_category();
			$cat_id = 0;
			$cat_name = 'Tin tức khác';
			
			if ( $cats && ! empty( $cats ) ) {
				$cat_id = $cats[0]->term_id;
				$cat_name = $cats[0]->name;
			}
			
			if ( ! isset( $posts_by_category[$cat_id] ) ) {
				$posts_by_category[$cat_id] = array(
					'name' => $cat_name,
					'posts' => array()
				);
			}
			$posts_by_category[$cat_id]['posts'][] = get_post();
		}
		?>

		<div class="space-y-4 md:space-y-6" id="archive-accordion">
			<?php 
			$acc_index = 0;
			foreach ( $posts_by_category as $cat_id => $cat_data ) : 
				$is_first = ($acc_index === 0);
			?>
				<div class="border border-gray-100 rounded-2xl overflow-hidden bg-white shadow-sm transition-all duration-300 group/acc">
					<button class="w-full px-5 py-4 md:px-8 md:py-5 flex items-center justify-between bg-white hover:bg-gray-50 transition-colors focus:outline-none accordion-toggle relative" aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>">
						<div class="flex items-center gap-3">
							<span class="w-1.5 h-6 bg-yellow-400 rounded-full transition-transform duration-300 group-hover/acc:scale-y-110"></span>
							<h2 class="text-lg md:text-xl font-bold text-gray-900 text-left flex items-center gap-2">
								<?php echo esc_html( $cat_data['name'] ); ?>
								<span class="text-xs font-semibold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full border border-gray-200"><?php echo count($cat_data['posts']); ?></span>
							</h2>
						</div>
						<div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center border border-gray-200 shadow-sm shrink-0 transition-colors group-hover/acc:bg-white group-hover/acc:border-yellow-400">
							<svg class="w-4 h-4 text-gray-600 transform transition-transform duration-300 accordion-icon <?php echo $is_first ? 'rotate-180 text-yellow-600' : ''; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
						</div>
					</button>
					<div class="accordion-content grid transition-[grid-template-rows] duration-300 ease-out" style="<?php echo $is_first ? 'grid-template-rows: 1fr;' : 'grid-template-rows: 0fr;'; ?>">
						<div class="overflow-hidden">
							<div class="p-5 md:p-8 bg-gray-50/50 border-t border-gray-100">
								<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
									<?php
									global $post;
									foreach ( $cat_data['posts'] as $post ) {
										setup_postdata( $post );
										get_template_part( 'template-parts/content', get_post_type() );
									}
									wp_reset_postdata();
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php 
			$acc_index++;
			endforeach; 
			?>
		</div>

		<div class="mt-12 flex justify-center">
			<?php
			the_posts_pagination( array(
				'prev_text' => '&laquo; Trước',
				'next_text' => 'Sau &raquo;',
				'class'     => 'pagination-links flex gap-2',
			) );
			?>
		</div>

	<?php else :

		get_template_part( 'template-parts/content', 'none' );

	endif;
	?>

</main><!-- #main -->

<?php
get_footer();
