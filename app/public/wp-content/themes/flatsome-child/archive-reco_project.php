<?php
/**
 * Filterable project archive — redesigned to match reco.nhaongay.vn/du-an.
 */

defined( 'ABSPATH' ) || exit;
get_header();

$found_posts = (int) $GLOBALS['wp_query']->found_posts;
?>
<main class="reco-project-archive reco-project-archive--v2" id="main-content">



	<!-- Hero Banner -->
	<header class="reco-project-archive__hero">
		<img class="reco-project-archive__hero-bg" src="<?php echo esc_url( reco_asset( 'images/hero-home.webp' ) ); ?>" alt="" width="1920" height="500" fetchpriority="high">
		<div class="reco-project-archive__hero-shade" aria-hidden="true"></div>
		<div class="reco-container reco-project-archive__hero-content">
			<span class="reco-project-archive__hero-sub">DỰ ÁN</span>
			<h1>BẤT ĐỘNG SẢN</h1>
			<div class="reco-project-archive__hero-divider" aria-hidden="true"></div>
			<p>Các dự án mới nhất của <strong>Nhà Ở Ngay RECO</strong></p>
		</div>
	</header>

	<!-- Results -->
	<section class="reco-section reco-project-archive__results">
		<div class="reco-container">

			<!-- Results Head -->
			<div class="reco-project-archive__results-head">
				<div class="reco-project-archive__results-title">
					<h2>DỰ ÁN</h2>
					<span>có <strong><?php echo esc_html( $found_posts ); ?></strong> sản phẩm</span>
				</div>
				<div class="reco-project-archive__results-sort">
					<label for="reco-project-sort">Sắp xếp theo:</label>
					<select id="reco-project-sort" name="sap-xep">
						<option value="moi-nhat" <?php selected( isset( $_GET['sap-xep'] ) ? $_GET['sap-xep'] : '', 'moi-nhat' ); ?>>Mới nhất</option>
						<option value="gia-tang" <?php selected( isset( $_GET['sap-xep'] ) ? $_GET['sap-xep'] : '', 'gia-tang' ); ?>>Giá tăng dần</option>
						<option value="gia-giam" <?php selected( isset( $_GET['sap-xep'] ) ? $_GET['sap-xep'] : '', 'gia-giam' ); ?>>Giá giảm dần</option>
						<option value="gia-thoa-thuan" <?php selected( isset( $_GET['sap-xep'] ) ? $_GET['sap-xep'] : '', 'gia-thoa-thuan' ); ?>>Giá thỏa thuận</option>
					</select>
					<?php if ( is_tax() ) : 
						$queried_object = get_queried_object();
						if ( $queried_object ) : ?>
							<input type="hidden" id="reco-project-tax" value="<?php echo esc_attr( $queried_object->taxonomy ); ?>">
							<input type="hidden" id="reco-project-term" value="<?php echo esc_attr( $queried_object->slug ); ?>">
						<?php endif;
					endif; ?>
				</div>
			</div>

			<!-- Card Grid -->
			<div id="reco-project-results-container">
				<?php if ( have_posts() ) : ?>
					<div class="reco-project-grid-v2">
						<?php reco_render_project_archive_cards(); ?>
					</div>
					<?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => '← Trước', 'next_text' => 'Sau →' ) ); ?>
				<?php else : ?>
				<div class="reco-project-archive__empty">
					<h2>Chưa tìm thấy dự án phù hợp</h2>
					<p>Hãy quay lại sau để xem các dự án mới nhất.</p>
				</div>
			<?php endif; ?>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>
