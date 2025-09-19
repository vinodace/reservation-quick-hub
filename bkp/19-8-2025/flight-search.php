<?php
session_start(); 

// =====================
// Amadeus API Credentials
// =====================
$client_id     = "IMewQoGGzsLuxu2vR2r9ImKFeRVNbf4m";
$client_secret = "bLW0u8zhqigZYcaC";

// =====================
// Function: Get Access Token
// =====================
function getAccessToken($client_id, $client_secret) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://test.api.amadeus.com/v1/security/oauth2/token");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        "grant_type"    => "client_credentials",
        "client_id"     => $client_id,
        "client_secret" => $client_secret
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        die("❌ Token Request Error: " . curl_error($ch));
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if (!isset($data["access_token"])) {
        die("❌ Failed to get access token. Response:<br><pre>" . print_r($data, true) . "</pre>");
    }

    return $data["access_token"];
}

// =====================
// Collect Form Inputs
// =====================
$origin         = strtoupper(trim($_GET['origin']));
$destination    = strtoupper(trim($_GET['destination']));
$departure_date = $_GET['departure_date'];
$return_date    = $_GET['return_date'] ?? '';
$trip_type      = $_GET['tripType'] ?? 'oneway';
$travel_class   = strtoupper($_GET['travel_class']); 
$adults         = (int)$_GET['adults'];
$children       = (int)($_GET['children'] ?? 0);
$infants        = (int)($_GET['infants'] ?? 0);

// =====================
// Get Token
// =====================
$token = getAccessToken($client_id, $client_secret);

// =====================
// Build Flight Search URL
// =====================
$url = "https://test.api.amadeus.com/v2/shopping/flight-offers?";
$params = [
    "originLocationCode"      => $origin,
    "destinationLocationCode" => $destination,
    "departureDate"           => $departure_date,
    "adults"                  => $adults,
    "travelClass"             => $travel_class,
    "currencyCode"            => "USD",
    "max"                     => 10
];
if ($trip_type === "roundtrip" && !empty($return_date)) {
    $params["returnDate"] = $return_date;
}
if ($children > 0) $params["children"] = $children;
if ($infants > 0)  $params["infants"]  = $infants;

$url .= http_build_query($params);

// =====================
// Call Amadeus API
// =====================
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer " . $token]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    die("❌ API Request Error: " . curl_error($ch));
}

curl_close($ch);

$results = json_decode($response, true);

// =====================
// Helper: Currency Symbols
// =====================
function getCurrencySymbol($currency) {
    $symbols = [
        "USD" => "$", "EUR" => "€", "GBP" => "£", "INR" => "₹",
        "AED" => "د.إ", "JPY" => "¥", "CNY" => "¥", "CAD" => "C$",
        "AUD" => "A$", "CHF" => "CHF",
    ];
    return $symbols[$currency] ?? $currency;
}
?>

<?php
$adults = isset($_POST['adults']) ? (int)$_POST['adults'] : 1;
$children = isset($_POST['children']) ? (int)$_POST['children'] : 0;
$infants = isset($_POST['infants']) ? (int)$_POST['infants'] : 0;
$travel_class = isset($_POST['travel_class']) ? $_POST['travel_class'] : 'ECONOMY';

// Build passenger summary
$summaryParts = [];
if ($adults > 0) $summaryParts[] = $adults . ' ' . ($adults > 1 ? 'Adults' : 'Adult');
if ($children > 0) $summaryParts[] = $children . ' ' . ($children > 1 ? 'Children' : 'Child');
if ($infants > 0) $summaryParts[] = $infants . ' ' . ($infants > 1 ? 'Infants' : 'Infant');

$passenger_summary = implode(', ', $summaryParts) . ' - ' . ucfirst(strtolower($travel_class));
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Flights</title>

<?php include("header.php"); ?>

<!-- Flight search result with waiting loader modal -->
<section class="flight-search-result-bg">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="flight-search-box mb-4 flight-search-box-neg_mt">
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="flight" role="tabpanel" aria-labelledby="flight-tab">
               
                <form id="flightForm" action="flight-search.php"  method="GET">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                          <label><input type="radio" class="choose-trip-type" name="tripType" value="oneway" <?= ($trip_type === "oneway") ? "checked" : "" ?>> One Way</label>
                          <label><input type="radio" class="choose-trip-type" name="tripType" value="roundtrip" <?= ($trip_type === "roundtrip") ? "checked" : "" ?>> Round Trip</label>
                      </div>    
                    </div>
                    <div class="col-md-5">
                      <div class="row">
                        <div class="col-sm-6 col-md-6 pe-md-0">
                          <div class="form-group" id="citySection">
                            <label class="filter-lbl">Leaving From</label>
                            <input type="text" class="filter-field from_oneway1 field-right-radius-0" id="fromAirport" name="origin" placeholder="From" value="<?= $origin ?>" required>
                          </div> 
                        </div>
                        <div class="col-sm-6 col-md-6 px-md-0">
                          <div class="form-group" id="citySection">
                            <label class="filter-lbl">Going To</label>
                            <input type="text" class="filter-field to_oneway1 field-radius-0" id="toAirport" name="destination" placeholder="To" value="<?= $destination ?>" required>
                          </div>
                        </div>    
                      </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-2 px-md-0">
                      <div class="form-group">
                         <label class="filter-lbl">Departure Date</label>
                          <input type="text" class="filter-field field-radius-0" id="departDate" name="departure_date" placeholder="Select date" value="<?= $departure_date ?>" required>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-2 px-md-0">
                      <div class="form-group">   
                          <label class="filter-lbl">Return Date</label> 
                          <input type="text" class="filter-field field-radius-0" name="return_date" id="returnDate" placeholder="Select date" value="<?= !empty($return_date) ? htmlspecialchars($return_date) : '' ?>" <?= ($trip_type === "roundtrip" && !empty($return_date)) ? '' : 'disabled' ?>>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3 ps-md-0">
                      <div class="form-group">
                          <label class="filter-lbl">Passenger & Class</label>
                          <div class="filter-field field-left-radius-0" id="passengerClassDisplay">
                            <?= htmlspecialchars($passenger_summary) ?>
                          </div>
                          <input type="hidden" name="passenger" id="passenger">

                          <div class="dropdown-panel" id="passengerDropdown">
                            <!-- Adults -->
                            <div class="traveller-row">
                              <input type="hidden" name="adults" id="adults" value="<?= $adults ?>">
                              <span>Adults <span>(12y+)</span></span>
                              <div>
                                <button type="button" class="count-btn" onclick="changeCount('adult', -1)">-</button>
                                <span class="passenger-count-output" id="adultCount"><?= $adults ?></span>
                                <button type="button" class="count-btn" onclick="changeCount('adult', 1)">+</button>
                              </div>
                            </div>

                            <!-- Children -->
                            <div class="traveller-row">
                              <input type="hidden" name="children" id="children" value="<?= $children ?>">
                              <span>Children <span>(2y - 12y)</span></span>
                              <div>
                                <button type="button" class="count-btn" onclick="changeCount('child', -1)">-</button>
                                <span class="passenger-count-output" id="childCount"><?= $children ?></span>
                                <button type="button" class="count-btn" onclick="changeCount('child', 1)">+</button>
                              </div>
                            </div>

                            <!-- Infants -->
                            <div class="traveller-row">
                              <input type="hidden" name="infants" id="infants" value="<?= $infants ?>">
                              <span>Infants <span>(Below 2y)</span></span>
                              <div>
                                <button type="button" class="count-btn" onclick="changeCount('infant', -1)">-</button>
                                <span class="passenger-count-output" id="infantCount"><?= $infants ?></span>
                                <button type="button" class="count-btn" onclick="changeCount('infant', 1)">+</button>
                              </div>
                            </div>

                            <!-- Travel Class -->
                            <div class="form-group mt-3">
                              <label class="travel-class-lbl">Choose Travel Class</label>
                              <select class="form-control" id="travelClass" onchange="updateCabinClass()">
                                <option value="ECONOMY" <?= $travel_class=="ECONOMY" ? "selected" : "" ?>>Economy</option>
                                <option value="BUSINESS" <?= $travel_class=="BUSINESS" ? "selected" : "" ?>>Business</option>
                                <option value="FIRST" <?= $travel_class=="FIRST" ? "selected" : "" ?>>First Class</option>
                              </select>
                              <input type="hidden" name="travel_class" id="cabin_class" value="<?= $travel_class ?>">
                            </div>

                            <div class="mt-3 text-end">
                              <button type="button" class="btn btn-primary btn-sm" onclick="confirmPassengers()">Confirm</button>
                            </div>
                          </div>
                      </div>
                      <!-- Total passenger and traveller updat  value -->

                    </div>
                    <div class="col-sm-12">
                      <div class="d-flex justify-content-md-end">
                        <button type="submit" name="submit" class="wrap-btn mx-auto mx-md-0 d-table"><i class="fa-solid fa-magnifying-glass"></i> Search Flights</button>
                      </div>  
                    </div>
                  </div>
                  

                  
                </form>

                <script>
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
                    
                </script>

              </div>
            </div>
        </div>
      </div>

      <!-- Start waiting loader modal-->
      
      <div class="w-100"></div>
      <!-- End Waiting loader modal -->

      <div class="col-md-3">
        <div class="package-filter-box pb-2 sticky-sidebar">
          
          <div class="pfb_padding">
            <h3 class="wrap-subhding pt-0">Airlines</h3>
            <ul class="pfb_checklist">
                <?php if (!empty($results["dictionaries"]["carriers"])): ?>
                    <?php foreach ($results["dictionaries"]["carriers"] as $code => $name): ?>
                        <?php 
                            $logoUrl = "https://static.tripcdn.com/packages/flight/airline-logo/latest/airline_logo/3x/" . strtolower($code) . ".webp";
                            $checkboxId = strtolower(str_replace(' ', '_', $name));
                        ?>
                        <li>
                            <input type="checkbox" class="pfb_checkbox" id="<?= $checkboxId ?>" value="<?= $code ?>">
                            <label for="<?= $checkboxId ?>">
                                <img src="<?= $logoUrl ?>" class="filter-airline-logo" alt="<?= $name ?>">
                                <?= htmlspecialchars($name) ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No airlines available.</li>
                <?php endif; ?>
            </ul>
            <!-- <ul class="pfb_checklist">
              <li>
                <input type="checkbox" name="" class="pfb_checkbox" id="delta_airlines">
                <label for="delta_airlines">
                  <img src="https://static.tripcdn.com/packages/flight/airline-logo/latest/airline_logo/3x/dl.webp" class="filter-airline-logo">
                  Delta Air Lines
                </label>
              </li>
              <li>
                <input type="checkbox" name="" class="pfb_checkbox" id="united_airlines">
                <label for="united_airlines">
                  <img src="https://static.tripcdn.com/packages/flight/airline-logo/latest/airline_logo/3x/ua.webp" class="filter-airline-logo">
                  United Airlines
                </label>
              </li>
              <li>
                <input type="checkbox" name="" class="pfb_checkbox" id="virgin_atlantic">
                <label for="virgin_atlantic">
                  <img src="https://static.tripcdn.com/packages/flight/airline-logo/latest/airline_logo/3x/va.webp" class="filter-airline-logo">
                  Virgin Atlantic
                </label>
              </li>
              <li>
                <input type="checkbox" name="" class="pfb_checkbox" id="frontier_airlines">
                <label for="frontier_airlines">
                  <img src="https://static.tripcdn.com/packages/flight/airline-logo/latest/airline_logo/3x/fa.webp" class="filter-airline-logo">
                  Frontier Airlines
                </label>
              </li>
              <li>
                <input type="checkbox" name="" class="pfb_checkbox" id="air_france">
                <label for="air_france">
                  <img src="https://static.tripcdn.com/packages/flight/airline-logo/latest/airline_logo/3x/af.webp" class="filter-airline-logo">
                  Air France
                </label>
              </li>
              <li>
                <input type="checkbox" name="" class="pfb_checkbox" id="air_canada">
                <label for="air_canada">
                  <img src="https://static.tripcdn.com/packages/flight/airline-logo/latest/airline_logo/3x/ac.webp" class="filter-airline-logo">
                  Air Canada
                </label>
              </li>
              <li>
                <input type="checkbox" name="" class="pfb_checkbox" id="air_canada">
                <label for="air_canada">
                  <img src="https://static.tripcdn.com/packages/flight/airline-logo/latest/airline_logo/3x/ba.webp" class="filter-airline-logo">
                  British Airways
                </label>
              </li>
              <li>
                <input type="checkbox" name="" class="pfb_checkbox" id="air_canada">
                <label for="air_canada">
                  <img src="https://static.tripcdn.com/packages/flight/airline-logo/latest/airline_logo/3x/qa.webp" class="filter-airline-logo">
                  Qatar Airways
                </label>
              </li>
            </ul> -->
            <hr>
            

            <h3 class="wrap-subhding pt-0">Recommended</h3>
            <ul class="pfb_checklist">
              <li>
                <input type="checkbox" name="" class="pfb_checkbox" id="checked_baggage_included">
                <label for="checked_baggage_included">Checked baggage included</label>
              </li>
              <li>
                <input type="checkbox" name="" class="pfb_checkbox" id="hide_budget_airlines">
                <label for="hide_budget_airlines">Hide budget airlines</label>
              </li>
              <li>
                <input type="checkbox" name="" class="pfb_checkbox" id="carry-on_baggage_included">
                <label for="carry-on_baggage_included">Carry-on baggage included</label>
              </li>
              <li>
                <input type="checkbox" name="" class="pfb_checkbox" id="hide_codeshare_flights">
                <label for="hide_codeshare_flights">Hide codeshare flights</label>
              </li>
            </ul>
            <hr>
            
            <h3 class="wrap-subhding pt-0">Stop</h3>
            <ul class="pfb_checklist">
              <li>
                <input type="checkbox" name="" class="pfb_checkbox" id="nonstop">
                <label for="nonstop">Nonstop</label>
              </li>
              <li>
                <input type="checkbox" name="" class="pfb_checkbox" id="1_stop">
                <label for="1_stop">1 Stop or fewer</label>
              </li>
              <li>
                <input type="checkbox" name="" class="pfb_checkbox" id="2_stop">
                <label for="2_stop">2 Stopr or fewer</label>
              </li>
            </ul>
          </div>  
        </div>
      </div>
      <div class="col-md-9">
        <?php if (isset($results["data"])): ?>
            <?php foreach ($results["data"] as $offer): ?>
            <div class="flight-result-box mb-3 p-3 border rounded">
                <div class="row">
                    <!-- Flight Details -->
                    <div class="col-md-9">
                        <?php foreach ($offer["itineraries"] as $itinIndex => $itinerary): ?>
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
                                $airlineName = $results["dictionaries"]["carriers"][$airlineCode] ?? $airlineCode;
                                $logoUrl = "https://static.tripcdn.com/packages/flight/airline-logo/latest/airline_logo/3x/" . strtolower($airlineCode) . ".webp";

                                $stops = count($segments) - 1;
                            ?>
                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <div class="d-flex d-md-block align-items-center gap-3 mb-2 mb-md-0">
                                        <img src="<?= $logoUrl ?>" width="50" alt="<?= $airlineCode ?>">
                                        <p class="flight-logo-name">
                                            <?= ucwords(strtolower($airlineName)) ?>
                                        </p>
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
                            <?php if (count($offer["itineraries"]) > 1 && $itinIndex == 0): ?>
                                <hr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <!-- Price & Select -->
                    <div class="col-md-3 d-lg-flex flex-column justify-content-center text-center">
                        <div class="d-flex d-mb-block flex-column justify-content-between justify-content-md-center text-md-center">
                            <div>
                                <a href="#" class="flight-price">
                                    <?= getCurrencySymbol($offer["price"]["currency"]) . " " . $offer["price"]["total"] ?>
                                </a>
                                <p class="wrap-prgh text-muted"><?= ucfirst($offer["type"]) ?> Ticket</p>
                            </div>
                            <?php 
                              $_SESSION['flights'][$offer['id']] = $offer; 
                            ?>
                            <a href="booking.php?offerId=<?= urlencode($offer['id']) ?>" class="wrap-btn bg-info mt-0">Select</a>
                        </div>
                    </div>
                </div>
            </div>
                <?php endforeach; ?>
            <?php else: ?>
            <div class="result alert alert-warning">
                ❌ No flights found.<br>
                <pre><?= htmlspecialchars($response) ?></pre>
            </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>



<!-- Modal for Stops -->
<div class="modal fade" id="stopsModal<?= $itineraryIndex.$offer["id"] ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Stopover Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
          <?php foreach ($itinerary["segments"] as $segIndex => $seg): ?>
            <?php if ($segIndex < count($itinerary["segments"]) - 1): ?>
              <?php
                $airlineCode = $seg["carrierCode"];
                $airlineName = $results["dictionaries"]["carriers"][$airlineCode] ?? $airlineCode;
                $arrivalAirport = $seg["arrival"]["iataCode"];
                $arrivalTime = date("h:i A", strtotime($seg["arrival"]["at"]));
              ?>
              <li class="list-group-item">
                ✈ Arrive at <strong><?= $arrivalAirport ?></strong> (<?= $arrivalTime ?>)  
                with <strong><?= $airlineName ?> (<?= $airlineCode ?>)</strong>
              </li>
            <?php endif; ?>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</div>

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
