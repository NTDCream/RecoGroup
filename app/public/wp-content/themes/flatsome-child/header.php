<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="reco-skip-link" href="#reco-main">Bỏ qua đến nội dung</a>

<div class="reco-topbar">
	<div class="reco-container reco-topbar__inner">
		<span>Thành viên hệ thống Nhà Ở Ngay Việt Nam</span>
		<div class="reco-topbar__links">
			<a href="tel:0934524445" aria-label="Gọi hotline 0934 524 445">Hotline: <strong>0934 524 445</strong></a>
			<span>19–21 Vũ Trọng Phụng, Thanh Xuân, Hà Nội</span>
		</div>
	</div>
</div>

<header class="reco-header" data-reco-header>
	<div class="reco-container reco-header__inner">
		<a class="reco-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Nhà Ở Ngay RECO — Trang chủ">
			<img src="<?php echo esc_url( reco_asset( 'images/logo.png' ) ); ?>" width="241" height="113" alt="Nhà Ở Ngay RECO">
		</a>

		<nav class="reco-nav reco-nav--desktop" aria-label="Điều hướng chính">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'reco-nav__list',
					'fallback_cb'    => 'reco_menu_fallback',
					'depth'          => 1,
				)
			);
			?>
		</nav>

		<a class="reco-header__cta" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Nhận tư vấn</a>
		<button class="reco-menu-toggle" type="button" aria-controls="reco-mobile-menu" aria-expanded="false" data-menu-toggle>
			<span class="reco-menu-toggle__label">Menu</span>
			<svg viewBox="0 0 24 24" width="26" height="26" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
		</button>
	</div>
</header>

<div class="reco-mobile-menu" id="reco-mobile-menu" aria-hidden="true" data-mobile-menu>
	<button class="reco-mobile-menu__backdrop" type="button" aria-label="Đóng menu" data-menu-close></button>
	<div class="reco-mobile-menu__panel" role="dialog" aria-modal="true" aria-label="Điều hướng di động">
		<div class="reco-mobile-menu__head">
			<span>Điều hướng</span>
			<button type="button" aria-label="Đóng menu" data-menu-close>
				<svg viewBox="0 0 24 24" width="26" height="26" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
			</button>
		</div>
		<nav aria-label="Điều hướng di động">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'reco-mobile-menu__list',
					'fallback_cb'    => 'reco_menu_fallback',
					'depth'          => 1,
				)
			);
			?>
		</nav>
		<div class="reco-mobile-menu__contact">
			<span>Tư vấn trực tiếp</span>
			<a href="tel:0934524445">0934 524 445</a>
		</div>
	</div>
</div>

<main id="reco-main" class="reco-main">
