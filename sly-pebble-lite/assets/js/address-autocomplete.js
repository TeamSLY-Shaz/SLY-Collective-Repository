/**
 * SLY Address Autocomplete
 *
 * Uses Google Places API to provide address suggestions on cart shipping
 * calculator and checkout address fields. Lazy-initialises on focus.
 */
(() => {
  if (typeof google === 'undefined' || !google.maps || !google.maps.places) {
    return;
  }

  const defaultCountry = (window.slyAddressAC && window.slyAddressAC.country)
    ? window.slyAddressAC.country.split(':')[0]
    : 'AU';

  const componentMap = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    postal_code: 'short_name',
    sublocality_level_1: 'long_name',
    country: 'short_name',
  };

  const setField = (id, value) => {
    const el = document.getElementById(id);
    if (!el || !value) return;
    if (el.tagName === 'SELECT') {
      const option = Array.from(el.options).find(
        (opt) => opt.value === value || opt.textContent.trim() === value
      );
      if (option) el.value = option.value;
    } else {
      el.value = value;
    }
  };

  const initAutocomplete = (input, fieldMap) => {
    if (input.dataset.acInit) return;
    input.dataset.acInit = '1';

    const autocomplete = new google.maps.places.Autocomplete(input, {
      types: ['address'],
      componentRestrictions: { country: defaultCountry },
      fields: ['address_components', 'formatted_address'],
    });

    input.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' && document.querySelector('.pac-container:not([style*="display: none"])')) {
        e.preventDefault();
      }
    });

    autocomplete.addListener('place_changed', () => {
      const place = autocomplete.getPlace();
      if (!place || !place.address_components) return;

      const parts = {};
      place.address_components.forEach((component) => {
        const type = component.types[0];
        if (componentMap[type]) parts[type] = component[componentMap[type]];
      });

      const streetNumber = parts.street_number || '';
      const route = parts.route || '';
      const streetAddress = (streetNumber + ' ' + route).trim();

      // Fill all fields silently — no change events yet
      if (fieldMap.street && streetAddress) setField(fieldMap.street, streetAddress);
      if (fieldMap.city) setField(fieldMap.city, parts.locality || parts.sublocality_level_1 || '');
      if (fieldMap.state) setField(fieldMap.state, parts.administrative_area_level_1 || '');
      if (fieldMap.postcode) setField(fieldMap.postcode, parts.postal_code || '');

      // Clear unit field — user fills manually
      if (fieldMap.unit) {
        const unitField = document.getElementById(fieldMap.unit);
        if (unitField) { unitField.value = ''; unitField.focus(); }
      }

      // Fire a single change event on postcode only — this triggers WooCommerce's
      // update_checkout once instead of once per field, preventing checkout freeze.
      if (fieldMap.postcode) {
        const postcodeField = document.getElementById(fieldMap.postcode);
        if (postcodeField) postcodeField.dispatchEvent(new Event('change', { bubbles: true }));
      }
    });
  };

  const fieldSets = [
    {
      trigger: 'calc_shipping_address_1',
      map: {
        street: 'calc_shipping_address_1',
        unit: 'calc_shipping_address_2',
        city: 'calc_shipping_city',
        state: 'calc_shipping_state',
        postcode: 'calc_shipping_postcode',
      },
    },
    {
      trigger: 'shipping_address_1',
      map: {
        street: 'shipping_address_1',
        unit: 'shipping_address_2',
        city: 'shipping_city',
        state: 'shipping_state',
        postcode: 'shipping_postcode',
      },
    },
    {
      trigger: 'billing_address_1',
      map: {
        street: 'billing_address_1',
        unit: 'billing_address_2',
        city: 'billing_city',
        state: 'billing_state',
        postcode: 'billing_postcode',
      },
    },
  ];

  const tryInit = () => {
    fieldSets.forEach((config) => {
      const input = document.getElementById(config.trigger);
      if (input && !input.dataset.acInit) {
        input.addEventListener('focus', () => initAutocomplete(input, config.map), { once: true });
      }
    });
  };

  tryInit();

  document.body.addEventListener('updated_checkout', tryInit);
  document.body.addEventListener('updated_shipping_method', tryInit);

  const calcObserver = new MutationObserver(tryInit);
  const calcForm = document.querySelector('.shipping-calculator-form');
  if (calcForm) {
    calcObserver.observe(calcForm, { attributes: true, attributeFilter: ['style'] });
  }
})();
