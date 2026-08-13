<?php
/**
 * Editable project-detail fields.
 *
 * The field keys intentionally keep the original demo keys so existing project
 * data continues to work when the richer detail layout is enabled.
 */

defined( 'ABSPATH' ) || exit;

function reco_register_project_detail_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_reco_project_details',
			'title'                 => 'Thông tin trang chi tiết dự án',
			'fields'                => array(
				array(
					'key'       => 'field_reco_tab_general',
					'label'     => 'Thông tin chung',
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'          => 'field_reco_project_tagline',
					'label'        => 'Thông điệp ngắn',
					'name'         => 'reco_project_tagline',
					'type'         => 'text',
					'instructions' => 'Một câu ngắn hiển thị cạnh tên dự án.',
					'wrapper'      => array( 'width' => 50 ),
				),
				array(
					'key'      => 'field_reco_project_address',
					'label'    => 'Địa chỉ',
					'name'     => 'reco_project_address',
					'type'     => 'text',
					'wrapper'  => array( 'width' => 50 ),
				),
				array(
					'key'           => 'field_reco_project_status',
					'label'         => 'Trạng thái',
					'name'          => 'reco_project_status',
					'type'          => 'select',
					'choices'       => array(
						'dang-mo-ban'   => 'Đang mở bán',
						'sap-mo-ban'    => 'Sắp mở bán',
						'dang-cap-nhat' => 'Đang cập nhật',
					),
					'default_value' => 'dang-cap-nhat',
					'return_format' => 'value',
					'ui'            => 1,
					'wrapper'       => array( 'width' => 25 ),
				),
				array(
					'key'           => 'field_reco_project_transaction',
					'label'         => 'Hình thức giao dịch',
					'name'          => 'reco_project_transaction',
					'type'          => 'select',
					'choices'       => reco_project_transaction_choices(),
					'default_value' => 'mua',
					'return_format' => 'value',
					'ui'            => 1,
					'wrapper'       => array( 'width' => 25 ),
				),
				array(
					'key'           => 'field_reco_project_price',
					'label'         => 'Giá bán',
					'name'          => 'reco_project_price_value',
					'type'          => 'number',
					'instructions'  => 'Nhập giá bán thực tế theo đơn vị tỷ đồng. Để trống nếu giá là Liên hệ.',
					'placeholder'   => 'Ví dụ: 3.5',
					'append'        => 'tỷ đồng',
					'min'           => 0.01,
					'step'          => 0.01,
					'wrapper'       => array( 'width' => 25 ),
				),
				array(
					'key'           => 'field_reco_project_hotline',
					'label'         => 'Hotline dự án',
					'name'          => 'reco_project_hotline',
					'type'          => 'text',
					'default_value' => '0934 524 445',
					'wrapper'       => array( 'width' => 25 ),
				),
				array(
					'key'          => 'field_reco_project_gallery',
					'label'        => 'Bộ ảnh mở đầu',
					'name'         => 'reco_project_gallery',
					'type'         => 'gallery',
					'instructions' => 'Năm ảnh đầu tạo thành lưới ảnh nổi bật giống trang mẫu.',
					'return_format' => 'id',
					'preview_size' => 'medium',
					'library'      => 'all',
					'min'          => 1,
					'max'          => 12,
				),

				array(
					'key'       => 'field_reco_tab_overview',
					'label'     => 'Tổng quan',
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_reco_project_overview_heading',
					'label'         => 'Tiêu đề tổng quan',
					'name'          => 'reco_project_overview_heading',
					'type'          => 'text',
					'default_value' => 'Tổng quan dự án',
					'wrapper'       => array( 'width' => 40 ),
				),
				array(
					'key'          => 'field_reco_project_overview_image',
					'label'        => 'Ảnh tổng quan',
					'name'         => 'reco_project_overview_image',
					'type'         => 'image',
					'return_format' => 'id',
					'preview_size' => 'medium',
					'library'      => 'all',
					'wrapper'      => array( 'width' => 60 ),
				),
				array(
					'key'          => 'field_reco_project_overview_intro',
					'label'        => 'Đoạn giới thiệu dưới tên dự án',
					'name'         => 'reco_project_overview_intro',
					'type'         => 'wysiwyg',
					'tabs'         => 'all',
					'toolbar'      => 'basic',
					'media_upload' => 0,
				),
				array(
					'key'          => 'field_reco_project_overview_content',
					'label'        => 'Mô tả tổng quan chi tiết',
					'name'         => 'reco_project_overview_content',
					'type'         => 'wysiwyg',
					'tabs'         => 'all',
					'toolbar'      => 'full',
					'media_upload' => 1,
				),
				array(
					'key'          => 'field_reco_project_facts',
					'label'        => 'Bảng thông số dự án',
					'name'         => 'reco_project_facts',
					'type'         => 'repeater',
					'instructions' => 'Ví dụ: Tên thương mại, chủ đầu tư, tổng diện tích, pháp lý, bàn giao.',
					'layout'       => 'table',
					'button_label' => 'Thêm thông số',
					'min'          => 0,
					'max'          => 14,
					'sub_fields'   => array(
						array(
							'key'      => 'field_reco_fact_label',
							'label'    => 'Nhãn',
							'name'     => 'reco_fact_label',
							'type'     => 'text',
							'required' => 1,
							'wrapper'  => array( 'width' => 35 ),
						),
						array(
							'key'      => 'field_reco_fact_value',
							'label'    => 'Nội dung',
							'name'     => 'reco_fact_value',
							'type'     => 'text',
							'required' => 1,
							'wrapper'  => array( 'width' => 65 ),
						),
					),
				),

				array(
					'key'       => 'field_reco_tab_location',
					'label'     => 'Vị trí & liên kết vùng',
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'          => 'field_reco_project_location_tabs',
					'label'        => 'Các tab vị trí',
					'name'         => 'reco_project_location_tabs',
					'type'         => 'repeater',
					'instructions' => 'Mặc định gồm 2 tab theo thứ tự: Vị trí và Liên kết vùng.',
					'layout'       => 'block',
					'button_label' => 'Thêm tab vị trí',
					'min'          => 2,
					'max'          => 4,
					'sub_fields'   => array(
						array(
							'key'      => 'field_reco_location_tab_label',
							'label'    => 'Tên tab',
							'name'     => 'reco_location_tab_label',
							'type'     => 'text',
							'required' => 1,
							'wrapper'  => array( 'width' => 30 ),
						),
						array(
							'key'      => 'field_reco_location_tab_heading',
							'label'    => 'Tiêu đề nội dung',
							'name'     => 'reco_location_tab_heading',
							'type'     => 'text',
							'wrapper'  => array( 'width' => 70 ),
						),
						array(
							'key'          => 'field_reco_location_tab_content',
							'label'        => 'Nội dung',
							'name'         => 'reco_location_tab_content',
							'type'         => 'wysiwyg',
							'toolbar'      => 'full',
							'media_upload' => 0,
						),
						array(
							'key'          => 'field_reco_location_tab_image',
							'label'        => 'Ảnh/bản đồ',
							'name'         => 'reco_location_tab_image',
							'type'         => 'image',
							'return_format' => 'id',
							'preview_size' => 'medium',
							'library'      => 'all',
						),
					),
				),

				array(
					'key'       => 'field_reco_tab_amenities',
					'label'     => 'Tiện ích',
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_reco_project_amenities_heading',
					'label'         => 'Tiêu đề tiện ích',
					'name'          => 'reco_project_amenities_heading',
					'type'          => 'text',
					'default_value' => 'Tiện ích dự án',
				),
				array(
					'key'          => 'field_reco_project_amenities_description',
					'label'        => 'Mô tả chung tiện ích',
					'name'         => 'reco_project_amenities_description',
					'type'         => 'wysiwyg',
					'instructions' => 'Nhập toàn bộ nội dung tiện ích tại đây; có thể dùng danh sách dấu đầu dòng trong trình soạn thảo.',
					'tabs'         => 'all',
					'toolbar'      => 'basic',
					'media_upload' => 0,
				),
				array(
					'key'          => 'field_reco_project_amenities_gallery',
					'label'        => 'Thư viện ảnh tiện ích',
					'name'         => 'reco_project_amenities_gallery',
					'type'         => 'gallery',
					'return_format' => 'id',
					'preview_size' => 'medium',
					'library'      => 'all',
					'min'          => 0,
					'max'          => 20,
				),

				array(
					'key'       => 'field_reco_tab_floorplans',
					'label'     => 'Mặt bằng',
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_reco_project_floorplan_heading',
					'label'         => 'Tiêu đề mặt bằng',
					'name'          => 'reco_project_floorplan_heading',
					'type'          => 'text',
					'default_value' => 'Mặt bằng tổng thể dự án',
				),
				array(
					'key'          => 'field_reco_project_floorplan_content',
					'label'        => 'Mô tả mặt bằng',
					'name'         => 'reco_project_floorplan_content',
					'type'         => 'wysiwyg',
					'toolbar'      => 'full',
					'media_upload' => 0,
				),
				array(
					'key'          => 'field_reco_project_floorplan_tabs',
					'label'        => 'Các mặt bằng',
					'name'         => 'reco_project_floorplan_tabs',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => 'Thêm mặt bằng',
					'min'          => 0,
					'max'          => 12,
					'sub_fields'   => array(
						array(
							'key'      => 'field_reco_floorplan_label',
							'label'    => 'Tên mặt bằng',
							'name'     => 'reco_floorplan_label',
							'type'     => 'text',
							'required' => 1,
							'wrapper'  => array( 'width' => 40 ),
						),
						array(
							'key'          => 'field_reco_floorplan_image',
							'label'        => 'Ảnh mặt bằng',
							'name'         => 'reco_floorplan_image',
							'type'         => 'image',
							'return_format' => 'id',
							'preview_size' => 'medium',
							'library'      => 'all',
							'required'     => 1,
							'wrapper'      => array( 'width' => 60 ),
						),
						array(
							'key'          => 'field_reco_floorplan_note',
							'label'        => 'Ghi chú',
							'name'         => 'reco_floorplan_note',
							'type'         => 'textarea',
							'rows'         => 3,
							'new_lines'    => 'br',
						),
					),
				),

				array(
					'key'       => 'field_reco_tab_apartment',
					'label'     => 'Căn hộ mẫu',
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_reco_project_apartment_heading',
					'label'         => 'Tiêu đề căn hộ mẫu',
					'name'          => 'reco_project_apartment_heading',
					'type'          => 'text',
					'default_value' => 'Hình ảnh căn hộ mẫu',
				),
				array(
					'key'          => 'field_reco_project_apartment_gallery',
					'label'        => 'Thư viện căn hộ mẫu',
					'name'         => 'reco_project_apartment_gallery',
					'type'         => 'gallery',
					'return_format' => 'id',
					'preview_size' => 'medium',
					'library'      => 'all',
					'min'          => 0,
					'max'          => 20,
				),

				array(
					'key'       => 'field_reco_tab_review',
					'label'     => 'Dự án liên quan',
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_reco_project_related',
					'label'         => 'Dự án liên quan',
					'name'          => 'reco_project_related',
					'type'          => 'relationship',
					'post_type'     => array( 'reco_project' ),
					'filters'       => array( 'search', 'taxonomy' ),
					'return_format' => 'id',
					'min'           => 0,
					'max'           => 8,
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'reco_project',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => array(),
			'active'                => true,
			'show_in_rest'          => 1,
		)
	);
}
add_action( 'acf/init', 'reco_register_project_detail_fields' );

/**
 * Seed the two standard location tabs without replacing saved project content.
 */
function reco_project_default_location_tabs( $value, $post_id, $field ) {
	$defaults = array(
		array(
			'field_reco_location_tab_label'   => 'Vị trí',
			'field_reco_location_tab_heading' => 'Vị trí dự án',
			'field_reco_location_tab_content' => '',
			'field_reco_location_tab_image'   => '',
		),
		array(
			'field_reco_location_tab_label'   => 'Liên kết vùng',
			'field_reco_location_tab_heading' => 'Liên kết vùng',
			'field_reco_location_tab_content' => '',
			'field_reco_location_tab_image'   => '',
		),
	);

	$value = is_array( $value ) ? array_values( $value ) : array();
	if ( ! $value ) {
		return $defaults;
	}

	$ordered   = array( null, null );
	$remaining = array();
	foreach ( $value as $row ) {
		$label = isset( $row['field_reco_location_tab_label'] ) ? trim( (string) $row['field_reco_location_tab_label'] ) : '';

		if ( null === $ordered[0] && in_array( $label, array( 'Vị trí', 'Vị trí dự án' ), true ) ) {
			$row['field_reco_location_tab_label'] = 'Vị trí';
			$ordered[0]                           = $row;
		} elseif ( null === $ordered[1] && in_array( $label, array( 'Liên kết vùng', 'Tiện ích vùng' ), true ) ) {
			$row['field_reco_location_tab_label'] = 'Liên kết vùng';
			$ordered[1]                           = $row;
		} else {
			$remaining[] = $row;
		}
	}

	// Keep unfamiliar custom tabs untouched. If there are no standard labels yet,
	// preserve their order and only append the missing standard row.
	if ( null === $ordered[0] && null === $ordered[1] ) {
		for ( $index = count( $value ); $index < count( $defaults ); ++$index ) {
			$value[] = $defaults[ $index ];
		}
		return $value;
	}

	$ordered[0] = null === $ordered[0] ? $defaults[0] : $ordered[0];
	$ordered[1] = null === $ordered[1] ? $defaults[1] : $ordered[1];

	return array_merge( $ordered, $remaining );
}
add_filter( 'acf/load_value/name=reco_project_location_tabs', 'reco_project_default_location_tabs', 20, 3 );

/**
 * Move legacy amenity rows into the shared description field when it is empty.
 */
function reco_project_legacy_amenities_description( $value, $post_id, $field ) {
	if ( trim( (string) $value ) || ! is_numeric( $post_id ) ) {
		return $value;
	}

	$row_count = absint( get_post_meta( (int) $post_id, 'reco_project_amenities', true ) );
	$items     = array();
	for ( $index = 0; $index < $row_count; ++$index ) {
		$name = trim( (string) get_post_meta( (int) $post_id, 'reco_project_amenities_' . $index . '_reco_amenity_name', true ) );
		if ( $name ) {
			$items[] = '<li>' . esc_html( $name ) . '</li>';
		}
	}

	return $items ? '<ul>' . implode( '', $items ) . '</ul>' : $value;
}
add_filter( 'acf/load_value/name=reco_project_amenities_description', 'reco_project_legacy_amenities_description', 20, 3 );
