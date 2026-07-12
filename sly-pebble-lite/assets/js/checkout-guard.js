(() => {
  const form = document.querySelector('form.checkout');
  if (!form) return;

  const stampField = document.createElement('input');
  stampField.type = 'hidden';
  stampField.name = 'sly_fg_client_stamp';
  stampField.value = String(Date.now());
  form.appendChild(stampField);

  // Re-enable the button whenever WooCommerce signals that the checkout
  // has errored or been reset — avoids the form staying frozen after a
  // failed payment attempt.
  const unlock = () => {
    const btn = form.querySelector('#place_order');
    if (btn) {
      btn.removeAttribute('disabled');
      btn.classList.remove('processing');
    }
  };

  document.body.addEventListener('checkout_error', unlock);
  document.body.addEventListener('payment_method_selected', unlock);
  document.body.addEventListener('updated_checkout', unlock);
})();
