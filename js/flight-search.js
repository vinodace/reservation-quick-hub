// show only total passenger -----------

 const displayBox = document.getElementById('passengerClassDisplay');
  const dropdownPanel = document.getElementById('passengerDropdown');
  const counts = { adult: 1, child: 0, infant: 0 };

  // Toggle dropdown
  displayBox.addEventListener('click', () => {
      dropdownPanel.style.display = dropdownPanel.style.display === 'block' ? 'none' : 'block';
  });

  // Update count
  function changeCount(type, delta) {
      if (counts[type] + delta >= 0) {
          counts[type] += delta;
          document.getElementById(type + 'Count').textContent = counts[type];
      }
  }

  // Build summary + update hidden fields
  function updateDisplay() {
      const travelClass = document.getElementById('travelClass').value;
      const totalPassengers = counts.adult + counts.child + counts.infant;

      const passengerLabel = totalPassengers === 1 ? 'Passenger' : 'Passengers';

      // Short display for box
      displayBox.textContent = `${totalPassengers} ${passengerLabel} - ${travelClass}`;

      // Hidden inputs for form
      document.getElementById('adults').value      = counts.adult;
      document.getElementById('children').value    = counts.child;
      document.getElementById('infants').value     = counts.infant;
      document.getElementById('cabin_class').value = travelClass;

      // Full summary (if needed in PHP)
      document.getElementById('passenger').value = 
          `${counts.adult} Adult${counts.adult > 1 ? 's' : ''}`
          + (counts.child > 0 ? `, ${counts.child} Child` : '')
          + (counts.infant > 0 ? `, ${counts.infant} Infant` : '')
          + ` - ${travelClass}`;
  }

  // Confirm button action
  function confirmPassengers() {
      updateDisplay(); // Update hidden fields
      dropdownPanel.style.display = 'none'; // Close dropdown
  }

  // Close dropdown if clicking outside
  document.addEventListener('click', function(e) {
      if (!e.target.closest('#passengerDropdown') && !e.target.closest('#passengerClassDisplay')) {
          dropdownPanel.style.display = 'none';
      }
  });

  // Initialize on load
  updateDisplay();

// airport list api with autocomplete ------------
  function getAccessToken() {
  return fetch("https://test.api.amadeus.com/v1/security/oauth2/token", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: new URLSearchParams({
      grant_type: "client_credentials",
      client_id: "IMewQoGGzsLuxu2vR2r9ImKFeRVNbf4m",      // 🔑 Replace with Amadeus API Key
      client_secret: "bLW0u8zhqigZYcaC" // 🔑 Replace with Amadeus Secret
    })
  }).then(res => res.json()).then(data => data.access_token);
}

function setupAutocomplete(inputId, hiddenId) {
  getAccessToken().then(token => {
    $("#" + inputId).autocomplete({
      minLength: 3,
      source: function(request, response) {
        fetch(`https://test.api.amadeus.com/v1/reference-data/locations?subType=AIRPORT&keyword=${request.term}`, {
          headers: { "Authorization": "Bearer " + token }
        })
        .then(res => res.json())
        .then(data => {
          response(data.data.map(airport => ({
            label: `${airport.name} (${airport.iataCode}) - ${airport.address.cityName}, ${airport.address.countryName}`,
            value: airport.iataCode,  // 👈 Input shows only code
            code: airport.iataCode
          })));
        });
      },
      select: function(event, ui) {
        $("#" + inputId).val(ui.item.code);   // input shows only code
        $("#" + hiddenId).val(ui.item.code); // hidden field also stores code
        return false;
      }
    });
  });
}

$(document).ready(function() {
  setupAutocomplete("fromAirport", "fromAirportCode");
  setupAutocomplete("toAirport", "toAirportCode");
});

// Departure and return date datepicker ---------------

$(function() {
      // Departure date picker
      $("#departDate").datepicker({
          dateFormat: "yy-mm-dd",
          minDate: 0,
          numberOfMonths: 2,
          onSelect: function(selectedDate) {
              // Set minimum return date
              $("#returnDate").datepicker("option", "minDate", selectedDate);

              // If round trip, open the return date calendar automatically
              if ($('input[name="tripType"]:checked').val() === 'roundtrip') {
                  setTimeout(function() {
                      $("#returnDate").datepicker("show");
                  }, 200); // small delay so it feels smooth
              }
          }
      });

      // Return date picker
      $("#returnDate").datepicker({
          dateFormat: "yy-mm-dd",
          minDate: 0,
          numberOfMonths: 2
      });

      // Trip type change handling
      $('input[name="tripType"]').on('change', function() {
          if ($(this).val() === 'roundtrip') {
              $("#returnDate").prop('disabled', false);
          } else {
              $("#returnDate").prop('disabled', true).val('');
          }
      });

      // Initial disable if not round trip
      if ($('input[name="tripType"]:checked').val() !== 'roundtrip') {
          $("#returnDate").prop('disabled', true);
      }
  });

// One way and Roundtrip checked function --------------
 tripTypeRadios.forEach(radio => {
    radio.addEventListener('change', () => {
        if (radio.value === 'roundtrip') {
            returnDateInput.readOnly = false; 
        } else {
            returnDateInput.readOnly = true;  
            returnDateInput.value = '';       
        }
    });
});

// Initial state
if (document.querySelector('input[name="tripType"]:checked').value !== 'roundtrip') {
    returnDateInput.readOnly = true;
}


// Flight search page code Travell and class value 
function changeCount(type, change) {
  let countEl, hiddenEl;
  if(type === 'adult') {
    countEl = document.getElementById('adultCount');
    hiddenEl = document.getElementById('adults');
  } else if(type === 'child') {
    countEl = document.getElementById('childCount');
    hiddenEl = document.getElementById('children');
  } else {
    countEl = document.getElementById('infantCount');
    hiddenEl = document.getElementById('infants');
  }

  let current = parseInt(countEl.innerText);
  let newVal = current + change;
  if(newVal < 0) newVal = 0;
  countEl.innerText = newVal;
  hiddenEl.value = newVal;
}

function updateCabinClass() {
  document.getElementById('cabin_class').value = document.getElementById('travelClass').value;
}

function confirmPassengers() {
  let adults = parseInt(document.getElementById('adults').value);
  let children = parseInt(document.getElementById('children').value);
  let infants = parseInt(document.getElementById('infants').value);
  let cls = document.getElementById('cabin_class').value;

  let summary = [];
  if(adults > 0) summary.push(adults + " " + (adults > 1 ? "Adults" : "Adult"));
  if(children > 0) summary.push(children + " " + (children > 1 ? "Children" : "Child"));
  if(infants > 0) summary.push(infants + " " + (infants > 1 ? "Infants" : "Infant"));

  document.getElementById('passengerClassDisplay').innerText = summary.join(", ") + " - " + cls.charAt(0).toUpperCase() + cls.slice(1).toLowerCase();

  // Close dropdown
  document.getElementById('passengerDropdown').style.display = "none";
}
