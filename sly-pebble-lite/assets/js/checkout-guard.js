// Stamp the checkout form with a client-side page-load timestamp.
// fraud-guard.php reads sly_fg_client_stamp from POST to measure time-on-page
// without relying on a server-side session (which can fail on AJAX requests).
(function () {
  var form = document.querySelector('form.checkout');
  if (!form) return;
  var field = document.createElement('input');
  field.type = 'hidden';
  field.name = 'sly_fg_client_stamp';
  field.value = String(Math.floor(Date.now() / 1000));
  form.appendChild(field);

  // Re-stamp after WooCommerce rebuilds the checkout fragment so the timestamp
  // stays fresh after shipping/coupon updates refresh the form HTML.
  document.body.addEventListener('updated_checkout', function () {
    var f = document.querySelector('form.checkout');
    if (!f) return;
    var existing = f.querySelector('[name="sly_fg_client_stamp"]');
    if (!existing) {
      var nf = field.cloneNode();
      nf.value = String(Math.floor(Date.now() / 1000));
      f.appendChild(nf);
    }
  });
}());
