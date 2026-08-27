<?php
defined( 'ABSPATH' ) || exit;
get_header();

while ( have_posts() ) :
	the_post();
	
	// Get categories for label and related posts
	$categories = get_the_category();
	$primary_cat = !empty($categories) ? $categories[0] : null;
	?>
	<section class="reco-breadcrumb-section">
		<div class="reco-container">
			<nav class="reco-breadcrumb" aria-label="Breadcrumb">
				<a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a> / 
				<a href="<?php echo esc_url(home_url('/tin-tuc/')); ?>">Tin tức</a>
				<?php if ($primary_cat): ?>
					/ <span><?php echo esc_html($primary_cat->name); ?></span>
				<?php endif; ?>
			</nav>
		</div>
	</section>

	<article class="reco-single reco-section">
		<div class="reco-container reco-single__grid">
			<div class="reco-single__content">
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

				<?php if (has_excerpt()): ?>
					<div class="reco-single__excerpt">
						<?php the_excerpt(); ?>
					</div>
				<?php endif; ?>

				<div class="reco-prose">
					<?php the_content(); ?>
				</div>
			</div>

			<aside class="reco-single__sidebar">
				<div class="reco-sidebar-widget reco-sidebar-categories">
					<h3>TIN TỨC</h3>
					<ul>
						<?php
						$all_cats = get_categories(array('hide_empty' => false));
						foreach ($all_cats as $cat):
						?>
							<li>
								<a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
									<svg viewBox="0 0 24 24" width="14" height="14"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6"></path></svg>
									<?php echo esc_html($cat->name); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>

				<div class="reco-sidebar-widget reco-sidebar-posts">
					<h3>TIN TỨC MỚI NHẤT</h3>
					<div class="reco-sidebar-posts__list">
						<?php
						$latest_posts = new WP_Query(array(
							'post_type' => 'post',
							'posts_per_page' => 4,
							'post__not_in' => array(get_the_ID()),
							'ignore_sticky_posts' => 1
						));
						
						if ($latest_posts->have_posts()):
							$count = 0;
							while ($latest_posts->have_posts()):
								$latest_posts->the_post();
								$count++;
								if ($count === 1):
								?>
									<article class="reco-sidebar-post--featured">
										<a href="<?php the_permalink(); ?>" class="reco-sidebar-post__thumb">
											<?php if (has_post_thumbnail()) {
												the_post_thumbnail('medium');
											} else {
												echo '<img src="'.esc_url(reco_asset('images/placeholder.jpg')).'" alt="">';
											} ?>
										</a>
										<div class="reco-sidebar-post__content">
											<div class="reco-sidebar-post__date">
												<svg viewBox="0 0 24 24" width="14" height="14"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
												<?php echo get_the_date('d/m/Y'); ?>
											</div>
											<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
										</div>
									</article>
								<?php else: ?>
									<article class="reco-sidebar-post--item">
										<div class="reco-sidebar-post__content">
											<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
										</div>
									</article>
								<?php 
								endif;
							endwhile;
							wp_reset_postdata();
						endif;
						?>
					</div>
				</div>
			</aside>
		</div>
	</article>

	<?php
	// Related Posts
	if ($primary_cat):
		$related_args = array(
			'category__in' => array($primary_cat->term_id),
			'post__not_in' => array(get_the_ID()),
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
							<a href="<?php the_permalink(); ?>" class="reco-post-card__image">
								<?php if (has_post_thumbnail()) {
									the_post_thumbnail('medium_large');
								} else {
									echo '<img src="'.esc_url(reco_asset('images/placeholder.jpg')).'" alt="">';
								} ?>
							</a>
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
