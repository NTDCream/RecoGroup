<?php
/**
 * Archive page for "Tin rao bán" — property listing grid.
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main class="reco-sale-archive" id="main-content">
	<?php reco_render_sale_search_form(); ?>

	<section class="reco-section reco-sale-archive__results">
		<div class="reco-container">
			<div class="reco-sale-archive__results-head">
				<h2>Kết quả</h2>
				<span><?php echo esc_html( sprintf( '%s tin đăng', (int) $GLOBALS['wp_query']->found_posts ) ); ?></span>
			</div>

			<?php if ( have_posts() ) : ?>
				<div class="reco-sale-grid">
					<?php reco_render_sale_cards( $GLOBALS['wp_query'] ); ?>
				</div>
				<?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => '← Trước', 'next_text' => 'Sau →' ) ); ?>
			<?php else : ?>
				<div class="reco-sale-archive__empty">
					<h2>Không có kết quả phù hợp</h2>
					<p>Hãy thử thay đổi tiêu chí tìm kiếm hoặc quay lại sau để xem các tin đăng mới nhất.</p>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php get_footer(); ?>
