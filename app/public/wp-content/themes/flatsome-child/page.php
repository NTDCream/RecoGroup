<?php
defined( 'ABSPATH' ) || exit;
get_header();

while ( have_posts() ) :
	the_post();
	$slug = get_post_field( 'post_name', get_the_ID() );
	if ( function_exists( 'reco_render_page' ) && reco_render_page( $slug ) ) {
		continue;
	}
	?>
	<article class="reco-generic-page reco-section">
		<div class="reco-container reco-prose">
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</div>
	</article>
	<?php
endwhile;

get_footer();
