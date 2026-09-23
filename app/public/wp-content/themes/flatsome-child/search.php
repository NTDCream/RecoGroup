<?php
defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="main" class="">
	<section class="reco-section" style="padding: 60px 0;">
		<div class="reco-container" style="max-width: 800px; margin: 0 auto; padding: 0 15px;">
			
			<header class="search-header" style="text-align: center; margin-bottom: 40px;">
				<h1 style="font-size: 28px; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">
					KẾT QUẢ TÌM KIẾM CHO: "<?php echo esc_html(get_search_query()); ?>"
				</h1>
				<div class="search-form-wrapper" style="max-width: 500px; margin: 0 auto;">
					<?php get_search_form(); ?>
				</div>
			</header>

			<?php if ( have_posts() ) : ?>
				<div class="reco-search-results">
					<?php while ( have_posts() ) : the_post(); ?>
						<article <?php post_class( 'reco-archive-item' ); ?> style="border-bottom: 1px solid #eaeaea; padding-bottom: 25px; margin-bottom: 25px;">
							<h2 style="font-size: 22px; margin-bottom: 8px; font-weight: 600;">
								<a href="<?php the_permalink(); ?>" style="color: #0073e6; text-decoration: none;"><?php the_title(); ?></a>
							</h2>
							<div class="post-meta" style="color: #888; font-size: 13px; margin-bottom: 12px; font-weight: 500; text-transform: uppercase;">
								<?php
									$post_type = get_post_type();
									if ($post_type === 'reco_sale') echo 'Tin rao bán';
									elseif ($post_type === 'reco_project') echo 'Dự án';
									elseif ($post_type === 'post') echo 'Tin tức';
									else echo get_post_type_object($post_type)->labels->singular_name;
								?>
							</div>
							<div class="reco-excerpt" style="color: #444; line-height: 1.6;">
								<?php echo wp_trim_words( get_the_excerpt(), 40, '...' ); ?>
							</div>
						</article>
					<?php endwhile; ?>
					
					<?php 
						$big = 999999999;
						$pagination_links = paginate_links(array(
							'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
							'format'    => '?paged=%#%',
							'current'   => max(1, get_query_var('paged')),
							'total'     => $wp_query->max_num_pages,
							'prev_text' => '&larr; Trước',
							'next_text' => 'Sau &rarr;',
						));
						if ($pagination_links) {
							echo '<nav class="navigation pagination" style="margin-top: 40px; text-align: center;" aria-label="Phân trang"><div class="nav-links" style="display: flex; justify-content: center; gap: 10px;">' . $pagination_links . '</div></nav>';
						}
					?>
				</div>
			<?php else : ?>
				<div class="no-results-content" style="text-align: center; padding: 40px 0; background: #f9f9f9; border-radius: 8px;">
					<h2 style="font-size: 24px; margin-bottom: 15px; color: #333;">Không tìm thấy kết quả nào</h2>
					<p style="color: #666; font-size: 16px; margin-bottom: 0;">Xin lỗi, nhưng không có kết quả nào phù hợp với cụm từ <strong>"<?php echo esc_html(get_search_query()); ?>"</strong>. <br>Vui lòng thử lại với một số từ khóa khác.</p>
				</div>
			<?php endif; ?>

		</div>
	</section>
</main>
<?php get_footer(); ?>
