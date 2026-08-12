<?php
/**
 * Presentation and page content for Nhà Ở Ngay RECO.
 */

defined( 'ABSPATH' ) || exit;

function reco_menu_fallback() {
	$items = array(
		'/'                       => 'Trang chủ',
		'/gioi-thieu/'            => 'Giới thiệu',
		'/he-thong-san-pham/'     => 'Hệ thống sản phẩm',
		'/tin-tuc/'               => 'Tin tức',
		'/noi-bo/'                => 'Nội bộ',
		'/tuyen-dung/'            => 'Tuyển dụng',
		'/lien-he/'               => 'Liên hệ',
	);
	echo '<ul class="reco-nav__list">';
	foreach ( $items as $path => $label ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( home_url( $path ) ), esc_html( $label ) );
	}
	echo '</ul>';
}

function reco_projects() {
	return array(
		array(
			'name'     => 'Celestine Westlake',
			'tagline'  => 'Viên ngọc bên Hồ Tây',
			'image'    => 'images/project-celestine.jpg',
			'location' => '300 Võ Chí Công, Tây Hồ, Hà Nội',
			'type'     => 'Căn hộ cao cấp',
			'category' => 'an-cu',
			'desc'     => 'Không gian sống cao cấp bên Hồ Tây, kết hợp kiến trúc đương đại và hệ tiện ích hiện đại.',
		),
		array(
			'name'     => 'Công viên Thiên Đường',
			'tagline'  => 'Giá trị vĩnh hằng',
			'image'    => 'images/project-thien-duong.jpg',
			'location' => 'Quần thể sinh thái tâm linh',
			'type'     => 'Bất động sản tâm linh',
			'category' => 'tam-linh',
			'desc'     => 'Không gian trang nghiêm, thanh tịnh, được kiến tạo để lưu giữ giá trị tinh thần cho nhiều thế hệ.',
		),
		array(
			'name'     => 'Palmy Biztown',
			'tagline'  => 'Trái tim kinh doanh sầm uất',
			'image'    => 'images/project-palmy.jpg',
			'location' => 'Tổ hợp thương mại đa chức năng',
			'type'     => 'Thương mại & văn phòng',
			'category' => 'thuong-mai',
			'desc'     => 'Tổ hợp thương mại, văn phòng và dịch vụ sở hữu khả năng kết nối thuận tiện cho doanh nghiệp.',
		),
		array(
			'name'     => 'Khu đô thị Việt Hàn',
			'tagline'  => 'Chuẩn mực sống quốc tế',
			'image'    => 'images/project-viet-han.jpg',
			'location' => 'Khu đô thị quy hoạch đồng bộ',
			'type'     => 'Nhà phố & liền kề',
			'category' => 'an-cu',
			'desc'     => 'Hạ tầng và tiện ích nội khu đồng bộ, hướng đến một cộng đồng sống hiện đại, tiện nghi.',
		),
	);
}

function reco_news_items() {
	return array(
		array(
			'title'    => 'Kết nối nguồn lực, mở rộng giá trị hợp tác chiến lược',
			'category' => 'Doanh nghiệp',
			'image'    => 'images/event-signing.jpg',
			'desc'     => 'RECO củng cố hệ sinh thái dịch vụ bằng các thỏa thuận hợp tác thiết thực, hướng đến trải nghiệm đồng bộ cho khách hàng.',
		),
		array(
			'title'    => 'Dấu ấn phát triển từ mạng lưới chi nhánh chuyên nghiệp',
			'category' => 'Hoạt động',
			'image'    => 'images/about-team.jpg',
			'desc'     => 'Năng lực vận hành được xây dựng từ đội ngũ am hiểu địa bàn, sản phẩm, pháp lý và nhu cầu thực tế của khách hàng.',
		),
		array(
			'title'    => 'Celestine Westlake — không gian sống mới bên Hồ Tây',
			'category' => 'Dự án',
			'image'    => 'images/project-celestine.jpg',
			'desc'     => 'Tổng quan dự án căn hộ cao cấp với 216 sản phẩm, pháp lý sở hữu lâu dài và vị trí tại 300 Võ Chí Công.',
		),
		array(
			'title'    => 'Chuẩn hóa đội ngũ tư vấn theo hành trình khách hàng',
			'category' => 'Góc nhìn',
			'image'    => 'images/about-collaboration.jpg',
			'desc'     => 'Từ tiếp nhận nhu cầu đến hậu mãi, mỗi điểm chạm đều được RECO xây dựng trên nền tảng minh bạch và trách nhiệm.',
		),
		array(
			'title'    => 'Khai trương điểm giao dịch — gần khách hàng hơn mỗi ngày',
			'category' => 'Nội bộ',
			'image'    => 'images/event-opening.jpg',
			'desc'     => 'Không gian làm việc mới hỗ trợ đội ngũ phục vụ nhanh hơn, kết nối tốt hơn và chia sẻ cơ hội phát triển.',
		),
		array(
			'title'    => 'Tư duy đầu tư bất động sản: ưu tiên pháp lý và giá trị sử dụng',
			'category' => 'Kiến thức',
			'image'    => 'images/contact-city.webp',
			'desc'     => 'Một quyết định bền vững bắt đầu từ thông tin rõ ràng, nhu cầu thật và kế hoạch tài chính phù hợp.',
		),
	);
}

function reco_section_heading( $eyebrow, $title, $description = '', $align = '' ) {
	$class = $align ? ' reco-section-head--' . sanitize_html_class( $align ) : '';
	echo '<div class="reco-section-head' . esc_attr( $class ) . '" data-reveal>';
	echo '<span class="reco-eyebrow">' . esc_html( $eyebrow ) . '</span>';
	echo '<h2>' . wp_kses_post( $title ) . '</h2>';
	if ( $description ) {
		echo '<p>' . esc_html( $description ) . '</p>';
	}
	echo '</div>';
}

function reco_subhero( $title, $subtitle, $image, $position = 'center' ) {
	?>
	<section class="reco-subhero" style="--media-position: <?php echo esc_attr( $position ); ?>;">
		<img class="reco-subhero__image" src="<?php echo esc_url( reco_asset( $image ) ); ?>" alt="" width="1920" height="760" fetchpriority="high">
		<div class="reco-subhero__shade" aria-hidden="true"></div>
		<div class="reco-container reco-subhero__content">
			<h1><?php echo esc_html( $title ); ?></h1>
			<p><?php echo esc_html( $subtitle ); ?></p>
		</div>
	</section>
	<?php
}

function reco_render_project_cards( $limit = 0 ) {
	$projects = reco_projects();
	if ( $limit ) {
		$projects = array_slice( $projects, 0, $limit );
	}
	foreach ( $projects as $index => $project ) {
		?>
		<article class="reco-project-card<?php echo 0 === $index ? ' reco-project-card--featured' : ''; ?>" data-project-card data-category="<?php echo esc_attr( $project['category'] ); ?>" data-reveal>
			<a class="reco-project-card__media" href="<?php echo esc_url( home_url( '/he-thong-san-pham/#' . sanitize_title( $project['name'] ) ) ); ?>" aria-label="Xem <?php echo esc_attr( $project['name'] ); ?>">
				<img src="<?php echo esc_url( reco_asset( $project['image'] ) ); ?>" alt="Phối cảnh <?php echo esc_attr( $project['name'] ); ?>" width="1000" height="720" loading="lazy">
				<span class="reco-project-card__type"><?php echo esc_html( $project['type'] ); ?></span>
			</a>
			<div class="reco-project-card__body">
				<span><?php echo esc_html( $project['location'] ); ?></span>
				<h3><?php echo esc_html( $project['name'] ); ?></h3>
				<p><?php echo esc_html( $project['tagline'] ); ?></p>
				<a class="reco-text-link" href="<?php echo esc_url( home_url( '/he-thong-san-pham/#' . sanitize_title( $project['name'] ) ) ); ?>">Khám phá dự án <span aria-hidden="true">↗</span></a>
			</div>
		</article>
		<?php
	}
}

/**
 * Read a project field managed by Secure Custom Fields.
 */
function reco_project_field( $name, $post_id = false, $default = '' ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $default;
	}

	$value = get_field( $name, $post_id ?: get_the_ID() );
	return null === $value || false === $value || '' === $value ? $default : $value;
}

/**
 * Return a compact list of taxonomy labels for a project.
 */
function reco_project_term_names( $post_id, $taxonomy ) {
	$terms = wp_get_post_terms( $post_id, $taxonomy, array( 'fields' => 'names' ) );
	return is_wp_error( $terms ) ? array() : $terms;
}

/**
 * Human-readable status for the project cards and detail page.
 */
function reco_project_status_label( $status ) {
	$labels = array(
		'dang-mo-ban' => 'Đang mở bán',
		'sap-mo-ban'  => 'Sắp mở bán',
		'dang-cap-nhat' => 'Đang cập nhật',
	);

	return isset( $labels[ $status ] ) ? $labels[ $status ] : 'Đang cập nhật';
}

/**
 * Project catalogue used on the temporary Test page.
 * Content remains editable in WP Admin through Secure Custom Fields.
 */
function reco_project_demo_shortcode() {
	$projects = new WP_Query(
		array(
			'post_type'      => 'reco_project',
			'post_status'    => 'publish',
			'posts_per_page' => 6,
			'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
		)
	);

	ob_start();
	?>
	<div class="reco-project-demo">
		<header class="reco-project-demo__head">
			<div>
				<span class="reco-eyebrow">Dữ liệu từ WP Admin</span>
				<h1>Danh mục dự án<br><em>dễ cập nhật.</em></h1>
			</div>
			<p>Ảnh, mô tả và nhóm dự án bên dưới được lưu bằng Secure Custom Fields. Khi chỉnh trong WP Admin, nội dung trên trang này sẽ thay đổi theo.</p>
		</header>

		<?php if ( $projects->have_posts() ) : ?>
			<div class="reco-project-demo__grid">
				<?php
				while ( $projects->have_posts() ) :
					$projects->the_post();
					$post_id   = get_the_ID();
					$types     = reco_project_term_names( $post_id, 'reco_project_type' );
					$locations = reco_project_term_names( $post_id, 'reco_location' );
					$tags      = reco_project_term_names( $post_id, 'reco_project_tag' );
					$status    = reco_project_status_label( reco_project_field( 'reco_project_status', $post_id ) );
					$tagline   = reco_project_field( 'reco_project_tagline', $post_id );
					?>
					<article class="reco-project-demo-card" data-reveal>
						<a class="reco-project-demo-card__media" href="<?php the_permalink(); ?>" aria-label="Xem dự án <?php the_title_attribute(); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); ?>
							<?php endif; ?>
							<span class="reco-project-demo-card__status"><?php echo esc_html( $status ); ?></span>
						</a>
						<div class="reco-project-demo-card__body">
							<div class="reco-project-demo-card__meta">
								<span><?php echo esc_html( $types ? implode( ', ', $types ) : 'Dự án' ); ?></span>
								<span><?php echo esc_html( $locations ? implode( ', ', $locations ) : 'Đang cập nhật vị trí' ); ?></span>
							</div>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<?php if ( $tagline ) : ?><p class="reco-project-demo-card__tagline"><?php echo esc_html( $tagline ); ?></p><?php endif; ?>
							<p class="reco-project-demo-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
							<?php if ( $tags ) : ?>
								<ul class="reco-project-demo-card__tags" aria-label="Đặc điểm dự án">
									<?php foreach ( array_slice( $tags, 0, 3 ) as $tag ) : ?><li><?php echo esc_html( $tag ); ?></li><?php endforeach; ?>
								</ul>
							<?php endif; ?>
							<a class="reco-text-link" href="<?php the_permalink(); ?>">Xem ảnh và thông tin <span aria-hidden="true">→</span></a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
		<?php else : ?>
			<p class="reco-project-demo__empty">Chưa có dự án mẫu. Hãy thêm một dự án trong WP Admin.</p>
		<?php endif; ?>
	</div>
	<?php
	wp_reset_postdata();
	return ob_get_clean();
}
add_shortcode( 'reco_project_demo', 'reco_project_demo_shortcode' );

function reco_render_news_cards( $items ) {
	foreach ( $items as $item ) {
		?>
		<article class="reco-news-card" data-reveal>
			<div class="reco-news-card__media">
				<img src="<?php echo esc_url( reco_asset( $item['image'] ) ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" width="800" height="560" loading="lazy">
				<span><?php echo esc_html( $item['category'] ); ?></span>
			</div>
			<div class="reco-news-card__body">
				<h3><?php echo esc_html( $item['title'] ); ?></h3>
				<p><?php echo esc_html( $item['desc'] ); ?></p>
				<a class="reco-text-link" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Trao đổi cùng chuyên gia <span aria-hidden="true">→</span></a>
			</div>
		</article>
		<?php
	}
}

function reco_contact_form() {
	$status = isset( $_GET['gui'] ) ? sanitize_key( wp_unslash( $_GET['gui'] ) ) : '';
	if ( 'thanh-cong' === $status ) {
		echo '<div class="reco-form-notice reco-form-notice--success" role="status">Thông tin đã được ghi nhận. Đội ngũ RECO sẽ liên hệ với anh/chị trong thời gian sớm nhất.</div>';
	} elseif ( 'thieu-thong-tin' === $status ) {
		echo '<div class="reco-form-notice reco-form-notice--error" role="alert">Vui lòng nhập họ tên và số điện thoại để RECO có thể liên hệ.</div>';
	} elseif ( 'loi' === $status ) {
		echo '<div class="reco-form-notice reco-form-notice--error" role="alert">Phiên gửi đã hết hạn. Vui lòng thử lại.</div>';
	}
	?>
	<form class="reco-contact-form" id="form-lien-he" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" data-contact-form>
		<input type="hidden" name="action" value="reco_contact">
		<?php wp_nonce_field( 'reco_contact', 'reco_contact_nonce' ); ?>
		<div class="reco-honeypot" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
		<div class="reco-field">
			<label for="reco-name">Họ và tên <span aria-hidden="true">*</span></label>
			<input id="reco-name" name="name" type="text" autocomplete="name" required placeholder="Nguyễn Văn An">
		</div>
		<div class="reco-field">
			<label for="reco-phone">Số điện thoại <span aria-hidden="true">*</span></label>
			<input id="reco-phone" name="phone" type="tel" autocomplete="tel" inputmode="tel" required placeholder="09xx xxx xxx">
		</div>
		<div class="reco-field">
			<label for="reco-email">Email</label>
			<input id="reco-email" name="email" type="email" autocomplete="email" placeholder="email@example.com">
		</div>
		<div class="reco-field">
			<label for="reco-topic">Nhu cầu quan tâm</label>
			<select id="reco-topic" name="topic">
				<option value="">Chọn nhu cầu</option>
				<option>Tìm nhà ở</option>
				<option>Đầu tư bất động sản</option>
				<option>Mặt bằng kinh doanh</option>
				<option>Hợp tác phân phối</option>
				<option>Cơ hội nghề nghiệp</option>
			</select>
		</div>
		<div class="reco-field reco-field--full">
			<label for="reco-message">Nội dung</label>
			<textarea id="reco-message" name="message" rows="4" placeholder="Chia sẻ thêm nhu cầu để chuyên gia RECO tư vấn phù hợp hơn"></textarea>
		</div>
		<div class="reco-contact-form__submit reco-field--full">
			<button class="reco-button reco-button--orange" type="submit">Gửi yêu cầu tư vấn <span aria-hidden="true">→</span></button>
			<p>Bằng việc gửi thông tin, anh/chị đồng ý để RECO liên hệ phục vụ đúng nhu cầu đã đăng ký.</p>
		</div>
	</form>
	<?php
}

function reco_render_home() {
	$news = array_slice( reco_news_items(), 0, 3 );
	?>
	<section class="reco-hero" aria-labelledby="reco-home-title">
		<img class="reco-hero__image" src="<?php echo esc_url( reco_asset( 'images/hero-home.webp' ) ); ?>" alt="Phối cảnh dự án bất động sản hiện đại tại Hà Nội" width="1920" height="960" fetchpriority="high">
		<div class="reco-hero__shade" aria-hidden="true"></div>
		<div class="reco-container reco-hero__content">
			<span class="reco-hero__eyebrow">Nhà Ở Ngay RECO</span>
			<h1 id="reco-home-title"><span>Kiến tạo điểm đến an cư</span><span>Định hình giá trị thịnh vượng</span></h1>
			<p>Giải pháp bất động sản minh bạch, toàn diện cho nhu cầu an cư và đầu tư.</p>
			<div class="reco-hero__actions">
				<a class="reco-button reco-button--orange" href="<?php echo esc_url( home_url( '/he-thong-san-pham/' ) ); ?>">Khám phá sản phẩm <span aria-hidden="true">→</span></a>
				<a class="reco-button reco-button--ghost" href="<?php echo esc_url( home_url( '/gioi-thieu/' ) ); ?>">Về RECO</a>
			</div>
		</div>
	</section>

	<section class="reco-section reco-intro">
		<div class="reco-container reco-intro__grid">
			<div class="reco-intro__copy" data-reveal>
				<span class="reco-eyebrow">Giới thiệu</span>
				<h2>Nền tảng vững vàng.<br><em>Tư vấn có chiều sâu.</em></h2>
				<p class="reco-lead">Nhà Ở Ngay RECO kế thừa uy tín, kinh nghiệm và năng lực vận hành từ hệ thống Nhà Ở Ngay thuộc Đất Xanh Miền Bắc.</p>
				<p>Chúng tôi kết nối khách hàng với những sản phẩm phù hợp bằng thông tin rõ ràng, đội ngũ am hiểu pháp lý – tài chính và dịch vụ đồng hành xuyên suốt.</p>
				<a class="reco-text-link" href="<?php echo esc_url( home_url( '/gioi-thieu/' ) ); ?>">Khám phá câu chuyện RECO <span aria-hidden="true">→</span></a>
			</div>
			<figure class="reco-intro__media" data-reveal>
				<img src="<?php echo esc_url( reco_asset( 'images/about-team.jpg' ) ); ?>" alt="Đội ngũ quản lý Nhà Ở Ngay RECO" width="1200" height="800" loading="lazy">
				<figcaption>Đội ngũ chuyên nghiệp · Kết nối toàn hệ thống</figcaption>
			</figure>
		</div>
		<div class="reco-container reco-metrics" aria-label="Năng lực hệ thống">
			<div data-reveal><strong>20</strong><span>Chi nhánh & đơn vị liên kết</span></div>
			<div data-reveal><strong>400+</strong><span>Nhân sự & chuyên gia</span></div>
			<div data-reveal><strong>2.000+</strong><span>Cộng tác viên toàn hệ thống</span></div>
			<div data-reveal><strong>15+</strong><span>Năm kinh nghiệm lãnh đạo</span></div>
		</div>
	</section>

	<section class="reco-section reco-section--blue reco-products-home">
		<div class="reco-container">
			<div class="reco-section-head reco-section-head--split" data-reveal>
				<div><span class="reco-eyebrow reco-eyebrow--light">Hệ thống sản phẩm</span><h2>Danh mục tuyển chọn cho<br>mỗi mục tiêu <em>sống & đầu tư.</em></h2></div>
				<div><p>Đa dạng từ căn hộ cao cấp, nhà phố thương mại đến bất động sản tâm linh — mỗi sản phẩm đều được tiếp cận với tiêu chí rõ ràng về giá trị và pháp lý.</p><a class="reco-text-link reco-text-link--light" href="<?php echo esc_url( home_url( '/he-thong-san-pham/' ) ); ?>">Xem toàn bộ sản phẩm <span aria-hidden="true">→</span></a></div>
			</div>
			<div class="reco-project-grid">
				<?php reco_render_project_cards(); ?>
			</div>
		</div>
	</section>

	<section class="reco-section reco-news-home">
		<div class="reco-container">
			<?php reco_section_heading( 'Tin tức & góc nhìn', 'Thông tin rõ ràng cho<br><em>quyết định vững vàng.</em>', 'Cập nhật hoạt động doanh nghiệp, dự án nổi bật và góc nhìn thực tiễn từ đội ngũ RECO.' ); ?>
			<div class="reco-news-grid">
				<?php reco_render_news_cards( $news ); ?>
			</div>
			<div class="reco-section-action"><a class="reco-button reco-button--outline" href="<?php echo esc_url( home_url( '/tin-tuc/' ) ); ?>">Xem tất cả tin tức <span aria-hidden="true">→</span></a></div>
		</div>
	</section>

	<section class="reco-section reco-culture-home">
		<div class="reco-container reco-culture-home__grid">
			<div class="reco-culture-home__collage" data-reveal>
				<img src="<?php echo esc_url( reco_asset( 'images/event-opening.jpg' ) ); ?>" alt="Đội ngũ RECO tại lễ khai trương" width="1000" height="760" loading="lazy">
				<img src="<?php echo esc_url( reco_asset( 'images/event-signing-2.jpg' ) ); ?>" alt="Hoạt động hợp tác của RECO" width="760" height="560" loading="lazy">
			</div>
			<div class="reco-culture-home__copy" data-reveal>
				<span class="reco-eyebrow">Hoạt động nội bộ</span>
				<h2>Một tập thể cùng<br><em>hướng về giá trị thật.</em></h2>
				<p>Văn hóa RECO được nuôi dưỡng bằng tinh thần học hỏi, hợp tác và chủ động. Mỗi hoạt động nội bộ là một điểm chạm để đội ngũ hiểu nhau hơn và phục vụ khách hàng tốt hơn.</p>
				<a class="reco-text-link" href="<?php echo esc_url( home_url( '/noi-bo/' ) ); ?>">Khám phá đời sống RECO <span aria-hidden="true">→</span></a>
			</div>
		</div>
	</section>

	<section class="reco-section reco-career-home">
		<div class="reco-career-home__media">
			<img src="<?php echo esc_url( reco_asset( 'images/event-opening-4.jpg' ) ); ?>" alt="Đội ngũ Nhà Ở Ngay RECO" width="1400" height="900" loading="lazy">
		</div>
		<div class="reco-career-home__panel" data-reveal>
			<span class="reco-eyebrow reco-eyebrow--light">Tuyển dụng</span>
			<h2>Cùng người giỏi<br>làm việc có ý nghĩa.</h2>
			<p>Môi trường chuyên nghiệp, cơ hội học hỏi liên tục và lộ trình phát triển rõ ràng cho những người muốn tiến xa trong ngành bất động sản.</p>
			<a class="reco-button reco-button--white" href="<?php echo esc_url( home_url( '/tuyen-dung/' ) ); ?>">Gia nhập RECO <span aria-hidden="true">→</span></a>
		</div>
	</section>

	<section class="reco-section reco-partners">
		<div class="reco-container">
			<?php reco_section_heading( 'Đối tác', 'Đồng hành cùng những<br><em>thương hiệu uy tín.</em>', 'Nền tảng hợp tác đa lĩnh vực giúp RECO mang đến giải pháp xuyên suốt cho khách hàng và chủ đầu tư.', 'center' ); ?>
			<div class="reco-partner-grid" data-reveal>
				<?php
				$partners = array(
					array( 'images/partner-vinaenco.svg', 'VINAENCO' ),
					array( 'images/partner-coteccons.webp', 'Coteccons' ),
					array( 'images/partner-cbre.png', 'CBRE' ),
					array( 'images/partner-indochine.png', 'Indochine' ),
					array( 'images/partner-mbbank.png', 'MBBank' ),
					array( 'images/partner-marina.jpg', 'Marina Holding' ),
				);
				foreach ( $partners as $partner ) {
					printf( '<div><img src="%s" alt="%s" loading="lazy"></div>', esc_url( reco_asset( $partner[0] ) ), esc_attr( $partner[1] ) );
				}
				?>
			</div>
		</div>
	</section>
	<?php
}

function reco_render_about() {
	reco_subhero( 'Giới thiệu', 'Từ nền tảng vững mạnh đến hành trình kiến tạo', 'images/about-team.jpg', 'center 42%' );
	?>
	<section class="reco-section">
		<div class="reco-container reco-story">
			<div class="reco-story__title" data-reveal><span class="reco-eyebrow">Câu chuyện của chúng tôi</span><h2>Xa hơn một giao dịch,<br><em>là một hành trình đồng hành.</em></h2></div>
			<div class="reco-story__copy" data-reveal>
				<p class="reco-lead">Nhà Ở Ngay RECO ra đời với mong muốn giúp quá trình tìm kiếm và sở hữu bất động sản trở nên rõ ràng, tin cậy và thuận tiện hơn.</p>
				<p>Là đơn vị đầu tiên phát triển từ hệ thống Nhà Ở Ngay thuộc Đất Xanh Miền Bắc, chúng tôi kế thừa kinh nghiệm thị trường, năng lực vận hành và nguồn sản phẩm được tuyển chọn.</p>
				<p>Sứ mệnh của RECO là đồng hành an cư cùng người trẻ bằng thông tin minh bạch, tư vấn phù hợp với nhu cầu, tài chính và lối sống, cùng các giải pháp hỗ trợ xuyên suốt.</p>
			</div>
		</div>
		<div class="reco-container reco-why-grid">
			<?php
			$reasons = array(
				array( '01', 'Thông tin dự án rõ ràng', 'Chú trọng hồ sơ pháp lý, tiến độ và phân tích sản phẩm.' ),
				array( '02', 'Tư vấn chuyên sâu', 'Am hiểu sản phẩm, pháp lý, tài chính và diễn biến thị trường.' ),
				array( '03', 'Dịch vụ toàn diện', 'Hỗ trợ pháp lý, kết nối tài chính và chăm sóc sau bán hàng.' ),
				array( '04', 'Danh mục tuyển chọn', 'Thẩm định chủ đầu tư, pháp lý, tiến độ và tiềm năng giá trị.' ),
			);
			foreach ( $reasons as $reason ) {
				echo '<article data-reveal><span>' . esc_html( $reason[0] ) . '</span><h3>' . esc_html( $reason[1] ) . '</h3><p>' . esc_html( $reason[2] ) . '</p></article>';
			}
			?>
		</div>
	</section>

	<section class="reco-section reco-history">
		<div class="reco-container reco-history__grid">
			<div data-reveal><span class="reco-eyebrow reco-eyebrow--light">Lịch sử hình thành</span><h2>Phát triển cân bằng.<br>Vận hành hiệu quả.</h2></div>
			<div data-reveal><p>Nền tảng của công ty là đội ngũ lãnh đạo giàu kinh nghiệm, trưởng thành từ môi trường chuyên nghiệp của Đất Xanh Miền Bắc.</p><p>Ngay từ đầu, RECO theo đuổi chiến lược tinh gọn mô hình kinh doanh truyền thống, duy trì hiệu quả và từng bước đầu tư vào công nghệ quản lý, kết nối.</p></div>
		</div>
	</section>

	<section class="reco-section reco-vision">
		<div class="reco-container">
			<?php reco_section_heading( 'Định hướng phát triển', 'Tầm nhìn dài hạn.<br><em>Giá trị nhất quán.</em>', 'RECO chuẩn hóa dịch vụ để tạo nên một hệ thống bán lẻ bất động sản đáng tin cậy.' ); ?>
			<div class="reco-vision__grid">
				<article data-reveal><span>Tầm nhìn</span><h3>Hệ thống được tin cậy hàng đầu Việt Nam</h3><p>Hướng tới mạng lưới hơn 500 điểm giao dịch, kết nối các đơn vị và nhà môi giới chuyên nghiệp trên toàn quốc.</p></article>
				<article data-reveal><span>Sứ mệnh</span><h3>Minh bạch hóa toàn bộ hành trình giao dịch</h3><p>Số hóa quá trình mua bán, ký gửi và chăm sóc khách hàng; xây dựng đội ngũ môi giới theo chuẩn chuyên gia tư vấn.</p></article>
				<article class="reco-vision__core" data-reveal><span>Giá trị cốt lõi</span><h3>Minh bạch · Chuyên nghiệp · Khởi nghiệp · Nhân văn · Linh hoạt</h3><p>Đề cao phát triển sự nghiệp, cơ hội thăng tiến và văn hóa học tập, đào tạo.</p></article>
			</div>
		</div>
	</section>

	<section class="reco-section reco-section--soft reco-services">
		<div class="reco-container">
			<?php reco_section_heading( 'Lĩnh vực hoạt động', 'Giải pháp toàn diện cho<br><em>mọi nhu cầu bất động sản.</em>', 'Hệ sinh thái khép kín đồng hành từ giao dịch, đầu tư và xây dựng đến khai thác, quản lý tài sản.' ); ?>
			<div class="reco-service-grid">
				<?php
				$services = array(
					array( 'Phân phối & giao dịch', 'Phân phối dự án sơ cấp và hỗ trợ mua bán, chuyển nhượng bất động sản thứ cấp.', 'images/service-distribution.png' ),
					array( 'Đầu tư, phát triển & xây dựng', 'Nghiên cứu cơ hội đầu tư, phát triển dự án và hoàn thiện công trình dân dụng.', 'images/service-investment.png' ),
					array( 'Khai thác, cho thuê & quản lý', 'Hỗ trợ cho thuê căn hộ, văn phòng, mặt bằng và quản lý vận hành tài sản.', 'images/service-operation.png' ),
					array( 'Tư vấn chuyên sâu', 'Tư vấn nội thất, quản lý bán hàng, marketing dự án, quy hoạch và chuyển đổi số.', 'images/service-consulting.png' ),
				);
				foreach ( $services as $index => $service ) {
					?>
					<article class="reco-service-card" data-reveal>
						<img src="<?php echo esc_url( reco_asset( $service[2] ) ); ?>" alt="<?php echo esc_attr( $service[0] ); ?>" width="900" height="600" loading="lazy">
						<div><span><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span><h3><?php echo esc_html( $service[0] ); ?></h3><p><?php echo esc_html( $service[1] ); ?></p></div>
					</article>
					<?php
				}
				?>
			</div>
		</div>
	</section>

	<section class="reco-section reco-leadership">
		<div class="reco-container">
			<?php reco_section_heading( 'Đội ngũ lãnh đạo', 'Kết hợp tầm nhìn chiến lược<br>và <em>năng lực vận hành.</em>', 'Kinh nghiệm quản trị, pháp lý và phát triển con người tạo nên nền tảng vững chắc cho RECO.' ); ?>
			<div class="reco-leader-grid">
				<article data-reveal><img src="<?php echo esc_url( reco_asset( 'images/leader-huy.jpg' ) ); ?>" alt="Ông Nguyễn Quốc Huy — Tổng Giám đốc" width="700" height="1000" loading="lazy"><div><span>Tổng Giám đốc</span><h3>Ông Nguyễn Quốc Huy</h3><p>Hơn 15 năm kinh nghiệm bất động sản, từng giữ vị trí Trưởng ban Kiểm soát kiêm Trưởng ban Pháp chế tại Đất Xanh Miền Bắc.</p></div></article>
				<article data-reveal><img src="<?php echo esc_url( reco_asset( 'images/leader-quynh.png' ) ); ?>" alt="Bà Nguyễn Thị Quỳnh — Phó Tổng Giám đốc" width="700" height="1000" loading="lazy"><div><span>Phó Tổng Giám đốc</span><h3>Bà Nguyễn Thị Quỳnh</h3><p>Hơn 10 năm kinh nghiệm nhân sự cấp cao, tập trung xây dựng đội ngũ kinh doanh, phát triển nguồn hàng và đào tạo sản phẩm.</p></div></article>
			</div>
		</div>
	</section>
	<?php
}

function reco_render_products() {
	reco_subhero( 'Hệ thống sản phẩm', 'Đa dạng lựa chọn — vững vàng giá trị', 'images/hero-home.webp', 'center' );
	?>
	<section class="reco-section reco-products-page">
		<div class="reco-container">
			<?php reco_section_heading( 'Danh mục dự án', 'Mỗi sản phẩm phù hợp với<br><em>một mục tiêu riêng.</em>', 'RECO lựa chọn danh mục đa dạng cho nhu cầu an cư, kinh doanh và đầu tư của từng khách hàng.' ); ?>
			<div class="reco-filter" role="group" aria-label="Lọc dự án" data-project-filter>
				<button class="is-active" type="button" data-filter="all">Tất cả</button>
				<button type="button" data-filter="an-cu">An cư</button>
				<button type="button" data-filter="thuong-mai">Thương mại</button>
				<button type="button" data-filter="tam-linh">Tâm linh</button>
			</div>
			<div class="reco-project-grid reco-project-grid--catalog" data-project-grid>
				<?php reco_render_project_cards(); ?>
			</div>
		</div>
	</section>

	<section class="reco-section reco-section--soft reco-project-detail" id="celestine-westlake">
		<div class="reco-container reco-project-detail__grid">
			<div class="reco-project-detail__media" data-reveal><img src="<?php echo esc_url( reco_asset( 'images/project-celestine.jpg' ) ); ?>" alt="Toàn cảnh Celestine Westlake bên Hồ Tây" width="1100" height="780" loading="lazy"><span>Dự kiến bàn giao từ năm 2027</span></div>
			<div class="reco-project-detail__content" data-reveal>
				<span class="reco-eyebrow">Dự án nổi bật</span>
				<h2>Celestine Westlake</h2>
				<p class="reco-lead">Tổ hợp căn hộ cao cấp tại lô CHC1–D6, số 300 Võ Chí Công, phường Tây Hồ, Hà Nội.</p>
				<dl>
					<div><dt>Chủ đầu tư</dt><dd>Tập đoàn VINAENCO</dd></div>
					<div><dt>Quy mô</dt><dd>2 tháp cao 23 tầng · 216 căn hộ</dd></div>
					<div><dt>Diện tích đất</dt><dd>4.338 m²</dd></div>
					<div><dt>Loại hình</dt><dd>1–3PN, Duplex, Dual Key, Penthouse</dd></div>
					<div><dt>Pháp lý</dt><dd>Sở hữu lâu dài, đầy đủ giấy phép</dd></div>
					<div><dt>Điểm nổi bật</dt><dd>238 chỗ đỗ ô tô</dd></div>
				</dl>
				<a class="reco-button reco-button--orange" href="<?php echo esc_url( home_url( '/lien-he/?du-an=celestine' ) ); ?>">Nhận thông tin dự án <span aria-hidden="true">→</span></a>
			</div>
		</div>
	</section>

	<section class="reco-section reco-property-request">
		<div class="reco-container reco-property-request__inner" data-reveal>
			<div><span class="reco-eyebrow reco-eyebrow--light">Chuyển nhượng khu vực Thanh Xuân</span><h2>An cư đúng nhu cầu.<br>Đầu tư đúng thời điểm.</h2></div>
			<div><p>Danh mục nhà ở, căn hộ, mặt bằng được đội ngũ RECO cập nhật theo vị trí, diện tích, pháp lý, nội thất và mức tài chính phù hợp.</p><a class="reco-button reco-button--white" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Gửi nhu cầu tìm kiếm <span aria-hidden="true">→</span></a></div>
		</div>
	</section>
	<?php
}

function reco_render_news() {
	$news = reco_news_items();
	reco_subhero( 'Tin tức', 'Cập nhật thị trường — chia sẻ góc nhìn', 'images/event-signing.jpg', 'center 44%' );
	?>
	<section class="reco-section">
		<div class="reco-container">
			<?php reco_section_heading( 'Tin mới từ RECO', 'Thông tin có chọn lọc.<br><em>Góc nhìn có chiều sâu.</em>', 'Những câu chuyện về dự án, hoạt động doanh nghiệp và kinh nghiệm bất động sản được trình bày rõ ràng, dễ tiếp cận.' ); ?>
			<div class="reco-news-feature" data-reveal>
				<img src="<?php echo esc_url( reco_asset( $news[0]['image'] ) ); ?>" alt="<?php echo esc_attr( $news[0]['title'] ); ?>" width="1200" height="760" loading="lazy">
				<div><span><?php echo esc_html( $news[0]['category'] ); ?></span><h2><?php echo esc_html( $news[0]['title'] ); ?></h2><p><?php echo esc_html( $news[0]['desc'] ); ?></p><a class="reco-text-link" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Kết nối cùng RECO <span aria-hidden="true">→</span></a></div>
			</div>
			<div class="reco-news-grid reco-news-grid--archive">
				<?php reco_render_news_cards( array_slice( $news, 1 ) ); ?>
			</div>
		</div>
	</section>

	<section class="reco-section reco-insight-cta">
		<div class="reco-container reco-insight-cta__inner" data-reveal>
			<div><span class="reco-eyebrow reco-eyebrow--light">Tư vấn theo nhu cầu</span><h2>Thông tin chỉ thực sự có giá trị<br>khi phù hợp với quyết định của bạn.</h2></div>
			<a class="reco-button reco-button--white" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Trao đổi với chuyên gia <span aria-hidden="true">→</span></a>
		</div>
	</section>
	<?php
}

function reco_render_internal() {
	reco_subhero( 'Nội bộ RECO', 'Gắn kết đội ngũ — lan tỏa giá trị', 'images/event-opening.jpg', 'center 42%' );
	?>
	<section class="reco-section reco-internal">
		<div class="reco-container">
			<?php reco_section_heading( 'Đời sống doanh nghiệp', 'Những khoảnh khắc làm nên<br><em>một tập thể vững mạnh.</em>', 'Từ đào tạo, bổ nhiệm đến khai trương và ký kết — mỗi dấu mốc đều góp phần xây dựng văn hóa RECO.' ); ?>
			<div class="reco-event-grid">
				<figure class="reco-event-grid__wide" data-reveal><img src="<?php echo esc_url( reco_asset( 'images/event-opening.jpg' ) ); ?>" alt="Đội ngũ RECO trong lễ khai trương" width="1200" height="800" loading="lazy"><figcaption><span>Khai trương</span><strong>Mở rộng điểm chạm, phục vụ khách hàng gần hơn</strong></figcaption></figure>
				<figure data-reveal><img src="<?php echo esc_url( reco_asset( 'images/about-team.jpg' ) ); ?>" alt="Bổ nhiệm quản lý chi nhánh RECO" width="900" height="700" loading="lazy"><figcaption><span>Phát triển đội ngũ</span><strong>Trao quyền cho những nhân sự xứng đáng</strong></figcaption></figure>
				<figure data-reveal><img src="<?php echo esc_url( reco_asset( 'images/event-signing.jpg' ) ); ?>" alt="Hoạt động đào tạo và chia sẻ tại RECO" width="900" height="700" loading="lazy"><figcaption><span>Học tập</span><strong>Cập nhật kiến thức, nâng chuẩn tư vấn</strong></figcaption></figure>
				<figure data-reveal><img src="<?php echo esc_url( reco_asset( 'images/event-signing-2.jpg' ) ); ?>" alt="Lễ ký kết hợp tác chiến lược" width="900" height="700" loading="lazy"><figcaption><span>Hợp tác</span><strong>Cộng hưởng năng lực, kiến tạo giá trị mới</strong></figcaption></figure>
				<figure class="reco-event-grid__wide" data-reveal><img src="<?php echo esc_url( reco_asset( 'images/event-opening-3.jpg' ) ); ?>" alt="Tập thể Nhà Ở Ngay RECO" width="1200" height="800" loading="lazy"><figcaption><span>Gắn kết</span><strong>Cùng một mục tiêu, cùng một tinh thần phục vụ</strong></figcaption></figure>
			</div>
		</div>
	</section>

	<section class="reco-section reco-section--soft reco-culture-values">
		<div class="reco-container">
			<?php reco_section_heading( 'Văn hóa RECO', 'Môi trường để mỗi cá nhân<br><em>được học, được làm, được lớn.</em>', 'Chúng tôi coi sự trưởng thành của con người là nền tảng cho sự phát triển bền vững của doanh nghiệp.' ); ?>
			<div class="reco-culture-values__grid">
				<article data-reveal><strong>01</strong><h3>Học hỏi liên tục</h3><p>Chia sẻ kiến thức, đào tạo sản phẩm và kỹ năng tư vấn theo thực tế thị trường.</p></article>
				<article data-reveal><strong>02</strong><h3>Hợp tác thẳng thắn</h3><p>Thông tin rõ ràng, trách nhiệm minh bạch và cùng giải quyết vấn đề đến cùng.</p></article>
				<article data-reveal><strong>03</strong><h3>Ghi nhận xứng đáng</h3><p>Lộ trình phát triển và cơ hội được trao dựa trên năng lực, nỗ lực và kết quả.</p></article>
				<article data-reveal><strong>04</strong><h3>Khách hàng là trọng tâm</h3><p>Mọi cải tiến trong vận hành đều hướng đến trải nghiệm thuận tiện và đáng tin cậy hơn.</p></article>
			</div>
		</div>
	</section>
	<?php
}

function reco_render_careers() {
	reco_subhero( 'Tuyển dụng', 'Cùng người giỏi — tạo giá trị thật', 'images/event-opening-4.jpg', 'center 38%' );
	?>
	<section class="reco-section reco-careers-intro">
		<div class="reco-container reco-careers-intro__grid">
			<div data-reveal><span class="reco-eyebrow">Gia nhập RECO</span><h2>Một hành trình nghề nghiệp<br><em>đáng để dấn thân.</em></h2></div>
			<div data-reveal><p class="reco-lead">RECO tìm kiếm những người chủ động, tử tế và muốn phát triển chuyên môn lâu dài trong ngành bất động sản.</p><p>Bạn được làm việc cùng đội ngũ giàu kinh nghiệm, tiếp cận nguồn sản phẩm đa dạng và tham gia các chương trình đào tạo gắn với tình huống thực tế.</p></div>
		</div>
		<div class="reco-container reco-benefit-grid">
			<article data-reveal><span>01</span><h3>Đào tạo thực chiến</h3><p>Sản phẩm, pháp lý, tài chính và kỹ năng tư vấn được cập nhật liên tục.</p></article>
			<article data-reveal><span>02</span><h3>Lộ trình rõ ràng</h3><p>Cơ hội phát triển dựa trên năng lực, kết quả và tinh thần dẫn dắt đội ngũ.</p></article>
			<article data-reveal><span>03</span><h3>Thu nhập cạnh tranh</h3><p>Cơ chế ghi nhận minh bạch, tương xứng với nỗ lực và hiệu quả công việc.</p></article>
			<article data-reveal><span>04</span><h3>Môi trường gắn kết</h3><p>Đồng đội sẵn sàng chia sẻ, hỗ trợ và cùng theo đuổi mục tiêu chung.</p></article>
		</div>
	</section>

	<section class="reco-section reco-section--blue reco-jobs" id="vi-tri-tuyen-dung">
		<div class="reco-container">
			<div class="reco-section-head reco-section-head--split" data-reveal><div><span class="reco-eyebrow reco-eyebrow--light">Vị trí đang tuyển</span><h2>Tìm nơi bạn có thể<br>tạo nên <em>dấu ấn.</em></h2></div><p>Mỗi vị trí đều có người hướng dẫn, mục tiêu rõ ràng và không gian để bạn phát huy thế mạnh riêng.</p></div>
			<div class="reco-job-list">
				<?php
				$jobs = array(
					array( 'Bộ phận Kinh doanh', 'Chuyên viên tư vấn bất động sản', 'Toàn thời gian · Hà Nội', 'Tìm kiếm và chăm sóc khách hàng, tư vấn sản phẩm phù hợp, phối hợp hoàn thiện hồ sơ giao dịch. Ưu tiên ứng viên chủ động, giao tiếp tốt; chưa có kinh nghiệm sẽ được đào tạo.' ),
					array( 'Bộ phận HCNS', 'Chuyên viên Nhân sự', 'Toàn thời gian · Hà Nội', 'Phụ trách tuyển dụng, hội nhập và hoạt động gắn kết. Cần khả năng tổ chức công việc, giao tiếp rõ ràng và tinh thần đồng hành cùng nhân sự.' ),
					array( 'Bộ phận Marketing', 'Chuyên viên Marketing dự án', 'Toàn thời gian · Hà Nội', 'Triển khai nội dung, truyền thông và hỗ trợ bán hàng cho danh mục dự án. Ưu tiên tư duy nội dung, khả năng phối hợp và am hiểu nền tảng số.' ),
					array( 'Bộ phận Kế toán', 'Chuyên viên Kế toán', 'Toàn thời gian · Hà Nội', 'Theo dõi chứng từ, đối soát doanh thu – chi phí và hỗ trợ báo cáo nội bộ. Yêu cầu cẩn trọng, chính xác và tuân thủ quy trình.' ),
					array( 'Bộ phận Sales Admin', 'Chuyên viên Sales Admin', 'Toàn thời gian · Hà Nội', 'Quản lý dữ liệu sản phẩm, hồ sơ giao dịch và hỗ trợ đội ngũ kinh doanh. Cần khả năng sắp xếp, phản hồi nhanh và làm việc có hệ thống.' ),
				);
				foreach ( $jobs as $index => $job ) {
					?>
					<details class="reco-job" <?php echo 0 === $index ? 'open' : ''; ?> data-reveal>
						<summary><span class="reco-job__number"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span><span class="reco-job__title"><small><?php echo esc_html( $job[0] ); ?></small><strong><?php echo esc_html( $job[1] ); ?></strong></span><span class="reco-job__meta"><?php echo esc_html( $job[2] ); ?></span><span class="reco-job__toggle" aria-hidden="true">+</span></summary>
						<div class="reco-job__body"><p><?php echo esc_html( $job[3] ); ?></p><a class="reco-button reco-button--white" href="<?php echo esc_url( add_query_arg( array( 'nhu-cau' => 'tuyen-dung', 'vi-tri' => $job[1] ), home_url( '/lien-he/' ) ) ); ?>#form-lien-he">Ứng tuyển vị trí này <span aria-hidden="true">→</span></a></div>
					</details>
					<?php
				}
				?>
			</div>
		</div>
	</section>
	<?php
}

function reco_render_contact() {
	reco_subhero( 'Liên hệ', 'Lắng nghe nhu cầu — đồng hành đúng hướng', 'images/contact-city.webp', 'center' );
	?>
	<section class="reco-section reco-contact-page">
		<div class="reco-container reco-contact-page__grid">
			<div class="reco-contact-page__info" data-reveal>
				<span class="reco-eyebrow">Kết nối với RECO</span>
				<h2>Bắt đầu từ nhu cầu<br><em>thật của bạn.</em></h2>
				<p>Bạn cần tư vấn nhà ở, mặt bằng kinh doanh hoặc đầu tư bất động sản? Để lại thông tin, đội ngũ RECO sẽ liên hệ và hỗ trợ miễn phí.</p>
				<div class="reco-contact-list">
					<div><span>Hotline</span><a href="tel:0934524445">0934 524 445</a></div>
					<div><span>Kênh trực tuyến</span><a href="#form-lien-he">Form liên hệ RECO</a></div>
					<div><span>Văn phòng</span><p>Số 19–21 phố Vũ Trọng Phụng, phường Thanh Xuân Trung, quận Thanh Xuân, TP. Hà Nội.</p></div>
					<div><span>Tiếp nhận yêu cầu</span><p>Qua hotline và form liên hệ trực tuyến.</p></div>
				</div>
			</div>
			<div class="reco-contact-page__form" data-reveal>
				<h2>Để lại thông tin</h2>
				<p>RECO sẽ kết nối anh/chị với chuyên gia phù hợp nhất.</p>
				<?php reco_contact_form(); ?>
			</div>
		</div>
	</section>

	<section class="reco-map-section">
		<iframe title="Bản đồ văn phòng Nhà Ở Ngay RECO" src="https://maps.google.com/maps?q=19-21%20V%C5%A9%20Tr%E1%BB%8Dng%20Ph%E1%BB%A5ng%2C%20Thanh%20Xu%C3%A2n%2C%20H%C3%A0%20N%E1%BB%99i&z=16&output=embed" width="1600" height="520" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
		<div class="reco-map-section__label"><span>Văn phòng RECO</span><strong>19–21 Vũ Trọng Phụng</strong><a href="https://maps.google.com/?q=19-21+Vũ+Trọng+Phụng+Thanh+Xuân+Hà+Nội" target="_blank" rel="noopener">Mở chỉ đường <span aria-hidden="true">↗</span></a></div>
	</section>
	<?php
}

function reco_render_page( $slug ) {
	$renderers = array(
		'gioi-thieu'        => 'reco_render_about',
		'he-thong-san-pham' => 'reco_render_products',
		'tin-tuc'           => 'reco_render_news',
		'noi-bo'            => 'reco_render_internal',
		'tuyen-dung'        => 'reco_render_careers',
		'lien-he'           => 'reco_render_contact',
	);

	if ( empty( $renderers[ $slug ] ) ) {
		return false;
	}

	call_user_func( $renderers[ $slug ] );
	return true;
}
