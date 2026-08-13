(function () {
	'use strict';
	document.documentElement.classList.add('reco-js');

	const ready = (callback) => {
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', callback, { once: true });
		} else {
			callback();
		}
	};

	ready(() => {
		const body = document.body;
		const header = document.querySelector('[data-reco-header]');
		const menu = document.querySelector('[data-mobile-menu]');
		const toggle = document.querySelector('[data-menu-toggle]');
		const closeButtons = document.querySelectorAll('[data-menu-close]');
		let lastFocused = null;

		const focusableSelector = 'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';

		const closeMenu = () => {
			if (!menu || !toggle) return;
			menu.classList.remove('is-open');
			menu.setAttribute('aria-hidden', 'true');
			toggle.setAttribute('aria-expanded', 'false');
			body.classList.remove('reco-menu-open');
			if (lastFocused) lastFocused.focus();
		};

		const openMenu = () => {
			if (!menu || !toggle) return;
			lastFocused = document.activeElement;
			menu.classList.add('is-open');
			menu.setAttribute('aria-hidden', 'false');
			toggle.setAttribute('aria-expanded', 'true');
			body.classList.add('reco-menu-open');
			const firstFocusable = menu.querySelector(focusableSelector);
			if (firstFocusable) window.setTimeout(() => firstFocusable.focus(), 40);
		};

		if (toggle && menu) {
			toggle.addEventListener('click', () => {
				if (menu.classList.contains('is-open')) closeMenu();
				else openMenu();
			});

			closeButtons.forEach((button) => button.addEventListener('click', closeMenu));
			menu.querySelectorAll('a').forEach((link) => link.addEventListener('click', closeMenu));

			document.addEventListener('keydown', (event) => {
				if (!menu.classList.contains('is-open')) return;
				if (event.key === 'Escape') {
					closeMenu();
					return;
				}
				if (event.key !== 'Tab') return;

				const focusable = Array.from(menu.querySelectorAll(focusableSelector)).filter((element) => element.offsetParent !== null);
				if (!focusable.length) return;
				const first = focusable[0];
				const last = focusable[focusable.length - 1];
				if (event.shiftKey && document.activeElement === first) {
					event.preventDefault();
					last.focus();
				} else if (!event.shiftKey && document.activeElement === last) {
					event.preventDefault();
					first.focus();
				}
			});
		}

		if (header) {
			const updateHeader = () => header.classList.toggle('is-scrolled', window.scrollY > 24);
			updateHeader();
			window.addEventListener('scroll', updateHeader, { passive: true });
		}

		const revealItems = document.querySelectorAll('[data-reveal]');
		const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
		if (reducedMotion || !('IntersectionObserver' in window)) {
			revealItems.forEach((item) => item.classList.add('is-visible'));
		} else {
			const revealObserver = new IntersectionObserver((entries, observer) => {
				entries.forEach((entry) => {
					if (!entry.isIntersecting) return;
					entry.target.classList.add('is-visible');
					observer.unobserve(entry.target);
				});
			}, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
			revealItems.forEach((item) => revealObserver.observe(item));
		}

		const filterGroup = document.querySelector('[data-project-filter]');
		const projectCards = document.querySelectorAll('[data-project-card]');
		if (filterGroup && projectCards.length) {
			filterGroup.addEventListener('click', (event) => {
				const button = event.target.closest('[data-filter]');
				if (!button) return;
				const category = button.dataset.filter;
				filterGroup.querySelectorAll('[data-filter]').forEach((item) => {
					item.classList.toggle('is-active', item === button);
				});
				projectCards.forEach((card) => {
					const hidden = category !== 'all' && card.dataset.category !== category;
					card.classList.toggle('is-filtered-out', hidden);
					card.setAttribute('aria-hidden', hidden ? 'true' : 'false');
				});
			});
		}

		document.querySelectorAll('.reco-property-search').forEach((searchPanel) => {
			const transactions = Array.from(searchPanel.querySelectorAll('input[name="giao-dich"]'));
			const priceRange = searchPanel.querySelector('[data-price-range]');
			const priceLabel = searchPanel.querySelector('[data-price-label]');
			if (!transactions.length || !priceRange) return;

			let priceOptions = {};
			try {
				priceOptions = JSON.parse(priceRange.dataset.priceOptions || '{}');
			} catch (error) {
				priceOptions = {};
			}

			const updatePriceRanges = () => {
				const checked = transactions.find((input) => input.checked);
				const transaction = checked ? checked.value : 'mua';
				const context = transaction === 'cho-thue' ? 'thuê' : 'bán';
				const selectedValue = priceRange.value;
				const choices = priceOptions[transaction] || {};

				priceRange.replaceChildren(new Option(`Tất cả giá ${context}`, ''));
				Object.entries(choices).forEach(([value, label]) => {
					priceRange.add(new Option(label, value));
				});
				priceRange.value = Object.prototype.hasOwnProperty.call(choices, selectedValue) ? selectedValue : '';
				if (priceLabel) priceLabel.textContent = `Khoảng giá ${context}`;
			};

			transactions.forEach((input) => input.addEventListener('change', updatePriceRanges));
			updatePriceRanges();
		});

		const contactForm = document.querySelector('[data-contact-form]');
		if (contactForm) {
			const params = new URLSearchParams(window.location.search);
			const topic = contactForm.querySelector('[name="topic"]');
			const message = contactForm.querySelector('[name="message"]');
			if (params.get('nhu-cau') === 'tuyen-dung' && topic) {
				topic.value = 'Cơ hội nghề nghiệp';
				if (params.get('vi-tri') && message) message.value = `Tôi quan tâm vị trí ${params.get('vi-tri')}.`;
			} else if (params.get('du-an') && topic) {
				topic.value = 'Đầu tư bất động sản';
			}

			contactForm.addEventListener('submit', () => {
				const button = contactForm.querySelector('button[type="submit"]');
				if (!button) return;
				button.disabled = true;
				button.setAttribute('aria-busy', 'true');
				button.textContent = 'Đang gửi thông tin…';
			});
		}

		document.querySelectorAll('[data-project-tabs]').forEach((tabGroup) => {
			const tabs = Array.from(tabGroup.querySelectorAll('[data-project-tab]'));
			const panels = Array.from(tabGroup.querySelectorAll('[data-project-panel]'));
			if (!tabs.length || !panels.length) return;

			const activateTab = (tab, moveFocus = false) => {
				const panelId = tab.getAttribute('aria-controls');
				tabs.forEach((item) => {
					const active = item === tab;
					item.setAttribute('aria-selected', active ? 'true' : 'false');
					item.tabIndex = active ? 0 : -1;
				});
				panels.forEach((panel) => {
					panel.hidden = panel.id !== panelId;
				});
				if (moveFocus) tab.focus();
			};

			tabs.forEach((tab, index) => {
				tab.addEventListener('click', () => activateTab(tab));
				tab.addEventListener('keydown', (event) => {
					if (!['ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(event.key)) return;
					event.preventDefault();
					let nextIndex = index;
					if (event.key === 'ArrowLeft') nextIndex = (index - 1 + tabs.length) % tabs.length;
					if (event.key === 'ArrowRight') nextIndex = (index + 1) % tabs.length;
					if (event.key === 'Home') nextIndex = 0;
					if (event.key === 'End') nextIndex = tabs.length - 1;
					activateTab(tabs[nextIndex], true);
				});
			});

			activateTab(tabs.find((tab) => tab.getAttribute('aria-selected') === 'true') || tabs[0]);
		});

		document.querySelectorAll('[data-project-slider]').forEach((slider) => {
			const slides = Array.from(slider.querySelectorAll('[data-project-slide]'));
			const previous = slider.querySelector('[data-project-prev]');
			const next = slider.querySelector('[data-project-next]');
			let activeIndex = 0;
			let pointerStart = null;

			if (!slides.length) return;

			const showSlide = (requestedIndex) => {
				activeIndex = (requestedIndex + slides.length) % slides.length;
				const previousIndex = (activeIndex - 1 + slides.length) % slides.length;
				const nextIndex = (activeIndex + 1) % slides.length;
				slides.forEach((slide, index) => {
					const active = index === activeIndex;
					slide.classList.toggle('is-active', active);
					slide.classList.toggle('is-prev', slides.length > 1 && index === previousIndex && !active);
					slide.classList.toggle('is-next', slides.length > 2 && index === nextIndex && !active);
					slide.setAttribute('aria-hidden', active ? 'false' : 'true');
				});
			};

			if (slides.length < 2) {
				if (previous) previous.hidden = true;
				if (next) next.hidden = true;
			}

			if (previous) previous.addEventListener('click', () => showSlide(activeIndex - 1));
			if (next) next.addEventListener('click', () => showSlide(activeIndex + 1));
			slides.forEach((slide) => slide.addEventListener('click', () => {
				if (slide.classList.contains('is-prev')) showSlide(activeIndex - 1);
				if (slide.classList.contains('is-next')) showSlide(activeIndex + 1);
			}));

			slider.addEventListener('keydown', (event) => {
				if (event.key === 'ArrowLeft') showSlide(activeIndex - 1);
				if (event.key === 'ArrowRight') showSlide(activeIndex + 1);
			});
			slider.addEventListener('pointerdown', (event) => {
				pointerStart = event.clientX;
			});
			slider.addEventListener('pointerup', (event) => {
				if (pointerStart === null) return;
				const distance = event.clientX - pointerStart;
				pointerStart = null;
				if (Math.abs(distance) < 45) return;
				showSlide(activeIndex + (distance < 0 ? 1 : -1));
			});

			showSlide(0);
		});
	});
})();
