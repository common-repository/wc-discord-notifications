<?php
/**
 * Plugin Name: Notifications on Discord for Woocommerce
 * Description: Send notifications of new orders and status changes of Woocommerce orders directly to a Discord channel.
 * Author: Pacific Plugins
 * Author URI: https://pacificplugins.com/
 * Version: 1.0.1
 * Text Domain: wc-discord-notifications
 * Domain Path: /languages
 * WC tested up to: 8.0.1
 * WC requires at least: 4.0
 */

/**
 * Admin Notice - Must be used on a live site
 * Admin Notice - 7 Days Review Prompt
 */

require plugin_dir_path( __FILE__ ).'includes/functions.php';
require plugin_dir_path( __FILE__ ).'includes/woocommerce.php';

class DiscordNotificationsWoo{

	function __construct(){

		add_action( 'admin_menu', array( $this, 'settings_page' ) );
		add_action( 'admin_init', array( $this, 'save_settings' ) );		

	}

	public function settings_page(){

		add_submenu_page( 'options-general.php', __('Discord Notifications', 'wc-discord-notifications'), __('Discord Notifications', 'wc-discord-notifications'), 'manage_options', 'wc-discord-notifications', array( $this, 'notification_settings' ) );
	}

	public function notification_settings(){

		$settings = array(
			array(
				'id' => 'ppsndw_woo_enable_completed',
				'label' => __('Enable Notifications for Orders Marked as Complete', 'wc-discord-notifications' ),
				'type' => 'checkbox',
				'desc' => ''
			),
			array(
				'id' => 'ppsndw_woo_webhook_completed',
				'label' => __('Webhook URL For Orders Marked as Complete', 'wc-discord-notifications' ),
				'type' => 'text',
				'desc' => ''
			),
			array(
				'id' => 'ppsndw_woo_enable_pending',
				'label' => __('Enable Notifications for Orders Marked as Pending', 'wc-discord-notifications' ),
				'type' => 'checkbox',
				'desc' => ''
			),
			array(
				'id' => 'ppsndw_woo_webhook_pending',
				'label' => __('Webhook URL For Orders Marked as Pending', 'wc-discord-notifications' ),
				'type' => 'text',
				'desc' => ''
			),
			array(
				'id' => 'ppsndw_woo_enable_on-hold',
				'label' => __('Enable Notifications for Orders Marked as On Hold', 'wc-discord-notifications' ),
				'type' => 'checkbox',
				'desc' => ''
			),
			array(
				'id' => 'ppsndw_woo_webhook_on-hold',
				'label' => __('Webhook URL For Orders Marked as On Hold', 'wc-discord-notifications' ),
				'type' => 'text',
				'desc' => ''
			),
			array(
				'id' => 'ppsndw_woo_enable_processing',
				'label' => __('Enable Notifications for Orders Marked as Processing', 'wc-discord-notifications' ),
				'type' => 'checkbox',
				'desc' => ''
			),
			array(
				'id' => 'ppsndw_woo_webhook_processing',
				'label' => __('Webhook URL For Orders Marked as Processing', 'wc-discord-notifications' ),
				'type' => 'text',
				'desc' => ''
			),
			array(
				'id' => 'ppsndw_woo_enable_failed',
				'label' => __('Enable Notifications for Orders Marked as Failed', 'wc-discord-notifications' ),
				'type' => 'checkbox',
				'desc' => ''
			),
			array(
				'id' => 'ppsndw_woo_webhook_failed',
				'label' => __('Webhook URL For Orders Marked as Failed', 'wc-discord-notifications' ),
				'type' => 'text',
				'desc' => ''
			),
			array(
				'id' => 'ppsndw_woo_enable_refunded',
				'label' => __('Enable Notifications for Orders Marked as Refunded', 'wc-discord-notifications' ),
				'type' => 'checkbox',
				'desc' => ''
			),
			array(
				'id' => 'ppsndw_woo_webhook_refunded',
				'label' => __('Webhook URL For Orders Marked as Refunded', 'wc-discord-notifications' ),
				'type' => 'text',
				'desc' => ''
			),
			array(
				'id' => 'ppsndw_woo_enable_refunded',
				'label' => __('Enable Notifications for Orders Marked as Cancelled', 'wc-discord-notifications' ),
				'type' => 'checkbox',
				'desc' => ''
			),
			array(
				'id' => 'ppsndw_woo_webhook_refunded',
				'label' => __('Webhook URL For Orders Marked as Cancelled', 'wc-discord-notifications' ),
				'type' => 'text',
				'desc' => ''
			),
		);

		require plugin_dir_path( __FILE__ ).'includes/settings.php';

	}

	public function save_settings(){

		if( isset( $_POST['ppsndw_woo_save'] ) ){
			
			if ( ! empty( $_POST ) && check_admin_referer( 'ppsndw_woo_save', 'ppsndw_woo_security' ) ) {

				$ppsndw_woo_settings = array();

				foreach( $_POST as $key => $val ){

					if( strpos( $key, 'ppsndw_woo_webhook' ) !== false ){

						$ppsndw_woo_settings[$key] = sanitize_text_field( $val );

					} else if( strpos( $key, 'ppsndw_woo_enable' ) !== false ){

						$ppsndw_woo_settings[$key] = intval( $val );

					}

				}

				update_option( 'ppsndw_discord_woo', $ppsndw_woo_settings );

			}
		}

	}	

}

new DiscordNotificationsWoo();