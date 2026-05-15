<?php
/**
 * Template part for displaying posts
 *
 * @package shopping
 */

$is_hero = isset( $args['is_hero'] ) ? $args['is_hero'] : false;

// Nếu là trang chi tiết (Single post) thì vẫn giữ layout đọc báo
if ( is_singular() ) :
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('mb-10'); ?>>
	<header class="entry-header mb-6">
		<?php the_title( '<h1 class="entry-title text-3xl md:text-4xl font-heading font-extrabold mb-3 text-dark leading-tight">', '</h1>' ); ?>
		
		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta flex flex-wrap items-center gap-4 text-[13px] text-gray-500 font-medium mb-6 pb-6 border-b border-gray-100">
				<!-- Author -->
				<span class="flex items-center gap-1.5">
					<svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
					<?php the_author(); ?>
				</span>
				
				<!-- Date -->
				<?php
				$time_string = '<time class="entry-date published updated flex items-center gap-1.5" datetime="%1$s"><svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>%2$s</time>';
				printf( $time_string, esc_attr( get_the_date( DATE_W3C ) ), esc_html( get_the_date() ) );
				?>
				
				<!-- Categories -->
				<span class="flex items-center gap-1.5">
					<svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
					<?php the_category( ', ' ); ?>
				</span>
			</div>
		<?php endif; ?>
	</header>

	<?php get_the_post_thumbnail( null, 'large', array( 'class' => 'w-full h-auto mb-8 rounded-xl shadow-sm' ) ); ?>

	<div class="entry-content text-gray-800 leading-relaxed text-[16px] md:text-[17px]">
		<?php
		the_content();
		wp_link_pages( array( 'before' => '<div class="page-links mt-6 font-bold">' . esc_html__( 'Pages:', 'shopping' ), 'after'  => '</div>' ) );
		?>
	</div>

	<footer class="entry-footer mt-10 pt-6 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
		<div class="post-tags flex items-center gap-2 flex-wrap">
			<?php if ( has_tag() ) : ?>
				<span class="text-sm font-bold text-gray-700">Tags:</span>
				<?php the_tags( '<span class="bg-gray-50 text-gray-600 px-3 py-1 text-[13px] rounded-md border border-gray-100 hover:text-primary transition-colors">', '</span><span class="bg-gray-50 text-gray-600 px-3 py-1 text-[13px] rounded-md border border-gray-100 hover:text-primary transition-colors">', '</span>' ); ?>
			<?php endif; ?>
		</div>
		
		<div class="social-share flex items-center gap-3">
			<span class="text-sm font-bold text-gray-700">Chia sẻ:</span>
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-colors shadow-sm" title="Chia sẻ Facebook">
				<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.77,7.46H14.5v-1.9c0-.9.6-1.1,1-1.1h3V.5h-4.33C10.24.5,9.5,3.44,9.5,5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4Z"/></svg>
			</a>
			<a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="w-8 h-8 flex items-center justify-center rounded-full bg-sky-500 text-white hover:bg-sky-600 transition-colors shadow-sm" title="Chia sẻ Twitter">
				<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.954 4.569c-.885.389-1.83.654-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.896-.959-2.173-1.559-3.591-1.559-2.717 0-4.92 2.203-4.92 4.917 0 .39.045.765.127 1.124C7.691 8.094 4.066 6.13 1.64 3.161c-.427.722-.666 1.561-.666 2.475 0 1.71.87 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.39 0-.779-.023-1.17-.067 2.189 1.394 4.768 2.209 7.557 2.209 9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63.961-.689 1.8-1.56 2.46-2.548l-.047-.02z"/></svg>
			</a>
		</div>
	</footer>
</article>

<?php else : // NẾU LÀ TRANG ARCHIVE / DANH SÁCH ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 flex flex-col group h-full transform hover:-translate-y-1', $is_hero ? 'md:col-span-2 lg:col-span-3 lg:flex-row' : '' ) ); ?>>
	
	<!-- Hình ảnh đại diện -->
	<div class="relative overflow-hidden w-full shrink-0 <?php echo $is_hero ? 'lg:w-[60%] aspect-[16/9] lg:aspect-auto' : 'aspect-[4/3] border-b border-gray-50'; ?>">
		<a href="<?php echo esc_url( get_permalink() ); ?>" class="block w-full h-full">
			<?php 
			if ( has_post_thumbnail() ) {
				$image_size = $is_hero ? 'full' : 'medium_large';
				the_post_thumbnail( $image_size, array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out' ) );
			} else {
				echo '<div class="w-full h-full bg-gray-50 flex items-center justify-center text-gray-400 text-xs">Không có ảnh</div>';
			}
			?>
			<div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
		</a>
		
		<!-- Category Badge -->
		<?php
		$categories = get_the_category();
		if ( ! empty( $categories ) ) {
			echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" class="absolute top-4 left-4 bg-primary text-white text-[11px] font-bold uppercase px-3 py-1.5 rounded-md shadow-sm hover:bg-primary-hover">' . esc_html( $categories[0]->name ) . '</a>';
		}
		?>
	</div>
	
	<!-- Nội dung text -->
	<div class="p-6 flex flex-col flex-1 bg-white relative z-10 <?php echo $is_hero ? 'lg:justify-center' : ''; ?>">
		<div class="text-[12px] text-gray-400 font-semibold mb-3 flex items-center gap-1.5 uppercase tracking-wider">
			<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
			<?php echo get_the_date(); ?>
		</div>
		
		<h2 class="entry-title font-heading font-extrabold mb-3 leading-snug <?php echo $is_hero ? 'text-[24px] md:text-[32px] line-clamp-3' : 'text-[18px] line-clamp-2'; ?>">
			<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark" class="text-dark hover:text-primary transition-colors"><?php the_title(); ?></a>
		</h2>
		
		<div class="text-[14px] text-gray-500 mb-5 leading-relaxed <?php echo $is_hero ? 'line-clamp-4' : 'line-clamp-3'; ?> flex-1">
			<?php echo wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), $is_hero ? 40 : 20, '...' ); ?>
		</div>
		
		<div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="text-primary font-bold text-[13px] hover:text-primary-hover inline-flex items-center gap-1.5 uppercase tracking-wider">
				Xem Chi Tiết
				<svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
			</a>
		</div>
	</div>

</article>

<?php endif; ?>
