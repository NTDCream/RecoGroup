<?php
/**
 * Archive page for "Tin rao bán" — property listing grid.
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main class="reco-sale-archive" id="main-content">
	<section class="reco-sale-search-wrap" style="padding-top: 120px;">
		<div class="reco-container">
			<form class="reco-sale-search-bar" action="<?php echo esc_url(get_post_type_archive_link('reco_sale')); ?>" method="get">
				<div class="reco-sale-search__keyword">
					<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="#666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<circle cx="11" cy="11" r="8"></circle>
						<line x1="21" y1="21" x2="16.65" y2="16.65"></line>
					</svg>
					<input type="text" name="tu-khoa" placeholder="Nhập từ khóa tìm kiếm" value="<?php echo esc_attr(isset($_GET['tu-khoa']) ? sanitize_text_field(wp_unslash($_GET['tu-khoa'])) : ''); ?>">
				</div>

				<div class="reco-sale-search__filters">
					<div class="reco-sale-search__dropdown">
						<label for="search-tinh-thanh">Tỉnh/Thành</label>
						<select name="tinh-thanh" id="search-tinh-thanh">
							<option value="">Tất cả</option>
							<option value="ha-noi" <?php selected(isset($_GET['tinh-thanh']) ? $_GET['tinh-thanh'] : '', 'ha-noi'); ?>>Hà Nội</option>
							<option value="ho-chi-minh" <?php selected(isset($_GET['tinh-thanh']) ? $_GET['tinh-thanh'] : '', 'ho-chi-minh'); ?>>Hồ Chí Minh</option>
							<option value="da-nang" <?php selected(isset($_GET['tinh-thanh']) ? $_GET['tinh-thanh'] : '', 'da-nang'); ?>>Đà Nẵng</option>
						</select>
					</div>

					<div class="reco-sale-search__dropdown">
						<label for="search-quan-huyen">Quận/Huyện</label>
						<select name="quan-huyen" id="search-quan-huyen">
							<option value="">Tất cả</option>
						</select>
					</div>

					<div class="reco-sale-search__dropdown">
						<label for="search-muc-gia">Mức giá</label>
						<select name="muc-gia" id="search-muc-gia">
							<option value="">Tất cả</option>
							<option value="duoi-2-ty" <?php selected(isset($_GET['muc-gia']) ? $_GET['muc-gia'] : '', 'duoi-2-ty'); ?>>Dưới 2 tỷ</option>
							<option value="2-3-ty" <?php selected(isset($_GET['muc-gia']) ? $_GET['muc-gia'] : '', '2-3-ty'); ?>>2 - 3 tỷ</option>
							<option value="3-5-ty" <?php selected(isset($_GET['muc-gia']) ? $_GET['muc-gia'] : '', '3-5-ty'); ?>>3 - 5 tỷ</option>
							<option value="tren-5-ty" <?php selected(isset($_GET['muc-gia']) ? $_GET['muc-gia'] : '', 'tren-5-ty'); ?>>Trên 5 tỷ</option>
						</select>
					</div>

					<button type="submit" class="reco-sale-search__submit" aria-label="Tìm kiếm">
						<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<circle cx="11" cy="11" r="8"></circle>
							<line x1="21" y1="21" x2="16.65" y2="16.65"></line>
						</svg>
					</button>
				</div>
			</form>
		</div>
	</section>

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
					<h2>Không có kết quả phù hợp</h2>
					<p>Hãy thử thay đổi tiêu chí tìm kiếm hoặc quay lại sau để xem các tin đăng mới nhất.</p>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php get_footer(); ?>
