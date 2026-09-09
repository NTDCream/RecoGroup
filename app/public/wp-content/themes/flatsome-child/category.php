<?php
/**
 * News category archive.
 *
 * Reuses the news hub layout while limiting every news query to the
 * currently selected WordPress category.
 */

defined('ABSPATH') || exit;

get_header();

$category = get_queried_object();
if ($category instanceof WP_Term && 'category' === $category->taxonomy && function_exists('reco_render_news')) {
	reco_render_news($category);
}

get_footer();
