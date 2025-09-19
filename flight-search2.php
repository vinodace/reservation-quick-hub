<?php
// Check if form data was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $leaving_from = htmlspecialchars($_POST['from']);
    $going_to = htmlspecialchars($_POST['to']);
    $departure_date = htmlspecialchars($_POST['departDate']);
    //$return_date = htmlspecialchars($_POST['returndate']);
    $return_date = isset($_POST['returnDate']) ? htmlspecialchars($_POST['returnDate']) : '';
    $passenger = htmlspecialchars($_POST['passenger']   ?? ''); // "3 Passengers - Economy"

    // Optional: get structured values too
    $adults        = (int)($_POST['adults']      ?? 1);
    $children      = (int)($_POST['children']    ?? 0);
    $infants       = (int)($_POST['infants']     ?? 0);
    $cabin_class   = htmlspecialchars($_POST['cabin_class'] ?? 'Economy');

} else {
    // Redirect back if page is accessed directly
    header("Location: index.php");
    exit();
}
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
               
                <form id="flightForm" action="flight-search.php" method="POST">
                  <div class="row">
                    <div class="col-sm-12">
                      <!-- Trip Type -->
                      <div class="form-group">
                          <label><input type="radio" class="choose-trip-type" name="tripType" value="oneway" checked> One Way</label>
                          <label><input type="radio" class="choose-trip-type" name="tripType" value="roundtrip"> Round Trip</label>
                          <!-- <label><input type="radio" class="choose-trip-type" name="tripType" value="multicity"> Multi-City</label> -->
                      </div>    
                    </div>
                    <div class="col-md-5">
                      <div class="row">
                        <div class="col-sm-6 col-md-6 pe-md-0">
                          <div class="form-group" id="citySection">
                            <label class="filter-lbl">Leaving From</label>
                            <input type="text" class="filter-field from_oneway field-right-radius-0" name="from" placeholder="From" required>
                          </div> 
                        </div>
                        <div class="col-sm-6 col-md-6 px-md-0">
                          <div class="form-group" id="citySection">
                            <label class="filter-lbl">Going To</label>
                            <input type="text" class="filter-field to_oneway field-radius-0" name="to" placeholder="To" required>
                          </div>
                        </div>    
                      </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-2 px-md-0">
                      <div class="form-group">
                         <label class="filter-lbl">Departure Date</label>
                          <input type="text" class="filter-field field-radius-0" id="departDate" name="departDate" placeholder="Select date" required>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-2 px-md-0">
                      <div class="form-group">   
                          <label class="filter-lbl">Return Date</label> 
                          <input type="text" class="filter-field field-radius-0" name="returnDate" id="returnDate" placeholder="Select date">
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3 ps-md-0">
                      <div class="form-group">
                        <label class="filter-lbl">Passenger & Class</label>
                        <div class="filter-field field-left-radius-0" id="passengerClassDisplay">1 Adult - Economy</div>
                        <input type="hidden" name="passenger" id="passenger"> 

                        <div class="dropdown-panel" id="passengerDropdown">
                            <!-- Passenger Counters -->
                            <div class="traveller-row">
                                <input type="hidden" name="adults" id="adults" value="1">
                                <span>Adults <span>(12y +)</span></span>
                                <div>
                                    <button type="button" class="count-btn" onclick="changeCount('adult', -1)">-</button>
                                    <span class="passenger-count-output" id="adultCount">1</span>
                                    <button type="button" class="count-btn" onclick="changeCount('adult', 1)">+</button>
                                </div>
                            </div>
                            <div class="traveller-row">
                                <input type="hidden" name="children" id="children" value="0">
                                <span>Children <span>(2y - 12y )</span></span>
                                <div>
                                    <button type="button" class="count-btn" onclick="changeCount('child', -1)">-</button>
                                    <span class="passenger-count-output" id="childCount">0</span>
                                    <button type="button" class="count-btn" onclick="changeCount('child', 1)">+</button>
                                </div>
                            </div>
                            <div class="traveller-row">
                                <input type="hidden" name="infants" id="infants" value="0">
                                <span>Infants <span>(Below 2y)</span></span>
                                <div>
                                    <button type="button" class="count-btn" onclick="changeCount('infant', -1)">-</button>
                                    <span class="passenger-count-output" id="infantCount">0</span>
                                    <button type="button" class="count-btn" onclick="changeCount('infant', 1)">+</button>
                                </div>
                            </div>

                            <!-- Class Selection -->
                            <div class="form-group mt-3">
                                <label class="travel-class-lbl">Choose Travel Class</label>
                                <select class="form-control" id="travelClass" onchange="updateDisplay()">
                                    <option value="Economy">Economy</option>
                                    <option value="Business">Business</option>
                                    <option value="First Class">First Class</option>
                                </select>
                                <input type="hidden" name="cabin_class" id="cabin_class" value="Economy">
                            </div>

                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="d-flex justify-content-md-end">
                        <button type="submit" name="submit" class="wrap-btn mx-auto mx-md-0 d-table"><i class="fa-solid fa-magnifying-glass"></i> Search Flights</button>
                      </div>  
                    </div>
                  </div>
                </form>

                <script>
                    const tripTypeRadios = document.querySelectorAll('input[name="tripType"]');
                    const returnDateInput = document.getElementById('returnDate');

                    tripTypeRadios.forEach(radio => {
                        radio.addEventListener('change', () => {
                            if (radio.value === 'roundtrip') {
                                returnDateInput.disabled = false; // Enable field
                            } else {
                                returnDateInput.disabled = true;  // Disable field
                                returnDateInput.value = '';       // Optional: clear value
                            }
                        });
                    });

                    // Initial state (in case page loads with non-roundtrip)
                    if (document.querySelector('input[name="tripType"]:checked').value !== 'roundtrip') {
                        returnDateInput.disabled = true;
                    }

                    
                </script>

              </div>
            </div>
        </div>
      </div>

      <!-- Start waiting loader modal-->
      <div class="col-sm-12 col-md-8 mt-4 mb-5" id="waiting-loader">
        <div class="search-form-box">
          <div class="d-flex justify-content-center align-items-center gap-4 pb-4">
            <div class="w-50">
              <p class="search-form-title text-center">Leaving From</p>
              <h1 class="search-form-name text-center"><?php echo $leaving_from; ?></h1>
            </div>  
            <h1 class="search-form-to text-center"> TO</h1>
            <div class="w-50">
              <p class="search-form-title text-center">Going To</p>
              <h1 class="search-form-name text-center"><?php echo $going_to; ?></h1>
            </div>  
          </div>
          <!-- <h2 class="search-form-hding"><?php //echo $passenger; ?></h2> -->
          <ul class="search-form-list">
            <li>Departure Date: <?php echo $departure_date; ?></li>
            <?php 
              if (!empty($return_date)) {
                  echo "<li>Return Date: {$return_date}</li>";
              }
            ?>
            <!-- <li>Return Date: <?php echo $return_date; ?></li> -->
          </ul>
          <p class="wrap-prgh text-center pt-2">Prices shown are per guest, inclusive of taxes and port fees. Additional baggage fees may apply.</p>
          <h2 class="wait-hding pt-4">Please Wait...</h2>
          <p class="wrap-prgh text-center fw-bold">We are Searching Airline Fares For You From Over 450 + Airlines</p>

          <img src="images/loader.gif" alt="loader" class="search-form-loader">
          <p class="wrap-prgh text-center">Still searching... Have questions? Our experts are just a call away</p>
          <a href="tel:<?php echo $phone; ?>" class="search-form-callbtn"><i class="fa-solid fa-phone-volume"></i> Call Us <?php echo $phone; ?></a>
        </div>
        
      </div>
      <div class="w-100"></div>
      <!-- End Waiting loader modal -->

      <div class="col-md-3 show-data">
        <div class="package-filter-box pb-2 sticky-sidebar">
          
          <div class="pfb_padding">
            <h3 class="wrap-subhding pt-0">Airlines</h3>
            <ul class="pfb_checklist">
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
            </ul>
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
      <div class="col-md-9 show-data">
        <div class="flight-result-box">
          <div class="row">
            <div class="col-md-9">
              <div class="row">
                <div class="col-auto">
                  <div class="d-flex align-items-center gap-3 mb-2 mb-md-0">
                    <img src="https://static.tripcdn.com/packages/flight/airline-logo/latest/airline_logo/3x/ua.webp" class="flight-result-logo">
                    <p class="flight-logo-name  d-block d-md-none">United Airlines</p>
                  </div>  
                </div>
                <div class="col-12 col-md">
                  <div class="row">
                    <div class="col-4">
                      <h4 class="flight-time">10:48 AM</h4>
                      <p class="flight-location">
                        <span class="text-uppercase">LAS </span> 
                        <span class="d-none d-md-inline">(Harry Reid International Airport )</span> 
                        <span class="text-primary">T3</span>
                      </p>
                    </div>
                    <div class="col-4">
                      <div class="flight-result-duration">
                        13h 32m
                        <div class="flight-duration-line">
                          <div class="step-1"></div>
                          <div class="step-2"></div>
                        </div>
                        1h 28m in Chicago
                      </div>
                    </div>
                    <div class="col-4">
                      <h4 class="flight-time">9:20 AM</h4>
                      <p class="flight-location">
                        <span class="text-uppercase">CDG </span> 
                        <span class="d-none d-md-inline">(Paris Charles de Gaulle Airport )</span> 
                        <span class="text-primary">T2</span> 
                      </p>
                    </div>
                  </div>
                  
                </div>
                <div class="col-sm-12 d-none d-md-block">
                  <p class="flight-logo-name">United Airlines</p>
                </div>
              </div>  
            </div>
            <div class="col-md-3">
              <div class="flight-result-price-area">
                <div>
                  <a href="#" class="flight-price">$1013</a>
                  <p class="wrap-prgh text-muted">Round-trip</p>
                </div>  
                <a href="#" class="wrap-btn bg-info mt-0">Select</a>
              </div>
            </div>
          </div>
        </div>

        <div class="flight-result-box">
          <div class="row">
            <div class="col-md-9">
              <div class="row">
                <div class="col-auto">
                  <div class="d-flex align-items-center gap-3 mb-2 mb-md-0">
                    <img src="https://static.tripcdn.com/packages/flight/airline-logo/latest/airline_logo/3x/dl.webp" class="flight-result-logo">
                    <p class="flight-logo-name  d-block d-md-none">Delta Air Lines</p>
                  </div>  
                </div>
                <div class="col-12 col-md">
                  <div class="row">
                    <div class="col-4">
                      <h4 class="flight-time">9:50 AM</h4>
                      <p class="flight-location">
                        <span class="text-uppercase">LAS </span> 
                        <span class="d-none d-md-inline">(Harry Reid International Airport )</span> 
                        <span class="text-primary">T1</span>
                      </p>
                    </div>
                    <div class="col-4">
                      <div class="flight-result-duration">
                        13h
                        <div class="flight-duration-line">
                          <div class="step-1"></div>
                          <div class="step-2"></div>
                        </div>
                        1h 8m in Detroit
                      </div>
                    </div>
                    <div class="col-4">
                      <h4 class="flight-time">7:50 AM</h4>
                      <p class="flight-location">
                        <span class="text-uppercase">CDG </span> 
                        <span class="d-none d-md-inline">(Paris Charles de Gaulle Airport )</span> 
                        <span class="text-primary">T2</span> 
                      </p>
                    </div>
                  </div>
                  
                </div>
                <div class="col-sm-12 d-none d-md-block">
                  <p class="flight-logo-name">Delta Air Lines</p>
                </div>
              </div>  
            </div>
            <div class="col-md-3">
              <div class="flight-result-price-area">
                <div>
                  <a href="#" class="flight-price">$1013</a>
                  <p class="wrap-prgh text-muted">Round-trip</p>
                </div>  
                <a href="#" class="wrap-btn bg-info mt-0">Select</a>
              </div>
            </div>
          </div>
        </div>

        <div class="flight-result-box">
          <div class="row">
            <div class="col-md-9">
              <div class="row">
                <div class="col-auto">
                  <div class="d-flex align-items-center gap-3 mb-2 mb-md-0">
                    <img src="https://static.tripcdn.com/packages/flight/airline-logo/latest/airline_logo/3x/vs.webp" class="flight-result-logo">
                    <p class="flight-logo-name  d-block d-md-none">Virgin Atlantic (Operated by Delta Air Lines)</p>
                  </div>  
                </div>
                <div class="col-12 col-md">
                  <div class="row">
                    <div class="col-4">
                      <h4 class="flight-time">1:35 PM</h4>
                      <p class="flight-location">
                        <span class="text-uppercase">LAS </span> 
                        <span class="d-none d-md-inline">(Harry Reid International Airport )</span> 
                        <span class="text-primary">T1</span>
                      </p>
                    </div>
                    <div class="col-4">
                      <div class="flight-result-duration">
                        14h 30m
                        <div class="flight-duration-line">
                          <div class="step-1"></div>
                          <div class="step-2"></div>
                        </div>
                        2h 27m in Los Angeles
                      </div>
                    </div>
                    <div class="col-4">
                      <h4 class="flight-time">1:05 PM</h4>
                      <p class="flight-location">
                        <span class="text-uppercase">CDG </span> 
                        <span class="d-none d-md-inline">(Paris Charles de Gaulle Airport )</span> 
                        <span class="text-primary">T2</span> 
                      </p>
                    </div>
                  </div>
                  
                </div>
                <div class="col-sm-12 d-none d-md-block">
                  <p class="flight-logo-name">Virgin Atlantic (Operated by Delta Air Lines)</p>
                </div>
              </div>  
            </div>
            <div class="col-md-3">
              <div class="flight-result-price-area">
                <div>
                  <a href="#" class="flight-price">$1010</a>
                  <p class="wrap-prgh text-muted">Round-trip</p>
                </div>  
                <a href="#" class="wrap-btn bg-info mt-0">Select</a>
              </div>
            </div>
          </div>
        </div>

        <div class="flight-result-box">
          <div class="row">
            <div class="col-md-9">
              <div class="row">
                <div class="col-auto">
                  <div class="d-flex align-items-center gap-3 mb-2 mb-md-0">
                    <img src="https://static.tripcdn.com/packages/flight/airline-logo/latest/airline_logo/3x/dl.webp" class="flight-result-logo">
                    <p class="flight-logo-name  d-block d-md-none">Delta Air Lines, Fiji Airways</p>
                  </div>  
                </div>
                <div class="col-12 col-md">
                  <div class="row">
                    <div class="col-4">
                      <h4 class="flight-time">8:30 AM</h4>
                      <p class="flight-location">
                        <span class="text-uppercase">JFK</span> 
                        <span class="d-none d-md-inline">(John F. Kennedy International Airport)</span> 
                        <span class="text-primary">T4</span>
                      </p>
                    </div>
                    <div class="col-4">
                      <div class="flight-result-duration">
                        38h 40m
                        <div class="flight-duration-line">
                          <div class="step-1"></div>
                          <div class="step-2"></div>
                        </div>
                        2 Stops in Dallas, Nadi
                      </div>
                    </div>
                    <div class="col-4">
                      <h4 class="flight-time">3:10 PM</h4>
                      <p class="flight-location">
                        <span class="text-uppercase">WLG</span> 
                        <span class="d-none d-md-inline">(Wellington International Airport)</span> 
                        <span class="text-primary">T2</span> 
                      </p>
                    </div>
                  </div>
                  
                </div>
                <div class="col-sm-12 d-none d-md-block">
                  <p class="flight-logo-name">Delta Air Lines, Fiji Airways</p>
                </div>
              </div>  
            </div>
            <div class="col-md-3">
              <div class="flight-result-price-area">
                <a href="#" class="flight-price">$704</a>
                <a href="#" class="wrap-btn bg-info mt-0">Select</a>
              </div>
            </div>
          </div>
        </div>

        <div class="flight-result-box">
          <div class="row">
            <div class="col-md-9">
              <div class="row">
                <div class="col-auto">
                  <div class="d-flex align-items-center gap-3 mb-2 mb-md-0">
                    <img src="https://static.tripcdn.com/packages/flight/airline-logo/latest/airline_logo/3x/f9.webp" class="flight-result-logo">
                    <p class="flight-logo-name  d-block d-md-none">Frontier Airlines, Fiji Airways</p>
                  </div>  
                  
                </div>
                <div class="col-12 col-md">  
                  <div class="row">
                    <div class="col-4">
                      <h4 class="flight-time">12:30 PM</h4>
                      <p class="flight-location">
                        <span class="text-uppercase">JFK</span> 
                        <span class="d-none d-md-inline">(John F. Kennedy International Airport)</span> 
                        <span class="text-primary">T4</span>
                      </p>
                    </div>
                    <div class="col-4">
                      <div class="flight-result-duration">
                        34h 40m
                        <div class="flight-duration-line">
                          <div class="step-1"></div>
                          <div class="step-2"></div>
                        </div>
                        2 Stops in Dallas, Nadi
                      </div>
                    </div>
                    <div class="col-4">
                      <h4 class="flight-time">3:10 PM</h4>
                      <p class="flight-location">
                        <span class="text-uppercase">WLG</span> 
                        <span class="d-none d-md-inline">(Wellington International Airport)</span> 
                        <span class="text-primary">T2</span> 
                      </p>
                    </div>
                  </div>
                  
                </div>
                <div class="col-sm-12 d-none d-md-block">
                  <p class="flight-logo-name">Frontier Airlines, Fiji Airways</p>
                </div>
              </div>  
            </div>
            <div class="col-md-3">
              <div class="flight-result-price-area">
                <a href="#" class="flight-price">$667</a>
                <a href="#" class="wrap-btn bg-info mt-0">Select</a>
              </div>
            </div>
          </div>
        </div>

        <div class="flight-result-box">
          <div class="row">
            <div class="col-md-9">
              <div class="row">
                <div class="col-auto">
                  <div class="d-flex align-items-center gap-3 mb-2 mb-md-0">
                    <img src="https://static.tripcdn.com/packages/flight/airline-logo/latest/airline_logo/3x/6e.webp" class="flight-result-logo">
                    <p class="flight-logo-name  d-block d-md-none">IndiGo</p>
                  </div>  
                </div>
                <div class="col-12 col-md">  
                  <div class="row">
                    <div class="col-4">
                      <h4 class="flight-time">9:00 am</h4>
                      <p class="flight-location">
                        <span class="text-uppercase">Del</span> 
                        <span class="d-none d-md-inline">(Indira Gandhi International Airport )</span> 
                        <span class="text-primary">T1</span>
                      </p>
                    </div>
                    <div class="col-4">
                      <div class="flight-result-duration">
                        2h 35m
                        <div class="flight-duration-line"></div>
                        Nonstop
                      </div>
                    </div>
                    <div class="col-4">
                      <h4 class="flight-time">11:35 AM</h4>
                      <p class="flight-location">
                        <span class="text-uppercase">bom</span> 
                        <span class="d-none d-md-inline">(Chhatrapati Shivaji Maharaj International Airport)</span> 
                        <span class="text-primary">T2</span> 
                      </p>
                    </div>
                  </div>
                  
                </div>
                <div class="col-sm-12 d-none d-md-block">
                  <p class="flight-logo-name">IndiGo</p>
                </div>
              </div>  
            </div>
            <div class="col-md-3">
              <div class="flight-result-price-area">
                <a href="#" class="flight-price">$55</a>
                <a href="#" class="wrap-btn bg-info mt-0">Select</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="container py-5 show-data">
  <div class="row">
    <div class="col-sm-12">
      <div class="d-flex align-items-center justify-content-between  pb-4">
        <h2 class="wrap-hding pt-0">Popular Trip</h2>
        <a href="packages.php" class="wrap-prgh pb-0 mb-0">View All</a>
      </div>  
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="top-tour">
        <div class="top-tour-img">
          <img src="images/tour-1.jpg" alt="">
          <div class="tour-pkg-pos">
            <div class="d-flex justify-content-between align-items-center">
              <p class="tour-duration">6N/7D</p>
              <p class="tour-price">From <span>$750</span></p>
            </div>
          </div>  
        </div>
        <div class="top-tour-textarea">
          <p class="wrap-prgh pb-1">Switzerland</p>
          <h4 class="wrap-title"> Swiss Alps Adventure</h4>
        </div>  
      </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="top-tour">
        <div class="top-tour-img">
          <img src="images/tour-2.jpg" alt="">
          <div class="tour-pkg-pos">
            <div class="d-flex justify-content-between align-items-center">
              <p class="tour-duration">4N/5D</p>
              <p class="tour-price">From <span>$1250</span></p>
            </div>
          </div> 
        </div>
        <div class="top-tour-textarea">
          <p class="wrap-prgh pb-1">France </p>
          <h4 class="wrap-title"> Paris Romantic Escape</h4>
        </div>  
      </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="top-tour">
        <div class="top-tour-img">
          <img src="images/tour-3.jpg" alt="">
          <div class="tour-pkg-pos">
            <div class="d-flex justify-content-between align-items-center">
              <p class="tour-duration">5N/6D</p>
              <p class="tour-price">From <span>$900</span></p>
            </div>
          </div>
        </div>
        <div class="top-tour-textarea">
          <p class="wrap-prgh pb-1">Indonesia </p>
          <h4 class="wrap-title"> Bali Beach Bliss</h4>
        </div>  
      </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="top-tour">
        <div class="top-tour-img">
          <img src="images/tour-4.jpg" alt="">
          <div class="tour-pkg-pos">
            <div class="d-flex justify-content-between align-items-center">
              <p class="tour-duration">3N/4D</p>
              <p class="tour-price">From <span>$785</span></p>
            </div>
          </div> 
        </div>
        <div class="top-tour-textarea">
          <p class="wrap-prgh pb-1">United Arab Emirates</p>
          <h4 class="wrap-title"> Dubai Luxury Getaway</h4>
        </div>  
      </div>
    </div>

  </div>
</section> 

<div class="modal fade airline-modal-design" id="airline-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <a href="tel:<?php echo $phone; ?>" class="modal-close">&times;</a>  
        <h1 class="modal-header-hding">Airline Sales Price </h1>
        <p class="modal-header-subhding">Due to Airline Policies, This Deal is Call-Only. <br> Hurry, offer ends in</p>
      </div>
      <div class="modal-body">
        <div class="modal-end-timer">End In <span id="countdown"></span></div>
        <h2 class="modal-offer-text">Call Now & Save up to <span>25% Off</span> on Exclusive Deals</h2>
        <div class="d-flex justify-content-center align-items-md-center gap-4 pb-3">
          <div class="w-50">
            <h1 class="modal-search-form-name text-center"><?php echo $leaving_from; ?></h1>
          </div>  
          <h1 class="modal-search-form-icon text-center"> <i class="fa-solid fa-arrow-right-long"></i></h1>
          <div class="w-50">
            <h1 class="modal-search-form-name text-center"><?php echo $going_to; ?></h1>
          </div>  
        </div>
        <div class="modal-deal-box">
          <div class="row">
            <div class="col-md-8">
              <h3 class="modal-deal-name"><?php echo $going_to; ?></h3>
              <p class="modal-deal-text"><?php echo $passenger; ?></p>
              <ul class="modal-search-form-list">
                <li>Adults: <?php echo $adults; ?></li>
                <li>Child: <?php echo $children; ?></li>
                <li>infants: <?php echo $infants; ?></li>
              </ul>
              <ul class="modal-search-form-list">
                <li>Departure Date: <?php echo $departure_date; ?></li>
              </ul>
            </div>
            <div class="col-md-4">
              <div class="modal-price-deal">
                <p class="modal-deal-text">Phone Deal Only*</p>
                <h1 class="wrap-hding pt-1 main-color">$560</h1>
                <p class="modal-price-per-person">Price Per Adult</p>
              </div>
            </div>
          </div>
        </div>
        <a href="tel:<?php echo $phone; ?>" class="modal-call-btn"><i class="fa-solid fa-phone-volume"></i> Call Us <?php echo $phone; ?></a>
        <p class="modal-note">*Note: All displayed prices are based on searches made in the last 24 hours and are subject to change. <br> Fares are not guaranteed until the ticket is issued.</p>
      </div>
    </div>
  </div>
</div>



<?php include("footer.php"); ?>

<!-- Sepreate Visible Adult, child and infant -->
<!-- <script>
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
            updateDisplay();
        }
    }

    // Update visible box text
    function updateDisplay() {
        const travelClass = document.getElementById('travelClass').value;
        let passengerText = [];
        if (counts.adult > 0) passengerText.push(`${counts.adult} Adult${counts.adult > 1 ? 's' : ''}`);
        if (counts.child > 0) passengerText.push(`${counts.child} Child${counts.child > 1 ? 'ren' : ''}`);
        if (counts.infant > 0) passengerText.push(`${counts.infant} Infant${counts.infant > 1 ? 's' : ''}`);
        displayBox.textContent = `${passengerText.join(', ')} - ${travelClass}`;
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.form-group')) {
            dropdownPanel.style.display = 'none';
        }
    });
</script> -->

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
            updateDisplay();
        }
    }

    // Update visible box text (only total passengers) + hidden inputs
    function updateDisplay() {
        const travelClass = document.getElementById('travelClass').value;
        const totalPassengers = counts.adult + counts.child + counts.infant;
        const passengerLabel = totalPassengers === 1 ? 'Passenger' : 'Passengers';
        const summary = `${totalPassengers} ${passengerLabel} - ${travelClass}`;

        // Visible text
        displayBox.textContent = summary;

        // Hidden fields for POST
        document.getElementById('passenger').value   = summary;
        document.getElementById('adults').value      = counts.adult;
        document.getElementById('children').value    = counts.child;
        document.getElementById('infants').value     = counts.infant;
        document.getElementById('cabin_class').value = travelClass;
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.form-group')) {
            dropdownPanel.style.display = 'none';
        }
    });

    // Initialize display + hidden fields
    updateDisplay();
</script>


<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="js/countries.js"></script>
<script>
$(function() {
    // Departure date picker
    $("#departDate").datepicker({
        dateFormat: "dd-M-yy",
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
        dateFormat: "dd-M-yy",
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
   setTimeout(function() {
      // Hide the loader
      document.getElementById("waiting-loader").style.display = "none";

      // Show all elements with class "show-data"
      document.querySelectorAll(".show-data").forEach(function(el) {
          el.style.display = "block";
      });
  }, 5000); // 5 seconds
 </script>

 <script>
  // countdown timer

  let timeLeft = 1 * 60; // 15 minutes in seconds

  const timerElement = document.getElementById('countdown'); // where you show time

  const countdown = setInterval(function() {
      let minutes = Math.floor(timeLeft / 60);
      let seconds = timeLeft % 60;
      seconds = seconds < 10 ? '0' + seconds : seconds;
      timerElement.textContent = `${minutes}:${seconds}`;
      
      if (timeLeft <= 0) {
          clearInterval(countdown);
          // custom modal hide
          //document.getElementById('airline-modal').style.display = 'none'; 

          // Bootstrap modal hide
          //$('#airline-modal').modal('hide'); 
          
      }
      timeLeft--;
  }, 1000);

  // Default modal show
  /* window.addEventListener('load', function() {
      var myModal = new bootstrap.Modal(document.getElementById('airline-modal'));
      myModal.show();
  });*/

  // modal show after 5 mint
  setTimeout(function() {
      // document.getElementById('airline-modal').style.display = 'none';
      $('#airline-modal').modal('show'); 
  }, 5000); // 5 Second


 </script>
