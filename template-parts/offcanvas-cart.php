<?php
/**
 * Off-canvas Cart Panel
 */
if ( ! class_exists( 'WooCommerce' ) ) {
    return;
}
?>

<!-- Khung tối phủ nền (Overlay) -->
<div id="shopping-cart-overlay" class="fixed inset-0 bg-black/60 z-[100] hidden opacity-0 transition-opacity duration-300 backdrop-blur-sm cursor-pointer"></div>

<!-- Thanh trượt Giỏ hàng Panel -->
<div id="shopping-cart-panel" class="fixed right-0 top-0 h-full w-full sm:w-[400px] bg-white shadow-2xl z-[101] transform translate-x-full transition-transform duration-400 ease-out flex flex-col">
    
    <!-- Tiêu đề Header của Panel -->
    <div class="flex items-center justify-between p-5 border-b border-gray-100 bg-gray-50">
        <h3 class="text-lg font-bold text-dark font-heading m-0 flex items-center gap-2">
            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <?php esc_html_e( 'Danh sách tư vấn', 'shopping' ); ?>
        </h3>
        <button id="close-cart-panel" class="text-gray-400 hover:text-red-500 hover:bg-red-50 transition w-8 h-8 flex items-center justify-center rounded-full" aria-label="Đóng">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Nội dung Mini Cart (WooCommerce AJAX target) -->
    <div class="flex-1 overflow-y-auto px-5 py-6">
        <div class="widget_shopping_cart_content">
            <?php woocommerce_mini_cart(); ?>
        </div>
    </div>
</div>

<style>
/* Tuỳ chỉnh lại giao diện widget mini cart của Woo */
#shopping-cart-panel .woocommerce-mini-cart { padding: 0; margin: 0; list-style: none; }
#shopping-cart-panel .woocommerce-mini-cart-item { padding: 15px 0; border-bottom: 1px solid #f3f4f6; display: flex; align-items: flex-start; gap: 15px; position: relative; }
#shopping-cart-panel .woocommerce-mini-cart-item:last-child { border-bottom: none; }
#shopping-cart-panel .woocommerce-mini-cart-item img { width: 64px; height: 64px; object-fit: cover; border-radius: 8px; border: 1px solid #e5e7eb; }
#shopping-cart-panel .woocommerce-mini-cart-item a.remove { position: absolute; right: 0; top: 15px; color: #ef4444!important; font-size: 20px; font-weight: normal; width: 24px; height: 24px; line-height: 20px; text-align: center; border-radius: 50%; opacity: 0.6; }
#shopping-cart-panel .woocommerce-mini-cart-item a.remove:hover { opacity: 1; background: #fee2e2; }
#shopping-cart-panel .woocommerce-mini-cart-item .quantity { display: none !important; } /* Triệt tiêu số lượng */
#shopping-cart-panel .woocommerce-mini-cart-item > a:not(.remove) { font-weight: 600; color: #1f2937; padding-right: 25px; line-height: 1.4; display: block; }
#shopping-cart-panel .woocommerce-mini-cart-item > a:not(.remove):hover { color: #ea580c; }
#shopping-cart-panel .woocommerce-mini-cart__total, #shopping-cart-panel .woocommerce-mini-cart__total.total { display: none !important; } /* Ẩn giá tạm tính */
#shopping-cart-panel .woocommerce-mini-cart__buttons { border-top: 1px solid #e5e7eb; padding-top: 20px; margin-top: 20px; display: flex; flex-direction: column; gap: 10px; }
#shopping-cart-panel .woocommerce-mini-cart__buttons a { display: block; text-align: center; padding: 12px 0; border-radius: 8px; font-weight: 600; text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px; }
#shopping-cart-panel .woocommerce-mini-cart__buttons a:not(.checkout) { display: none !important; } /* Ẩn nút xem giỏ hàng lẻ loi */
#shopping-cart-panel .woocommerce-mini-cart__buttons .checkout { background-color: #ea580c; color: white; display: flex !important; align-items: center; justify-content: center; }
#shopping-cart-panel .woocommerce-mini-cart__buttons .checkout:hover { background-color: #c2410c; }
#shopping-cart-panel .woocommerce-mini-cart__empty-message { text-align: center; color: #6b7280; padding: 40px 0; font-style: italic; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const triggerBtn = document.getElementById('shopping-cart-trigger'); // sẽ được gắn vào thẻ A trên header
    const closeBtn = document.getElementById('close-cart-panel');
    const overlay = document.getElementById('shopping-cart-overlay');
    const panel = document.getElementById('shopping-cart-panel');

    function openCartPanel() {
        overlay.classList.remove('hidden');
        // Kích hoạt transition
        setTimeout(() => {
            overlay.classList.remove('opacity-0');
            panel.classList.remove('translate-x-full');
        }, 10);
        document.body.style.overflow = 'hidden'; // Khoá cuộn trang
    }

    function closeCartPanel() {
        overlay.classList.add('opacity-0');
        panel.classList.add('translate-x-full');
        document.body.style.overflow = '';
        setTimeout(() => {
            overlay.classList.add('hidden');
        }, 300); // 300ms khớp div duration
    }

    if (triggerBtn) {
        triggerBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openCartPanel();
        });
    }
    
    // Tự động mở khi bấm thêm vào giỏ hàng AJAX thành công
    jQuery(document.body).on('added_to_cart', function() {
        openCartPanel();
    });

    closeBtn.addEventListener('click', closeCartPanel);
    overlay.addEventListener('click', closeCartPanel);
});
</script>
