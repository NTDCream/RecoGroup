<?php
defined( 'ABSPATH' ) || exit;
get_header();
?>
<section class="reco-section">
	<div class="reco-container reco-prose">
		<h1><?php single_post_title(); ?></h1>
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class( 'reco-archive-item' ); ?>>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php the_excerpt(); ?>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<p>Chưa có bài viết.</p>
		<?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>
