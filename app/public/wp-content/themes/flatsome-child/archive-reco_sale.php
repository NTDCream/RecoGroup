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
		<div class="reco-container" id="reco-sale-results-container">
			<div class="reco-sale-archive__results-head">
				<div class="reco-sale-archive__results-title">
					<h2>Kết quả</h2>
					<span><?php echo esc_html( sprintf( 'có %s sản phẩm', (int) $GLOBALS['wp_query']->found_posts ) ); ?></span>
				</div>
				<div class="reco-sale-archive__results-sort">
					<label for="reco-sale-sort">Sắp xếp theo:</label>
					<select id="reco-sale-sort" name="sap-xep">
						<option value="moi-nhat" <?php selected(isset($_GET['sap-xep']) ? $_GET['sap-xep'] : '', 'moi-nhat'); ?>>Mới nhất</option>
						<option value="gia-tang" <?php selected(isset($_GET['sap-xep']) ? $_GET['sap-xep'] : '', 'gia-tang'); ?>>Giá tăng dần</option>
						<option value="gia-giam" <?php selected(isset($_GET['sap-xep']) ? $_GET['sap-xep'] : '', 'gia-giam'); ?>>Giá giảm dần</option>
						<option value="gia-thoa-thuan" <?php selected(isset($_GET['sap-xep']) ? $_GET['sap-xep'] : '', 'gia-thoa-thuan'); ?>>Giá thỏa thuận</option>
					</select>
				</div>
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
