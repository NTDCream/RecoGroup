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
					</select>
				</div>
			</div>

			<!-- Card Grid -->
			<?php if ( have_posts() ) : ?>
				<div class="reco-project-grid-v2">
					<?php while ( have_posts() ) :
						the_post();
						$project_id = get_the_ID();

						$types     = reco_project_term_names( $project_id, 'reco_project_type' );
						$type_name = ! empty( $types ) ? $types[0] : 'Dự án';

						$province = reco_project_field( 'reco_project_province', $project_id );
						$commune  = reco_project_field( 'reco_project_commune', $project_id );
						$location_parts = array_filter( array( $commune, $province ) );
						$location = ! empty( $location_parts ) ? implode( ', ', $location_parts ) : 'Đang cập nhật';

						$status_raw = reco_project_field( 'reco_project_status', $project_id );
						$is_hot     = in_array( $status_raw, array( 'dang-mo-ban' ), true );

						$transaction_value = reco_project_field( 'reco_project_transaction', $project_id, 'mua' );
						$price             = reco_project_display_price( $project_id, $transaction_value );
						?>
						<article class="reco-pcard">
							<a class="reco-pcard__media" href="<?php the_permalink(); ?>" aria-label="Xem dự án <?php the_title_attribute(); ?>">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); ?>
								<?php endif; ?>
								<span class="reco-pcard__badge"><?php echo esc_html( $type_name ); ?></span>
								<span class="reco-pcard__btn">Chi tiết</span>
							</a>
							<?php if ( $is_hot ) : ?>
								<div class="reco-pcard__ribbon"><span>HOT</span></div>
							<?php endif; ?>
							<div class="reco-pcard__body">
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<div class="reco-pcard__divider" aria-hidden="true"></div>
								<p class="reco-pcard__location">
									<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
									<?php echo esc_html( $location ); ?>
								</p>
								<p class="reco-pcard__price"><em>Giá:</em> <strong><?php echo esc_html( $price ); ?></strong></p>
							</div>
						</article>
					<?php endwhile; ?>
				</div>
				<?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => '← Trước', 'next_text' => 'Sau →' ) ); ?>
			<?php else : ?>
				<div class="reco-project-archive__empty">
					<h2>Chưa tìm thấy dự án phù hợp</h2>
					<p>Hãy quay lại sau để xem các dự án mới nhất.</p>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php get_footer(); ?>
