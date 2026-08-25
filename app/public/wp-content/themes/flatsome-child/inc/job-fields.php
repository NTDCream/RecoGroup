<?php
/**
 * SCF fields for Vị trí tuyển dụng (reco_job).
 *
 * Follows the same pattern as project-fields.php.
 * Title field is used as the job position name.
 */

defined( 'ABSPATH' ) || exit;

function reco_register_job_detail_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_reco_job_details',
			'title'                 => 'Thông tin vị trí tuyển dụng',
			'fields'                => array(
				array(
					'key'           => 'field_reco_job_department',
					'label'         => 'Bộ phận',
					'name'          => 'reco_job_department',
					'type'          => 'select',
					'instructions'  => 'Chọn bộ phận tuyển dụng.',
					'choices'       => array(
						'Bộ phận Kinh doanh'   => 'Bộ phận Kinh doanh',
						'Bộ phận HCNS'         => 'Bộ phận HCNS',
						'Bộ phận Marketing'    => 'Bộ phận Marketing',
						'Bộ phận Kế toán'      => 'Bộ phận Kế toán',
						'Bộ phận Sales Admin'  => 'Bộ phận Sales Admin',
						'Khác'                 => 'Khác',
					),
					'default_value' => 'Bộ phận Kinh doanh',
					'return_format' => 'value',
					'ui'            => 1,
					'wrapper'       => array( 'width' => 50 ),
				),
				array(
					'key'           => 'field_reco_job_branch',
					'label'         => 'Chi nhánh',
					'name'          => 'reco_job_branch',
					'type'          => 'select',
					'instructions'  => 'Chọn chi nhánh làm việc.',
					'choices'       => array(
						'Hà Nội'      => 'Hà Nội',
						'Nha Trang'   => 'Nha Trang',
						'Thái Nguyên' => 'Thái Nguyên',
						'Tuyên Quang' => 'Tuyên Quang',
					),
					'default_value' => 'Hà Nội',
					'return_format' => 'value',
					'ui'            => 1,
					'wrapper'       => array( 'width' => 50 ),
				),
				array(
					'key'          => 'field_reco_job_description',
					'label'        => 'Mô tả công việc',
					'name'         => 'reco_job_description',
					'type'         => 'wysiwyg',
					'instructions' => 'Mô tả chi tiết về vị trí, yêu cầu và quyền lợi.',
					'tabs'         => 'all',
					'toolbar'      => 'basic',
					'media_upload' => 0,
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'reco_job',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => array( 'the_content' ),
			'active'                => true,
			'show_in_rest'          => 1,
		)
	);
}
add_action( 'acf/init', 'reco_register_job_detail_fields' );
