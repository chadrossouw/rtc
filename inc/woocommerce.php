<?php

/**
 * Remove related products output
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action( 'woocommerce_after_single_product_summary', 'bl_related', 20 );
/**
 * Rename product data tabs
 */
add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {
	if(is_single('291') || is_single('289')){
	$tabs['description']['title'] = __( 'More About This Item' );		// Rename the description tab
	}
	else{
	$tabs['description']['title'] = __( 'More About This Book' );		// Rename the description tab
	}
	return $tabs;

}
add_filter( 'woocommerce_product_description_heading', 'wc_change_product_description_tab_heading', 10, 1 );
function wc_change_product_description_tab_heading( $title ) {
	global $post;
	return $post->post_title;
}
function custom_single_product_image_html( $html, $post_id ) {
    $post_thumbnail_id = get_post_thumbnail_id( $post_id );
    return get_the_post_thumbnail( $post_thumbnail_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
}
add_filter('woocommerce_single_product_image_thumbnail_html', 'custom_single_product_image_html', 10, 2);

add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

    unset( $tabs['reviews'] ); 			// Remove the reviews tab
    unset( $tabs['additional_information'] );  	// Remove the additional information tab

    return $tabs;
}

//add_action( 'woocommerce_product_query', 'bl_pre_get_posts_query' );

//* Remove duplicate page-title from WooCommerce archive pages



add_filter( 'woocommerce_output_related_products_args', 'bl_related_products_args' );
function bl_related_products_args( $args ) {
$args['posts_per_page'] = 3; // 4 related products
$args['columns'] = 3; // arranged in 2 columns
return $args;
}
/*
add_action( 'woocommerce_before_cart', 'get_free_shipping_minimum' );

function get_free_shipping_minimum() {
    $shipping_packages =  WC()->cart->get_shipping_packages();

// Get the WC_Shipping_Zones instance object for the first package
$shipping_zone = wc_get_shipping_zone( reset( $shipping_packages ) );
$zone_id   = $shipping_zone->get_id(); // Get the zone ID
$zone_name = $shipping_zone->get_zone_name(); // Get the zone name

    $result = null;
    $zone = null;

    $zones = WC_Shipping_Zones::get_zones();
    foreach ( $zones as $z ) {
    		if ( $z['zone_name'] == $zone_name ) {
            $zone = $z;
            
        }
        
    }
	
    if ( $zone ) {
        $shipping_methods_nl = $zone['shipping_methods'];
        $free_shipping_method = null;
        foreach ( $shipping_methods_nl as $method ) {
            if ( $method->id == 'free_shipping' ) {
                $free_shipping_method = $method;
                break;
            }
        }

        if ( $free_shipping_method ) {
            $result = $free_shipping_method->min_amount;
        }
    }

    $cart = WC()->cart->subtotal;
         $remaining = $result - $cart;

           if( $result > $cart ){
               $notice = sprintf( "Spend another %s to get free shipping", wc_price($remaining));
               wc_print_notice( $notice , 'notice' );
           }
    
}*/
            
add_filter( 'woocommerce_package_rates', 'my_hide_shipping_when_free_is_available' );

function my_hide_shipping_when_free_is_available( $rates ) {
        $free = array();
        foreach( $rates as $rate_id => $rate ) {
          if( 'free_shipping' === $rate->method_id ) {
                $free[ $rate_id ] = $rate;
                break;
          }
        }

        return ! empty( $free ) ? $free : $rates;
}
 /* 
 Woocommerce Out of STock Notice
*/	
add_action( 'woocommerce_after_shop_loop_item_title', 'bl_wc_template_loop_stock', 10 );



function bl_wc_template_loop_stock() {
    global $product;
    if($product->managing_stock() && (int)$product->get_stock_quantity() < 1)
    echo '<p class="bl_stock out-of-stock">'.__('Out of Stock').'</p>';
}
add_action( 'woocommerce_single_product_summary', 'bl_custom_get_availability',20);

function bl_custom_get_availability() {
	
    global $product;
    if($product->managing_stock() && (int)$product->get_stock_quantity() < 1)
    echo '<p class="bl_stock out-of-stock">Out of Stock</p><div class="bl_events_link"><h3><a href="/enquire-about-a-book/">Email us about this book</a></h3></div>';
    

}
add_filter( 'woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_args' );
add_filter( 'woocommerce_default_catalog_orderby_options', 'custom_woocommerce_catalog_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby' );
 
 // Apply custom args to main query
function custom_woocommerce_get_catalog_ordering_args( $args ) {

	$orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
 
	if ( 'oldest_to_recent' == $orderby_value ) {
		$args['orderby'] = 'date';
		$args['order'] = 'DESC';
	}
 
	return $args;
}
 
// Create new sorting method
function custom_woocommerce_catalog_orderby( $sortby ) {
	
	$sortby['oldest_to_recent'] = __( 'Oldest to most recent', 'woocommerce' );
	
	return $sortby;
}
add_filter('woocommerce_default_catalog_orderby', 'misha_default_catalog_orderby');
 
function misha_default_catalog_orderby( $sort_by ) {
	return 'oldest_to_recent';
}

add_filter( 'woocommerce_product_backorders_allowed', '__return_false', 1000 );
add_filter( 'woocommerce_product_backorders_require_notification', '__return_false', 1000 );

add_filter( 'woocommerce_product_get_backorders', 'get_backorders_return_no' );
add_filter( 'woocommerce_product_variation_get_backorders', 'get_backorders_return_no' );
function get_backorders_return_no( $backorders ){
    return 'no';
}

add_filter( 'woocommerce_product_get_stock_status', 'filter_product_stock_status', 10, 2 );
add_filter( 'woocommerce_product_variation_get_stock_status', 'filter_product_stock_status', 10, 2 );
function filter_product_stock_status( $stock_status, $product ){
    return $product->get_manage_stock() && $product->get_stock_quantity() <= 0 ? 'outofstock' : $stock_status;
}

add_filter('woocommerce_product_related_products_heading',function(){

    return 'You Might Be Interested In';
 
 });

 add_action('woocommerce_before_single_product', 'add_writer_to_title', 10);
 add_action('woocommerce_after_shop_loop_item_title' ,'add_writer_to_title', 7);
 function add_writer_to_title(){
     global $post;
    $id = $post->ID;?>
    <h4 class = "bl_book_author product_author margins">
       <?php echo get_the_term_list($id,'writer'); ?>
 </h4>
 <?php } ?>

 <?php if ( ! function_exists( 'reclaimthecity_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function reclaimthecity_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		reclaimthecity_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();
		ob_start();
		?><div id="site-header-cart" class="site-header-cart"><?php
		woocommerce_mini_cart();
		?></div><?php 
		$fragments['#site-header-cart'] = ob_get_clean();
		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'reclaimthecity_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'reclaimthecity_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function reclaimthecity_woocommerce_cart_link() {
		$count =  WC()->cart->get_cart_contents_count();
		if($count>0){ ?>
            <a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'reclaimthecity' ); ?>">
            <?php echo file_get_contents(get_template_directory() . '/assets/basket.svg'); ?>
            
            
                <span class="count"><?php echo $count; ?></span>
            </a>
		<?php
        } 
	}
}

if ( ! function_exists( 'reclaimthecity_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function reclaimthecity_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'nav_cart current-menu-item';
		} else {
			$class = 'nav_cart';
		}
		?>
			<div class="<?php echo esc_attr( $class ); ?>">
				<?php reclaimthecity_woocommerce_cart_link(); ?>
				<div id="site-header-cart" class="site-header-cart">
				<?php
				woocommerce_mini_cart();
				?>
				</div>
            </div>
			
		
		<?php
	}
}
/* Mini Cart Totals and Buttons */
remove_action('woocommerce_widget_shopping_cart_total','woocommerce_widget_shopping_cart_subtotal',10);
add_action('woocommerce_widget_shopping_cart_total','reclaimthecity_widget_shopping_cart_subtotal',10);
function reclaimthecity_widget_shopping_cart_subtotal() {
    echo '<strong>' . esc_html__( 'Total:', 'woocommerce' ) . WC()->cart->get_cart_subtotal() . '</strong> '; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
  }
add_action( 'woocommerce_widget_shopping_cart_buttons', function(){
    remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );
    add_action( 'woocommerce_widget_shopping_cart_buttons', 'reclaimthecity_widget_shopping_cart_proceed_to_checkout', 20 );
}, 1 );
function reclaimthecity_widget_shopping_cart_proceed_to_checkout() {
    echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="button checkout wc-forward">' . esc_html__( 'Proceed to Checkout', 'woocommerce' ) . '</a>';
}

function user_login_or_account(){
    $user = wp_get_current_user();
    $output='<div class="my-account"><a href="/my-account" >'.file_get_contents(get_template_directory() . '/assets/login.svg');
    if($user->ID==0){
        $output.='Sign in</a></div>';
    }
    else{
        $name=get_user_meta($user->ID,'first_name',true);
        $output.='Hello ';
        $output.=!empty($name)?$name:$user->data->user_nicename;
        $output.='</a></div>';
    }
    
    return $output;
}
/*Add Wishlist to my Account*/
add_filter ( 'woocommerce_account_menu_items', 'reclaimthecity_customize_account_menu_items' );
function reclaimthecity_customize_account_menu_items( $items ){
    $items['wishlist'] = 'Your Wishlist';
    return $items;
}
// point the endpoint to a custom URL
//add_filter( 'woocommerce_get_endpoint_url', 'reclaimthecity_custom_woo_endpoint', 10, 2 );
function reclaimthecity_custom_woo_endpoint( $url, $endpoint ){
     if( $endpoint == 'wishlist' ) {
        $url = get_site_url().'/wishlist'; // Your custom URL to add to the My Account menu
    }
}

 /*Add Wishlist Button*/
add_action('woocommerce_after_shop_loop_item' ,'add_wishlist_to_summary',15);
add_action('woocommerce_single_product_summary','add_wishlist_to_summary',35);
function add_wishlist_to_summary(){
    global $post;
    if($post->post_name == 'voucher'){
        return;
    }
    echo do_shortcode('[yith_wcwl_add_to_wishlist]');
}

/*Add discount from last order*/
function get_last_order_amount(){
    if ( is_user_logged_in() ) :

        $user_id = get_current_user_id(); // The current user ID
    
        // Get the WC_Customer instance Object for the current user
        $customer = new WC_Customer( $user_id );
    
        // Get the last WC_Order Object instance from current customer
        $last_order = $customer->get_last_order();
        $last_order->get_status();
        if('completed'==$last_order->get_status()){
            $total = $last_order->get_total();
        }
        else{
            $orders = wc_get_orders([
                'customer_id'=>$customer->get_id(),
                'status'=>array('completed'),
                'limit'=>1
            ]);
            $total = $orders[0]->get_total();
        } 
        return $total;
    endif;   
}

/*add store credit of 5% of current completed order*/
add_action('woocommerce_order_status_completed','add_loyalty_discount_to_user');
function add_loyalty_discount_to_user($order_id){
    $order = wc_get_order($order_id);
    $user_id = $order->get_user_id();
    $total = $order->get_total();
    $previous_discount = get_user_meta($user_id,'bl_loyalty_discount',true);
    $has_voucher=false;
    foreach($order->get_items()  as $item){
        if($item->get_name()=='Voucher'){
            $total = $total - $item->get_total();
        }
    }
    if($total>0){
        if($previous_discount){
            $total = $total + $previous_discount;
        }

        $discount = $total/100*5;

        if($user_id && $user_id!=0){
            update_user_meta($user_id,'bl_loyalty_discount',$discount);
        }
        update_user_meta($user_id,'bl_store_credit',0);
    }
    elseif($total<0){
        update_user_meta($user_id,'bl_store_credit',$total);
    }
}

function get_loyalty_discount(){
    $user_id = get_current_user_id(); 
    return get_user_meta($user_id,'bl_loyalty_discount',true);
}

function get_store_credit(){
    $user_id = get_current_user_id(); 
    return get_user_meta($user_id,'bl_store_credit',true);
}

function reclaimthecity_discount_price(){
    if ( is_user_logged_in() ) {
        $discount = get_loyalty_discount();
        if($discount && $discount!==0){
            $message = 'Loyalty discount';
            WC()->cart->add_fee($message, -$discount, true, 'standard');
        }
        $credit = get_store_credit();
        if($credit && $credit!==0){
            $message = 'Store Credit';
            WC()->cart->add_fee($message, -$credit, true, 'standard');
        }
    }
}

function display_discount_reason(){
    $discount=get_loyalty_discount();
    if($discount && $discount!=0){
        echo '<p>Our Loyalty programme gives you a discount of 5% from your previous order. You are eligible for a discount of R'.number_format((float)$discount,2,'.','').'</p>';
    }
    $credit=get_store_credit();
    if($credit && $credit!=0){
        echo '<p>You have a store credit of R'.number_format((float)$credit,2,'.','').'</p>';
    }
}

function check_store_credit(){
    $subtotal = (int) WC()->cart->get_subtotal();
    $coupon_ids = WC()->cart->get_applied_coupons();
    if($coupon_ids){
        $coupon_amount = 0;
        foreach($coupon_ids as $coupon_id){
            $coupon = new WC_Coupon($coupon_id);
            $coupon_amount += (int) $coupon->get_amount();
        }
        if($coupon_amount>$subtotal){
            $store_credit = $coupon_amount - $subtotal;
            echo '<p>Your Voucher amount is greater than the total. You will receive a store credit of R'.$store_credit.' towards your next order</p>';
        }
    }
    
}
add_action( 'woocommerce_cart_calculate_fees','reclaimthecity_discount_price' ); 
add_action( 'woocommerce_before_cart_totals', 'display_discount_reason' );
add_action( 'woocommerce_checkout_before_order_review','display_discount_reason' );

add_action('woocommerce_proceed_to_checkout','check_store_credit');

/*Generate Voucher Coupon Code, Add Store Credit*/
add_action( 'woocommerce_order_status_completed', 'reclaimthecity_payment_complete' );
function reclaimthecity_payment_complete( $order_id ){
    $order = wc_get_order( $order_id );
    $subtotal = (int) $order->get_subtotal();
    $user_id = $order->get_user_id();
    if($coupons = $order->get_coupons()){
        $coupon_amount = 0;
        foreach($coupons as $coupon){
            $coupon_amount += (int) $coupon->get_meta('coupon_data')['amount'];
        }
        if($coupon_amount>$subtotal){
            $store_credit = $coupon_amount - $subtotal;
            update_user_meta($user_id,'bl_store_credit',$store_credit);
        }
    }
    else{
        update_user_meta($user_id,'bl_store_credit',0);
    }
    foreach($order->get_items() as $item_id=>$item);{
        $product = $item->get_product();
        if($product->get_name()=='Voucher'||$product->get_id()==289){
            $recipient = $item->get_meta('Recipient\'s Full Name');
            $subject = 'You have recieved a Book Lounge Voucher!';
            $message = $item->get_meta('Personal Note');
            $email = $item->get_meta('Email Address');
            $user_data = get_userdata($user_id);
            $user_name = $user_data->first_name.' '.$user_data->last_name;
            $user_mail = $user_data->user_email;
            $name = str_replace(' ','',strtolower(strip_tags($recipient)));
            $uid = bin2hex(random_bytes(3));
            $voucher_id = $name.'_'.$uid;
            $coupon = array(
                'post_title'=>$voucher_id,
                'post_content' => '',
                'post_status' => 'publish',
                'post_author' => 1,
                'post_type' => 'shop_coupon'
            );
            $new_coupon_id = wp_insert_post($coupon);
            update_post_meta( $new_coupon_id, 'discount_type', 'fixed_cart' );
            update_post_meta( $new_coupon_id, 'coupon_amount', $item->get_subtotal());
            update_post_meta( $new_coupon_id, 'individual_use', 'yes' );
            update_post_meta( $new_coupon_id, 'usage_limit', '1' );
            update_post_meta( $new_coupon_id, 'usage_limit_per_user', '1' );

            /*Create PDF*/
            $voucher_pdf = new Create_Voucher_PDF($voucher_id,$recipient,$message,$item->get_subtotal(),$user_name);
            $headers[]='Content-Type: text/html;  charset=UTF-8';
            $headers[]='From: The Book Lounge<reclaimthecity@gmail.com>';
            $headers[]='CC: '.$user_name.'<'.$user_mail.'>';
            wp_mail($email,$subject,$voucher_pdf->get_mail_html(),$headers,$voucher_pdf->get_file_path());
        }
    }
}


/*Coupon to Voucher*/
add_filter( 'gettext', 'bl_rename_coupon_field_on_cart', 10, 3 );
add_filter( 'woocommerce_coupon_error', 'bl_rename_coupon_label', 10, 3 );
add_filter( 'woocommerce_coupon_message', 'bl_rename_coupon_label', 10, 3 );
add_filter( 'woocommerce_cart_totals_coupon_label', 'bl_rename_coupon_label',10, 1 );
add_filter( 'woocommerce_checkout_coupon_message', 'bl_rename_coupon_message_on_checkout' );

function bl_rename_coupon_field_on_cart( $translated_text, $text, $text_domain ) {
	// bail if not modifying frontend woocommerce text
	if ( is_admin() || 'woocommerce' !== $text_domain ) {
		return $translated_text;
	}
	if ( 'Coupon:' === $text ) {
		$translated_text = 'Voucher Code:';
	}

	if ('Coupon has been removed.' === $text){
		$translated_text = 'Voucher code has been removed.';
	}

	if ( 'Apply coupon' === $text ) {
		$translated_text = 'Apply Voucher';
	}

	if ( 'Coupon code' === $text ) {
		$translated_text = 'Voucher Code';
	
	} 

	return $translated_text;
}


// Rename the "Have a Coupon?" message on the checkout page
function bl_rename_coupon_message_on_checkout() {
	return 'Have a Voucher code?' . ' ' . __( 'Click here to enter your code', 'woocommerce' ) . '';
}


function bl_rename_coupon_label( $err, $err_code=null, $something=null ){
	$err = str_ireplace("Coupon","Voucher Code ",$err);
	return $err;
}

add_action('woocommerce_thankyou', 'bl_auto_complete');
function bl_auto_complete($order_id)
{
  
  if ( ! $order_id ) {
        return;
  }
  
  global $product;
  $order = wc_get_order( $order_id );
  $order_data = $order->get_data();
  if ($order_data['status'] == 'processing') {
      $order->update_status( 'completed' );
  }    
}


/*Add Credits and Dicounts to Customer Table*/
add_filter( 'manage_users_columns', 'bl_add_user_column' );
function bl_add_user_column( $columns ){
	$columns['credit']='Store Credit';
    $columns['loyalty']='Loyalty Discount';
	return $columns;
}

add_filter( 'manage_users_custom_column', 'bl_add_data_to_columns', 10, 3 );
function bl_add_data_to_columns( $row_output, $user_column_name, $user_id ) {

	if( $user_column_name == 'credit' ) {
      return get_user_meta($user_id,'bl_store_credit',true);
	}
    elseif($user_column_name =='loyalty'){
        return get_user_meta($user_id,'bl_loyalty_discount',true);
    }
}