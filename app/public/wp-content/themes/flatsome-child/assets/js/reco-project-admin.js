(function ($) {
	'use strict';

	const transactionSelector = '[data-key="field_reco_project_transaction"] select';
	const priceFieldSelector = '[data-key="field_reco_project_price"]';

	const updatePriceField = () => {
		const transaction = $(transactionSelector).val() || 'mua';
		const priceField = $(priceFieldSelector);
		if (!priceField.length) return;

		const isRental = transaction === 'cho-thue';
		priceField.find('.acf-label > label').first().text(isRental ? 'Giá thuê' : 'Giá bán');
		priceField.find('.acf-label .description').first().text(
			isRental
				? 'Nhập giá thuê thực tế theo đơn vị triệu đồng/tháng. Để trống nếu giá là Liên hệ.'
				: 'Nhập giá bán thực tế theo đơn vị tỷ đồng. Để trống nếu giá là Liên hệ.'
		);
		priceField.find('.acf-input-append').text(isRental ? 'triệu/tháng' : 'tỷ đồng');
		priceField.find('input[type="number"]')
			.attr('placeholder', isRental ? 'Ví dụ: 15' : 'Ví dụ: 3.5')
			.attr('step', isRental ? '0.1' : '0.01');
	};

	$(document).on('change', transactionSelector, () => {
		$(priceFieldSelector).find('input[type="number"]').val('').trigger('change');
		updatePriceField();
	});
	$(updatePriceField);

	if (window.acf) {
		window.acf.addAction('ready append', updatePriceField);
	}
})(jQuery);
