/**
 * ArcUnify theme behaviour. No dependencies, loaded with defer.
 *
 * - Header state on scroll (homepage overlay header)
 * - Desktop dropdowns / mega menu (disclosure pattern: click, hover, Esc)
 * - Mobile menu (focus managed, Esc closes)
 * - Tabs (WAI-ARIA tabs with arrow keys)
 * - Reveal for [data-reveal] elements
 * - Mobile sticky CTA
 * - Reduced motion: pauses SVG (SMIL) animation
 */
(function () {
	'use strict';

	var doc = document;
	var root = doc.documentElement;
	var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
	var desktopMQ = window.matchMedia('(min-width: 1024px)');
	var hoverMQ = window.matchMedia('(hover: hover) and (pointer: fine)');

	var header = doc.querySelector('[data-au-header]');

	/* Header scroll state ------------------------------------------------- */

	if (header) {
		var ticking = false;
		var updateHeader = function () {
			header.classList.toggle('is-scrolled', window.scrollY > 8);
			ticking = false;
		};
		window.addEventListener('scroll', function () {
			if (!ticking) {
				window.requestAnimationFrame(updateHeader);
				ticking = true;
			}
		}, { passive: true });
		updateHeader();
	}

	/* Desktop navigation -------------------------------------------------- */

	var desktopNav = header ? header.querySelector('.au-nav--desktop') : null;

	function setOpen(item, open) {
		var toggle = item.querySelector(':scope > .au-nav__toggle');
		item.classList.toggle('is-open', open);
		if (toggle) {
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		}
		if (header) {
			header.classList.toggle('has-open-sub', !!header.querySelector('.au-nav--desktop .is-open'));
		}
	}

	function closeAll(except) {
		if (!desktopNav) {
			return;
		}
		desktopNav.querySelectorAll('.has-sub.is-open').forEach(function (item) {
			if (item !== except) {
				setOpen(item, false);
			}
		});
	}

	if (desktopNav) {
		desktopNav.querySelectorAll('.au-nav__list > .has-sub').forEach(function (item) {
			var toggle = item.querySelector(':scope > .au-nav__toggle');
			var closeTimer;
			var openedByHover = false;

			if (toggle) {
				toggle.addEventListener('click', function () {
					// A click right after hover-open confirms it rather than closing it.
					var willOpen = openedByHover ? true : !item.classList.contains('is-open');
					openedByHover = false;
					closeAll(item);
					setOpen(item, willOpen);
				});
			}

			item.addEventListener('mouseenter', function () {
				if (!hoverMQ.matches) {
					return;
				}
				window.clearTimeout(closeTimer);
				if (!item.classList.contains('is-open')) {
					openedByHover = true;
				}
				closeAll(item);
				setOpen(item, true);
			});

			item.addEventListener('mouseleave', function () {
				if (!hoverMQ.matches) {
					return;
				}
				closeTimer = window.setTimeout(function () {
					openedByHover = false;
					setOpen(item, false);
				}, 180);
			});

			// Close when focus leaves the item entirely.
			item.addEventListener('focusout', function (e) {
				if (!item.contains(e.relatedTarget)) {
					setOpen(item, false);
				}
			});
		});

		doc.addEventListener('click', function (e) {
			if (!desktopNav.contains(e.target)) {
				closeAll();
			}
		});
	}

	doc.addEventListener('keydown', function (e) {
		if (e.key !== 'Escape') {
			return;
		}
		if (desktopNav) {
			var open = desktopNav.querySelector('.has-sub.is-open');
			if (open) {
				setOpen(open, false);
				var t = open.querySelector(':scope > .au-nav__toggle');
				if (t) {
					t.focus();
				}
			}
		}
		if (mobilePanel && !mobilePanel.hidden) {
			setMobile(false);
			menuToggle.focus();
		}
	});

	/* Mobile menu --------------------------------------------------------- */

	var menuToggle = header ? header.querySelector('[data-au-menu-toggle]') : null;
	var mobilePanel = header ? header.querySelector('[data-au-mobile]') : null;

	function setMobile(open) {
		if (!menuToggle || !mobilePanel) {
			return;
		}
		if (open) {
			var bar = header.querySelector('.au-header__bar');
			var bottom = bar ? Math.max(0, Math.round(bar.getBoundingClientRect().bottom)) : 0;
			mobilePanel.style.setProperty('--au-mobile-top', bottom + 'px');
		}
		mobilePanel.hidden = !open;
		menuToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		header.classList.toggle('is-menu-open', open);
		doc.body.classList.toggle('au-menu-open', open);
		if (open) {
			var first = mobilePanel.querySelector('a, button');
			if (first) {
				first.focus();
			}
		}
	}

	if (menuToggle && mobilePanel) {
		menuToggle.addEventListener('click', function () {
			setMobile(mobilePanel.hidden);
		});

		mobilePanel.querySelectorAll('.au-nav__toggle').forEach(function (toggle) {
			toggle.addEventListener('click', function () {
				var item = toggle.parentElement;
				var open = !item.classList.contains('is-open');
				item.classList.toggle('is-open', open);
				toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
			});
		});

		// Keep focus inside the open panel (toggle + panel form the dialog).
		mobilePanel.addEventListener('keydown', function (e) {
			if (e.key !== 'Tab') {
				return;
			}
			var focusables = Array.prototype.filter.call(
				mobilePanel.querySelectorAll('a[href], button:not([disabled])'),
				function (el) { return el.offsetParent !== null; }
			);
			if (!focusables.length) {
				return;
			}
			var last = focusables[focusables.length - 1];
			if (e.shiftKey && doc.activeElement === focusables[0]) {
				e.preventDefault();
				menuToggle.focus();
			} else if (!e.shiftKey && doc.activeElement === last) {
				e.preventDefault();
				menuToggle.focus();
			}
		});

		desktopMQ.addEventListener('change', function (e) {
			if (e.matches) {
				setMobile(false);
			}
		});
	}

	/* Tabs ---------------------------------------------------------------- */

	doc.querySelectorAll('[data-au-tabs]').forEach(function (wrap) {
		var tabs = Array.prototype.slice.call(wrap.querySelectorAll('[role="tab"]'));
		var panels = tabs.map(function (tab) {
			return doc.getElementById(tab.getAttribute('aria-controls'));
		});

		function select(index, focus) {
			tabs.forEach(function (tab, i) {
				var on = i === index;
				tab.setAttribute('aria-selected', on ? 'true' : 'false');
				tab.tabIndex = on ? 0 : -1;
				if (panels[i]) {
					panels[i].hidden = !on;
				}
			});
			if (focus) {
				tabs[index].focus();
				tabs[index].scrollIntoView({ block: 'nearest', inline: 'nearest' });
			}
		}

		tabs.forEach(function (tab, i) {
			tab.addEventListener('click', function () {
				select(i, false);
			});
			tab.addEventListener('keydown', function (e) {
				var next = null;
				if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
					next = (i + 1) % tabs.length;
				} else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
					next = (i - 1 + tabs.length) % tabs.length;
				} else if (e.key === 'Home') {
					next = 0;
				} else if (e.key === 'End') {
					next = tabs.length - 1;
				}
				if (next !== null) {
					e.preventDefault();
					select(next, true);
				}
			});
		});

		var initial = tabs.findIndex(function (t) { return t.getAttribute('aria-selected') === 'true'; });
		select(initial < 0 ? 0 : initial, false);
	});

	/* Reveal -------------------------------------------------------------- */

	var revealEls = doc.querySelectorAll('[data-reveal]');
	if (revealEls.length) {
		if (!('IntersectionObserver' in window) || reduceMotion.matches) {
			revealEls.forEach(function (el) { el.classList.add('is-in'); });
		} else {
			var io = new IntersectionObserver(function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						entry.target.classList.add('is-in');
						io.unobserve(entry.target);
					}
				});
			}, { rootMargin: '0px 0px -15% 0px' });
			revealEls.forEach(function (el) { io.observe(el); });
		}
	}

	/* Mobile sticky CTA --------------------------------------------------- */

	var mobileCta = doc.querySelector('[data-au-mobile-cta]');
	if (mobileCta) {
		var showAfter = function () {
			var hero = doc.querySelector('.au-hero, .au-page-hero, .au-elementor > .elementor > :first-child');
			return hero ? hero.getBoundingClientRect().height : window.innerHeight * 0.8;
		};
		var limit = showAfter();
		var nearFooter = function () {
			var footer = doc.querySelector('.au-footer');
			return footer ? footer.getBoundingClientRect().top < window.innerHeight : false;
		};
		var updateCta = function () {
			mobileCta.classList.toggle('is-visible', window.scrollY > limit && !nearFooter());
		};
		window.addEventListener('scroll', updateCta, { passive: true });
		window.addEventListener('resize', function () {
			limit = showAfter();
		}, { passive: true });
		updateCta();
	}

	/* Reduced motion: stop SVG animation ---------------------------------- */

	function applyMotionPreference() {
		doc.querySelectorAll('.au-arc__lines, svg.au-v').forEach(function (svg) {
			if (typeof svg.pauseAnimations !== 'function') {
				return;
			}
			if (reduceMotion.matches) {
				svg.pauseAnimations();
				svg.querySelectorAll('.au-arc__pulse, .au-v__packet').forEach(function (p) { p.style.display = 'none'; });
			} else {
				svg.unpauseAnimations();
			}
		});
	}
	applyMotionPreference();
	reduceMotion.addEventListener('change', applyMotionPreference);

	/* Contact form: inline validation before submit ----------------------- */

	doc.querySelectorAll('[data-au-form]').forEach(function (form) {
		var messages = {
			valueMissing: 'Please fill in this field.',
			typeMismatch: 'Please enter a valid email address.'
		};
		function check(field) {
			var err = doc.getElementById(field.id + '-error');
			var ok = field.checkValidity();
			field.setAttribute('aria-invalid', ok ? 'false' : 'true');
			if (err) {
				err.hidden = ok;
				err.textContent = ok ? '' : (field.validity.valueMissing ? messages.valueMissing : messages.typeMismatch);
				if (ok) {
					field.removeAttribute('aria-describedby');
				} else {
					field.setAttribute('aria-describedby', err.id);
				}
			}
			return ok;
		}
		form.querySelectorAll('input[required], textarea[required], input[type="email"]').forEach(function (field) {
			field.addEventListener('blur', function () {
				if (field.value !== '') {
					check(field);
				}
			});
		});
		form.addEventListener('submit', function (e) {
			var first = null;
			form.querySelectorAll('input[required], textarea[required], input[type="email"]').forEach(function (field) {
				if (!check(field) && !first) {
					first = field;
				}
			});
			if (first) {
				e.preventDefault();
				first.focus();
			}
		});
	});

	var notice = doc.querySelector('.au-form__notice--ok');
	if (notice) {
		notice.focus();
	}

	root.classList.add('au-ready');
})();
