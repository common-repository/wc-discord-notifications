<?php

function ppsndw_woo_status_trigger( $order_id ){

	$order = new WC_Order( $order_id );

	$order_status  = $order->get_status();

	$stored_settings = get_option( 'ppsndw_discord_woo' );

	$items = $order->get_items();

	$order_value = $order->get_currency().' '.$order->get_total();

	$products = array();

	foreach ( $items as $item_id => $product ) {
		$products[] = $product->get_name();
	}

	if( !empty( $stored_settings ) ){

		foreach( $stored_settings as $key => $val ){

			if( $key == 'ppsndw_woo_enable_'.$order_status ){
				//Enabled
				if( !empty( $stored_settings['ppsndw_woo_webhook_'.$order_status] ) ){
					//Ping Discord
					ppsndw_woo_discord_request( 
						$stored_settings['ppsndw_woo_webhook_'.$order_status],
						$order_id,
						$order_status,
						$order_value,
						implode( ", ", $products )						
					);
				}
			}
		}

	}

}
add_action( 'woocommerce_order_status_completed', 'ppsndw_woo_status_trigger', 10, 1 );
add_action( 'woocommerce_order_status_pending', 'ppsndw_woo_status_trigger', 10, 1 );
add_action( 'woocommerce_order_status_on-hold', 'ppsndw_woo_status_trigger', 10, 1 );
add_action( 'woocommerce_order_status_processing', 'ppsndw_woo_status_trigger', 10, 1 );
add_action( 'woocommerce_order_status_failed', 'ppsndw_woo_status_trigger', 10, 1 );
add_action( 'woocommerce_order_status_refunded', 'ppsndw_woo_status_trigger', 10, 1 );
add_action( 'woocommerce_order_status_cancelled', 'ppsndw_woo_status_trigger', 10, 1 );