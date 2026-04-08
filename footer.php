	<?php get_template_part( 'template-parts/pre-footer' ); ?>

<footer id="colophon" class="site-footer bg-dark text-gray-300 py-16 mt-auto border-t-[8px] border-primary">
		<div class="container mx-auto px-6">
			<!-- THÔNG TIN CÔNG TY 3EM -->
			<div class="flex flex-col items-center justify-center mb-8 text-center text-sm md:text-base leading-relaxed max-w-4xl mx-auto border-b border-primary/30 pb-8">
				<h3 class="text-2xl font-bold text-[#ffeb3b] mb-6 uppercase tracking-wider">CÔNG TY TNHH BAO BÌ PHỤ GIA THỰC PHẨM 3EM</h3>
				<div class="space-y-4">
					<p><strong class="text-white font-semibold">Trụ sở chính:</strong> 160/49/34 Huỳnh Thị Hai, Phường Tân Chánh Hiệp, Quận 12, Tp. Hồ Chí Minh</p>
					<p><strong class="text-white font-semibold">Chi Nhánh:</strong> An Thổ, Phổ An, Thị Xã Đức Phổ, Quảng Ngãi</p>
				</div>
			</div>

			<!-- THÔNG TIN & CHÍNH SÁCH & NHẬN BẢN TIN -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-10 text-sm md:text-base max-w-5xl mx-auto border-b border-primary/30 pb-10">
				<!-- Cột Thông tin -->
				<div class="text-left">
					<h4 class="text-lg font-bold text-[#ffeb3b] mb-4 uppercase"><?php echo esc_html(get_theme_mod('footer_info_title', 'Thông tin')); ?></h4>
					<div class="text-gray-300 [&>ul>li]:mb-3 [&>ul>li>a:hover]:text-[#ffeb3b] [&>ul>li>a]:transition-colors [&>ul>li>a]:underline-offset-4 [&>ul>li>a:hover]:underline">
						<?php echo wp_kses_post(get_theme_mod('footer_info_content', "<ul><li><a href='#'>Về chúng tôi</a></li><li><a href='#'>Hệ thống chi nhánh</a></li><li><a href='#'>Chất lượng sản phẩm</a></li><li><a href='#'>Tin tức & Sự kiện</a></li></ul>")); ?>
					</div>
				</div>

				<!-- Cột Chính sách (Cột mới) -->
				<div class="text-left">
					<h4 class="text-lg font-bold text-[#ffeb3b] mb-4 uppercase"><?php echo esc_html(get_theme_mod('footer_policy_title', 'CHÍNH SÁCH')); ?></h4>
					<div class="text-gray-300 [&>ul>li]:mb-3 [&>ul>li>a:hover]:text-[#ffeb3b] [&>ul>li>a]:transition-colors [&>ul>li>a]:underline-offset-4 [&>ul>li>a:hover]:underline">
						<?php echo wp_kses_post(get_theme_mod('footer_policy_content', "<ul><li><a href='#'>Chính sách bảo mật</a></li><li><a href='#'>Quy định sử dụng</a></li><li><a href='#'>Thông tin giao hàng</a></li><li><a href='#'>Bảo hành & Đổi trả</a></li></ul>")); ?>
					</div>
				</div>

				<!-- Cột Nhận bản tin -->
				<div class="text-left">
					<h4 class="text-lg font-bold text-[#ffeb3b] mb-4 uppercase"><?php echo esc_html(get_theme_mod('footer_newsletter_title', 'NHẬN BẢN TIN')); ?></h4>
					<p class="mb-4 text-gray-300"><?php echo esc_html(get_theme_mod('footer_newsletter_desc', 'Đăng ký email để nhanh chóng nhận được các thông báo về khuyến mại, chương trình giảm giá của chúng tôi')); ?></p>
					<form action="#" method="post" class="flex mt-2">
						<input type="email" placeholder="Nhập email tại đây..." class="w-full px-4 py-2.5 text-gray-800 rounded-l-md border-none focus:ring-2 focus:ring-[#ffeb3b] outline-none">
						<button type="submit" class="bg-primary hover:bg-primary-hover border border-primary text-white px-5 py-2.5 rounded-r-md font-bold transition-colors">Gửi</button>
					</form>
				</div>
			</div>

			<!-- LINE NGANG VÀ LINK DƯỚI CÙNG -->
			<div class="text-center space-y-6">
				<!-- Footer Links -->
				<?php $footer_links = get_theme_mod('footer_links', 'Hướng dẫn mua online | Chính sách giao hàng | Bảo hành & đổi trả sản phẩm | Chính sách bảo mật | Cam kết chất lượng sản phẩm | Khách hàng chia sẻ'); ?>
				<div class="text-[14px] font-bold text-white uppercase tracking-wide">
					<?php echo wp_kses_post($footer_links); ?>
				</div>

				<!-- Logo Center (Load từ WP nếu có) -->
				<div class="flex justify-center my-6">
					<?php 
					if ( has_custom_logo() ) {
						echo '<div class="brightness-0 invert">';
						the_custom_logo(); 
						echo '</div>';
					} 
					?>
				</div>

				<!-- Bộ Công Thương Badge (Dùng CSS tạo mô phỏng) -->
				<div class="flex justify-center mt-2">
					<div class="px-3 py-1 bg-red-600 rounded-lg border border-white text-white text-xs font-bold flex items-center gap-1.5 shadow-sm opacity-90 hover:opacity-100 transition whitespace-nowrap">
						<svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-1.5H9c-.55 0-1-.45-1-1s.45-1 1-1h3c1.1 0 2-.9 2-2s-.9-2-2-2h-1v-1.5h-2v1.5H7v2h3v1H9c-1.1 0-2 .9-2 2s.9 2 2 2h3v1.5h2v-1.5h1.5v-2H11z"/></svg> 
						ĐÃ ĐĂNG KÝ BỘ CÔNG THƯƠNG
					</div>
				</div>
			</div>

		</div><!-- .container -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
