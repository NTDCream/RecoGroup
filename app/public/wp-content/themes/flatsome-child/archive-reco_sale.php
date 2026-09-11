<?php
/**
 * Archive page for "Tin rao bán" — property listing grid.
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main class="reco-sale-archive" id="main-content">
	<header class="reco-sale-archive__hero">
		<div class="reco-container">
			<span class="reco-eyebrow reco-eyebrow--light">Nhà đất bán</span>
			<h1>Danh sách<br><em>tin rao bán.</em></h1>
		</div>
	</header>

	<section class="reco-section reco-sale-archive__results">
		<div class="reco-container">
			<div class="reco-sale-archive__results-head">
				<h2>Kết quả</h2>
				<span><?php echo esc_html( sprintf( '%s tin đăng', (int) $GLOBALS['wp_query']->found_posts ) ); ?></span>
			</div>

			<?php if ( have_posts() ) : ?>
				<div class="reco-sale-grid">
					<?php while ( have_posts() ) :
						the_post();
						$sale_id   = get_the_ID();
						$bedrooms  = absint( reco_project_field( 'reco_sale_bedrooms', $sale_id, 0 ) );
						$bathrooms = absint( reco_project_field( 'reco_sale_bathrooms', $sale_id, 0 ) );
						$area      = floatval( reco_project_field( 'reco_sale_area', $sale_id, 0 ) );
						$price_val = floatval( reco_project_field( 'reco_sale_price_value', $sale_id, 0 ) );
						$price_unit = reco_project_field( 'reco_sale_price_unit', $sale_id, 'ty' );
						$price_text = $price_val ? number_format( $price_val, ( fmod( $price_val, 1 ) ? 1 : 0 ), '.', '.' ) . ' ' . ( 'trieu' === $price_unit ? 'triệu' : 'tỷ' ) : 'Liên hệ';
						$gallery = array_values( array_filter( array_map( 'absint', (array) reco_project_field( 'reco_sale_gallery', $sale_id, array() ) ) ) );
						$thumb_id = $gallery ? $gallery[0] : get_post_thumbnail_id( $sale_id );
					?>
					<article class="reco-sale-card">
						<a class="reco-sale-card__media" href="<?php the_permalink(); ?>" aria-label="Xem <?php the_title_attribute(); ?>">
							<?php if ( $thumb_id ) : ?>
								<?php echo wp_get_attachment_image( $thumb_id, 'medium_large', false, array( 'loading' => 'lazy' ) ); ?>
							<?php else : ?>
								<span class="reco-sale-card__placeholder"></span>
							<?php endif; ?>
							<span class="reco-sale-card__price-badge"><?php echo esc_html( $price_text ); ?></span>
						</a>
						<div class="reco-sale-card__body">
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<div class="reco-sale-card__meta">
								<?php if ( $area ) : ?><span><?php echo esc_html( $area ); ?>m²</span><?php endif; ?>
								<?php if ( $bedrooms ) : ?><span><?php echo esc_html( $bedrooms ); ?> PN</span><?php endif; ?>
								<?php if ( $bathrooms ) : ?><span><?php echo esc_html( $bathrooms ); ?> WC</span><?php endif; ?>
							</div>
							<p class="reco-sale-card__date"><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></p>
						</div>
					</article>
					<?php endwhile; ?>
				</div>
				<?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => '← Trước', 'next_text' => 'Sau →' ) ); ?>
			<?php else : ?>
				<div class="reco-sale-archive__empty">
					<h2>Chưa có tin rao bán nào</h2>
					<p>Hãy quay lại sau để xem các tin đăng mới nhất.</p>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php get_footer(); ?>
