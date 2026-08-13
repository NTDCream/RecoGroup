<?php
/**
 * Project detail page inspired by the Nhà Ở Ngay project portal structure.
 */

defined( 'ABSPATH' ) || exit;
get_header();

while ( have_posts() ) :
	the_post();

	$post_id             = get_the_ID();
	$gallery             = array_values( array_filter( array_map( 'absint', (array) reco_project_field( 'reco_project_gallery', $post_id, array() ) ) ) );
	$facts               = (array) reco_project_field( 'reco_project_facts', $post_id, array() );
	$tagline             = reco_project_field( 'reco_project_tagline', $post_id );
	$address             = reco_project_field( 'reco_project_address', $post_id );
	$transaction         = reco_project_field( 'reco_project_transaction', $post_id, 'mua' );
	$transaction_label   = reco_project_transaction_label( $transaction );
	$price               = reco_project_display_price( $post_id, $transaction );
	$price_caption       = 'cho-thue' === $transaction ? 'Giá thuê' : 'Giá bán';
	$hotline             = reco_project_field( 'reco_project_hotline', $post_id, '0934 524 445' );
	$hotline_href        = preg_replace( '/[^0-9+]/', '', $hotline );
	$types               = reco_project_term_names( $post_id, 'reco_project_type' );
	$locations           = reco_project_term_names( $post_id, 'reco_location' );
	$tags                = reco_project_term_names( $post_id, 'reco_project_tag' );
	$overview_heading    = reco_project_field( 'reco_project_overview_heading', $post_id, 'Tổng quan dự án ' . get_the_title() );
	$overview_intro      = reco_project_field( 'reco_project_overview_intro', $post_id, get_the_excerpt() );
	$overview_content    = reco_project_field( 'reco_project_overview_content', $post_id, get_the_content() );
	$overview_image      = absint( reco_project_field( 'reco_project_overview_image', $post_id, 0 ) );
	$location_tabs       = (array) reco_project_field( 'reco_project_location_tabs', $post_id, array() );
	$amenities_heading   = reco_project_field( 'reco_project_amenities_heading', $post_id, 'Tiện ích dự án ' . get_the_title() );
	$amenities_description = reco_project_field( 'reco_project_amenities_description', $post_id );
	$amenities_gallery   = array_values( array_filter( array_map( 'absint', (array) reco_project_field( 'reco_project_amenities_gallery', $post_id, array() ) ) ) );
	$floorplan_heading   = reco_project_field( 'reco_project_floorplan_heading', $post_id, 'Mặt bằng tổng thể dự án ' . get_the_title() );
	$floorplan_content   = reco_project_field( 'reco_project_floorplan_content', $post_id );
	$floorplan_tabs      = (array) reco_project_field( 'reco_project_floorplan_tabs', $post_id, array() );
	$apartment_heading   = reco_project_field( 'reco_project_apartment_heading', $post_id, 'Hình ảnh căn hộ mẫu' );
	$apartment_gallery   = array_values( array_filter( array_map( 'absint', (array) reco_project_field( 'reco_project_apartment_gallery', $post_id, array() ) ) ) );
	$selected_related    = array_values( array_filter( array_map( 'absint', (array) reco_project_field( 'reco_project_related', $post_id, array() ) ) ) );
	$render_rich_text    = static function ( $content ) {
		return $content ? apply_filters( 'the_content', $content ) : '';
	};

	if ( ! $gallery && has_post_thumbnail() ) {
		$gallery[] = get_post_thumbnail_id();
	}
	if ( ! $overview_image && $gallery ) {
		$overview_image = $gallery[0];
	}

	$hero_gallery = $gallery;
	if ( $hero_gallery ) {
		$source_gallery = $hero_gallery;
		$source_index   = 0;
		while ( count( $hero_gallery ) < 5 ) {
			$hero_gallery[] = $source_gallery[ $source_index % count( $source_gallery ) ];
			++$source_index;
		}
		$hero_gallery = array_slice( $hero_gallery, 0, 5 );
	}
	?>
	<article class="reco-project-page" id="main-content">
		<div class="reco-project-breadcrumb">
			<div class="reco-container">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a>
				<span aria-hidden="true">/</span>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'reco_project' ) ?: home_url( '/he-thong-san-pham/' ) ); ?>">Dự án</a>
				<span aria-hidden="true">/</span>
				<span><?php echo esc_html( $types ? implode( ', ', $types ) : 'Dự án RECO' ); ?></span>
			</div>
		</div>

		<?php if ( $hero_gallery ) : ?>
			<section class="reco-project-hero-gallery" aria-label="Ảnh nổi bật của <?php the_title_attribute(); ?>">
				<div class="reco-container reco-project-hero-gallery__grid">
					<?php foreach ( $hero_gallery as $index => $image_id ) : ?>
						<figure class="reco-project-hero-gallery__item reco-project-hero-gallery__item--<?php echo esc_attr( $index + 1 ); ?>">
							<?php echo wp_get_attachment_image( $image_id, 0 === $index ? 'large' : 'medium_large', false, array( 'loading' => 0 === $index ? 'eager' : 'lazy', 'fetchpriority' => 0 === $index ? 'high' : 'auto' ) ); ?>
						</figure>
					<?php endforeach; ?>
					<a class="reco-project-hero-gallery__count" href="#anh-can-ho-mau">
						<span aria-hidden="true">▦</span> <?php echo esc_html( count( $gallery ) ); ?> ảnh
					</a>
				</div>
			</section>
		<?php endif; ?>

		<?php reco_project_search_form( array( 'transaction' => $transaction ) ); ?>

		<section class="reco-project-summary">
			<div class="reco-container reco-project-summary__grid">
				<div class="reco-project-summary__main">
					<?php if ( $tagline ) : ?><span class="reco-project-summary__tagline"><?php echo esc_html( $tagline ); ?></span><?php endif; ?>
					<h1><?php the_title(); ?></h1>
					<?php if ( $address || $locations ) : ?>
						<p class="reco-project-address">
							<svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path d="M12 21s7-6.2 7-12A7 7 0 105 9c0 5.8 7 12 7 12zM9.5 9a2.5 2.5 0 105 0 2.5 2.5 0 00-5 0z" fill="none" stroke="currentColor" stroke-width="1.6"/></svg>
							<?php echo esc_html( $address ?: implode( ', ', $locations ) ); ?>
						</p>
					<?php endif; ?>
					<h2><?php echo esc_html( $overview_heading ); ?></h2>
					<div class="reco-project-summary__intro reco-project-rich-text"><?php echo wp_kses_post( $render_rich_text( $overview_intro ) ); ?></div>
				</div>
				<aside class="reco-project-price-card" aria-label="Thông tin giá và liên hệ">
					<div class="reco-project-price-card__price"><span><?php echo esc_html( $price_caption ); ?></span><strong><?php echo esc_html( $price ); ?></strong><small><?php echo esc_html( $transaction_label ); ?></small></div>
					<a href="tel:<?php echo esc_attr( $hotline_href ); ?>">
						<svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path d="M7.3 3.2l2.2 4.1-1.8 1.8a14.4 14.4 0 007.2 7.2l1.8-1.8 4.1 2.2-.7 3.2c-.2.8-.9 1.4-1.7 1.4C9.8 21.3 2.7 14.2 2.7 5.6c0-.8.6-1.5 1.4-1.7l3.2-.7z" fill="none" stroke="currentColor" stroke-width="1.7"/></svg>
						<?php echo esc_html( $hotline ); ?>
					</a>
					<a href="<?php echo esc_url( home_url( '/lien-he/?du-an=' . get_post_field( 'post_name', $post_id ) ) ); ?>#form-lien-he">Liên hệ ngay <span aria-hidden="true">→</span></a>
				</aside>
			</div>
		</section>

		<section class="reco-project-overview reco-project-section">
			<div class="reco-container reco-project-overview__grid">
				<?php if ( $overview_image ) : ?>
					<figure class="reco-project-overview__image" data-reveal>
						<?php echo wp_get_attachment_image( $overview_image, 'large', false, array( 'loading' => 'lazy' ) ); ?>
					</figure>
				<?php endif; ?>
				<div class="reco-project-overview__card" data-reveal>
					<div class="reco-project-rich-text"><?php echo wp_kses_post( $render_rich_text( $overview_content ) ); ?></div>
					<?php if ( $facts ) : ?>
						<dl class="reco-project-facts">
							<?php foreach ( $facts as $fact ) :
								$fact_label = isset( $fact['reco_fact_label'] ) ? $fact['reco_fact_label'] : '';
								$fact_value = isset( $fact['reco_fact_value'] ) ? $fact['reco_fact_value'] : '';
								if ( ! $fact_label && ! $fact_value ) {
									continue;
								}
								?>
								<div><dt><?php echo esc_html( $fact_label ); ?></dt><dd><?php echo esc_html( $fact_value ); ?></dd></div>
							<?php endforeach; ?>
						</dl>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<?php if ( $location_tabs ) : ?>
			<section class="reco-project-location reco-project-section" data-project-tabs>
				<div class="reco-container">
					<div class="reco-project-tabs" role="tablist" aria-label="Thông tin vị trí">
						<?php foreach ( $location_tabs as $index => $tab ) : ?>
							<button type="button" role="tab" aria-selected="<?php echo 0 === $index ? 'true' : 'false'; ?>" aria-controls="reco-location-panel-<?php echo esc_attr( $index ); ?>" id="reco-location-tab-<?php echo esc_attr( $index ); ?>" data-project-tab>
								<?php echo esc_html( isset( $tab['reco_location_tab_label'] ) && $tab['reco_location_tab_label'] ? $tab['reco_location_tab_label'] : 'Vị trí ' . ( $index + 1 ) ); ?>
							</button>
						<?php endforeach; ?>
					</div>
					<?php foreach ( $location_tabs as $index => $tab ) :
						$tab_heading = isset( $tab['reco_location_tab_heading'] ) ? $tab['reco_location_tab_heading'] : '';
						$tab_content = isset( $tab['reco_location_tab_content'] ) ? $tab['reco_location_tab_content'] : '';
						$tab_image   = isset( $tab['reco_location_tab_image'] ) ? absint( $tab['reco_location_tab_image'] ) : 0;
						?>
						<div class="reco-project-location__panel<?php echo 1 === $index ? ' reco-project-location__panel--reverse' : ''; ?>" id="reco-location-panel-<?php echo esc_attr( $index ); ?>" role="tabpanel" aria-labelledby="reco-location-tab-<?php echo esc_attr( $index ); ?>" <?php echo 0 === $index ? '' : 'hidden'; ?> data-project-panel>
							<div class="reco-project-location__content">
								<h2><?php echo esc_html( $tab_heading ?: 'Vị trí dự án ' . get_the_title() ); ?></h2>
								<div class="reco-project-rich-text"><?php echo wp_kses_post( $render_rich_text( $tab_content ) ); ?></div>
							</div>
							<?php if ( $tab_image ) : ?><figure><?php echo wp_get_attachment_image( $tab_image, 'large', false, array( 'loading' => 'lazy' ) ); ?></figure><?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $amenities_description || $amenities_gallery ) : ?>
			<section class="reco-project-amenities reco-project-section" id="tien-ich-du-an">
				<div class="reco-container">
					<h2><?php echo esc_html( $amenities_heading ); ?></h2>
					<?php if ( $amenities_description ) : ?>
						<div class="reco-project-amenities__description reco-project-rich-text"><?php echo wp_kses_post( $render_rich_text( $amenities_description ) ); ?></div>
					<?php endif; ?>
				</div>
				<?php if ( $amenities_gallery ) : ?>
					<div class="reco-project-slider reco-project-slider--showcase reco-project-slider--amenities" data-project-slider>
						<div class="reco-project-slider__viewport">
							<?php foreach ( $amenities_gallery as $index => $image_id ) : ?>
								<figure class="reco-project-slider__slide<?php echo 0 === $index ? ' is-active' : ''; ?>" data-project-slide aria-hidden="<?php echo 0 === $index ? 'false' : 'true'; ?>">
									<?php echo wp_get_attachment_image( $image_id, 'large', false, array( 'loading' => $index < 3 ? 'eager' : 'lazy' ) ); ?>
								</figure>
							<?php endforeach; ?>
							<button class="reco-project-slider__arrow reco-project-slider__arrow--prev" type="button" aria-label="Ảnh tiện ích trước" data-project-prev>‹</button>
							<button class="reco-project-slider__arrow reco-project-slider__arrow--next" type="button" aria-label="Ảnh tiện ích tiếp theo" data-project-next>›</button>
						</div>
					</div>
				<?php endif; ?>
			</section>
		<?php endif; ?>

		<?php if ( $floorplan_content || $floorplan_tabs ) : ?>
			<section class="reco-project-floorplan reco-project-section" data-project-tabs>
				<div class="reco-container">
					<div class="reco-project-floorplan__intro">
						<h2><?php echo esc_html( $floorplan_heading ); ?></h2>
						<div class="reco-project-rich-text"><?php echo wp_kses_post( $render_rich_text( $floorplan_content ) ); ?></div>
					</div>
					<?php if ( $floorplan_tabs ) : ?>
						<div class="reco-project-floorplan__viewer">
							<div class="reco-project-floorplan__panels">
								<?php foreach ( $floorplan_tabs as $index => $plan ) :
									$plan_image = isset( $plan['reco_floorplan_image'] ) ? absint( $plan['reco_floorplan_image'] ) : 0;
									$plan_note  = isset( $plan['reco_floorplan_note'] ) ? $plan['reco_floorplan_note'] : '';
									?>
									<figure id="reco-plan-panel-<?php echo esc_attr( $index ); ?>" role="tabpanel" aria-labelledby="reco-plan-tab-<?php echo esc_attr( $index ); ?>" <?php echo 0 === $index ? '' : 'hidden'; ?> data-project-panel>
										<?php if ( $plan_image ) : ?><?php echo wp_get_attachment_image( $plan_image, 'large', false, array( 'loading' => 'lazy' ) ); ?><?php endif; ?>
										<?php if ( $plan_note ) : ?><figcaption><?php echo wp_kses_post( $plan_note ); ?></figcaption><?php endif; ?>
									</figure>
								<?php endforeach; ?>
							</div>
							<div class="reco-project-floorplan__tabs" role="tablist" aria-label="Chọn mặt bằng">
								<strong>Mặt bằng dự án</strong>
								<?php foreach ( $floorplan_tabs as $index => $plan ) : ?>
									<button type="button" role="tab" aria-selected="<?php echo 0 === $index ? 'true' : 'false'; ?>" aria-controls="reco-plan-panel-<?php echo esc_attr( $index ); ?>" id="reco-plan-tab-<?php echo esc_attr( $index ); ?>" data-project-tab>
										<?php echo esc_html( isset( $plan['reco_floorplan_label'] ) ? $plan['reco_floorplan_label'] : 'Mặt bằng ' . ( $index + 1 ) ); ?>
									</button>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $apartment_gallery ) : ?>
			<section class="reco-project-apartment reco-project-section" id="anh-can-ho-mau">
				<h2><?php echo esc_html( $apartment_heading ); ?></h2>
				<div class="reco-project-slider reco-project-slider--showcase reco-project-slider--apartment" data-project-slider>
					<div class="reco-project-slider__viewport">
						<?php foreach ( $apartment_gallery as $index => $image_id ) : ?>
							<figure class="reco-project-slider__slide<?php echo 0 === $index ? ' is-active' : ''; ?>" data-project-slide aria-hidden="<?php echo 0 === $index ? 'false' : 'true'; ?>">
								<?php echo wp_get_attachment_image( $image_id, 'full', false, array( 'loading' => $index < 3 ? 'eager' : 'lazy' ) ); ?>
							</figure>
						<?php endforeach; ?>
						<button class="reco-project-slider__arrow reco-project-slider__arrow--prev" type="button" aria-label="Ảnh căn hộ trước" data-project-prev>‹</button>
						<button class="reco-project-slider__arrow reco-project-slider__arrow--next" type="button" aria-label="Ảnh căn hộ tiếp theo" data-project-next>›</button>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php
		$related_args = array(
			'post_type'      => 'reco_project',
			'post_status'    => 'publish',
			'posts_per_page' => 4,
			'post__not_in'   => array( $post_id ),
			'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
		);
		if ( $selected_related ) {
			$related_args['post__in']       = $selected_related;
			$related_args['orderby']        = 'post__in';
			$related_args['posts_per_page'] = count( $selected_related );
		}
		$related_projects = new WP_Query( $related_args );
		if ( $related_projects->have_posts() ) :
			?>
			<section class="reco-project-related reco-project-section">
				<div class="reco-container">
					<h2>Dự án liên quan</h2>
					<div class="reco-project-related__grid">
						<?php while ( $related_projects->have_posts() ) :
							$related_projects->the_post();
							$related_id        = get_the_ID();
							$related_locations = reco_project_term_names( $related_id, 'reco_location' );
							$related_types     = reco_project_term_names( $related_id, 'reco_project_type' );
							$related_price     = reco_project_display_price( $related_id );
							?>
							<article class="reco-project-related-card">
								<a class="reco-project-related-card__image" href="<?php the_permalink(); ?>">
									<?php if ( has_post_thumbnail() ) : ?><?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); ?><?php endif; ?>
									<span><?php echo esc_html( $related_types ? $related_types[0] : 'Dự án' ); ?></span>
								</a>
								<div class="reco-project-related-card__body">
									<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<?php if ( $related_locations ) : ?><p><?php echo esc_html( implode( ', ', $related_locations ) ); ?></p><?php endif; ?>
									<div><span>Giá:</span><strong><?php echo esc_html( $related_price ); ?></strong></div>
								</div>
							</article>
						<?php endwhile; ?>
					</div>
				</div>
			</section>
			<?php
		endif;
		wp_reset_postdata();
		?>

		<div class="reco-project-mobile-cta" aria-label="Liên hệ dự án">
			<div><span><?php echo esc_html( $price_caption ); ?></span><strong><?php echo esc_html( $price ); ?></strong></div>
			<a href="tel:<?php echo esc_attr( $hotline_href ); ?>" aria-label="Gọi <?php echo esc_attr( $hotline ); ?>">
				<svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true"><path d="M7.3 3.2l2.2 4.1-1.8 1.8a14.4 14.4 0 007.2 7.2l1.8-1.8 4.1 2.2-.7 3.2c-.2.8-.9 1.4-1.7 1.4C9.8 21.3 2.7 14.2 2.7 5.6c0-.8.6-1.5 1.4-1.7l3.2-.7z" fill="none" stroke="currentColor" stroke-width="1.7"/></svg>
			</a>
		</div>
	</article>
	<?php
endwhile;

get_footer();
