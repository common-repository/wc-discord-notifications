<div class='wrap'>
	<h2><?php _e('Notifications on Discord for Woocommerce', 'wc-discord-notifications'); ?></h2>
	<div class='notice notice-warning'>
		<p><?php _e('Note: Notifications on Discord for Woocommerce will not notify Discord on a local environment. Your website must be online and publicly accessible.', 'wc-discord-notifications'); ?></p>
	</div>
	<?php
		/**
		 * Check if WooCommerce is active
		 **/
		if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		    ?>
		    <div class='notice notice-error'>
				<p><?php _e('Woocommerce needs to be installed and activated for Notifications on Discord for Woocommerce to work.', 'wc-discord-notifications'); ?></p>
			</div>
		    <?php
		}
	?>
	<form method='POST'>
		<?php wp_nonce_field( 'ppsndw_woo_save', 'ppsndw_woo_security' ); ?>
		<table class='form-table striped'>
			<?php 

				$stored_settings = get_option( 'ppsndw_discord_woo' );

				if( !empty( $settings ) ){
					foreach( $settings as $setting ){
						echo "<tr>";
						echo "<th>".$setting['label']."</th>";
						$description = !empty( $setting['desc'] ) ? $setting['desc'] : "";
						if( $setting['type'] == 'text' ){ 
							$value = isset( $stored_settings[$setting['id']] ) ? $stored_settings[$setting['id']] : "";
							echo "<td><input type='text' name='".$setting['id']."' id='".$setting['id']."' value='".$value."' /><p class='description'>".$description."</p></td>";
						} else {
							$value = isset( $stored_settings[$setting['id']] ) ? 1 : 0;
							echo "<td><input type='checkbox' name='".$setting['id']."' id='".$setting['id']."' ".checked( $value, 1, false )." value='1' /><p class='description'>".$description."</p></td>";
						}
						echo "</tr>";
					}	
				}

			?>
			<tr>
				<td></td>
				<td><input type='submit' name='ppsndw_woo_save' class='button button-primary' value='<?php _e('Save Settings', 'wc-discord-notifications'); ?>' /></td>
			</tr>
		</table>
	</form>
</div>