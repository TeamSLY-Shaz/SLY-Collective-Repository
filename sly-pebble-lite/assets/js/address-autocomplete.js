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

  /**
   * Component type mapping from Google Places to form fields.
   */
  const componentMap = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    postal_code: 'short_name',
    sublocality_level_1: 'long_name',
    country: 'short_name',
  };

  /**
   * Attach autocomplete to a street address input and auto-fill sibling fields.
   */
  const initAutocomplete = (input, fieldMap) => {
    if (input.dataset.acInit) {
      return;
    }
    input.dataset.acInit = '1';

    const autocomplete = new google.maps.places.Autocomplete(input, {
      types: ['address'],
      componentRestrictions: { country: defaultCountry },
      fields: ['address_components', 'formatted_address'],
    });

    // Prevent form submit on Enter when picking a suggestion
    input.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' && document.querySelector('.pac-container:not([style*="display: none"])')) {
        e.preventDefault();
      }
    });

    autocomplete.addListener('place_changed', () => {
      const place = autocomplete.getPlace();
      if (!place || !place.address_components) {
        return;
      }

      const parts = {};
      place.address_components.forEach((component) => {
        const type = component.types[0];
        if (componentMap[type]) {
          parts[type] = component[componentMap[type]];
        }
      });

      // Build street address: "123 Main Street"
      const streetNumber = parts.street_number || '';
      const route = parts.route || '';
      const streetAddress = (streetNumber + ' ' + route).trim();

      // Fill the fields using the provided field map
      if (fieldMap.street && streetAddress) {
        const streetField = document.getElementById(fieldMap.street);
        if (streetField) {
          streetField.value = streetAddress;
          streetField.dispatchEvent(new Event('change', { bubbles: true }));
        }
      }

      if (fieldMap.city) {
        const cityField = document.getElementById(fieldMap.city);
        const city = parts.locality || parts.sublocality_level_1 || '';
        if (cityField && city) {
          cityField.value = city;
          cityField.dispatchEvent(new Event('change', { bubbles: true }));
        }
      }

      if (fieldMap.state) {
        const stateField = document.getElementById(fieldMap.state);
        const state = parts.administrative_area_level_1 || '';
        if (stateField && state) {
          // Handle both select and text inputs
          if (stateField.tagName === 'SELECT') {
            const option = Array.from(stateField.options).find(
              (opt) => opt.value === state || opt.textContent.trim() === state
            );
            if (option) {
              stateField.value = option.value;
            }
          } else {
            stateField.value = state;
          }
          stateField.dispatchEvent(new Event('change', { bubbles: true }));
        }
      }

      if (fieldMap.postcode) {
        const postcodeField = document.getElementById(fieldMap.postcode);
        const postcode = parts.postal_code || '';
        if (postcodeField && postcode) {
          postcodeField.value = postcode;
          postcodeField.dispatchEvent(new Event('change', { bubbles: true }));
        }
      }

      // Clear unit field — user fills manually
      if (fieldMap.unit) {
        const unitField = document.getElementById(fieldMap.unit);
        if (unitField) {
          unitField.value = '';
          unitField.focus();
        }
      }
    });
  };

  /**
   * Field configurations for cart calculator and checkout forms.
   */
  const fieldSets = [
    // Cart shipping calculator
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
    // Checkout — shipping
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
    // Checkout — billing
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

  /**
   * Lazy-init: attach autocomplete when user focuses an address field.
   */
  const tryInit = () => {
    fieldSets.forEach((config) => {
      const input = document.getElementById(config.trigger);
      if (input && !input.dataset.acInit) {
        input.addEventListener('focus', () => initAutocomplete(input, config.map), { once: true });
      }
    });
  };

  // Run on load
  tryInit();

  // WooCommerce dynamically replaces checkout fragments — re-init after AJAX
  document.body.addEventListener('updated_checkout', tryInit);
  document.body.addEventListener('updated_shipping_method', tryInit);

  // Also handle the cart calculator being toggled open
  const calcObserver = new MutationObserver(tryInit);
  const calcForm = document.querySelector('.shipping-calculator-form');
  if (calcForm) {
    calcObserver.observe(calcForm, { attributes: true, attributeFilter: ['style'] });
  }
})();
