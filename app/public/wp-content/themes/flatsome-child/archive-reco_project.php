<?php
/**
 * Filterable project archive.
 */

defined( 'ABSPATH' ) || exit;
get_header();

$selected_transaction = reco_project_search_value( 'giao-dich', 'mua' );
?>
<main class="reco-project-archive" id="main-content">
	<header class="reco-project-archive__hero">
		<div class="reco-container">
			<span class="reco-eyebrow reco-eyebrow--light">Danh mục dự án</span>
			<h1>Tìm bất động sản<br><em>đúng nhu cầu.</em></h1>
		</div>
	</header>

	<?php reco_project_search_form( array( 'transaction' => $selected_transaction, 'heading' => 'Lọc danh sách dự án' ) ); ?>

	<section class="reco-section reco-project-archive__results">
		<div class="reco-container">
			<div class="reco-project-archive__results-head">
				<h2>Kết quả tìm kiếm</h2>
				<span><?php echo esc_html( sprintf( '%s dự án', (int) $GLOBALS['wp_query']->found_posts ) ); ?></span>
			</div>

			<?php if ( have_posts() ) : ?>
				<div class="reco-project-demo__grid">
					<?php while ( have_posts() ) :
						the_post();
						$project_id  = get_the_ID();
						$types       = reco_project_term_names( $project_id, 'reco_project_type' );
						$locations   = reco_project_term_names( $project_id, 'reco_location' );
						$status      = reco_project_status_label( reco_project_field( 'reco_project_status', $project_id ) );
						$transaction_value = reco_project_field( 'reco_project_transaction', $project_id, 'mua' );
						$transaction       = reco_project_transaction_label( $transaction_value );
						$price             = reco_project_display_price( $project_id, $transaction_value );
						?>
						<article class="reco-project-demo-card">
							<a class="reco-project-demo-card__media" href="<?php the_permalink(); ?>" aria-label="Xem dự án <?php the_title_attribute(); ?>">
								<?php if ( has_post_thumbnail() ) : ?><?php the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); ?><?php endif; ?>
								<span class="reco-project-demo-card__status"><?php echo esc_html( $status ); ?></span>
							</a>
							<div class="reco-project-demo-card__body">
								<div class="reco-project-demo-card__meta"><span><?php echo esc_html( $transaction ); ?></span><span><?php echo esc_html( $price ); ?></span></div>
								<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<p class="reco-project-demo-card__tagline"><?php echo esc_html( $types ? implode( ', ', $types ) : 'Dự án' ); ?></p>
								<p class="reco-project-demo-card__excerpt"><?php echo esc_html( $locations ? implode( ', ', $locations ) : get_the_excerpt() ); ?></p>
								<a class="reco-text-link" href="<?php the_permalink(); ?>">Xem thông tin <span aria-hidden="true">→</span></a>
							</div>
						</article>
					<?php endwhile; ?>
				</div>
				<?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => '← Trước', 'next_text' => 'Sau →' ) ); ?>
			<?php else : ?>
				<div class="reco-project-demo__empty">
					<h2>Chưa tìm thấy dự án phù hợp</h2>
					<p>Hãy chọn khoảng giá rộng hơn hoặc thử một tỉnh/thành khác.</p>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php get_footer(); ?>
