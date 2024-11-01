<?php

function ppsndw_woo_discord_request( $webhookurl, $order_id, $status, $order_value, $products ){	

	$timestamp = date("c", strtotime("now"));

	$json_data = json_encode([
  
    // Text-to-speech
    "tts" => false,

    // Embeds Array
    "embeds" => [
        [
            // Embed Title
            "title" => "Order status changed to ".$status." on ".get_bloginfo('name'),

            // Embed Type
            "type" => "rich",

            // URL of title link
            "url" => admin_url( 'post.php?post=' . $order_id . '&action=edit'),

            // Timestamp of embed must be formatted as ISO8601
            "timestamp" => $timestamp,

            // Embed left border color in HEX
            "color" => hexdec( "3366ff" ),

            // Additional Fields array
            "fields" => [
                // Field 1
                [
                    "name" => __("Order Number", "wc-discord-notifications"),
                    "value" => $order_id,
                    "inline" => false
                ],
                [
                    "name" => __("Total Order Value", "wc-discord-notifications"),
                    "value" => $order_value,
                    "inline" => false
                ],
                [
                    "name" => __("Products Ordered", "wc-discord-notifications"),
                    "value" => $products,
                    "inline" => false
                ],
                
            ]
        ]
    ]

    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

    $args = array( 
        'headers' => array( 'Content-Type' => 'application/json' ), 
        'body' => $json_data, 
        'data_format' => 'body' 
    );

    wp_remote_post( $webhookurl, $args );

}
