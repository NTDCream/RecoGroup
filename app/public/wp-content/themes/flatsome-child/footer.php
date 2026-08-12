</main>

<section class="reco-footer-cta" aria-labelledby="footer-cta-title">
	<div class="reco-container reco-footer-cta__inner">
		<div>
			<span class="reco-eyebrow reco-eyebrow--light">Bắt đầu từ một cuộc trò chuyện</span>
			<h2 id="footer-cta-title">Cùng RECO kiến tạo<br>giá trị bất động sản bền vững.</h2>
		</div>
		<a class="reco-button reco-button--white" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Đặt lịch tư vấn <span aria-hidden="true">→</span></a>
	</div>
</section>

<footer class="reco-footer">
	<div class="reco-container reco-footer__grid">
		<div class="reco-footer__brand">
			<a class="reco-footer__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<img src="<?php echo esc_url( reco_asset( 'images/logo.png' ) ); ?>" width="241" height="113" alt="Nhà Ở Ngay RECO">
			</a>
			<p>Giải pháp môi giới, phân phối và quản lý bất động sản minh bạch, toàn diện cho nhu cầu an cư và đầu tư.</p>
		</div>
		<div>
			<h3>Khám phá</h3>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'reco-footer__nav',
					'fallback_cb'    => 'reco_menu_fallback',
					'depth'          => 1,
				)
			);
			?>
		</div>
		<div class="reco-footer__contact">
			<h3>Kết nối với chúng tôi</h3>
			<a class="reco-footer__phone" href="tel:0934524445">0934 524 445</a>
			<p>Số 19–21 phố Vũ Trọng Phụng, phường Thanh Xuân Trung, quận Thanh Xuân, TP. Hà Nội.</p>
			<a href="<?php echo esc_url( home_url( '/lien-he/#form-lien-he' ) ); ?>">Gửi yêu cầu trực tuyến</a>
		</div>
	</div>
	<div class="reco-container reco-footer__bottom">
		<span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> Công ty Cổ phần Nhà Ở Ngay RECO.</span>
		<span>Minh bạch · Chuyên nghiệp · Nhân văn</span>
	</div>
</footer>

<div class="reco-float-actions" aria-label="Liên hệ nhanh">
	<a class="reco-float-actions__phone" href="tel:0934524445" aria-label="Gọi 0934 524 445">
		<svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true"><path d="M7.3 3.2l2.2 4.1-1.8 1.8a14.4 14.4 0 007.2 7.2l1.8-1.8 4.1 2.2-.7 3.2c-.2.8-.9 1.4-1.7 1.4C9.8 21.3 2.7 14.2 2.7 5.6c0-.8.6-1.5 1.4-1.7l3.2-.7z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg>
		<span>Gọi tư vấn</span>
	</a>
	<a class="reco-float-actions__zalo" href="https://zalo.me/0934524445" target="_blank" rel="noopener" aria-label="Liên hệ qua Zalo"><span>Zalo</span></a>
</div>

<nav class="reco-mobile-dock" aria-label="Liên hệ nhanh trên di động">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<svg viewBox="0 0 24 24" width="21" height="21" aria-hidden="true"><path d="M3 11.2L12 4l9 7.2v8.3a.5.5 0 01-.5.5H15v-6H9v6H3.5a.5.5 0 01-.5-.5v-8.3z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg>
		<span>Trang chủ</span>
	</a>
	<a href="<?php echo esc_url( home_url( '/he-thong-san-pham/' ) ); ?>">
		<svg viewBox="0 0 24 24" width="21" height="21" aria-hidden="true"><path d="M4 20h16M6 20V9l6-4 6 4v11M9 12h2v2H9zm4 0h2v2h-2zM9 16h2v4H9zm4 0h2v4h-2z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
		<span>Sản phẩm</span>
	</a>
	<a class="reco-mobile-dock__call" href="tel:0934524445">
		<svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true"><path d="M7.3 3.2l2.2 4.1-1.8 1.8a14.4 14.4 0 007.2 7.2l1.8-1.8 4.1 2.2-.7 3.2c-.2.8-.9 1.4-1.7 1.4C9.8 21.3 2.7 14.2 2.7 5.6c0-.8.6-1.5 1.4-1.7l3.2-.7z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg>
		<span>Gọi ngay</span>
	</a>
	<a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">
		<svg viewBox="0 0 24 24" width="21" height="21" aria-hidden="true"><path d="M4 5h16v12H8l-4 3V5zm3 4h10M7 13h7" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
		<span>Liên hệ</span>
	</a>
</nav>

<?php wp_footer(); ?>
</body>
</html>
