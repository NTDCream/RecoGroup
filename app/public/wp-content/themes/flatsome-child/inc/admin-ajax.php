<?php
/**
 * Load Vietnam Map Data for ACF/SCF
 */
function reco_get_vietnam_map_data() {
	$file_path = get_stylesheet_directory() . '/assets/data/vietnam_map_34tinh.json';
	if ( file_exists( $file_path ) ) {
		$json_data = file_get_contents( $file_path );
		$json_data = preg_replace('/^[\xef\xbb\xbf]+/', '', $json_data);
		$data = json_decode( $json_data, true );
		return $data ? $data : array();
	}
	return array();
}

/**
 * Populate Province field choices from JSON
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
add_filter( 'acf/load_field/name=reco_sale_province', 'reco_acf_load_province_field' );

/**
 * Populate Commune field choices based on saved province value (for edit screen)
 */
function reco_acf_load_commune_field( $field ) {
	$post_id = isset( $_GET['post'] ) ? intval( $_GET['post'] ) : 0;
	if ( $post_id ) {
		$province = get_post_meta( $post_id, 'reco_sale_province', true );
		if ( $province ) {
			$map_data = reco_get_vietnam_map_data();
			if ( isset( $map_data[ $province ] ) ) {
				$field['choices'] = array();
				foreach ( $map_data[ $province ] as $commune ) {
					$field['choices'][ $commune ] = $commune;
				}
			}
		}
	}
	return $field;
}
add_filter( 'acf/load_field/name=reco_sale_commune', 'reco_acf_load_commune_field' );

/**
 * Admin script: load communes when province changes
 */
function reco_admin_sale_location_script() {
	$screen = get_current_screen();
	if ( ! $screen || $screen->post_type !== 'reco_sale' ) {
		return;
	}
	$map_data = reco_get_vietnam_map_data();
	?>
	<script type="text/javascript">
	(function($) {
		var recoMap = <?php echo wp_json_encode( $map_data, JSON_UNESCAPED_UNICODE ); ?>;

		function updateCommuneField(province) {
			var $communeWrapper = $('[data-name="reco_sale_commune"]');
			var $select = $communeWrapper.find('select');

			if (!$select.length) {
				$select = $('select[name="acf[field_reco_sale_commune]"]');
			}
			if (!$select.length) return;

			// Clear and rebuild native option list
			$select.empty().append('<option value="">Chọn Phường/Xã...</option>');

			if (province && recoMap[province] && recoMap[province].length) {
				var communes = recoMap[province];
				for (var i = 0; i < communes.length; i++) {
					$select.append('<option value="' + communes[i] + '">' + communes[i] + '</option>');
				}
			}
		}

		$(document).ready(function() {
			var lastProvince = null;
			
			// Bulletproof polling approach: bypasses all ACF/SCF event suppression issues
			setInterval(function() {
				var $provinceSelect = $('[data-name="reco_sale_province"] select');
				if (!$provinceSelect.length) {
					$provinceSelect = $('select[name="acf[field_reco_sale_province]"]');
				}
				
				if ($provinceSelect.length) {
					var currentProvince = $provinceSelect.val();
					if (currentProvince !== lastProvince) {
						if (lastProvince !== null) {
							updateCommuneField(currentProvince);
						}
						lastProvince = currentProvince;
					}
				}
			}, 500);
		});
	})(jQuery);
	</script>
	<?php
}
add_action( 'admin_footer', 'reco_admin_sale_location_script' );
