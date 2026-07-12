(() => {
  if (typeof jQuery === 'undefined') return;

  const form = document.querySelector('form.checkout');
  if (!form) return;

  const stampField = document.createElement('input');
  stampField.type = 'hidden';
  stampField.name = 'sly_fg_client_stamp';
  stampField.value = String(Date.now());
  form.appendChild(stampField);

  // WooCommerce fires all checkout events through jQuery.trigger(), which does NOT
  // dispatch native DOM events — addEventListener() never fires. Must use jQuery.on().
  const unlock = () => {
    const btn = form.querySelector('#place_order');
    if (btn) {
      btn.removeAttribute('disabled');
      btn.classList.remove('processing');
    }
  };

  jQuery(document.body).on('checkout_error payment_method_selected updated_checkout', unlock);
})();
