<?php
/**
 * Single sale listing page — "Tin rao bán" detail.
 *
 * Layout modelled after reco.nhaongay.vn listing pages:
 * two-column layout with content on the left and a sticky
 * price / contact sidebar on the right.
 */

defined( 'ABSPATH' ) || exit;
get_header();

while ( have_posts() ) :
	the_post();

	$post_id   = get_the_ID();
	$gallery   = array_values( array_filter( array_map( 'absint', (array) reco_project_field( 'reco_sale_gallery', $post_id, array() ) ) ) );
	$bedrooms  = absint( reco_project_field( 'reco_sale_bedrooms', $post_id, 0 ) );
	$bathrooms = absint( reco_project_field( 'reco_sale_bathrooms', $post_id, 0 ) );
	$area      = floatval( reco_project_field( 'reco_sale_area', $post_id, 0 ) );
	$direction_value = reco_project_field( 'reco_sale_direction', $post_id, '' );
	$map_embed = reco_project_field( 'reco_sale_map', $post_id, '' );
	$related   = array_values( array_filter( array_map( 'absint', (array) reco_project_field( 'reco_sale_project_related', $post_id, array() ) ) ) );

	/* Price display */
	$price_value = floatval( reco_project_field( 'reco_sale_price_value', $post_id, 0 ) );
	$price_unit  = reco_project_field( 'reco_sale_price_unit', $post_id, 'ty' );
	$price_label = $price_value ? number_format( $price_value, ( fmod( $price_value, 1 ) ? 1 : 0 ), '.', '.' ) . ' ' . ( 'trieu' === $price_unit ? 'triệu' : 'tỷ' ) : 'Liên hệ';

	/* Direction label */
	$direction_labels = array(
		'dong'     => 'Đông',
		'tay'      => 'Tây',
		'nam'      => 'Nam',
		'bac'      => 'Bắc',
		'dong-nam' => 'Đông Nam',
		'dong-bac' => 'Đông Bắc',
		'tay-nam'  => 'Tây Nam',
		'tay-bac'  => 'Tây Bắc',
	);
	$direction_text = isset( $direction_labels[ $direction_value ] ) ? $direction_labels[ $direction_value ] : '';

	/* Fallback gallery from featured image */
	if ( ! $gallery && has_post_thumbnail() ) {
		$gallery[] = get_post_thumbnail_id();
	}

	/* Dates */
	$date_published = get_the_date( 'd/m/Y' );
	$date_modified  = get_the_modified_date( 'd/m/Y' );
?>
<article class="reco-sale-single" id="main-content">

	<!-- Breadcrumb -->
	<div class="reco-sale-breadcrumb">
		<div class="reco-container">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a>
			<span aria-hidden="true">/</span>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'reco_sale' ) ?: home_url( '/nha-dat-ban/' ) ); ?>">Nhà đất bán</a>
			<span aria-hidden="true">/</span>
			<span><?php the_title(); ?></span>
		</div>
	</div>

	<?php if ( $gallery ) : ?>
	<!-- Gallery mosaic 5 images -->
	<section class="reco-sale-gallery" aria-label="Ảnh bất động sản">
		<div class="reco-container">
			<div class="reco-sale-gallery__grid">
				<div class="reco-sale-gallery__main">
					<?php echo wp_get_attachment_image( $gallery[0], 'large', false, array( 'loading' => 'eager' ) ); ?>
				</div>
				<?php if ( count( $gallery ) > 1 ) : ?>
					<div class="reco-sale-gallery__side">
						<?php for ( $i = 1; $i < min(5, count($gallery)); $i++ ) : ?>
							<div class="reco-sale-gallery__side-item">
								<?php echo wp_get_attachment_image( $gallery[$i], 'medium_large', false, array( 'loading' => 'lazy' ) ); ?>
								<?php if ( $i === 4 && count( $gallery ) > 5 ) : ?>
									<div class="reco-sale-gallery__more">
										<span>+<?php echo count( $gallery ) - 5; ?> ảnh</span>
									</div>
								<?php endif; ?>
							</div>
						<?php endfor; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- Main content + Sidebar -->
	<div class="reco-sale-layout">
		<div class="reco-container reco-sale-layout__grid">

			<!-- LEFT: Content -->
			<div class="reco-sale-content">

				<!-- Title & badges -->
				<div class="reco-sale-header">
					<h1><?php the_title(); ?></h1>
				</div>

				<!-- Quick specs -->
				<div class="reco-sale-specs">
					<div class="reco-sale-specs__item">
						<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><text x="12" y="16" text-anchor="middle" font-size="8" fill="currentColor" stroke="none">m²</text></svg>
						<span><?php echo $area ? esc_html( $area ) . 'm2' : '—'; ?></span>
					</div>
					<div class="reco-sale-specs__divider"></div>
					<div class="reco-sale-specs__item">
						<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 12h18v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4z"/><path d="M3 12V7a1 1 0 011-1h3a1 1 0 011 1v5"/><line x1="3" y1="18" x2="3" y2="21"/><line x1="21" y1="18" x2="21" y2="21"/></svg>
						<span><?php echo esc_html( $bedrooms ); ?>PN</span>
					</div>
					<div class="reco-sale-specs__divider"></div>
					<div class="reco-sale-specs__item">
						<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 12h16v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5z"/><path d="M6 12V5a2 2 0 012-2h0a2 2 0 012 2v1"/><circle cx="8" cy="9" r="2"/><line x1="4" y1="19" x2="4" y2="22"/><line x1="20" y1="19" x2="20" y2="22"/></svg>
						<span><?php echo esc_html( $bathrooms ); ?>WC</span>
					</div>
				</div>

				<!-- Tabs -->
				<nav class="reco-sale-tabs" id="sale-tabs-nav">
					<button class="reco-sale-tabs__btn reco-sale-tabs__btn--active" data-tab="mo-ta">Mô tả</button>
					<button class="reco-sale-tabs__btn" data-tab="chi-tiet">Chi tiết</button>
					<?php if ( $map_embed ) : ?><button class="reco-sale-tabs__btn" data-tab="maps">Maps</button><?php endif; ?>
				</nav>

				<!-- Tab: Mô tả -->
				<section class="reco-sale-tab-panel reco-sale-tab-panel--active" id="tab-mo-ta">
					<h2 class="reco-sale-section-title">MÔ TẢ</h2>
					<div class="reco-sale-description">
						<?php the_content(); ?>
					</div>
				</section>

				<!-- Tab: Chi tiết -->
				<section class="reco-sale-tab-panel" id="tab-chi-tiet">
					<h2 class="reco-sale-section-title">CHI TIẾT</h2>
					<div class="reco-sale-detail-table">
						<div class="reco-sale-detail-row">
							<div class="reco-sale-detail-cell">
								<span class="reco-sale-detail-cell__icon">
									<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
								</span>
								<span class="reco-sale-detail-cell__label">Ngày đăng</span>
								<span class="reco-sale-detail-cell__value"><?php echo esc_html( $date_published ); ?></span>
							</div>
							<div class="reco-sale-detail-cell">
								<span class="reco-sale-detail-cell__icon">
									<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
								</span>
								<span class="reco-sale-detail-cell__label">Ngày cập nhật</span>
								<span class="reco-sale-detail-cell__value"><?php echo esc_html( $date_modified ); ?></span>
							</div>
						</div>
						<div class="reco-sale-detail-row">
							<div class="reco-sale-detail-cell">
								<span class="reco-sale-detail-cell__icon">
									<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 12h18v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4z"/><path d="M3 12V7a1 1 0 011-1h3a1 1 0 011 1v5"/></svg>
								</span>
								<span class="reco-sale-detail-cell__label">Phòng ngủ</span>
								<span class="reco-sale-detail-cell__value"><?php echo esc_html( $bedrooms ); ?></span>
							</div>
							<div class="reco-sale-detail-cell">
								<span class="reco-sale-detail-cell__icon">
									<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><text x="12" y="16" text-anchor="middle" font-size="7" fill="currentColor" stroke="none">m²</text></svg>
								</span>
								<span class="reco-sale-detail-cell__label">Diện tích</span>
								<span class="reco-sale-detail-cell__value"><?php echo $area ? esc_html( $area ) . ' m²' : '—'; ?></span>
							</div>
						</div>
						<div class="reco-sale-detail-row">
							<div class="reco-sale-detail-cell">
								<span class="reco-sale-detail-cell__icon">
									<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 12h16v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5z"/><circle cx="8" cy="9" r="2"/></svg>
								</span>
								<span class="reco-sale-detail-cell__label">Phòng tắm</span>
								<span class="reco-sale-detail-cell__value"><?php echo esc_html( $bathrooms ); ?></span>
							</div>
							<div class="reco-sale-detail-cell">
								<span class="reco-sale-detail-cell__icon">
									<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"/></svg>
								</span>
								<span class="reco-sale-detail-cell__label">Hướng</span>
								<span class="reco-sale-detail-cell__value"><?php echo $direction_text ? esc_html( $direction_text ) : '—'; ?></span>
							</div>
						</div>
					</div>
				</section>

				<?php if ( $map_embed ) : ?>
				<!-- Tab: Maps -->
				<section class="reco-sale-tab-panel" id="tab-maps">
					<h2 class="reco-sale-section-title">MAPS</h2>
					<div class="reco-sale-map">
						<?php echo $map_embed; // Map iframe embed. ?>
					</div>
				</section>
				<?php endif; ?>

				<?php if ( $related ) :
					$related_project_id = $related[0];
					$related_title = get_the_title( $related_project_id );
					$related_link  = get_permalink( $related_project_id );
					$related_thumb = get_post_thumbnail_id( $related_project_id );
				?>
				<!-- Related project -->
				<section class="reco-sale-related-project">
					<h2 class="reco-sale-section-title">DỰ ÁN LIÊN QUAN</h2>
					<a href="<?php echo esc_url( $related_link ); ?>" class="reco-sale-related-project__card">
						<?php if ( $related_thumb ) : ?>
							<div class="reco-sale-related-project__thumb">
								<?php echo wp_get_attachment_image( $related_thumb, 'medium', false, array( 'loading' => 'lazy' ) ); ?>
							</div>
						<?php endif; ?>
						<div class="reco-sale-related-project__info">
							<h3><?php echo esc_html( $related_title ); ?></h3>
							<span class="reco-text-link">Xem dự án <span aria-hidden="true">→</span></span>
						</div>
					</a>
				</section>
				<?php endif; ?>

			</div>

			<!-- RIGHT: Sidebar -->
			<aside class="reco-sale-sidebar">
				<!-- Price box -->
				<div class="reco-sale-price-box">
					<span class="reco-sale-price-box__label">Giá bán</span>
					<span class="reco-sale-price-box__value"><?php echo esc_html( $price_label ); ?></span>
				</div>

				<!-- Contact card -->
				<div class="reco-sale-contact-card">
					<a href="tel:0934524445" class="reco-sale-contact-card__phone">
						<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
						0934 524 445
					</a>
					<a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="reco-sale-contact-card__email">
						<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
						Liên hệ ngay
					</a>
				</div>
			</aside>

		</div>
	</div>

</article>
<?php endwhile; ?>

<script>
(function() {
	/* Tabs */
	var tabBtns = document.querySelectorAll('.reco-sale-tabs__btn');
	var tabPanels = document.querySelectorAll('.reco-sale-tab-panel');
	tabBtns.forEach(function(btn) {
		btn.addEventListener('click', function() {
			var target = 'tab-' + this.dataset.tab;
			tabBtns.forEach(function(b) { b.classList.remove('reco-sale-tabs__btn--active'); });
			tabPanels.forEach(function(p) { p.classList.remove('reco-sale-tab-panel--active'); });
			this.classList.add('reco-sale-tabs__btn--active');
			var panel = document.getElementById(target);
			if (panel) panel.classList.add('reco-sale-tab-panel--active');
		});
	});
})();
</script>

<?php get_footer(); ?>
