<?php
/**
 * Temporary showcase page for project content managed in WP Admin.
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main class="reco-main reco-project-demo-page" id="main-content">
	<section class="reco-section">
		<div class="reco-container">
			<?php
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
			?>
		</div>
	</section>
</main>
<?php get_footer(); ?>
