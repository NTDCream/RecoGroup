<?php
/**
 * Load Vietnam Map Data for ACF
 */
function reco_get_vietnam_map_data() {
	$file_path = get_stylesheet_directory() . '/assets/data/vietnam_map_34tinh.json';
	if ( file_exists( $file_path ) ) {
		$json_data = file_get_contents( $file_path );
		// Remove BOM if present
		$json_data = preg_replace('/^[\xef\xbb\xbf]+/', '', $json_data);
		$data = json_decode( $json_data, true );
		return $data ? $data : array();
	}
	return array();
}

/**
 * Populate Province field
 */
function reco_acf_load_province_field( $field ) {
	$field['choices'] = array();
	$map_data = reco_get_vietnam_map_data();
	if ( ! empty( $map_data ) ) {
		foreach ( $map_data as $province => $communes ) {
			$field['choices'][ $province ] = $province;
		}
	}
	return $field;
}
add_filter('acf/load_field/name=reco_sale_province', 'reco_acf_load_province_field');

/**
 * AJAX handler for fetching communes
 */
function reco_ajax_get_communes() {
	if ( ! isset( $_POST['province'] ) ) {
		wp_send_json_error( 'No province provided' );
	}
	$province = stripslashes( $_POST['province'] );
	$map_data = reco_get_vietnam_map_data();
	
	if ( isset( $map_data[ $province ] ) ) {
		wp_send_json_success( $map_data[ $province ] );
	} else {
		wp_send_json_error( 'Province not found: ' . $province );
	}
}
add_action( 'wp_ajax_reco_get_communes', 'reco_ajax_get_communes' );
add_action( 'wp_ajax_nopriv_reco_get_communes', 'reco_ajax_get_communes' );

/**
 * Admin script for ACF dynamic dropdown
 */
function reco_admin_sale_location_script() {
	$screen = get_current_screen();
	if ( ! $screen || $screen->post_type !== 'reco_sale' ) {
		return;
	}
	$map_data = reco_get_vietnam_map_data();
	?>
	<script type="text/javascript">
	var reco_vietnam_map = <?php echo json_encode( $map_data, JSON_UNESCAPED_UNICODE ); ?>;
	
	jQuery(document).ready(function($) {
		$(document).on('change', '.acf-field[data-name="reco_sale_province"] select', function() {
			var province = $(this).val();
			var $communeSelect = $('.acf-field[data-name="reco_sale_commune"] select');
			
			// Disable select2 to update DOM
			if ($communeSelect.hasClass('select2-hidden-accessible')) {
				$communeSelect.select2('destroy');
			}
			
			$communeSelect.empty();
			$communeSelect.append('<option value="">- Chọn Phường/Xã -</option>');
			
			var communes = reco_vietnam_map[province];
			if (communes && communes.length > 0) {
				$.each(communes, function(index, value) {
					$communeSelect.append('<option value="' + value + '">' + value + '</option>');
				});
			} else {
				$communeSelect.append('<option value="">Không có dữ liệu</option>');
			}
			
			// Re-init select2 via ACF if available
			if (typeof acf !== 'undefined') {
				var field = acf.getField($('.acf-field[data-name="reco_sale_commune"]'));
				if (field) {
					acf.doAction('append', field.$el);
				} else {
					$communeSelect.select2();
				}
			} else {
				$communeSelect.select2();
			}
		});
	});
	</script>
	<?php
}
add_action( 'admin_footer', 'reco_admin_sale_location_script' );
