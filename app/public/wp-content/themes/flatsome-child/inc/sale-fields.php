<?php
/**
 * Editable sale posting fields for "Tin rao bán".
 */

defined('ABSPATH') || exit;

function reco_register_sale_detail_fields()
{
	if (!function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key' => 'group_reco_sale_details',
			'title' => 'Thông tin tin rao bán',
			'fields' => array(
				array(
					'key' => 'field_reco_sale_tab_general',
					'label' => 'Thông tin cơ bản',
					'type' => 'tab',
					'placement' => 'top',
				),
				array(
					'key' => 'field_reco_sale_project_related',
					'label' => 'Dự án liên quan',
					'name' => 'reco_sale_project_related',
					'type' => 'relationship',
					'instructions' => 'Chọn dự án liên quan đến tin rao bán này (nếu có).',
					'post_type' => array('reco_project'),
					'filters' => array('search'),
					'return_format' => 'id',
					'min' => 0,
					'max' => 1,
				),
				array(
					'key' => 'field_reco_sale_gallery',
					'label' => 'Các hình ảnh liên quan',
					'name' => 'reco_sale_gallery',
					'type' => 'gallery',
					'instructions' => 'Chọn tối đa 5 hình ảnh thực tế của bất động sản.',
					'return_format' => 'id',
					'preview_size' => 'medium',
					'library' => 'all',
					'max' => 5,
				),
				array(
					'key' => 'field_reco_sale_tab_details',
					'label' => 'Chi tiết bất động sản',
					'type' => 'tab',
					'placement' => 'top',
				),
				array(
					'key' => 'field_reco_sale_price_value',
					'label' => 'Giá bán',
					'name' => 'reco_sale_price_value',
					'type' => 'number',
					'instructions' => 'Nhập giá bán. Ví dụ: 3.4',
					'placeholder' => 'Ví dụ: 3.4',
					'min' => 0,
					'step' => 0.01,
					'wrapper' => array('width' => 50),
				),
				array(
					'key' => 'field_reco_sale_price_unit',
					'label' => 'Đơn vị giá',
					'name' => 'reco_sale_price_unit',
					'type' => 'select',
					'choices' => array(
						'ty' => 'Tỷ',
						'trieu' => 'Triệu',
					),
					'default_value' => 'ty',
					'return_format' => 'value',
					'ui' => 1,
					'wrapper' => array('width' => 50),
				),
				array(
					'key' => 'field_reco_sale_province',
					'label' => 'Tỉnh/Thành phố',
					'name' => 'reco_sale_province',
					'type' => 'select',
					'instructions' => 'Chọn Tỉnh/Thành phố (dựa theo bản đồ 34 tỉnh sáp nhập mới).',
					'choices' => array(), // Populated dynamically
					'allow_null' => 1,
					'ui' => 1,
					'wrapper' => array('width' => 25),
				),
				array(
					'key' => 'field_reco_sale_commune',
					'label' => 'Phường/Xã',
					'name' => 'reco_sale_commune',
					'type' => 'select',
					'instructions' => 'Chọn Phường/Xã (sẽ tự động tải khi chọn Tỉnh).',
					'choices' => array(),
					'allow_null' => 1,
					'ui' => 1,
					'ajax' => 0,
					'wrapper' => array('width' => 25),
				),
				array(
					'key' => 'field_reco_sale_contact_phone',
					'label' => 'Số điện thoại liên hệ',
					'name' => 'reco_sale_contact_phone',
					'type' => 'text',
					'instructions' => 'Nhập số điện thoại liên hệ cho tin đăng này.',
					'wrapper' => array('width' => 50),
				),
				array(
					'key' => 'field_reco_sale_bedrooms',
					'label' => 'Số phòng ngủ',
					'name' => 'reco_sale_bedrooms',
					'type' => 'number',
					'min' => 0,
					'step' => 1,
					'wrapper' => array('width' => 25),
				),
				array(
					'key' => 'field_reco_sale_bathrooms',
					'label' => 'Số phòng vệ sinh',
					'name' => 'reco_sale_bathrooms',
					'type' => 'number',
					'min' => 0,
					'step' => 1,
					'wrapper' => array('width' => 25),
				),
				array(
					'key' => 'field_reco_sale_area',
					'label' => 'Diện tích',
					'name' => 'reco_sale_area',
					'type' => 'number',
					'append' => 'm²',
					'min' => 0,
					'step' => 0.01,
					'wrapper' => array('width' => 25),
				),
				array(
					'key' => 'field_reco_sale_direction',
					'label' => 'Hướng',
					'name' => 'reco_sale_direction',
					'type' => 'select',
					'choices' => array(
						'' => 'Không xác định',
						'dong' => 'Đông',
						'tay' => 'Tây',
						'nam' => 'Nam',
						'bac' => 'Bắc',
						'dong-nam' => 'Đông Nam',
						'dong-bac' => 'Đông Bắc',
						'tay-nam' => 'Tây Nam',
						'tay-bac' => 'Tây Bắc',
					),
					'default_value' => '',
					'return_format' => 'value',
					'ui' => 1,
					'wrapper' => array('width' => 25),
				),
				array(
					'key' => 'field_reco_sale_tab_location',
					'label' => 'Bản đồ',
					'type' => 'tab',
					'placement' => 'top',
				),
				array(
					'key' => 'field_reco_sale_map',
					'label' => 'Mã nhúng bản đồ (Iframe)',
					'name' => 'reco_sale_map',
					'type' => 'textarea',
					'instructions' => 'Dán mã nhúng iframe của Google Maps vào đây để hiển thị bản đồ.',
					'rows' => 4,
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'reco_sale',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => array(),
			'active' => true,
			'show_in_rest' => 1,
		)
	);
}
add_action('acf/init', 'reco_register_sale_detail_fields');
