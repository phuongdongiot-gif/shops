	<?php get_template_part( 'template-parts/pre-footer' ); ?>

<footer id="colophon" class="site-footer bg-[#431407] text-gray-300 py-16 mt-auto border-t-[8px] border-primary">
		<div class="container mx-auto px-6">
			<!-- HỆ THỐNG CHI NHÁNH (4 CỘT) -->
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-12 text-[12px] leading-relaxed">
				<?php 
				$default_cols = array(
					1 => '<div class="mb-5"><h4 class="font-bold text-[#ffeb3b] mb-1">TRỤ SỞ VMCGROUP</h4><p>311 Điện Biên Phủ - TP Nha Trang</p><p>Call/Zalo 0945 002 568 Tel 0258 3551...</p><p>Email: nt@vmcgroup.com.vn <a href="#" class="text-[#ffeb3b] hover:underline">>> Bản đồ</a></p></div><div class="mb-5"><h4 class="font-bold text-[#ffeb3b] mb-1">VMCGROUP BẮC NINH</h4><p>77 Lê Chân - Khu 2 Đại Phúc - TP Bắc Ninh</p><p>Call/Zalo 093456 2758 Tel 093456 3159</p><p>Email: bn@vmcgroup.com.vn <a href="#" class="text-[#ffeb3b] hover:underline">>> Bản đồ</a></p></div>',
					2 => '<div class="mb-5"><h4 class="font-bold text-[#ffeb3b] mb-1">VMCGROUP CẦU GIẤY</h4><p>Số 2-A26 Ngõ 385 Hoàng Quốc Việt, Hà Nội</p><p>Call/Zalo 093456 5526 Tel 093456 2606</p><p>Email: hanoi@vmcgroup.com.vn <a href="#" class="text-[#ffeb3b] hover:underline">>> Bản đồ</a></p></div><div class="mb-5"><h4 class="font-bold text-[#ffeb3b] mb-1">VMCGROUP HẢI PHÒNG</h4><p>406 Hùng Vương - Quận Hồng Bàng</p><p>Call/Zalo 093456 8012 Tel 0934 561 825</p><p>Email: hp@vmcgroup.com.vn <a href="#" class="text-[#ffeb3b] hover:underline">>> Bản đồ</a></p></div>',
					3 => '<div class="mb-5"><h4 class="font-bold text-[#ffeb3b] mb-1">VMCGROUP THANH TRÌ</h4><p>8 Ngõ 111 Phan Trọng Tuệ, TP Hà Nội</p><p>Call/Zalo 0946 020 868 Tel 0936 089 855</p><p>Email: hn@vmcgroup.com.vn <a href="#" class="text-[#ffeb3b] hover:underline">>> Bản đồ</a></p></div><div class="mb-5"><h4 class="font-bold text-[#ffeb3b] mb-1">VMCGROUP QUẢNG NINH</h4><p>418 Cái Lân - P. Bãi Cháy - Hạ Long</p><p>Call/Zalo 093456 8012 Tel 0906 024 199</p><p>Email: quangninh@vmcgroup.com.vn <a href="#" class="text-[#ffeb3b] hover:underline">>> Bản đồ</a></p></div>',
					4 => '<div class="mb-5"><h4 class="font-bold text-[#ffeb3b] mb-1">VMCGROUP HÀ ĐÔNG</h4><p>Lô DG07-22 KĐT Mậu Lương, Hà Nội</p><p>Call/Zalo 093456 2915 Tel 093456 2950</p><p>Email: hanoi@vmcgroup.com.vn <a href="#" class="text-[#ffeb3b] hover:underline">>> Bản đồ</a></p></div><div class="mb-5"><h4 class="font-bold text-[#ffeb3b] mb-1">VMCGROUP NAM ĐỊNH</h4><p>Xóm 8 - Giao Nhân - Giao Thủy</p><p>Call/Zalo 093456 5160 Tel 0945 517...</p><p>Email: nd@vmcgroup.com.vn <a href="#" class="text-[#ffeb3b] hover:underline">>> Bản đồ</a></p></div>'
				);

				for($i=1; $i<=4; $i++) {
					$col_html = get_theme_mod('footer_col_'.$i, $default_cols[$i]);
					echo '<div>' . wp_kses_post( $col_html ) . '</div>';
				}
				?>
			</div>

			<!-- LINE NGANG VÀ LINK DƯỚI CÙNG -->
			<div class="text-center space-y-6">
				<!-- Footer Links -->
				<?php $footer_links = get_theme_mod('footer_links', 'Hướng dẫn mua online | Chính sách giao hàng | Bảo hành & đổi trả sản phẩm | Chính sách bảo mật | Cam kết chất lượng sản phẩm | Khách hàng chia sẻ'); ?>
				<div class="text-[14px] font-bold text-white border-t border-primary pt-6 uppercase tracking-wide">
					<?php echo wp_kses_post($footer_links); ?>
				</div>

				<!-- Logo Center (Load từ WP nếu có) -->
				<div class="flex justify-center my-6">
					<?php 
					if ( has_custom_logo() ) {
						echo '<div class="brightness-0 invert">';
						the_custom_logo(); 
						echo '</div>';
					} else {
						echo '<h2 class="text-3xl text-white font-heading font-bold">VMC GROUP</h2>';
					}
					?>
				</div>

				<!-- Company Name -->
				<?php $footer_company = get_theme_mod('footer_company', 'CÔNG TY PHỤ GIA VIỆT MỸ'); ?>
				<div class="text-[13px] font-bold text-white uppercase tracking-wider">
					<?php echo esc_html($footer_company); ?>
				</div>

				<!-- Bộ Công Thương Badge (Dùng CSS tạo mô phỏng) -->
				<div class="flex justify-center mt-4">
					<div class="px-3 py-1 bg-red-600 rounded-lg border border-white text-white text-xs font-bold flex items-center gap-1.5 shadow-sm transform scale-90 opacity-90 hover:opacity-100 transition whitespace-nowrap">
						<svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-1.5H9c-.55 0-1-.45-1-1s.45-1 1-1h3c1.1 0 2-.9 2-2s-.9-2-2-2h-1v-1.5h-2v1.5H7v2h3v1H9c-1.1 0-2 .9-2 2s.9 2 2 2h3v1.5h2v-1.5h1.5v-2H11z"/></svg> 
						ĐÃ ĐĂNG KÝ BỘ CÔNG THƯƠNG
					</div>
				</div>

				<!-- Slogan Đỏ -->
				<?php $footer_slogan = get_theme_mod('footer_slogan', 'DẪN ĐẦU TRONG LĨNH VỰC HÓA CHẤT, THIẾT BỊ CÔNG NGHIỆP & SẢN PHẨM LIÊN QUAN'); ?>
				<div class="text-[12px] font-bold text-red-500 uppercase tracking-widest mt-6">
					<?php echo esc_html($footer_slogan); ?>
				</div>
			</div>

		</div><!-- .container -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
