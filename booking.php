
<?php
session_start();

// Helper: Currency Symbols
function getCurrencySymbol($currency) {
    $symbols = [
        "USD" => "$", "EUR" => "€", "GBP" => "£", "INR" => "₹",
        "AED" => "د.إ", "JPY" => "¥", "CNY" => "¥", "CAD" => "C$",
        "AUD" => "A$", "CHF" => "CHF",
    ];
    return $symbols[$currency] ?? $currency;
}

// 1) Validate offerId in URL
$offerId = $_GET['offerId'] ?? null;
if (!$offerId) {
    http_response_code(400);
    die('<div class="alert alert-danger">Missing offerId. Please go back and select a flight.</div>');
}

// 2) Fetch selected offer from session
$selectedOffer = $_SESSION['flights'][$offerId] ?? null;
if (!$selectedOffer) {
    http_response_code(410);
    die('<div class="alert alert-danger">Selected flight not found (session expired). Please search again.</div>');
}

// 3) Get dictionaries (for airline names). May be empty fallback.
$dictionaries = $_SESSION['dictionaries'] ?? [];
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>Flights</title>

<?php include("header.php"); ?>


<section class="flight-result-bg pt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
          <!-- Show Same Flight Card -->
          <div class="flight-result-box mb-3 p-3 border rounded">
            <div class="row">
              <!-- Flight Details -->
              <div class="col-md-9">
                <?php foreach ($selectedOffer["itineraries"] as $itinIndex => $itinerary): ?>
                  <?php 
                    $segments = $itinerary["segments"];
                    $firstSeg = $segments[0];
                    $lastSeg  = end($segments);

                    $depTime = date("h:i A", strtotime($firstSeg["departure"]["at"]));
                    $arrTime = date("h:i A", strtotime($lastSeg["arrival"]["at"]));
                    $depAirport = $firstSeg["departure"]["iataCode"];
                    $arrAirport = $lastSeg["arrival"]["iataCode"];

                    // duration
                    $depDT = strtotime($firstSeg["departure"]["at"]);
                    $arrDT = strtotime($lastSeg["arrival"]["at"]);
                    $durationMin = round(($arrDT - $depDT)/60);
                    $hrs = floor($durationMin / 60);
                    $mins = $durationMin % 60;
                    $duration = "{$hrs}h {$mins}m";

                    // airline
                    $airlineCode = $firstSeg["carrierCode"];
                    $airlineName = $_SESSION['flights']['dictionaries']['carriers'][$airlineCode] ?? $airlineCode;
                    $logoUrl = "https://static.tripcdn.com/packages/flight/airline-logo/latest/airline_logo/3x/" . strtolower($airlineCode) . ".webp";

                    $stops = count($segments) - 1;
                  ?>
                  <div class="row align-items-center mb-3">
                    <div class="col-md-3">
                      <div class="d-flex d-md-block align-items-center gap-3 mb-2 mb-md-0">
                        <img src="<?= $logoUrl ?>" width="50" alt="<?= $airlineCode ?>">
                        <p class="flight-logo-name"><?= ucwords(strtolower($airlineName)) ?></p>
                      </div>
                    </div>
                    <div class="col">
                      <div class="row text-center">
                        <div class="col-4">
                          <h5 class="flight-time"><?= $depTime ?></h5>
                          <p class="flight-location"><?= $depAirport ?></p>
                        </div>
                        <div class="col-4">
                          <div class="flight-result-duration">
                            <?= $duration ?>
                            <div class="flight-duration-line"></div>
                            <?php if ($stops > 0): ?>
                              <small class="text-muted"><?= $stops ?> Stop<?= $stops > 1 ? "s" : "" ?></small>
                            <?php else: ?>
                              <small class="text-muted">Non-stop</small>
                            <?php endif; ?>
                          </div>    
                        </div>
                        <div class="col-4">
                          <h5 class="flight-time"><?= $arrTime ?></h5>
                          <p class="flight-location"><?= $arrAirport ?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php if (count($selectedOffer["itineraries"]) > 1 && $itinIndex == 0): ?>
                    <hr>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>

              <!-- Price -->
              <div class="col-md-3 d-lg-flex flex-column justify-content-center text-center">
                <div>
                  <span class="flight-price">
                    <?= getCurrencySymbol($selectedOffer["price"]["currency"]) . " " . $selectedOffer["price"]["total"] ?>
                  </span>
                  <p class="wrap-prgh text-muted"><?= ucfirst($selectedOffer["type"]) ?> Ticket</p>
                </div>
              </div>
            </div>
          </div>

      </div>
      <div class="col-sm-12">
          <form action="confirm-booking.php" method="post">
          <input type="hidden" name="offerId" value="<?= htmlspecialchars($offerId) ?>">

          <!-- Passenger Info -->
          <div class="flight-result-box">
              <h1 class="wrap-subhding pb-4">Passenger Information</h1>
              <p class="note"><strong>Important</strong>: Each passenger's full name must be entered as it appears on their passport or government ID.</p>
              <?php 
              // Support both GET and POST
              $adults   = $_REQUEST['adults']   ?? 1;
              $children = $_REQUEST['children'] ?? 0;
              $infants  = $_REQUEST['infants']  ?? 0;
              ?>

              <div class="table-responsive">
                <table class="table passenger-table" id="traveller-table">
                  <tbody>
                      <?php 
                      // Adults
                      for ($i = 1; $i <= $adults; $i++): ?>
                          <tr>
                              <td><strong>Adult <?= $i ?></strong></td>
                              <td>
                                  <label class="traveller-form-lbl">First Name</label>
                                  <input type="text" name="first-name[]" class="traveller-form-field" required>
                              </td>
                              <td>
                                  <label class="traveller-form-lbl">Last Name</label>
                                  <input type="text" name="last-name[]" class="traveller-form-field" required>
                              </td>
                              <td>
                                  <label class="traveller-form-lbl">Gender</label>
                                  <select name="gender[]" class="traveller-form-field">
                                      <option>Male</option>
                                      <option>Female</option>
                                  </select>
                              </td>
                              <td>
                                  <label class="traveller-form-lbl">DOB</label>
                                  <input type="date" name="dob[]" class="traveller-form-field" required>
                              </td>
                          </tr>
                      <?php endfor; ?>

                      <!-- Children -->
                      <?php for ($i = 1; $i <= $children; $i++): ?>
                          <tr>
                              <td><strong>Child <?= $i ?></strong></td>
                              <td>
                                  <label class="traveller-form-lbl">First Name</label>
                                  <input type="text" name="first-name[]" class="traveller-form-field" required>
                              </td>
                              <td>
                                  <label class="traveller-form-lbl">Last Name</label>
                                  <input type="text" name="last-name[]" class="traveller-form-field" required>
                              </td>
                              <td>
                                  <label class="traveller-form-lbl">Gender</label>
                                  <select name="gender[]" class="traveller-form-field">
                                      <option>Male</option>
                                      <option>Female</option>
                                  </select>
                              </td>
                              <td>
                                  <label class="traveller-form-lbl">DOB</label>
                                  <input type="date" name="dob[]" class="traveller-form-field" required>
                              </td>
                          </tr>
                      <?php endfor; ?>

                      <!-- Infants -->
                      <?php for ($i = 1; $i <= $infants; $i++): ?>
                          <tr>
                              <td><strong>Infant <?= $i ?></strong></td>
                              <td>
                                  <label class="traveller-form-lbl">First Name</label>
                                  <input type="text" name="first-name[]" class="traveller-form-field" required>
                              </td>
                              <td>
                                  <label class="traveller-form-lbl">Last Name</label>
                                  <input type="text" name="last-name[]" class="traveller-form-field" required>
                              </td>
                              <td>
                                  <label class="traveller-form-lbl">Gender</label>
                                  <select name="gender[]" class="traveller-form-field">
                                      <option>Male</option>
                                      <option>Female</option>
                                  </select>
                              </td>
                              <td>
                                  <label class="traveller-form-lbl">DOB</label>
                                  <input type="date" name="dob[]" class="traveller-form-field" required>
                              </td>
                          </tr>
                      <?php endfor; ?>
                  </tbody>
                </table>
              </div>

          </div>

          <!-- Billing Info -->
          <div class="flight-result-box">
              <h1 class="wrap-subhding pb-4">Billing Information</h1>
              <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-lbl">Address 1</label><input type="text" name="address1" class="form-field" required>
                    </div>  
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-lbl">Address 2</label><input type="text" name="address2" class="form-field">
                    </div>  
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-lbl">Country</label><input type="text" name="country" class="form-field" required>
                    </div>  
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-lbl">State</label><input type="text" name="state" class="form-field" required>
                    </div>  
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-lbl">City</label><input type="text" name="city" class="form-field" required>
                    </div>  
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-lbl">Zip Code</label><input type="text" name="zip" class="form-field" required>
                    </div>  
                  </div>
              </div>
          </div>

          <!-- Contact Info -->
          <div class="flight-result-box">
              <h1 class="wrap-subhding pb-4">Contact Information</h1>
              <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-lbl">Phone</label><input type="text" name="phone" class="form-field" required>
                    </div>
                  </div>   
                  <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-lbl">Email</label><input type="email" name="email" class="form-field" required>
                    </div>
                  </div>  
              </div>
          </div>

          <div class="text-center mt-3">
              <input type="hidden" name="offerId" value="<?= htmlspecialchars($_GET['offerId']) ?>">
              <button type="submit" class="submit-btn btn btn-success">Proceed to Confirmation</button>
          </div>
      </form>
      </div>
    </div>
  </div>
</section>


<script>
document.addEventListener("DOMContentLoaded", function(){
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
});
</script>
<?php include("footer.php"); ?>

<!-- <div class="search-summary">
    <h3>Search Details</h3>
    <p>
        <strong>From:</strong> <?= $origin ?><br>
        <strong>To:</strong> <?= $destination ?><br>
        <strong>Departure Date:</strong> <?= $departure_date ?><br>
        <?php if (!empty($return_date)): ?>
            <strong>Return Date:</strong> <?= $return_date ?><br>
        <?php endif; ?>
        <strong>Travel Class:</strong> <?= ucfirst(strtolower($travel_class)) ?><br>
        <strong>Passengers:</strong> 
        <?= $adults ?> Adult<?= ($adults > 1 ? 's' : '') ?>
        <?= ($children > 0 ? ', ' . $children . ' Child' . ($children > 1 ? 'ren' : '') : '') ?>
        <?= ($infants > 0 ? ', ' . $infants . ' Infant' . ($infants > 1 ? 's' : '') : '') ?>
    </p>
</div> -->


<!-- show only total passenger -->
<script>
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
</script>


<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="js/countries.js"></script>
<script>
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

</script>


<script>
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
</script>

</body>
</html>
