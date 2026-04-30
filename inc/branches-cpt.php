<?php
/**
 * Register Branch (Chi nhánh) Custom Post Type & Meta Boxes
 */

function shopping_register_branches_cpt() {
    $labels = array(
        'name'                  => _x( 'Hệ Thống Chi Nhánh', 'Post Type General Name', 'shopping' ),
        'singular_name'         => _x( 'Chi Nhánh', 'Post Type Singular Name', 'shopping' ),
        'menu_name'             => __( '📌 Chi Nhánh', 'shopping' ),
        'name_admin_bar'        => __( 'Chi Nhánh', 'shopping' ),
        'add_new'               => __( 'Thêm Chi Nhánh Khác', 'shopping' ),
        'add_new_item'          => __( 'Thêm Chi Nhánh Mới', 'shopping' ),
        'new_item'              => __( 'Chi Nhánh Mới', 'shopping' ),
        'edit_item'             => __( 'Sửa Chi Nhánh', 'shopping' ),
        'view_item'             => __( 'Xem Chi Nhánh', 'shopping' ),
        'all_items'             => __( 'Tất cả Chi Nhánh', 'shopping' ),
        'search_items'          => __( 'Tìm Chi Nhánh', 'shopping' ),
        'not_found'             => __( 'Không tìm thấy chi nhánh nào.', 'shopping' ),
    );
    $args = array(
        'label'                 => __( 'Chi Nhánh', 'shopping' ),
        'description'           => __( 'Quản lý thông tin chi nhánh công ty', 'shopping' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'thumbnail' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-location',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'branch', $args );
}
add_action( 'init', 'shopping_register_branches_cpt', 0 );

/**
 * Register Meta Boxes for Branch
 */
function shopping_add_branch_meta_boxes() {
    add_meta_box(
        'branch_info_meta_box', // ID
        'Thông tin Chi Nhánh (Bản Đồ, Liên Hệ)', // Title
        'shopping_branch_meta_box_callback', // Callback
        'branch', // Screen
        'normal', // Context
        'high' // Priority
    );
}
add_action( 'add_meta_boxes', 'shopping_add_branch_meta_boxes' );

/**
 * Render Meta Box content
 */
function shopping_branch_meta_box_callback( $post ) {
    // Thêm nonce để bảo mật
    wp_nonce_field( 'shopping_save_branch_meta_box_data', 'shopping_branch_meta_box_nonce' );

    $address = get_post_meta( $post->ID, '_branch_address', true );
    $phone = get_post_meta( $post->ID, '_branch_phone', true );
    $email = get_post_meta( $post->ID, '_branch_email', true );
    $map_iframe = get_post_meta( $post->ID, '_branch_map_iframe', true );

    echo '<table class="form-table">';
    echo '<tr>';
        echo '<th><label for="branch_address">Địa chỉ chi nhánh</label></th>';
        echo '<td><input type="text" id="branch_address" name="branch_address" value="' . esc_attr( $address ) . '" style="width:100%;" placeholder="VD: 123 Lê Lợi, Phường Bến Thành, Quận 1, TPHCM" /></td>';
    echo '</tr>';

    echo '<tr>';
        echo '<th><label for="branch_phone">Số điện thoại / Hotline</label></th>';
        echo '<td><input type="text" id="branch_phone" name="branch_phone" value="' . esc_attr( $phone ) . '" style="width:100%;" placeholder="VD: 0909.123.456" /></td>';
    echo '</tr>';

    echo '<tr>';
        echo '<th><label for="branch_email">Email liên hệ</label></th>';
        echo '<td><input type="email" id="branch_email" name="branch_email" value="' . esc_attr( $email ) . '" style="width:100%;" placeholder="VD: lienhe@congty.com" /></td>';
    echo '</tr>';

    echo '<tr>';
        echo '<th><label for="branch_map_iframe">Mã nhúng Bản đồ (Google Maps Iframe)</label><br><small>Cách lấy: Vào Google Map > Chia sẻ > Nhúng bản đồ > Copy HTML paste vào đây</small></th>';
        echo '<td><textarea id="branch_map_iframe" name="branch_map_iframe" style="width:100%; height:100px;" placeholder="<iframe src=\'...\' width=\'600\' height=\'450\' ...></iframe>">' . esc_textarea( $map_iframe ) . '</textarea></td>';
    echo '</tr>';
    
    echo '</table>';
}

/**
 * Save Meta Box data
 */
function shopping_save_branch_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['shopping_branch_meta_box_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['shopping_branch_meta_box_nonce'], 'shopping_save_branch_meta_box_data' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Địa chỉ
    if ( isset( $_POST['branch_address'] ) ) {
        update_post_meta( $post_id, '_branch_address', sanitize_text_field( $_POST['branch_address'] ) );
    }

    // Điện thoại
    if ( isset( $_POST['branch_phone'] ) ) {
        update_post_meta( $post_id, '_branch_phone', sanitize_text_field( $_POST['branch_phone'] ) );
    }

    // Email
    if ( isset( $_POST['branch_email'] ) ) {
        update_post_meta( $post_id, '_branch_email', sanitize_email( $_POST['branch_email'] ) );
    }

    // Map Iframe (Cần kses để giữ lại thẻ iframe)
    if ( isset( $_POST['branch_map_iframe'] ) ) {
        $iframe_code = wp_kses( $_POST['branch_map_iframe'], array(
            'iframe' => array(
                'src'             => array(),
                'width'           => array(),
                'height'          => array(),
                'frameborder'     => array(),
                'style'           => array(),
                'allowfullscreen' => array(),
                'aria-hidden'     => array(),
                'tabindex'        => array(),
                'loading'         => array(),
                'referrerpolicy'  => array(),
            )
        ) );
        update_post_meta( $post_id, '_branch_map_iframe', $iframe_code );
    }
}
add_action( 'save_post', 'shopping_save_branch_meta_box_data' );
