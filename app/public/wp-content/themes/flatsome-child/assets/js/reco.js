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
		let revealObserver = null;
		if (reducedMotion || !('IntersectionObserver' in window)) {
			revealItems.forEach((item) => item.classList.add('is-visible'));
		} else {
			revealObserver = new IntersectionObserver((entries, observer) => {
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

		const loadMoreBtn = document.getElementById('reco-news-loadmore-btn');
		const newsListContainer = document.getElementById('reco-news-list-container');
		if (loadMoreBtn && newsListContainer && typeof recoAjax !== 'undefined') {
			loadMoreBtn.addEventListener('click', () => {
				let page = parseInt(loadMoreBtn.dataset.page || 1, 10);
				page++;
				const originalText = loadMoreBtn.innerHTML;
				loadMoreBtn.textContent = 'Đang tải...';
				loadMoreBtn.disabled = true;

				const formData = new FormData();
				formData.append('action', 'reco_load_more_news');
				formData.append('nonce', recoAjax.nonce);
				formData.append('page', page);
				formData.append('category', loadMoreBtn.dataset.category || '');

				fetch(recoAjax.ajaxurl, {
					method: 'POST',
					body: formData
				})
				.then(response => response.json())
				.then(result => {
					if (result.success) {
						loadMoreBtn.dataset.page = page;
						newsListContainer.insertAdjacentHTML('beforeend', result.data.html);
						if (!result.data.has_more) {
							loadMoreBtn.parentElement.remove();
						} else {
							loadMoreBtn.innerHTML = originalText;
							loadMoreBtn.disabled = false;
						}
						const newReveals = newsListContainer.querySelectorAll('.reco-news-list-item:not(.is-visible)');
						if (revealObserver && newReveals.length) {
							newReveals.forEach(item => revealObserver.observe(item));
						} else {
							newReveals.forEach(item => item.classList.add('is-visible'));
						}
					} else {
						loadMoreBtn.innerHTML = originalText;
						loadMoreBtn.disabled = false;
					}
				})
				.catch(err => {
					loadMoreBtn.innerHTML = originalText;
					loadMoreBtn.disabled = false;
				});
			});
		}
	});
})();

(function() {
	document.addEventListener('DOMContentLoaded', function() {
		const dropdowns = document.querySelectorAll('.reco-sale-search__dropdown');
		dropdowns.forEach(function(dropdown) {
			const selectEl = dropdown.querySelector('select');
			if (!selectEl) return;
			
			// ?n select g?c
			selectEl.style.display = 'none';
			
			// T?o wrapper (display)
			const displayBox = document.createElement('div');
			displayBox.className = 'reco-custom-select-display';
			
			const selectedOpt = selectEl.options[selectEl.selectedIndex];
			displayBox.textContent = selectedOpt ? selectedOpt.textContent : selectEl.options[0].textContent;
			
			// Th�m mui t�n
			const arrow = document.createElement('span');
			arrow.className = 'reco-custom-select-arrow';
			dropdown.appendChild(arrow);
			
			dropdown.appendChild(displayBox);
			
			// T?o danh s�ch
			const optionsList = document.createElement('div');
			optionsList.className = 'reco-custom-select-options';
			
			for (let i = 0; i < selectEl.options.length; i++) {
				const opt = selectEl.options[i];
				const item = document.createElement('div');
				item.textContent = opt.textContent;
				item.dataset.value = opt.value;
				if (i === selectEl.selectedIndex) {
					item.classList.add('selected');
				}
				
				item.addEventListener('click', function(e) {
					e.stopPropagation();
					selectEl.value = this.dataset.value;
					
					// Trigger native change event
					const evt = new Event('change');
					selectEl.dispatchEvent(evt);
					
					displayBox.textContent = this.textContent;
					
					const siblings = optionsList.children;
					for (let j = 0; j < siblings.length; j++) {
						siblings[j].classList.remove('selected');
					}
					this.classList.add('selected');
					
					optionsList.classList.remove('show');
					dropdown.classList.remove('active');
				});
				optionsList.appendChild(item);
			}
			
			dropdown.appendChild(optionsList);
			
			// Event m? danh s�ch
			dropdown.addEventListener('click', function(e) {
				e.stopPropagation();
				
				// ��ng c�c select kh�c
				document.querySelectorAll('.reco-custom-select-options.show').forEach(function(list) {
					if (list !== optionsList) {
						list.classList.remove('show');
						list.parentElement.classList.remove('active');
					}
				});
				
				optionsList.classList.toggle('show');
				dropdown.classList.toggle('active');
			});
		});
		
		// ��ng khi click ngo�i
		document.addEventListener('click', function() {
			document.querySelectorAll('.reco-custom-select-options.show').forEach(function(list) {
				list.classList.remove('show');
				list.parentElement.classList.remove('active');
			});
		});
	});
})();

(function() {
    document.addEventListener('DOMContentLoaded', function() {
        const searchForm = document.querySelector('.reco-sale-search-bar');
        const resultsContainer = document.getElementById('reco-sale-results-container');
        
        if (!searchForm || !resultsContainer || typeof recoAjax === 'undefined') return;

        const performSearch = (url, isPushState = true) => {
            resultsContainer.classList.add('is-loading');
            
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    resultsContainer.innerHTML = result.data.html;
                    if (isPushState) {
                        window.history.pushState({ path: url }, '', url);
                    }
                }
            })
            .catch(err => console.error(err))
            .finally(() => {
                resultsContainer.classList.remove('is-loading');
                const offset = resultsContainer.getBoundingClientRect().top + window.scrollY - 100;
                if (window.scrollY > offset) {
                    window.scrollTo({ top: offset, behavior: 'smooth' });
                }
            });
        };

        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(searchForm);
            
            const sortSelect = document.getElementById('reco-sale-sort');
            if (sortSelect) {
                formData.append('sap-xep', sortSelect.value);
            }

            const params = new URLSearchParams(formData);
            params.append('action', 'reco_sale_search');
            const targetUrl = recoAjax.ajaxurl + '?' + params.toString();
            
            const cleanParams = new URLSearchParams(formData);
            for (const [key, value] of Array.from(cleanParams.entries())) {
                if (!value) {
                    cleanParams.delete(key);
                }
            }
            const queryString = cleanParams.toString();
            const cleanUrl = searchForm.action + (queryString ? '?' + queryString : '');
            
            performSearch(targetUrl, false);
            window.history.pushState({ path: cleanUrl }, '', cleanUrl);
        });

        const selects = searchForm.querySelectorAll('select');
        selects.forEach(select => {
            select.addEventListener('change', () => {
                searchForm.dispatchEvent(new Event('submit'));
            });
        });

        document.addEventListener('change', function(e) {
            if (e.target && e.target.id === 'reco-sale-sort') {
                searchForm.dispatchEvent(new Event('submit'));
            }
        });

        resultsContainer.addEventListener('click', function(e) {
            const pageLink = e.target.closest('.pagination a');
            if (pageLink) {
                e.preventDefault();
                const url = pageLink.href;
                
                const urlObj = new URL(url);
                const params = new URLSearchParams(urlObj.search);
                
                const pathMatches = urlObj.pathname.match(/\/page\/(\d+)/);
                if (pathMatches && pathMatches[1]) {
                    params.set('paged', pathMatches[1]);
                }
                
                const sortSelect = document.getElementById('reco-sale-sort');
                if (sortSelect && !params.has('sap-xep')) {
                    params.set('sap-xep', sortSelect.value);
                }
                
                params.append('action', 'reco_sale_search');
                const ajaxUrl = recoAjax.ajaxurl + '?' + params.toString();
                
                performSearch(ajaxUrl, false);
                window.history.pushState({ path: url }, '', url);
            }
        });

        window.addEventListener('popstate', function(e) {
            if (e.state && e.state.path) {
                const urlObj = new URL(e.state.path, window.location.origin);
                const params = new URLSearchParams(urlObj.search);
                
                const pathMatches = urlObj.pathname.match(/\/page\/(\d+)/);
                if (pathMatches && pathMatches[1]) {
                    params.set('paged', pathMatches[1]);
                }
                
                params.append('action', 'reco_sale_search');
                const ajaxUrl = recoAjax.ajaxurl + '?' + params.toString();
                
                performSearch(ajaxUrl, false);
            } else {
                window.location.reload();
            }
        });
    });
})();

// Project Archive AJAX logic
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        const resultsContainer = document.getElementById('reco-project-results-container');
        const sortSelect = document.getElementById('reco-project-sort');
        const taxInput = document.getElementById('reco-project-tax');
        const termInput = document.getElementById('reco-project-term');
        
        if (!resultsContainer || typeof recoAjax === 'undefined') return;

        const performProjectSearch = (url, isPushState = true) => {
            resultsContainer.classList.add('is-loading');
            
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    resultsContainer.innerHTML = result.data.html;
                    if (isPushState) {
                        window.history.pushState({ path: url }, '', url);
                    }
                }
            })
            .catch(err => console.error(err))
            .finally(() => {
                resultsContainer.classList.remove('is-loading');
                const offset = resultsContainer.getBoundingClientRect().top + window.scrollY - 100;
                if (window.scrollY > offset) {
                    window.scrollTo({ top: offset, behavior: 'smooth' });
                }
            });
        };

        const triggerSearch = (e, targetUrl = null) => {
            if (e && e.preventDefault) e.preventDefault();
            
            let params = new URLSearchParams();
            
            if (sortSelect) {
                params.append('sap-xep', sortSelect.value);
            }
            if (taxInput && taxInput.value) {
                params.append('tax', taxInput.value);
            }
            if (termInput && termInput.value) {
                params.append('term', termInput.value);
            }
            
            if (targetUrl) {
                const urlObj = new URL(targetUrl);
                urlObj.searchParams.forEach((val, key) => {
                    params.set(key, val);
                });
                
                const pathMatches = urlObj.pathname.match(/\/page\/(\d+)/);
                if (pathMatches && pathMatches[1]) {
                    params.set('paged', pathMatches[1]);
                }
            }

            params.append('action', 'reco_project_search');
            const ajaxUrl = recoAjax.ajaxurl + '?' + params.toString();
            
            let cleanUrl = window.location.pathname;
            const cleanParams = new URLSearchParams();
            if (sortSelect && sortSelect.value && sortSelect.value !== 'moi-nhat') {
                cleanParams.append('sap-xep', sortSelect.value);
            }
            
            if (targetUrl) {
                const urlObj = new URL(targetUrl);
                cleanUrl = urlObj.pathname;
                cleanParams.delete('action');
                cleanParams.delete('tax');
                cleanParams.delete('term');
            }
            
            const queryString = cleanParams.toString();
            cleanUrl = cleanUrl + (queryString ? '?' + queryString : '');

            performProjectSearch(ajaxUrl, false);
            window.history.pushState({ path: cleanUrl }, '', cleanUrl);
        };

        if (sortSelect) {
            sortSelect.addEventListener('change', triggerSearch);
        }

        resultsContainer.addEventListener('click', function(e) {
            const paginationLink = e.target.closest('.pagination a');
            if (paginationLink) {
                e.preventDefault();
                triggerSearch(null, paginationLink.href);
            }
        });
        
        window.addEventListener('popstate', function(e) {
            if (e.state && e.state.path) {
                const urlObj = new URL(e.state.path, window.location.origin);
                let params = new URLSearchParams(urlObj.search);
                if (taxInput && taxInput.value) params.append('tax', taxInput.value);
                if (termInput && termInput.value) params.append('term', termInput.value);
                const pathMatches = urlObj.pathname.match(/\/page\/(\d+)/);
                if (pathMatches && pathMatches[1]) params.set('paged', pathMatches[1]);
                params.append('action', 'reco_project_search');
                const ajaxUrl = recoAjax.ajaxurl + '?' + params.toString();
                performProjectSearch(ajaxUrl, false);
            } else {
                window.location.reload();
            }
        });
    });
})();

