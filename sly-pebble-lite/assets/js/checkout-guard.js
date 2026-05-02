(() => {
  const form = document.querySelector('form.checkout');
  if (!form) {
    return;
  }

  const stampField = document.createElement('input');
  stampField.type = 'hidden';
  stampField.name = 'sly_fg_client_stamp';
  stampField.value = String(Date.now());
  form.appendChild(stampField);

  form.addEventListener('submit', () => {
    const placeOrderButton = form.querySelector('#place_order');
    if (placeOrderButton) {
      placeOrderButton.setAttribute('disabled', 'disabled');
      placeOrderButton.classList.add('processing');
      setTimeout(() => {
        placeOrderButton.removeAttribute('disabled');
        placeOrderButton.classList.remove('processing');
      }, 12000);
    }
  });
})();
