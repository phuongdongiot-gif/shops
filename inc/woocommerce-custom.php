<?php
/**
 * WooCommerce Custom Adjustments
 */

// =========================================================
// WOOCOMMERCE: THAY ĐỔI NGÔN TỪ ĐỂ TRÁNH QUY ĐỊNH BỘ CÔNG THƯƠNG
// =========================================================
add_filter( 'gettext', 'shopping_change_woocommerce_strings', 20, 3 );
function shopping_change_woocommerce_strings( $translated_text, $text, $domain ) {
    if ( ! is_admin() && in_array( $domain, array( 'woocommerce', 'shopping' ) ) ) {
        switch ( $translated_text ) {
            case 'Thêm vào giỏ hàng':
            case 'Thêm vào giỏ':
            case 'Add to cart':
                $translated_text = 'Thêm vào danh sách tư vấn';
                break;
            case 'Xem giỏ hàng':
            case 'View cart':
                $translated_text = 'Xem danh sách';
                break;
            case 'Giỏ hàng':
            case 'Cart':
            case 'cart':
                $translated_text = 'Danh sách tư vấn';
                break;
            case 'Thanh toán':
            case 'Tiến hành thanh toán':
            case 'Proceed to checkout':
            case 'Checkout':
            case 'checkout':
                $translated_text = 'Gửi yêu cầu tư vấn';
                break;
            case 'Chi tiết thanh toán':
            case 'Billing details':
                $translated_text = 'Thông tin của bạn';
                break;
            case 'Đặt hàng':
            case 'Đặt hàng ngay':
            case 'Place order':
                $translated_text = 'Gửi yêu cầu ngay';
                break;
            case 'Cộng giỏ hàng':
            case 'Tổng giỏ hàng':
            case 'Cart totals':
                $translated_text = 'Tổng (Tạm tính)';
                break;
            case 'Đơn hàng của bạn':
            case 'Your order':
                $translated_text = 'Danh sách cần tư vấn';
                break;
            case 'Đơn hàng':
            case 'Order':
                $translated_text = 'Yêu cầu tư vấn';
                break;
            case 'Đơn hàng #':
            case 'Order #':
                $translated_text = 'Yêu cầu #';
                break;
            case 'Chi tiết đơn hàng':
            case 'Order details':
                $translated_text = 'Chi tiết yêu cầu';
                break;
            case 'Order summary':
            case 'Tóm tắt đơn hàng':
                $translated_text = 'Danh sách đã chọn';
                break;
            case 'Thank you. Your order has been received.':
            case 'Cảm ơn bạn. Đơn hàng của bạn đã được nhận.':
                $translated_text = 'Cảm ơn bạn. Yêu cầu tư vấn của bạn đã được tiếp nhận và chúng tôi sẽ liên hệ sớm nhất.';
                break;
            case 'Mã đơn hàng':
            case 'Order number':
                $translated_text = 'Mã yêu cầu';
                break;
            case 'Cập nhật giỏ hàng':
            case 'Update cart':
                $translated_text = 'Cập nhật danh sách';
                break;
            case 'Quay lại cửa hàng':
            case 'Return to shop':
                $translated_text = 'Quay lại danh mục';
                break;
            case 'Số lượng':
            case 'Quantity':
                $translated_text = '';
                break;
            case 'Tổng':
            case 'Tổng cộng':
            case 'Total':
                $translated_text = '';
                break;
        }
    }
    return $translated_text;
}

// Lọc cả tiêu đề trang (Giỏ hàng -> Danh sách tư vấn, Thanh toán -> Gửi yêu cầu tư vấn)
add_filter( 'the_title', 'shopping_change_page_titles', 10, 2 );
function shopping_change_page_titles( $title, $id = null ) {
    if ( ! is_admin() ) {
        if ( $title === 'Giỏ hàng' || $title === 'Cart' ) {
            return 'Danh sách tư vấn';
        }
        if ( $title === 'Thanh toán' || $title === 'Checkout' ) {
            return 'Gửi yêu cầu tư vấn';
        }
    }
    return $title;
}

// Thay thế trực tiếp text từ khoá trên các Breadcrumbs / Elementor / menu
add_filter( 'the_content', 'shopping_scrub_ecommerce_words', 99 );
function shopping_scrub_ecommerce_words( $content ) {
    if ( ! is_admin() ) {
        $content = str_ireplace( 'Giỏ hàng', 'Danh sách tư vấn', $content );
        $content = str_ireplace( 'Tiến hành thanh toán', 'Gửi yêu cầu tư vấn', $content );
    }
    return $content;
}

// Bắt buộc tất cả sản phẩm chỉ được bán số lượng 1 (Ẩn chọn số lượng ở mọi nơi, ngăn chặn hiểu lầm là mua buôn/bán lẻ số lượng lớn)
add_filter( 'woocommerce_is_sold_individually', '__return_true' );

// Ẩn thông báo "Bạn chi có thể thêm 1 sản phẩm..." nếu click nhiều lần, chuyển thành thông báo nhẹ nhàng
add_filter( 'woocommerce_cart_product_cannot_add_another_message', 'shopping_custom_cannot_add_message', 10, 2 );
function shopping_custom_cannot_add_message( $message, $product_data ) {
    return 'Sản phẩm này đã có trong danh sách tư vấn của bạn.';
}

// Cấu hình CSS triệt tiêu giá và số lượng liên quan đến Tư Vấn
add_action( 'wp_head', 'shopping_hide_checkout_elements', 999 );
function shopping_hide_checkout_elements() {
    echo '<style>
        /* Ẩn chữ Ghi chú đơn hàng (tuỳ chọn) */
        .woocommerce-additional-fields h3 { display: none; }
            /* Cột sản phẩm - nhấn mạnh nội dung gửi yêu cầu */
            .woocommerce-checkout h3[id="order_review_heading"] { font-size: 0; }
            .woocommerce-checkout h3[id="order_review_heading"]::after { content: "Danh sách cần tư vấn"; font-size: 1.5rem; display: block; }
            /* ========= TÙY CHỈNH GIỎ HÀNG & THANH TOÁN KHÔNG XUẤT HIỆN GIÁ, SỐ LƯỢNG ========= */
            /* Triệt tiêu giá và tổng ở chuẩn Shortcode cũ */
            .woocommerce-cart table.cart th.product-price,
            .woocommerce-cart table.cart td.product-price,
            .woocommerce-cart table.cart th.product-subtotal,
            .woocommerce-cart table.cart td.product-subtotal,
            .woocommerce-cart .product-subtotal,
            .woocommerce-cart .product-price,
            .woocommerce-cart .amount,
            .woocommerce-cart .cart_totals table,
            .woocommerce-cart .cart_totals h2,
            
            /* Triệt tiêu ô số lượng */
            .product-quantity,
            .quantity,
            .woocommerce-cart table.cart th.product-quantity,
            .woocommerce-cart table.cart td.product-quantity,
            .woocommerce-checkout table.shop_table .product-quantity,
            
            .woocommerce-checkout table.shop_table thead th.product-total,
            .woocommerce-checkout table.shop_table tfoot,
            .woocommerce-checkout table.shop_table td.product-total,
            .woocommerce-checkout .woocommerce-checkout-review-order-table tfoot,
            .woocommerce-checkout .amount,
            .woocommerce-checkout .product-total {
                display: none !important;
            }
            .woocommerce-cart-form__cart-item dl.variation { display: none !important; }
            .cart_totals { width: 100% !important; border:none !important; }
            .cart-collaterals .cart_totals .wc-proceed-to-checkout { border-top: none !important; padding-top: 0 !important; margin-top: 0 !important; }
            
            /* GIAO DIỆN WOOCOMMERCE BLOCKS (Phiên bản mới) Cart & Checkout */
            .wc-block-cart-item__price, 
            .wc-block-cart-item__total,
            .wc-block-components-quantity-selector,
            .wc-block-components-product-price,
            .wc-block-components-totals-item,
            .wc-block-cart__totals-title,
            .wc-block-components-totals-coupon,
            .wc-block-components-totals-discount,
            .wc-block-components-totals-shipping,
            .wc-block-components-order-summary-item__total,
            .wc-block-components-totals-wrapper {
                display: none !important;
            }
            .wc-block-cart-item__wrap .wc-block-components-product-details {
                margin-bottom: 0 !important;
            }
            /* Căn giữa nút Checkout của WC Blocks */
            .wc-block-cart__submit-container {
                margin-top: 10px !important;
            }
        </style>';
}

// Chèn JS mạnh để đối phó với WooCommerce Blocks tải chữ bằng Javascript
add_action( 'wp_footer', 'shopping_force_rename_wc_words', 999 );
function shopping_force_rename_wc_words() {
    if ( is_cart() || is_checkout() || is_shop() || is_product() || is_product_category() || is_front_page() ) {
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            function replaceWooCommerceText(node) {
                if (node.nodeType === Node.TEXT_NODE) {
                    let txt = node.textContent;
                    let originalTxt = txt;
                    txt = txt.replace(/Giỏ hàng/g, 'Danh sách tư vấn')
                             .replace(/giỏ hàng/g, 'danh sách tư vấn')
                             .replace(/Tiến hành thanh toán/g, 'Gửi yêu cầu tư vấn')
                             .replace(/Thanh toán/g, 'Nhập thông tin yêu cầu')
                             .replace(/thanh toán/g, 'nhập thông tin yêu cầu')
                             .replace(/Đơn hàng /g, 'Yêu cầu ')
                             .replace(/đơn hàng /g, 'yêu cầu ')
                             .replace(/Đơn hàng/g, 'Yêu cầu tư vấn')
                             .replace(/đơn hàng/g, 'yêu cầu tư vấn')
                             .replace(/Đặt hàng /g, 'Gửi yêu cầu ')
                             .replace(/đặt hàng /g, 'gửi yêu cầu ')
                             .replace(/Đặt hàng/g, 'Gửi yêu cầu')
                             .replace(/đặt hàng/g, 'gửi yêu cầu')
                             .replace(/Tóm tắt yêu cầu tư vấn/gi, 'Danh sách đã chọn')
                             .replace(/Tóm tắt yêu cầu/gi, 'Danh sách đã chọn');
                    
                    if (txt !== originalTxt) {
                        node.textContent = txt;
                    }
                } else if (node.nodeType === Node.ELEMENT_NODE) {
                    // Ignore scripts and styles
                    if (node.tagName.toLowerCase() === 'script' || node.tagName.toLowerCase() === 'style') {
                        return;
                    }
                    if (node.tagName.toLowerCase() === 'input' && (node.type === 'button' || node.type === 'submit')) {
                        if (node.value.includes('Giỏ hàng')) node.value = node.value.replace(/Giỏ hàng/gi, 'Danh sách tư vấn');
                        if (node.value.includes('Thanh toán')) node.value = node.value.replace(/Thanh toán/gi, 'Gửi yêu cầu tư vấn');
                    }
                    for (let child of node.childNodes) {
                        replaceWooCommerceText(child);
                    }
                }
            }

            // Quét 1 lần đầu tiên
            replaceWooCommerceText(document.body);

            // Cắm MutationObserver để quét nếu WooCommerce Blocks re-render bằng React
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    mutation.addedNodes.forEach((addedNode) => {
                        replaceWooCommerceText(addedNode);
                    });
                });
            });

            observer.observe(document.body, { childList: true, subtree: true });
            
            // Xoá thêm các element nếu CSS bị đè
            setTimeout(()=>{
                document.querySelectorAll('.wc-block-components-quantity-selector, .quantity').forEach(el => el.style.display = 'none');
            }, 1000);
        });
        </script>
        <?php
    }
}
