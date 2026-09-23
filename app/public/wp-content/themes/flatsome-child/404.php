<?php
/**
 * The template for displaying 404 pages (not found).
 */
get_header(); ?>

<main id="main" class="site-main">
	<div class="reco-404-container"
		style="min-height: 75vh; display: flex; align-items: center; justify-content: center; text-align: center; padding: 60px 20px; background-color: #f8f9fa;">
		<div class="reco-404-content"
			style="max-width: 700px; width: 100%; padding: 60px 50px; background: #ffffff; border-top: 4px solid #0a5597; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); position: relative; overflow: hidden;">

			<!-- Decorative Background Watermark -->
			<div
				style="position: absolute; top: -20px; right: -20px; font-size: 250px; font-weight: 900; color: rgba(10, 85, 151, 0.03); line-height: 1; pointer-events: none; z-index: 0; user-select: none;">
				404</div>

			<!-- Large Decorated 404 -->
			<div class="reco-404-number-wrapper"
				style="position: relative; z-index: 1; margin-bottom: 30px; display: inline-block;">
				<h1 class="reco-404-title"
					style="font-size: 130px; font-weight: 900; margin: 0; line-height: 1; position: relative; letter-spacing: -2px;">
					<span style="color: #0a5597;">4</span><span
						style="background: linear-gradient(135deg, #0a5597 0%, #f5831f 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">0</span><span
						style="color: #f5831f;">4</span>
				</h1>
				<!-- Architectural decorative lines -->
				<div
					style="position: absolute; bottom: 15px; left: -20px; width: 40px; height: 3px; background: #f5831f;">
				</div>
				<div
					style="position: absolute; top: 15px; right: -20px; width: 40px; height: 3px; background: #0a5597;">
				</div>
			</div>

			<h2
				style="position: relative; z-index: 1; font-size: 32px; font-weight: 700; color: #222; margin: 0 0 20px; line-height: 1.3;">
				Không Tìm Thấy Nội Dung</h2>

			<div
				style="position: relative; z-index: 1; width: 60px; height: 3px; background: linear-gradient(90deg, #0a5597 0%, #f5831f 100%); margin: 0 auto 25px;">
			</div>

			<p
				style="position: relative; z-index: 1; font-size: 16px; color: #555; margin-bottom: 40px; line-height: 1.8; max-width: 550px; margin-left: auto; margin-right: auto;">
				Rất tiếc, trang Quý khách đang tìm kiếm không tồn tại, đã bị gỡ bỏ hoặc tạm thời không thể truy cập. Xin
				vui lòng quay lại trang trước để tiếp tục duyệt web.
			</p>

			<button onclick="history.back()" class="reco-404-btn"
				style="position: relative; z-index: 1; display: inline-flex; align-items: center; justify-content: center; background: #0a5597; color: #fff; border: 1px solid #0a5597; padding: 14px 32px; border-radius: 4px; font-size: 15px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer; transition: all 0.3s ease;">
				<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
					stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
					style="margin-right: 8px;">
					<path d="M19 12H5M12 19l-7-7 7-7" />
				</svg>
				Quay Lại
			</button>
		</div>
	</div>

	<style>
		/* Hover states */
		.reco-404-btn:hover {
			background: #f5831f !important;
			border-color: #f5831f !important;
			color: #fff !important;
			box-shadow: 0 4px 15px rgba(245, 131, 31, 0.2);
		}

		/* Responsiveness */
		@media (max-width: 768px) {
			.reco-404-content {
				padding: 40px 20px;
			}

			.reco-404-title {
				font-size: 100px !important;
			}

			.reco-404-content h2 {
				font-size: 26px !important;
			}

			.reco-404-btn {
				width: 100%;
			}
		}
	</style>
</main>

<?php get_footer(); ?>