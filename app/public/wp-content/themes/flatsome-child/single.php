<?php
defined( 'ABSPATH' ) || exit;
get_header();

while ( have_posts() ) :
	the_post();

	// Get categories for label and related posts
	$categories = get_the_category();
	$primary_cat = !empty($categories) ? $categories[0] : null;
	$current_post_id = get_the_ID();
	?>
	<section class="reco-news-page">
		<div class="reco-container">
			<nav class="reco-news-breadcrumb" aria-label="Breadcrumb">
				<a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a><span aria-hidden="true">/</span>
				<a href="<?php echo esc_url(home_url('/tin-tuc/')); ?>">Tin tức</a>
				<?php if ($primary_cat): ?>
					<span aria-hidden="true">/</span>
					<a href="<?php echo esc_url(get_category_link($primary_cat->term_id)); ?>"><?php echo esc_html($primary_cat->name); ?></a>
					<span aria-hidden="true">/</span>
					<span aria-current="page"><?php the_title(); ?></span>
				<?php endif; ?>
			</nav>

			<div class="reco-news-page__layout">
				<main class="reco-news-page__main">
					<?php if ($primary_cat): ?>
						<div class="reco-single__category">
							<a href="<?php echo esc_url(get_category_link($primary_cat->term_id)); ?>">
								<?php echo esc_html($primary_cat->name); ?>
							</a>
						</div>
					<?php endif; ?>

					<div class="reco-single__header">
						<div class="reco-single__date">
							<span class="reco-single__date-day"><?php echo get_the_date('d/m'); ?></span>
							<span class="reco-single__date-year"><svg viewBox="0 0 24 24" width="16" height="16"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> <?php echo get_the_date('Y'); ?></span>
						</div>
						<h1 class="reco-single__title"><?php the_title(); ?></h1>
					</div>

					<div class="reco-single__meta">
						<span>
							<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
							<?php echo esc_html(get_the_author()); ?>
						</span>
						<span>
							<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
							<?php echo esc_html(get_the_date('d/m/Y H:i')); ?>
						</span>
					</div>

					<?php if (has_post_thumbnail()): ?>
						<div class="reco-single__thumbnail">
							<?php the_post_thumbnail('large', array('loading' => 'eager')); ?>
						</div>
					<?php endif; ?>

					<?php if (has_excerpt()): ?>
						<div class="reco-single__excerpt">
							<?php the_excerpt(); ?>
						</div>
					<?php endif; ?>

					<div class="reco-prose">
						<?php the_content(); ?>
					</div>
				</main>

				<aside class="reco-news-page__sidebar" aria-label="Danh mục và tin tham khảo">
					<section class="reco-news-widget reco-news-widget--categories" data-reveal>
						<h2>Danh mục tin tức</h2>
						<ul>
							<?php
							$wp_categories = get_categories(array(
								'orderby' => 'name',
								'order' => 'ASC',
								'hide_empty' => false,
							));
							if (!empty($wp_categories)):
								foreach ($wp_categories as $cat):
									$is_active = $primary_cat && $primary_cat->term_id === $cat->term_id;
									?>
									<li><a class="<?php echo $is_active ? 'is-active' : ''; ?>" href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"<?php echo $is_active ? ' aria-current="page"' : ''; ?>><span aria-hidden="true">›</span><?php echo esc_html($cat->name); ?></a></li>
								<?php endforeach;
							endif;
							?>
						</ul>
					</section>

					<section class="reco-news-widget reco-news-widget--reviews" data-reveal>
						<h2>Tin tức mới nhất</h2>
						<?php
						$review_query = new WP_Query(array(
							'post_type' => 'post',
							'post_status' => 'publish',
							'posts_per_page' => 4,
							'post__not_in' => array($current_post_id),
							'orderby' => 'date',
							'order' => 'DESC',
						));
						if ($review_query->have_posts()):
							$review_index = 0;
							while ($review_query->have_posts()):
								$review_query->the_post();
								$review_thumb = get_the_post_thumbnail_url();
								?>
								<article class="reco-news-review<?php echo 0 === $review_index ? ' reco-news-review--featured' : ''; ?>">
									<a class="reco-news-review__image" href="<?php echo esc_url(get_permalink()); ?>"
										aria-label="<?php echo esc_attr(get_the_title()); ?>">
										<?php if ($review_thumb): ?>
											<img src="<?php echo esc_url($review_thumb); ?>"
												alt="<?php echo esc_attr(get_the_title()); ?>" width="400" height="260" loading="lazy">
										<?php endif; ?>
									</a>
									<div class="reco-news-review__body">
										<time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('d/m/Y')); ?></time>
										<h3><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a></h3>
										<?php if ($review_index === 0 && has_excerpt()): ?>
											<p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 18)); ?></p>
										<?php endif; ?>
									</div>
								</article>
								<?php
								$review_index++;
							endwhile;
							wp_reset_postdata();
						endif;
						?>
					</section>
				</aside>
			</div>
		</div>
	</section>

	<?php
	// Related Posts
	if ($primary_cat):
		$related_args = array(
			'category__in' => array($primary_cat->term_id),
			'post__not_in' => array($current_post_id),
			'posts_per_page' => 4,
			'ignore_sticky_posts' => 1
		);
		$related_query = new WP_Query($related_args);

		if ($related_query->have_posts()):
	?>
		<section class="reco-related-posts reco-section reco-section--soft">
			<div class="reco-container">
				<div class="reco-section-head reco-section-head--center" data-reveal>
					<h2>TIN TỨC<br><em>LIÊN QUAN</em></h2>
				</div>

				<div class="reco-related-grid" data-reveal>
					<?php while ($related_query->have_posts()): $related_query->the_post(); ?>
						<article class="reco-post-card">
							<?php if (has_post_thumbnail()): ?>
								<a href="<?php the_permalink(); ?>" class="reco-post-card__image">
									<?php the_post_thumbnail('medium_large'); ?>
								</a>
							<?php endif; ?>
							<div class="reco-post-card__content">
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<div class="reco-post-card__meta">
									<svg viewBox="0 0 24 24" width="16" height="16"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
									<?php echo get_the_date('d/m/Y'); ?>
								</div>
							</div>
						</article>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			</div>
		</section>
	<?php
		endif;
	endif;
	?>

<?php
endwhile;

get_footer();
