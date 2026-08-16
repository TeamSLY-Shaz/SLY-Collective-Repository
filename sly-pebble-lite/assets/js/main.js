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
const dotsWrapper = gallery.querySelector('[data-gallery-dots]');
const galleryDots = dotsWrapper ? Array.from(dotsWrapper.querySelectorAll('.sly-gallery-dot')) : [];
if (galleryDots.length) {
const setActiveDot = (targetId) => {
galleryDots.forEach((dot) => {
dot.classList.toggle('is-active', 'sly-product-image-' + (dot.getAttribute('data-dot-index') || '0') === targetId);
});
};
if ('IntersectionObserver' in window) {
const dotObserver = new IntersectionObserver(
(entries) => {
entries.forEach((entry) => {
if (entry.isIntersecting) setActiveDot(entry.target.id);
});
},
{ root: imageStack, threshold: 0.5 }
);
images.forEach((img) => dotObserver.observe(img));
}
galleryDots.forEach((dot, idx) => {
dot.addEventListener('click', () => {
const target = images[idx];
if (target) target.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
});
});
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
const ajaxAddToCart = (productId, quantity, button, variationId, variation, redirectUrl) => {
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
if (variationId) body.append('variation_id', variationId);
if (variation) body.append('variation', JSON.stringify(variation));
fetch(window.slyAjax.url, { method: 'POST', body, credentials: 'same-origin' })
.then((res) => res.json())
.then((json) => {
if (json.success) {
if (redirectUrl) {
window.location.href = redirectUrl === 'checkout' ? json.data.checkout_url : redirectUrl;
return;
}
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
function slyGetVariationData(form) {
var variationId = '';
var variation = {};
var vIdInput = form.querySelector('input[name="variation_id"]');
if (vIdInput) variationId = vIdInput.value;
form.querySelectorAll('select[name^="attribute_"]').forEach(function(sel) {
variation[sel.name] = sel.value;
});
form.querySelectorAll('input[name^="attribute_"]').forEach(function(inp) {
variation[inp.name] = inp.value;
});
return { variationId: variationId, variation: variation };
}
var mainVarForm = document.querySelector('[data-atc-zone] form.cart.variations_form');
if (mainVarForm && window.slyAjax) {
mainVarForm.addEventListener('submit', function(e) {
e.preventDefault();
var isBuyNow = document.activeElement && document.activeElement.name === 'sly_buy_now';
var vd = slyGetVariationData(mainVarForm);
if (!vd.variationId || vd.variationId === '0') {
mainVarForm.submit();
return;
}
var qtyInput = mainVarForm.querySelector('.qty');
var qty = qtyInput ? parseInt(qtyInput.value, 10) || 1 : 1;
var productInput = mainVarForm.querySelector('[name="add-to-cart"]');
var productId = productInput ? productInput.value : '';
var btn = isBuyNow
? (mainVarForm.querySelector('.sly-buy-now') || mainVarForm.querySelector('.single_add_to_cart_button'))
: mainVarForm.querySelector('.single_add_to_cart_button');
ajaxAddToCart(productId, qty, btn, vd.variationId, vd.variation, isBuyNow ? 'checkout' : null);
});
}
const mainAtcForm = document.querySelector('[data-atc-zone] form.cart:not(.variations_form)');
if (mainAtcForm && window.slyAjax) {
const mainSubmit = mainAtcForm.querySelector('.single_add_to_cart_button');
if (mainSubmit) {
mainAtcForm.addEventListener('submit', (e) => {
var isBuyNow = document.activeElement && document.activeElement.name === 'sly_buy_now';
e.preventDefault();
const qtyInput = mainAtcForm.querySelector('.qty');
const qty = qtyInput ? parseInt(qtyInput.value, 10) || 1 : 1;
const productInput = mainAtcForm.querySelector('[name="add-to-cart"]');
const productId = productInput ? productInput.value : '';
var btn = isBuyNow ? (mainAtcForm.querySelector('.sly-buy-now') || mainSubmit) : mainSubmit;
ajaxAddToCart(productId, qty, btn, null, null, isBuyNow ? 'checkout' : null);
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
// Qty stepper — Quantity [−|n|+] unified box, label on left
(function($){
function buildQtyStepper(){
var $qty=$('.sly-pd-wc .qty');
if(!$qty.length||$qty.data('sly-stepper'))return;
$qty.data('sly-stepper',true).hide();
var val=parseInt($qty.val())||1;
var $stepper=$('<div class="sly-qty-stepper"></div>');
var $label=$('<span class="sly-qty-label">QTY</span>');
var $box=$('<div class="sly-qty-box"></div>');
var $minus=$('<button type="button" class="sly-qty-btn" aria-label="Decrease quantity">−</button>');
var $div1=$('<span class="sly-qty-divider"></span>');
var $num=$('<span class="sly-qty-num">'+val+'</span>');
var $div2=$('<span class="sly-qty-divider"></span>');
var $plus=$('<button type="button" class="sly-qty-btn" aria-label="Increase quantity">+</button>');
$box.append($minus).append($div1).append($num).append($div2).append($plus);
$stepper.append($label).append($box);
var $varRow=$('.sly-pd-var-row');
if($varRow.length){$varRow.append($stepper);}else{$qty.closest('.quantity').after($stepper);}
function update(n){n=Math.max(1,n);$qty.val(n).trigger('change');$num.text(n);}
$minus.on('click',function(){update(parseInt($num.text())-1);});
$plus.on('click',function(){update(parseInt($num.text())+1);});
$qty.on('change.slystepper',function(){$num.text(parseInt($qty.val())||1);});
}
$(function(){setTimeout(buildQtyStepper,0);});
$(document.body).on('wc-variation-form-ready updated_wc_div',buildQtyStepper);
})(jQuery);
// Mobile carousel arrows
(function(){
var slides=document.querySelector('[data-pd-slides]');
if(!slides)return;
var prevBtn=document.querySelector('.sly-slide-arrow--prev');
var nextBtn=document.querySelector('.sly-slide-arrow--next');
var mq=window.matchMedia('(max-width:900px)');
function scrollBy(dir){
var w=slides.offsetWidth;
slides.scrollBy({left:dir*w,behavior:'smooth'});
}
if(prevBtn)prevBtn.addEventListener('click',function(){scrollBy(-1);});
if(nextBtn)nextBtn.addEventListener('click',function(){scrollBy(1);});
function toggleArrows(){
if(prevBtn)prevBtn.style.display=mq.matches?'flex':'none';
if(nextBtn)nextBtn.style.display=mq.matches?'flex':'none';
}
toggleArrows();
mq.addEventListener('change',toggleArrows);
})();
// Bulk buy card grid — card click selects tier and sets qty
(function($){
var $bb=$('[data-bb]');
if(!$bb.length)return;
$bb.on('click','.sly-bb__card,.sly-bb__btn',function(){
var $card=$(this).closest('.sly-bb__card');
$bb.find('.sly-bb__card').removeClass('is-selected');
$card.addClass('is-selected');
var qty=parseInt($card.attr('data-bb-qty'))||1;
var $qtyInput=$('.sly-pd-wc .qty');
$qtyInput.val(qty).trigger('change');
var $numDisplay=$('.sly-qty-num');
$numDisplay.text(qty);
});
})(jQuery);
// Product page: size box swatches — builds visual boxes before the hidden WC table
(function($){
function buildSlyPdSizeBoxes(){
var $form=$('.sly-pd-wc .variations_form');
if(!$form.length)return;
if($form.find('.sly-pd-var-row').length)return;
var $varTable=$form.find('table.variations');
$varTable.find('tr').each(function(){
var $row=$(this);
var $select=$row.find('select');
if(!$select.length)return;
var labelText=$row.find('.label label').text();
var $rowWrapper=$('<div class="sly-pd-var-row"></div>');
if(labelText)$rowWrapper.append($('<p class="sly-pd-attr-label"></p>').text(labelText));
var $boxes=$('<div class="sly-size-boxes"></div>');
$select.find('option').each(function(){
var val=$(this).val();
if(!val)return;
var $btn=$('<button type="button" class="sly-size-box"></button>').text($(this).text().trim()).attr('data-value',val);
if($select.val()===val)$btn.addClass('is-selected');
$btn.on('click',function(){
$select.val(val).trigger('change');
$boxes.find('.sly-size-box').removeClass('is-selected');
$btn.addClass('is-selected');
});
$boxes.append($btn);
});
$select.on('change.slypd',function(){
$boxes.find('.sly-size-box').removeClass('is-selected');
var cur=$(this).val();
if(cur)$boxes.find('[data-value="'+cur+'"]').addClass('is-selected');
});
$rowWrapper.append($boxes);
var $qty=$form.find('.quantity');
if($qty.length)$rowWrapper.append($qty);
$varTable.first().before($rowWrapper);
});
}
$(function(){buildSlyPdSizeBoxes();});
$(document.body).on('wc-variation-form-ready',buildSlyPdSizeBoxes);
})(jQuery);
// Product page accordion tabs
document.querySelectorAll('.sly-pd-tab-trigger').forEach((trigger)=>{
trigger.addEventListener('click',()=>{
const expanded=trigger.getAttribute('aria-expanded')==='true';
trigger.setAttribute('aria-expanded',expanded?'false':'true');
const content=trigger.nextElementSibling;
if(content)content.hidden=expanded;
});
});
// Review carousel — dot tracking + click-to-scroll
(function(){
var rvTrack=document.querySelector('[data-rv-track]');
var rvDotsWrap=document.querySelector('[data-rv-dots]');
if(!rvTrack||!rvDotsWrap)return;
var rvCards=Array.from(rvTrack.querySelectorAll('[data-rv-card]'));
var rvDots=Array.from(rvDotsWrap.querySelectorAll('.sly-rv-dot'));
if(!rvCards.length||!rvDots.length)return;
var rvObs=new IntersectionObserver(function(entries){entries.forEach(function(e){if(e.isIntersecting){var idx=parseInt(e.target.getAttribute('data-rv-card'),10);rvDots.forEach(function(d,i){d.classList.toggle('is-active',i===idx);});}});},{root:rvTrack,threshold:0.5});
rvCards.forEach(function(c){rvObs.observe(c);});
rvDots.forEach(function(dot,i){dot.addEventListener('click',function(){rvTrack.scrollTo({left:i*rvTrack.clientWidth,behavior:'smooth'});});});
})();
// Product gallery dots — tracks carousel position on mobile, decorative on desktop
(function(){
const pdSlideWrap=document.querySelector('[data-pd-slides]');
const pdDotsWrap=document.querySelector('[data-pd-dots]');
if(!pdSlideWrap||!pdDotsWrap)return;
const pdDots=Array.from(pdDotsWrap.querySelectorAll('.sly-pd-dot'));
const pdSlides=Array.from(pdSlideWrap.querySelectorAll('[data-pd-slide]'));
if(!pdSlides.length||!pdDots.length)return;
let pdObs=null;
const mq=window.matchMedia('(max-width:900px)');
function setupDots(){
if(mq.matches){
if(pdObs)return;
pdObs=new IntersectionObserver((entries)=>{entries.forEach((e)=>{if(e.isIntersecting){const idx=parseInt(e.target.getAttribute('data-pd-slide'),10);pdDots.forEach((d,i)=>d.classList.toggle('is-active',i===idx));}});},{root:pdSlideWrap,threshold:0.5});
pdSlides.forEach((s)=>pdObs.observe(s));
}else{
if(pdObs){pdObs.disconnect();pdObs=null;}
pdDots.forEach((d)=>d.classList.remove('is-active'));
}
}
setupDots();
mq.addEventListener('change',setupDots);
pdDots.forEach((dot,i)=>{
dot.addEventListener('click',()=>{
if(!mq.matches)return;
const t=pdSlides[i];
if(t)t.scrollIntoView({behavior:'smooth',block:'nearest',inline:'start'});
});
});
})();
})();