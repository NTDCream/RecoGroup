<?php
/**
 * Flatsome Child — Nhà Ở Ngay RECO.
 */

defined('ABSPATH') || exit;

require_once get_stylesheet_directory() . '/inc/content.php';
require_once get_stylesheet_directory() . '/inc/project-fields.php';
require_once get_stylesheet_directory() . '/inc/job-fields.php';
require_once get_stylesheet_directory() . '/inc/sale-fields.php';

function reco_asset($path)
{
	return trailingslashit(get_stylesheet_directory_uri()) . 'assets/' . ltrim($path, '/');
}

function reco_theme_setup()
{
	load_child_theme_textdomain('flatsome-child', get_stylesheet_directory() . '/languages');
	register_nav_menus(
		array(
			'primary' => __('Điều hướng chính', 'flatsome-child'),
			'footer' => __('Điều hướng chân trang', 'flatsome-child'),
		)
	);
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('html5', array('search-form', 'comment-form', 'gallery', 'caption', 'style', 'script'));
}
add_action('after_setup_theme', 'reco_theme_setup', 20);

function reco_enqueue_assets()
{
	$style_path = get_stylesheet_directory() . '/assets/css/reco.css';
	$script_path = get_stylesheet_directory() . '/assets/js/reco.js';
	$style_version = file_exists($style_path) ? (string) filemtime($style_path) : wp_get_theme()->get('Version');
	$script_version = file_exists($script_path) ? (string) filemtime($script_path) : wp_get_theme()->get('Version');
	wp_enqueue_style(
		'reco-fonts',
		'https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&family=Lora:ital,wght@1,500;1,600&display=swap',
		array(),
		null
	);
	wp_enqueue_style('reco-theme', reco_asset('css/reco.css'), array('reco-fonts'), $style_version);
	wp_enqueue_script('reco-theme', reco_asset('js/reco.js'), array(), $script_version, true);
	wp_localize_script('reco-theme', 'recoAjax', array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('reco_load_more_news')
	));
}
add_action('wp_enqueue_scripts', 'reco_enqueue_assets', 90);

function reco_enqueue_project_admin_assets()
{
	$screen = function_exists('get_current_screen') ? get_current_screen() : null;
	if (!$screen || 'reco_project' !== $screen->post_type) {
		return;
	}

	$script_path = get_stylesheet_directory() . '/assets/js/reco-project-admin.js';
	$script_version = file_exists($script_path) ? (string) filemtime($script_path) : wp_get_theme()->get('Version');
	wp_enqueue_script('reco-project-admin', reco_asset('js/reco-project-admin.js'), array('jquery'), $script_version, true);
}
add_action('acf/input/admin_enqueue_scripts', 'reco_enqueue_project_admin_assets');

function reco_body_classes($classes)
{
	$classes[] = 'reco-site';
	if (is_front_page()) {
		$classes[] = 'reco-home';
	}
	return $classes;
}
add_filter('body_class', 'reco_body_classes');

function reco_register_lead_type()
{
	register_post_type(
		'reco_lead',
		array(
			'labels' => array(
				'name' => 'Khách hàng quan tâm',
				'singular_name' => 'Khách hàng quan tâm',
			),
			'public' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_icon' => 'dashicons-businessperson',
			'supports' => array('title', 'editor', 'custom-fields'),
		)
	);
}
add_action('init', 'reco_register_lead_type');

function reco_register_job_type()
{
	register_post_type(
		'reco_job',
		array(
			'labels' => array(
				'name' => 'Vị trí tuyển dụng',
				'singular_name' => 'Vị trí tuyển dụng',
				'add_new' => 'Thêm vị trí',
				'add_new_item' => 'Thêm vị trí mới',
				'edit_item' => 'Sửa vị trí',
				'new_item' => 'Vị trí mới',
				'view_item' => 'Xem vị trí',
				'search_items' => 'Tìm vị trí',
				'not_found' => 'Không tìm thấy vị trí nào',
				'not_found_in_trash' => 'Không có vị trí nào trong thùng rác',
			),
			'public' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_icon' => 'dashicons-megaphone',
			'supports' => array('title'),
			'has_archive' => false,
		)
	);
}
add_action('init', 'reco_register_job_type');



function reco_install_site_content()
{
	if (get_option('reco_site_version') === '1.0.0') {
		return;
	}

	$pages = array(
		'trang-chu' => 'Trang chủ',
		'gioi-thieu' => 'Giới thiệu',
		'du-an' => 'Dự án',
		'nha-dat-ban' => 'Nhà đất bán',
		'tin-tuc' => 'Tin tức',
		'noi-bo' => 'Nội bộ',
		'tuyen-dung' => 'Tuyển dụng',
		'lien-he' => 'Liên hệ',
	);

	$page_ids = array();
	foreach ($pages as $slug => $title) {
		$existing = get_page_by_path($slug);
		if ($existing) {
			$page_ids[$slug] = (int) $existing->ID;
			continue;
		}

		$page_ids[$slug] = wp_insert_post(
			array(
				'post_title' => $title,
				'post_name' => $slug,
				'post_status' => 'publish',
				'post_type' => 'page',
				'post_content' => '',
				'comment_status' => 'closed',
			)
		);
	}

	if (!empty($page_ids['trang-chu'])) {
		update_option('show_on_front', 'page');
		update_option('page_on_front', $page_ids['trang-chu']);
	}

	update_option('blogname', 'Nhà Ở Ngay RECO');
	update_option('blogdescription', 'Kiến tạo điểm đến an cư – Định hình giá trị thịnh vượng');
	update_option('permalink_structure', '/%postname%/');

	$menu_name = 'Menu chính RECO';
	$menu = wp_get_nav_menu_object($menu_name);
	$menu_id = $menu ? (int) $menu->term_id : wp_create_nav_menu($menu_name);
	if (!is_wp_error($menu_id)) {
		$existing_items = wp_get_nav_menu_items($menu_id);
		if (empty($existing_items)) {
			foreach ($pages as $slug => $title) {
				if (empty($page_ids[$slug])) {
					continue;
				}
				wp_update_nav_menu_item(
					$menu_id,
					0,
					array(
						'menu-item-title' => $title,
						'menu-item-object-id' => $page_ids[$slug],
						'menu-item-object' => 'page',
						'menu-item-type' => 'post_type',
						'menu-item-status' => 'publish',
					)
				);
			}
		}
		$locations = get_theme_mod('nav_menu_locations', array());
		$locations['primary'] = $menu_id;
		$locations['footer'] = $menu_id;
		set_theme_mod('nav_menu_locations', $locations);
	}

	flush_rewrite_rules(false);
}
add_action('init', 'reco_install_site_content', 30);

function reco_ensure_sale_page()
{
	if (get_option('reco_sale_page_created')) {
		return;
	}
	$existing = get_page_by_path('nha-dat-ban');
	if (!$existing) {
		wp_insert_post(array(
			'post_title'    => 'Nhà đất bán',
			'post_name'     => 'nha-dat-ban',
			'post_status'   => 'publish',
			'post_type'     => 'page',
			'post_content'  => '',
			'comment_status' => 'closed',
		));
	}
	update_option('reco_sale_page_created', '1');
}
add_action('init', 'reco_ensure_sale_page', 31);

function reco_contact_redirect($status)
{
	$target = wp_get_referer() ? wp_get_referer() : home_url('/lien-he/');
	wp_safe_redirect(add_query_arg('gui', sanitize_key($status), $target) . '#form-lien-he');
	exit;
}

function reco_handle_contact_form()
{
	if (!isset($_POST['reco_contact_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['reco_contact_nonce'])), 'reco_contact')) {
		reco_contact_redirect('loi');
	}

	if (!empty($_POST['website'])) {
		reco_contact_redirect('thanh-cong');
	}

	$name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
	$phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
	$email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
	$topic = isset($_POST['topic']) ? sanitize_text_field(wp_unslash($_POST['topic'])) : '';
	$message = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';

	if ('' === $name || '' === $phone) {
		reco_contact_redirect('thieu-thong-tin');
	}

	$lead_id = wp_insert_post(
		array(
			'post_type' => 'reco_lead',
			'post_status' => 'private',
			'post_title' => sprintf('%s – %s', $name, $phone),
			'post_content' => $message,
		)
	);

	if ($lead_id && !is_wp_error($lead_id)) {
		update_post_meta($lead_id, 'phone', $phone);
		update_post_meta($lead_id, 'email', $email);
		update_post_meta($lead_id, 'topic', $topic);
	}

	$subject = sprintf('[RECO] Khách hàng mới: %s', $name);
	$body = "Họ tên: {$name}\nSố điện thoại: {$phone}\nEmail: {$email}\nNhu cầu: {$topic}\n\nNội dung:\n{$message}";
	wp_mail(get_option('admin_email'), $subject, $body);

	reco_contact_redirect('thanh-cong');
}
add_action('admin_post_reco_contact', 'reco_handle_contact_form');
add_action('admin_post_nopriv_reco_contact', 'reco_handle_contact_form');

function reco_add_schema()
{
	$schema = array(
		'@context' => 'https://schema.org',
		'@type' => 'RealEstateAgent',
		'name' => 'Công ty Cổ phần Nhà Ở Ngay RECO',
		'url' => home_url('/'),
		'logo' => reco_asset('images/logo.png'),
		'telephone' => '+84934524445',
		'address' => array(
			'@type' => 'PostalAddress',
			'streetAddress' => '19–21 Vũ Trọng Phụng, Thanh Xuân Trung',
			'addressLocality' => 'Hà Nội',
			'addressCountry' => 'VN',
		),
	);
	printf('<script type="application/ld+json">%s</script>', wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
}
add_action('wp_head', 'reco_add_schema', 5);

function reco_add_favicon()
{
	echo '<link rel="shortcut icon" href="' . esc_url(get_stylesheet_directory_uri() . '/favicon.png') . '" type="image/png" />' . "\n";
}
add_action('wp_head', 'reco_add_favicon');
add_action('admin_head', 'reco_add_favicon');

function reco_track_post_views()
{
	if (is_admin() || is_preview() || wp_doing_ajax() || !is_singular('post')) {
		return;
	}

	$post_id = get_queried_object_id();
	if (!$post_id) {
		return;
	}

	$views = absint(get_post_meta($post_id, 'post_views_count', true));
	update_post_meta($post_id, 'post_views_count', $views + 1);
}
add_action('wp', 'reco_track_post_views');

add_action('wp_ajax_reco_load_more_news', 'reco_ajax_load_more_news');
add_action('wp_ajax_nopriv_reco_load_more_news', 'reco_ajax_load_more_news');
function reco_ajax_load_more_news() {
	check_ajax_referer('reco_load_more_news', 'nonce');
	$paged = isset($_POST['page']) ? max(2, (int) $_POST['page']) : 2;
	$category_id = isset($_POST['category']) ? absint($_POST['category']) : 0;
	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => 10,
		'offset' => 3 + (($paged - 1) * 10),
	);
	if ($category_id && get_category($category_id)) {
		$args['cat'] = $category_id;
	}
	$query = new WP_Query($args);
	if ($query->have_posts()) {
		ob_start();
		reco_render_news_list_items($query);
		wp_send_json_success(array('html' => ob_get_clean(), 'has_more' => $query->found_posts > $args['offset'] + $args['posts_per_page']));
	} else {
		wp_send_json_error('No posts found');
	}
	wp_die();
}

/**
 * Remove 'reco_sale' slug from permalinks for cleaner URLs
 */
function reco_remove_sale_slug( $post_link, $post ) {
	if ( 'reco_sale' === $post->post_type && 'publish' === $post->post_status ) {
		$post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
	}
	return $post_link;
}
add_filter( 'post_type_link', 'reco_remove_sale_slug', 10, 2 );

/**
 * Teach WordPress to resolve the root slug for 'reco_sale' posts
 */
function reco_add_cpt_post_names_to_main_query( $query ) {
	if ( ! $query->is_main_query() ) {
		return;
	}
	if ( is_admin() ) {
		return;
	}
	if ( ! empty( $query->query['name'] ) && empty( $query->query['post_type'] ) ) {
		$query->set( 'post_type', array( 'post', 'page', 'reco_sale' ) );
	}
}
add_action( 'pre_get_posts', 'reco_add_cpt_post_names_to_main_query' );
