(() => {
const toggle = document.querySelector('[data-menu-toggle]');
const nav = document.getElementById('site-navigation');
const mobileBreakpoint = window.matchMedia('(max-width: 900px)');
if (toggle && nav) {
toggle.addEventListener('click', () => {
const isOpen = nav.classList.toggle('is-open');
toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
});
document.addEventListener('click', (event) => {
if (!nav.contains(event.target) && !toggle.contains(event.target)) {
nav.classList.remove('is-open');
toggle.setAttribute('aria-expanded', 'false');
nav.querySelectorAll('.menu-item-has-children.is-open').forEach((item) => item.classList.remove('is-open'));
}
});
const navParentItems = nav.querySelectorAll('.menu-item-has-children');
navParentItems.forEach((item) => {
item.addEventListener('click', (event) => {
if (!mobileBreakpoint.matches) return;
const subMenu = item.querySelector(':scope > .sub-menu');
if (subMenu && subMenu.contains(event.target)) return;
event.preventDefault();
event.stopPropagation();
const isOpen = item.classList.toggle('is-open');
if (isOpen) {
navParentItems.forEach((sibling) => {
if (sibling !== item) sibling.classList.remove('is-open');
});
}
});
});
mobileBreakpoint.addEventListener('change', () => {
if (!mobileBreakpoint.matches) {
navParentItems.forEach((item) => item.classList.remove('is-open'));
}
});
}
const footerNavParents = document.querySelectorAll('.footer-nav .menu-item-has-children > a');
footerNavParents.forEach((link) => {
link.addEventListener('click', (event) => {
if (!mobileBreakpoint.matches) {
return;
}
const parent = link.parentElement;
if (!parent) {
return;
}
if (!parent.classList.contains('is-open')) {
event.preventDefault();
parent.classList.add('is-open');
} else {
event.preventDefault();
parent.classList.remove('is-open');
}
});
});
const categoryCarousels = document.querySelectorAll('[data-carousel]');
categoryCarousels.forEach((viewport) => {
const shell = viewport.closest('[data-carousel-shell]');
const track = viewport.querySelector('.category-carousel__track');
if (!shell || !track) {
return;
}
const prevButton = shell.querySelector('[data-carousel-prev]');
const nextButton = shell.querySelector('[data-carousel-next]');
const progressBar = shell.querySelector('[data-carousel-progress]');
const getStep = () => {
const card = track.querySelector('.category-carousel__item');
if (!card) {
return viewport.clientWidth * 0.86;
}
const style = window.getComputedStyle(track);
const gap = parseFloat(style.gap || style.columnGap || '14');
return card.getBoundingClientRect().width + (Number.isNaN(gap) ? 14 : gap);
};
const updateState = () => {
const maxScroll = Math.max(viewport.scrollWidth - viewport.clientWidth, 0);
const ratio = maxScroll > 0 ? viewport.scrollLeft / maxScroll : 0;
if (progressBar) {
progressBar.style.width = `${20 + ratio * 80}%`;
}
if (prevButton) {
prevButton.disabled = viewport.scrollLeft <= 2;
}
if (nextButton) {
nextButton.disabled = viewport.scrollLeft >= maxScroll - 2;
}
};
if (prevButton) {
prevButton.addEventListener('click', () => {
viewport.scrollBy({ left: -getStep(), behavior: 'smooth' });
});
}
if (nextButton) {
nextButton.addEventListener('click', () => {
viewport.scrollBy({ left: getStep(), behavior: 'smooth' });
});
}
viewport.addEventListener('scroll', updateState, { passive: true });
window.addEventListener('resize', updateState);
updateState();
});
const focusSections = document.querySelectorAll('[data-interactive-focus]');
focusSections.forEach((section) => {
const image = section.querySelector('[data-focus-image]');
const kicker = section.querySelector('[data-focus-kicker]');
const title = section.querySelector('[data-focus-title]');
const link = section.querySelector('[data-focus-link]');
const summaryTitle = section.querySelector('[data-focus-summary-title]');
const summaryText = section.querySelector('[data-focus-summary-text]');
const triggers = section.querySelectorAll('[data-focus-trigger]');
if (!image || !kicker || !title || !link || !summaryTitle || !summaryText || !triggers.length) {
return;
}
const applyState = (trigger) => {
const triggerImage = trigger.getAttribute('data-image') || '';
const triggerKicker = trigger.getAttribute('data-kicker') || '';
const triggerTitle = trigger.getAttribute('data-title') || '';
const triggerLink = trigger.getAttribute('data-link') || '#';
const triggerLinkLabel = trigger.getAttribute('data-link-label') || '';
const triggerSummary = trigger.getAttribute('data-summary') || '';
const triggerAlt = trigger.getAttribute('data-alt') || '';
image.setAttribute('src', triggerImage);
image.setAttribute('alt', triggerAlt);
kicker.textContent = triggerKicker;
title.textContent = triggerTitle;
link.setAttribute('href', triggerLink);
link.textContent = triggerLinkLabel;
summaryTitle.textContent = triggerKicker;
summaryText.textContent = triggerSummary;
};
triggers.forEach((trigger) => {
trigger.addEventListener('mouseenter', () => applyState(trigger));
trigger.addEventListener('focus', () => applyState(trigger));
trigger.addEventListener('click', () => {
triggers.forEach((item) => {
item.classList.remove('is-active');
item.setAttribute('aria-selected', 'false');
});
trigger.classList.add('is-active');
trigger.setAttribute('aria-selected', 'true');
applyState(trigger);
});
});
const activeTrigger = section.querySelector('[data-focus-trigger].is-active') || triggers[0];
if (activeTrigger) {
applyState(activeTrigger);
}
});
const productGalleries = document.querySelectorAll('[data-product-gallery]');
productGalleries.forEach((gallery) => {
const thumbs = gallery.querySelectorAll('[data-gallery-thumb]');
const imageStack = gallery.querySelector('[data-product-image-stack]');
const images = gallery.querySelectorAll('[data-gallery-image]');
if (!thumbs.length || !imageStack || !images.length) {
return;
}
const setActiveThumb = (targetId) => {
thumbs.forEach((thumb) => {
const href = thumb.getAttribute('href') || '';
const isMatch = href === `#${targetId}`;
thumb.classList.toggle('is-active', isMatch);
});
};
thumbs.forEach((thumb) => {
thumb.addEventListener('click', (event) => {
const targetSelector = thumb.getAttribute('href') || '';
if (!targetSelector.startsWith('#')) {
return;
}
const target = imageStack.querySelector(targetSelector);
if (!target) {
return;
}
event.preventDefault();
target.scrollIntoView({ behavior: 'smooth', block: 'start' });
setActiveThumb(target.id);
});
});
if ('IntersectionObserver' in window) {
const observer = new IntersectionObserver(
(entries) => {
entries.forEach((entry) => {
if (entry.isIntersecting) {
setActiveThumb(entry.target.id);
}
});
},
{
root: imageStack,
threshold: 0.58
}
);
images.forEach((image) => observer.observe(image));
}
const videoFigures = gallery.querySelectorAll('[data-is-video]');
videoFigures.forEach((figure) => {
const video = figure.querySelector('video');
if (!video) {
return;
}
const overlay = document.createElement('div');
overlay.className = 'sly-video-play-overlay';
overlay.innerHTML = '<svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>';
figure.appendChild(overlay);
figure.addEventListener('click', () => {
if (video.paused) {
video.play();
figure.classList.remove('is-paused');
} else {
video.pause();
figure.classList.add('is-paused');
}
});
});
});
const cardVideos = document.querySelectorAll('[data-card-video]');
if (cardVideos.length) {
const isMobile = window.matchMedia('(max-width: 900px)');
const loadVideo = (video) => {
if (video.dataset.loaded) {
return;
}
video.querySelectorAll('source[data-src]').forEach((source) => {
source.src = source.dataset.src;
source.removeAttribute('data-src');
});
video.load();
video.dataset.loaded = '1';
};
cardVideos.forEach((video) => {
const card = video.closest('.sly-shop-card');
if (!card) {
return;
}
card.addEventListener('mouseenter', () => {
if (isMobile.matches) {
return;
}
loadVideo(video);
video.play().catch(() => {});
});
card.addEventListener('mouseleave', () => {
if (isMobile.matches) {
return;
}
video.pause();
video.currentTime = 0;
});
});
if ('IntersectionObserver' in window) {
const cardVideoObserver = new IntersectionObserver(
(entries) => {
entries.forEach((entry) => {
const video = entry.target;
if (entry.isIntersecting && isMobile.matches) {
loadVideo(video);
video.play().then(() => {
video.classList.add('is-playing');
}).catch(() => {});
} else {
video.pause();
video.classList.remove('is-playing');
}
});
},
{ threshold: 0.5 }
);
cardVideos.forEach((video) => cardVideoObserver.observe(video));
}
}
const revealNodes = document.querySelectorAll('[data-reveal]');
if (!revealNodes.length) {
return;
}
if (!('IntersectionObserver' in window)) {
revealNodes.forEach((node) => node.classList.add('is-visible'));
return;
}
const observer = new IntersectionObserver(
(entries) => {
entries.forEach((entry) => {
if (entry.isIntersecting) {
entry.target.classList.add('is-visible');
observer.unobserve(entry.target);
}
});
},
{ rootMargin: '0px 0px -8% 0px', threshold: 0.15 }
);
revealNodes.forEach((node, index) => {
node.style.transitionDelay = `${Math.min(index * 40, 240)}ms`;
observer.observe(node);
});
const stickyBar = document.querySelector('[data-sticky-atc]');
const atcZone = document.querySelector('[data-atc-zone]');
if (stickyBar && atcZone) {
const stickyObserver = new IntersectionObserver(
(entries) => {
entries.forEach((entry) => {
const isHidden = entry.isIntersecting;
stickyBar.classList.toggle('is-visible', !isHidden);
stickyBar.setAttribute('aria-hidden', isHidden ? 'true' : 'false');
});
},
{ threshold: 0 }
);
stickyObserver.observe(atcZone);
}
const updateCartCount = (count) => {
document.querySelectorAll('.header-cart span').forEach((el) => {
el.textContent = count;
});
};
const ajaxAddToCart = (productId, quantity, button) => {
if (!window.slyAjax || !productId) {
return;
}
const originalText = button.textContent;
button.disabled = true;
button.textContent = button.getAttribute('data-adding-text') || 'Adding...';
const body = new FormData();
body.append('action', 'sly_add_to_cart');
body.append('nonce', window.slyAjax.nonce);
body.append('product_id', productId);
body.append('quantity', quantity || 1);
fetch(window.slyAjax.url, { method: 'POST', body, credentials: 'same-origin' })
.then((res) => res.json())
.then((json) => {
if (json.success) {
updateCartCount(json.data.count);
button.textContent = json.data.message;
button.classList.add('sly-button--success');
setTimeout(() => {
button.textContent = originalText;
button.classList.remove('sly-button--success');
button.disabled = false;
}, 1800);
} else {
button.textContent = (json.data && json.data.message) || 'Error';
setTimeout(() => {
button.textContent = originalText;
button.disabled = false;
}, 2000);
}
})
.catch(() => {
button.textContent = originalText;
button.disabled = false;
});
};
const stickyAtcBtn = document.querySelector('[data-sticky-atc-btn]');
if (stickyAtcBtn) {
stickyAtcBtn.addEventListener('click', () => {
ajaxAddToCart(stickyAtcBtn.getAttribute('data-product-id'), 1, stickyAtcBtn);
});
}
const mainAtcForm = document.querySelector('[data-atc-zone] form.cart:not(.variations_form)');
if (mainAtcForm && window.slyAjax) {
const mainSubmit = mainAtcForm.querySelector('.single_add_to_cart_button');
if (mainSubmit) {
mainAtcForm.addEventListener('submit', (e) => {
if (document.activeElement && document.activeElement.name === 'sly_buy_now') {
return;
}
e.preventDefault();
const qtyInput = mainAtcForm.querySelector('.qty');
const qty = qtyInput ? parseInt(qtyInput.value, 10) || 1 : 1;
const productInput = mainAtcForm.querySelector('[name="add-to-cart"]');
const productId = productInput ? productInput.value : '';
ajaxAddToCart(productId, qty, mainSubmit);
});
}
}
const sizeGuideLinks = document.querySelectorAll('[data-size-guide]');
sizeGuideLinks.forEach((link) => {
link.addEventListener('click', (e) => {
e.preventDefault();
const event = new CustomEvent('sly:size-guide', { bubbles: true });
document.dispatchEvent(event);
});
});
})();