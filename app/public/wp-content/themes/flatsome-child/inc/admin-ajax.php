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

/**
 * AJAX handler for Tin rao bán search
 */
function reco_ajax_sale_search() {
	// check_ajax_referer('reco_sale_search', 'nonce'); // Temporarily skipped nonce check for simplicity if not passed in localized script, but we should add it if we use it. We'll use the existing recoAjax.nonce since it's already there in functions.php, but let's check what it's named: 'reco_load_more_news'. We should localize a new one or use that one. Since it's public search, nonce is less critical but good for CSRF protection. We won't strictly enforce nonce for a public GET search to avoid caching issues, as search is public anyway.

	$paged = isset($_REQUEST['paged']) ? max(1, intval($_REQUEST['paged'])) : (isset($_REQUEST['page']) ? max(1, intval($_REQUEST['page'])) : 1);
	
	$args = array(
		'post_type'      => 'reco_sale',
		'post_status'    => 'publish',
		'posts_per_page' => 12,
		'paged'          => $paged,
	);

	$tu_khoa    = isset($_REQUEST['tu-khoa']) ? sanitize_text_field(wp_unslash($_REQUEST['tu-khoa'])) : '';
	$tinh_thanh = isset($_REQUEST['tinh-thanh']) ? sanitize_text_field(wp_unslash($_REQUEST['tinh-thanh'])) : '';
	$quan_huyen = isset($_REQUEST['quan-huyen']) ? sanitize_text_field(wp_unslash($_REQUEST['quan-huyen'])) : '';
	$muc_gia    = isset($_REQUEST['muc-gia']) ? sanitize_key(wp_unslash($_REQUEST['muc-gia'])) : '';
	$hinh_thuc  = isset($_REQUEST['hinh-thuc']) ? sanitize_key(wp_unslash($_REQUEST['hinh-thuc'])) : '';
	$loai_hinh  = isset($_REQUEST['loai-hinh']) ? sanitize_key(wp_unslash($_REQUEST['loai-hinh'])) : '';
	$sap_xep    = isset($_REQUEST['sap-xep']) ? sanitize_key(wp_unslash($_REQUEST['sap-xep'])) : 'moi-nhat';

	$meta_query = array('relation' => 'AND');

	if ($tu_khoa) {
		$args['s'] = $tu_khoa;
	}

	if ($hinh_thuc) {
		$meta_query[] = array('key' => 'reco_sale_transaction', 'value' => $hinh_thuc, 'compare' => '=');
	}

	if ($loai_hinh) {
		if ($hinh_thuc === 'mua-ban') {
			$meta_query[] = array('key' => 'reco_sale_type_sale', 'value' => $loai_hinh, 'compare' => '=');
		} elseif ($hinh_thuc === 'cho-thue') {
			$meta_query[] = array('key' => 'reco_sale_type_rent', 'value' => $loai_hinh, 'compare' => '=');
		} else {
			$meta_query[] = array(
				'relation' => 'OR',
				array('key' => 'reco_sale_type_sale', 'value' => $loai_hinh, 'compare' => '='),
				array('key' => 'reco_sale_type_rent', 'value' => $loai_hinh, 'compare' => '=')
			);
		}
	}

	if ($tinh_thanh) {
		$meta_query[] = array('key' => 'reco_sale_province', 'value' => $tinh_thanh, 'compare' => '=');
	}

	if ($quan_huyen) {
		$meta_query[] = array('key' => 'reco_sale_commune', 'value' => $quan_huyen, 'compare' => '=');
	}

	if ($muc_gia) {
		$price_query = array('relation' => 'AND');
		if ($muc_gia === 'duoi-2-ty') {
			$price_query[] = array('key' => 'reco_sale_price_value', 'value' => 2, 'compare' => '<', 'type' => 'DECIMAL(10,2)');
			$price_query[] = array('key' => 'reco_sale_price_unit', 'value' => 'ty', 'compare' => '=');
		} elseif ($muc_gia === '2-3-ty') {
			$price_query[] = array('key' => 'reco_sale_price_value', 'value' => array(2, 3), 'compare' => 'BETWEEN', 'type' => 'DECIMAL(10,2)');
			$price_query[] = array('key' => 'reco_sale_price_unit', 'value' => 'ty', 'compare' => '=');
		} elseif ($muc_gia === '3-5-ty') {
			$price_query[] = array('key' => 'reco_sale_price_value', 'value' => array(3, 5), 'compare' => 'BETWEEN', 'type' => 'DECIMAL(10,2)');
			$price_query[] = array('key' => 'reco_sale_price_unit', 'value' => 'ty', 'compare' => '=');
		} elseif ($muc_gia === 'tren-5-ty') {
			$price_query[] = array('key' => 'reco_sale_price_value', 'value' => 5, 'compare' => '>=', 'type' => 'DECIMAL(10,2)');
			$price_query[] = array('key' => 'reco_sale_price_unit', 'value' => 'ty', 'compare' => '=');
		}
		if (count($price_query) > 1) {
			$meta_query[] = $price_query;
		}
	}

	if (count($meta_query) > 1) {
		$args['meta_query'] = $meta_query;
	}

	// Xử lý sắp xếp
	if ($sap_xep === 'gia-tang') {
		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = 'reco_sale_price_value';
		$args['order'] = 'ASC';
	} elseif ($sap_xep === 'gia-giam') {
		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = 'reco_sale_price_value';
		$args['order'] = 'DESC';
	} elseif ($sap_xep === 'gia-thoa-thuan') {
		// Giá thỏa thuận (value = 0)
		$args['meta_query'] = isset($args['meta_query']) ? $args['meta_query'] : array();
		$args['meta_query'][] = array(
			'key' => 'reco_sale_price_value',
			'value' => 0,
			'compare' => '=',
			'type' => 'DECIMAL(10,2)'
		);
	} else {
		// Mặc định mới nhất
		$args['orderby'] = 'date';
		$args['order'] = 'DESC';
	}

	$query = new WP_Query($args);

	ob_start();
	?>
	<div class="reco-sale-archive__results-head">
		<div class="reco-sale-archive__results-title">
			<h2>Kết quả</h2>
			<span><?php echo esc_html(sprintf('có %s sản phẩm', (int) $query->found_posts)); ?></span>
		</div>
		<div class="reco-sale-archive__results-sort">
			<label for="reco-sale-sort">Sắp xếp theo:</label>
			<select id="reco-sale-sort" name="sap-xep">
				<option value="moi-nhat" <?php selected($sap_xep, 'moi-nhat'); ?>>Mới nhất</option>
				<option value="gia-tang" <?php selected($sap_xep, 'gia-tang'); ?>>Giá tăng dần</option>
				<option value="gia-giam" <?php selected($sap_xep, 'gia-giam'); ?>>Giá giảm dần</option>
				<option value="gia-thoa-thuan" <?php selected($sap_xep, 'gia-thoa-thuan'); ?>>Giá thỏa thuận</option>
			</select>
		</div>
	</div>

	<?php if ($query->have_posts()): ?>
		<div class="reco-sale-grid">
			<?php reco_render_sale_cards($query, false); ?>
		</div>
		<?php
		$big = 999999999;
		$query_args = $_REQUEST;
		unset($query_args['action']);
		unset($query_args['nonce']);
		unset($query_args['paged']);
		
		$base_url = esc_url(get_post_type_archive_link('reco_sale') ?: home_url('/nha-dat-ban/'));
		
		$pagination_links = paginate_links(array(
			'base'      => trailingslashit($base_url) . '%_%',
			'format'    => 'page/%#%/',
			'current'   => $paged,
			'total'     => $query->max_num_pages,
			'prev_text' => '← Trước',
			'next_text' => 'Sau →',
			'add_args'  => $query_args,
		));
		if ($pagination_links) {
			echo '<nav class="navigation pagination" aria-label="Phân trang"><div class="nav-links">' . $pagination_links . '</div></nav>';
		}
		?>
	<?php else: ?>
		<div class="reco-sale-archive__empty">
			<h2>Chưa có kết quả phù hợp</h2>
			<p>Hãy thử thay đổi tiêu chí tìm kiếm để xem các tin đăng khác.</p>
		</div>
	<?php endif; ?>
	<?php
	wp_reset_postdata();

	$html = ob_get_clean();

	wp_send_json_success(array(
		'html' => $html
	));
}
add_action('wp_ajax_reco_sale_search', 'reco_ajax_sale_search');
add_action('wp_ajax_nopriv_reco_sale_search', 'reco_ajax_sale_search');
