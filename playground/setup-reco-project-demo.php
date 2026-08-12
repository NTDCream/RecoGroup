<?php
/**
 * One-time, idempotent setup for the SCF project demo.
 *
 * Usage:
 *   php setup-reco-project-demo.php configure
 *   php setup-reco-project-demo.php seed
 */

$project_root = dirname( __DIR__ );
require $project_root . '/app/public/wp-load.php';

if ( ! function_exists( 'acf_import_post_type' ) || ! function_exists( 'acf_import_field_group' ) ) {
	fwrite( STDERR, "Secure Custom Fields is not active.\n" );
	exit( 1 );
}

$mode = isset( $argv[1] ) ? $argv[1] : 'configure';

function reco_demo_existing_id( $getter, $key ) {
	$existing = call_user_func( $getter, $key );
	return is_array( $existing ) && ! empty( $existing['ID'] ) ? (int) $existing['ID'] : 0;
}

function reco_demo_configure() {
	$post_type = array(
		'ID'                     => reco_demo_existing_id( 'acf_get_post_type', 'post_type_reco_project' ),
		'key'                    => 'post_type_reco_project',
		'title'                  => 'Dự án',
		'active'                 => true,
		'post_type'              => 'reco_project',
		'advanced_configuration' => true,
		'labels'                 => array(
			'name'                  => 'Dự án',
			'singular_name'         => 'Dự án',
			'menu_name'             => 'Dự án',
			'all_items'             => 'Tất cả dự án',
			'add_new'               => 'Thêm dự án',
			'add_new_item'          => 'Thêm dự án mới',
			'edit_item'             => 'Sửa dự án',
			'new_item'              => 'Dự án mới',
			'view_item'             => 'Xem dự án',
			'view_items'            => 'Xem các dự án',
			'search_items'          => 'Tìm dự án',
			'not_found'             => 'Chưa có dự án',
			'not_found_in_trash'    => 'Không có dự án trong thùng rác',
			'archives'              => 'Danh mục dự án',
			'featured_image'        => 'Ảnh đại diện',
			'set_featured_image'    => 'Chọn ảnh đại diện',
			'remove_featured_image' => 'Bỏ ảnh đại diện',
		),
		'description'            => 'Danh mục dự án bất động sản do RECO giới thiệu.',
		'public'                 => true,
		'publicly_queryable'     => true,
		'show_ui'                => true,
		'show_in_menu'           => true,
		'show_in_admin_bar'      => true,
		'show_in_nav_menus'      => true,
		'show_in_rest'           => true,
		'menu_position'          => 5,
		'menu_icon'              => 'dashicons-building',
		'supports'               => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes' ),
		'taxonomies'             => array( 'reco_project_type', 'reco_location', 'reco_project_tag' ),
		'has_archive'            => true,
		'has_archive_slug'       => 'du-an',
		'rewrite'                => array(
			'permalink_rewrite' => 'custom_permalink',
			'slug'              => 'du-an',
			'feeds'             => false,
			'pages'             => true,
			'with_front'        => false,
		),
		'query_var'              => 'post_type_key',
		'can_export'             => true,
		'enter_title_here'       => 'Nhập tên dự án',
	);
	acf_import_post_type( $post_type );

	$taxonomies = array(
		array(
			'ID'                     => reco_demo_existing_id( 'acf_get_taxonomy', 'taxonomy_reco_project_type' ),
			'key'                    => 'taxonomy_reco_project_type',
			'title'                  => 'Loại bất động sản',
			'active'                 => true,
			'taxonomy'               => 'reco_project_type',
			'object_type'            => array( 'reco_project' ),
			'advanced_configuration' => true,
			'labels'                 => array(
				'name'          => 'Loại bất động sản',
				'singular_name' => 'Loại bất động sản',
				'menu_name'     => 'Loại bất động sản',
				'all_items'     => 'Tất cả loại bất động sản',
				'edit_item'     => 'Sửa loại bất động sản',
				'add_new_item'  => 'Thêm loại bất động sản',
			),
			'public'                 => true,
			'publicly_queryable'     => true,
			'hierarchical'           => true,
			'show_ui'                => true,
			'show_in_menu'           => true,
			'show_in_rest'           => true,
			'show_admin_column'      => true,
			'rewrite'                => array( 'permalink_rewrite' => 'custom_permalink', 'slug' => 'loai-du-an', 'with_front' => false ),
		),
		array(
			'ID'                     => reco_demo_existing_id( 'acf_get_taxonomy', 'taxonomy_reco_location' ),
			'key'                    => 'taxonomy_reco_location',
			'title'                  => 'Địa điểm',
			'active'                 => true,
			'taxonomy'               => 'reco_location',
			'object_type'            => array( 'reco_project' ),
			'advanced_configuration' => true,
			'labels'                 => array(
				'name'          => 'Địa điểm',
				'singular_name' => 'Địa điểm',
				'menu_name'     => 'Địa điểm',
				'all_items'     => 'Tất cả địa điểm',
				'edit_item'     => 'Sửa địa điểm',
				'add_new_item'  => 'Thêm địa điểm',
			),
			'public'                 => true,
			'publicly_queryable'     => true,
			'hierarchical'           => true,
			'show_ui'                => true,
			'show_in_menu'           => true,
			'show_in_rest'           => true,
			'show_admin_column'      => true,
			'rewrite'                => array( 'permalink_rewrite' => 'custom_permalink', 'slug' => 'dia-diem', 'with_front' => false ),
		),
		array(
			'ID'                     => reco_demo_existing_id( 'acf_get_taxonomy', 'taxonomy_reco_project_tag' ),
			'key'                    => 'taxonomy_reco_project_tag',
			'title'                  => 'Thẻ dự án',
			'active'                 => true,
			'taxonomy'               => 'reco_project_tag',
			'object_type'            => array( 'reco_project' ),
			'advanced_configuration' => true,
			'labels'                 => array(
				'name'          => 'Thẻ dự án',
				'singular_name' => 'Thẻ dự án',
				'menu_name'     => 'Thẻ dự án',
				'all_items'     => 'Tất cả thẻ dự án',
				'edit_item'     => 'Sửa thẻ dự án',
				'add_new_item'  => 'Thêm thẻ dự án',
			),
			'public'                 => true,
			'publicly_queryable'     => true,
			'hierarchical'           => false,
			'show_ui'                => true,
			'show_in_menu'           => true,
			'show_in_rest'           => true,
			'show_admin_column'      => true,
			'rewrite'                => array( 'permalink_rewrite' => 'custom_permalink', 'slug' => 'the-du-an', 'with_front' => false ),
		),
	);

	foreach ( $taxonomies as $taxonomy ) {
		acf_import_taxonomy( $taxonomy );
	}

	$field_group = array(
		'ID'       => reco_demo_existing_id( 'acf_get_field_group', 'group_reco_project_details' ),
		'key'      => 'group_reco_project_details',
		'title'    => 'Thông tin dự án',
		'fields'   => array(
			array(
				'key' => 'field_reco_project_tagline',
				'label' => 'Thông điệp ngắn',
				'name' => 'reco_project_tagline',
				'type' => 'text',
				'instructions' => 'Một câu ngắn hiển thị dưới tên dự án.',
				'required' => 1,
				'wrapper' => array( 'width' => 50 ),
			),
			array(
				'key' => 'field_reco_project_address',
				'label' => 'Địa chỉ',
				'name' => 'reco_project_address',
				'type' => 'text',
				'required' => 0,
				'wrapper' => array( 'width' => 50 ),
			),
			array(
				'key' => 'field_reco_project_status',
				'label' => 'Trạng thái',
				'name' => 'reco_project_status',
				'type' => 'select',
				'choices' => array(
					'dang-mo-ban' => 'Đang mở bán',
					'sap-mo-ban' => 'Sắp mở bán',
					'dang-cap-nhat' => 'Đang cập nhật',
				),
				'default_value' => 'dang-cap-nhat',
				'return_format' => 'value',
				'ui' => 1,
				'wrapper' => array( 'width' => 35 ),
			),
			array(
				'key' => 'field_reco_project_gallery',
				'label' => 'Thư viện ảnh',
				'name' => 'reco_project_gallery',
				'type' => 'gallery',
				'instructions' => 'Kéo thả để sắp xếp ảnh. Ba ảnh đầu dùng cho bố cục giới thiệu.',
				'required' => 1,
				'return_format' => 'id',
				'preview_size' => 'medium',
				'library' => 'all',
				'min' => 1,
				'max' => 12,
				'wrapper' => array( 'width' => 65 ),
			),
			array(
				'key' => 'field_reco_project_facts',
				'label' => 'Thông tin nhanh',
				'name' => 'reco_project_facts',
				'type' => 'repeater',
				'instructions' => 'Ví dụ: Chủ đầu tư, quy mô, pháp lý.',
				'layout' => 'table',
				'button_label' => 'Thêm thông tin',
				'min' => 0,
				'max' => 8,
				'sub_fields' => array(
					array(
						'key' => 'field_reco_fact_label',
						'label' => 'Nhãn',
						'name' => 'reco_fact_label',
						'type' => 'text',
						'required' => 1,
						'wrapper' => array( 'width' => 35 ),
					),
					array(
						'key' => 'field_reco_fact_value',
						'label' => 'Nội dung',
						'name' => 'reco_fact_value',
						'type' => 'text',
						'required' => 1,
						'wrapper' => array( 'width' => 65 ),
					),
				),
			),
		),
		'location' => array(
			array(
				array( 'param' => 'post_type', 'operator' => '==', 'value' => 'reco_project' ),
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
	);
	acf_import_field_group( $field_group );

	flush_rewrite_rules( false );
	echo "SCF project structure configured.\n";
}

function reco_demo_ensure_term( $name, $taxonomy, $parent = 0 ) {
	$existing = term_exists( $name, $taxonomy, $parent );
	if ( $existing ) {
		return (int) ( is_array( $existing ) ? $existing['term_id'] : $existing );
	}

	$created = wp_insert_term( $name, $taxonomy, array( 'parent' => $parent ) );
	if ( is_wp_error( $created ) ) {
		throw new RuntimeException( $created->get_error_message() );
	}
	return (int) $created['term_id'];
}

function reco_demo_import_image( $source, $filename, $title, $alt ) {
	$existing = get_posts(
		array(
			'post_type' => 'attachment',
			'post_status' => 'inherit',
			'posts_per_page' => 1,
			'fields' => 'ids',
			'meta_key' => '_reco_demo_source',
			'meta_value' => $filename,
		)
	);
	if ( $existing ) {
		return (int) $existing[0];
	}

	if ( ! file_exists( $source ) ) {
		throw new RuntimeException( 'Missing image: ' . $source );
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$tmp = wp_tempnam( $filename );
	if ( ! $tmp || ! copy( $source, $tmp ) ) {
		throw new RuntimeException( 'Could not stage image: ' . $source );
	}

	$file = array(
		'name' => $filename,
		'tmp_name' => $tmp,
	);
	$attachment_id = media_handle_sideload( $file, 0, $title );
	if ( is_wp_error( $attachment_id ) ) {
		@unlink( $tmp );
		throw new RuntimeException( $attachment_id->get_error_message() );
	}

	update_post_meta( $attachment_id, '_wp_attachment_image_alt', $alt );
	update_post_meta( $attachment_id, '_reco_demo_source', $filename );
	return (int) $attachment_id;
}

function reco_demo_seed() {
	if ( ! post_type_exists( 'reco_project' ) ) {
		throw new RuntimeException( 'The reco_project post type is not registered. Run configure first.' );
	}

	$hanoi    = reco_demo_ensure_term( 'Hà Nội', 'reco_location' );
	$location = array(
		'tay-ho'    => reco_demo_ensure_term( 'Tây Hồ', 'reco_location', $hanoi ),
		'thanh-tri' => reco_demo_ensure_term( 'Thanh Trì', 'reco_location', $hanoi ),
		'ba-vi'     => reco_demo_ensure_term( 'Ba Vì', 'reco_location', $hanoi ),
	);

	$asset_root = dirname( __DIR__ ) . '/playground/reco-project-demo-assets';
	$projects = array(
		array(
			'slug' => 'celestine-westlake',
			'title' => 'Celestine Westlake',
			'excerpt' => 'Không gian căn hộ cao cấp tại 300 Võ Chí Công, kết nối trực tiếp nhịp sống Hồ Tây.',
			'content' => '<p>Celestine Westlake gồm hai tháp căn hộ với hệ tiện ích hiện đại và tầm nhìn hướng Hồ Tây. Dự án phù hợp nhu cầu an cư lâu dài trong khu vực có hạ tầng hoàn thiện.</p><p>Thông tin mẫu được rút gọn để kiểm tra quy trình quản trị nội dung bằng SCF.</p>',
			'tagline' => 'Viên ngọc bên Hồ Tây',
			'address' => '300 Võ Chí Công, phường Tây Hồ, Hà Nội',
			'status' => 'dang-mo-ban',
			'type' => 'Căn hộ cao cấp',
			'location' => $location['tay-ho'],
			'tags' => array( 'Ven Hồ Tây', 'Sở hữu lâu dài', 'Tiện ích cao cấp' ),
			'facts' => array(
				array( 'label' => 'Chủ đầu tư', 'value' => 'Tập đoàn VINAENCO' ),
				array( 'label' => 'Quy mô', 'value' => '2 tháp, 216 căn hộ' ),
				array( 'label' => 'Dự kiến bàn giao', 'value' => 'Từ năm 2027' ),
			),
			'images' => array(
				array( 'celestine-01.jpg', 'Toàn cảnh Celestine Westlake' ),
				array( 'celestine-02.jpg', 'Phối cảnh dự án Celestine Westlake' ),
				array( 'celestine-03.webp', 'Tiện ích bể bơi Celestine Westlake' ),
			),
		),
		array(
			'slug' => 'palmy-biztown',
			'title' => 'Palmy Biztown',
			'excerpt' => 'Tổ hợp thương mại đa chức năng tại cửa ngõ phía Nam Hà Nội, thuận lợi cho kinh doanh và dịch vụ.',
			'content' => '<p>Palmy Biztown định hướng hình thành một điểm đến thương mại và văn phòng có khả năng kết nối nhanh với các tuyến vành đai phía Nam thành phố.</p><p>Dữ liệu ảnh, vị trí và điểm nổi bật đều có thể cập nhật trực tiếp trong WP Admin.</p>',
			'tagline' => 'Trái tim kinh doanh sầm uất',
			'address' => 'Khu vực Vành đai 3,5, Thanh Trì, Hà Nội',
			'status' => 'sap-mo-ban',
			'type' => 'Thương mại & văn phòng',
			'location' => $location['thanh-tri'],
			'tags' => array( 'Kinh doanh', 'Kết nối vành đai', 'Đa chức năng' ),
			'facts' => array(
				array( 'label' => 'Loại hình', 'value' => 'Thương mại, văn phòng, dịch vụ' ),
				array( 'label' => 'Khu vực', 'value' => 'Cửa ngõ phía Nam Hà Nội' ),
				array( 'label' => 'Điểm nhấn', 'value' => 'Kết nối Vành đai 3,5' ),
			),
			'images' => array(
				array( 'palmy-01.jpg', 'Toàn cảnh Palmy Biztown' ),
				array( 'palmy-02.jpg', 'Phối cảnh Palmy Biztown' ),
				array( 'palmy-03.webp', 'Phối cảnh mặt đường Palmy Biztown' ),
			),
		),
		array(
			'slug' => 'cong-vien-thien-duong',
			'title' => 'Công viên Thiên Đường',
			'excerpt' => 'Quần thể sinh thái tâm linh được quy hoạch trang nghiêm, xanh và chú trọng giá trị bền vững cho nhiều thế hệ.',
			'content' => '<p>Công viên Thiên Đường kết hợp cảnh quan sinh thái với không gian tưởng niệm được tổ chức chỉn chu. Hệ thống khuôn viên đa dạng phục vụ nhu cầu riêng của từng gia đình.</p><p>Trang mẫu minh họa cách quản lý nhiều ảnh và thông tin dự án mà không cần sửa nội dung trong file PHP.</p>',
			'tagline' => 'Giá trị vĩnh hằng',
			'address' => 'Khu vực Ba Vì, Hà Nội',
			'status' => 'dang-mo-ban',
			'type' => 'Bất động sản tâm linh',
			'location' => $location['ba-vi'],
			'tags' => array( 'Sinh thái', 'Tâm linh', 'Quy hoạch đồng bộ' ),
			'facts' => array(
				array( 'label' => 'Loại hình', 'value' => 'Công viên nghĩa trang sinh thái' ),
				array( 'label' => 'Không gian', 'value' => 'Khuôn viên đơn, đôi và gia tộc' ),
				array( 'label' => 'Khu vực', 'value' => 'Ba Vì, Hà Nội' ),
			),
			'images' => array(
				array( 'thien-duong-01.jpg', 'Toàn cảnh Công viên Thiên Đường' ),
				array( 'thien-duong-02.jpg', 'Cảnh quan Công viên Thiên Đường' ),
				array( 'thien-duong-03.jpg', 'Tổng quan Công viên Thiên Đường' ),
			),
		),
	);

	foreach ( $projects as $index => $project ) {
		$existing = get_page_by_path( $project['slug'], OBJECT, 'reco_project' );
		$post_data = array(
			'ID' => $existing ? (int) $existing->ID : 0,
			'post_type' => 'reco_project',
			'post_status' => 'publish',
			'post_title' => $project['title'],
			'post_name' => $project['slug'],
			'post_excerpt' => $project['excerpt'],
			'post_content' => $project['content'],
			'menu_order' => $index + 1,
		);
		$post_id = wp_insert_post( wp_slash( $post_data ), true );
		if ( is_wp_error( $post_id ) ) {
			throw new RuntimeException( $post_id->get_error_message() );
		}

		$gallery = array();
		foreach ( $project['images'] as $image ) {
			$gallery[] = reco_demo_import_image( $asset_root . '/' . $image[0], $image[0], $project['title'], $image[1] );
		}

		set_post_thumbnail( $post_id, $gallery[0] );
		update_field( 'field_reco_project_tagline', $project['tagline'], $post_id );
		update_field( 'field_reco_project_address', $project['address'], $post_id );
		update_field( 'field_reco_project_status', $project['status'], $post_id );
		update_field( 'field_reco_project_gallery', $gallery, $post_id );

		$fact_rows = array();
		foreach ( $project['facts'] as $fact ) {
			$fact_rows[] = array(
				'field_reco_fact_label' => $fact['label'],
				'field_reco_fact_value' => $fact['value'],
			);
		}
		update_field( 'field_reco_project_facts', $fact_rows, $post_id );

		wp_set_object_terms( $post_id, array( $project['type'] ), 'reco_project_type', false );
		wp_set_object_terms( $post_id, array( $project['location'] ), 'reco_location', false );
		wp_set_object_terms( $post_id, $project['tags'], 'reco_project_tag', false );
		echo 'Seeded project #' . $post_id . ': ' . $project['title'] . "\n";
	}

	$test_page = get_page_by_path( 'test' );
	if ( $test_page ) {
		$result = wp_update_post(
			wp_slash(
				array(
					'ID' => $test_page->ID,
					'post_title' => 'Thử nghiệm dự án',
					'post_content' => '[reco_project_demo]',
				)
			),
			true
		);
		if ( is_wp_error( $result ) ) {
			throw new RuntimeException( $result->get_error_message() );
		}
		echo 'Updated Test page #' . $test_page->ID . "\n";
	}

	flush_rewrite_rules( false );
}

try {
	if ( 'configure' === $mode ) {
		reco_demo_configure();
	} elseif ( 'seed' === $mode ) {
		reco_demo_seed();
	} else {
		throw new InvalidArgumentException( 'Unknown mode: ' . $mode );
	}
} catch ( Throwable $error ) {
	fwrite( STDERR, 'ERROR: ' . $error->getMessage() . "\n" );
	exit( 1 );
}
