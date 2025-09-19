<!DOCTYPE html>
<html lang="en">

<head>
  <title>Flights</title>

<?php include("header.php"); ?>

<section class="flight-banner">
  <img src="images/about-us2.jpg" alt="">
  <img src="images/about-us3.jpg" alt="">
  <img src="images/about-us.jpg" alt="">
  <div class="container-pos">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="flight-banner-hding text-center text-white">Explore the world together</h1>
          <h2 class="flight-banner-prgh  text-center text-white text-capitalize">Find awesome flights Packages</h2>
        </div>
        <div class="col-sm-12">
          <div class="flight-search-box">
            <ul class="nav nav-tabs flight-nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="flight-tab" data-bs-toggle="tab" data-bs-target="#flight" type="button" role="tab" aria-controls="flight" aria-selected="true"><i class="fa-solid fa-plane-departure"></i> Flights</button>
              </li>
              <!-- <li class="nav-item" role="presentation">
                <button class="nav-link" id="hotel-tab" data-bs-toggle="tab" data-bs-target="#hotel" type="button" role="tab" aria-controls="hotel" aria-selected="false"><i class="fa-solid fa-hotel"></i> Hotel</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="tour-tab" data-bs-toggle="tab" data-bs-target="#tour" type="button" role="tab" aria-controls="tour" aria-selected="false"><i class="fa-solid fa-globe"></i> Tour</button>
              </li> -->
            </ul>
            <div class="tab-content mt-4" id="myTabContent">
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
              <div class="tab-pane fade" id="hotel" role="tabpanel" aria-labelledby="hotel-tab">Hotel</div>
              <div class="tab-pane fade" id="tour" role="tabpanel" aria-labelledby="tour-tab">Tour</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  
</section>

<!-- Flight search result-->
<section class="flight-result-bg">
  <div class="container">
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-12">
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
                  <a href="united-airlines-LAS-CDG.php" class="flight-price">$1013</a>
                  <p class="wrap-prgh text-muted">Round-trip</p>
                </div>  
                <a href="united-airlines-LAS-CDG.php" class="wrap-btn bg-info mt-0">Select</a>
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
                  <a href="delta-airline-LAS-CDG.php" class="flight-price">$1013</a>
                  <p class="wrap-prgh text-muted">Round-trip</p>
                </div>  
                <a href="delta-airline-LAS-CDG.php" class="wrap-btn bg-info mt-0">Select</a>
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
                  <a href="virgin-atlantic-LAS-CDG.php" class="flight-price">$1010</a>
                  <p class="wrap-prgh text-muted">Round-trip</p>
                </div>  
                <a href="virgin-atlantic-LAS-CDG.php" class="wrap-btn bg-info mt-0">Select</a>
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
                <a href="delta-airline-JFK-WLG.php" class="flight-price">$704</a>
                <a href="delta-airline-JFK-WLG.php" class="wrap-btn bg-info mt-0">Select</a>
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
                <a href="frontier-airlines-JFK-WLG.php" class="flight-price">$667</a>
                <a href="frontier-airlines-JFK-WLG.php" class="wrap-btn bg-info mt-0">Select</a>
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
                        <span class="text-uppercase">Bom</span> 
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
                <a href="indigo-Del-Bom.php" class="flight-price">$55</a>
                <a href="indigo-Del-Bom.php" class="wrap-btn bg-info mt-0">Select</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="container pt-5">
    <div class="row">
        <div class="col-sm-12">
            <h2 class="wrap-hding pb-4">Top Destinations</h2>
        </div>
        <div class="owl-carousel owl-theme" id="top-destination">
            <div class="col-md-12">
                <div class="destination-box">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="destination-img">
                                <img src="images/london.jpg" alt="">
                            </div>
                        </div>
                        <div class="col-md-7 ps-md-0">
                            <div class="p-2 pe-3">
                                <h5 class="destination-price">$599<span>/Person</span></h5>
                                <ul class="destination-route">
                                    <li>
                                        <p class="dest-title">From</p>
                                        <p class="dest-name">JFK</p>
                                    </li>
                                    <li>
                                        <div class="destination-process">
                                            <span><i class="fas fa-plane"></i></span>
                                        </div>
                                        <p class="dest-time">7h 5m</p>
                                    </li>
                                    <li>
                                        <p class="dest-title">To</p>
                                        <p class="dest-name">LHR</p>
                                    </li>
                                </ul>
                                <p class="desination-class">Economy</p>
                                <p class="destination-date">18 Sep 2025</p>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="destination-box">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="destination-img">
                                <img src="images/tokyo2.jpg" alt="">
                            </div>
                        </div>
                        <div class="col-md-7 ps-md-0">
                            <div class="p-2 pe-3">
                                <h5 class="destination-price">$799<span>/Person</span></h5>
                                <ul class="destination-route">
                                    <li>
                                        <p class="dest-title">From</p>
                                        <p class="dest-name">LAX</p>
                                    </li>
                                    <li>
                                        <div class="destination-process">
                                            <span><i class="fas fa-plane"></i></span>
                                        </div>
                                        <p class="dest-time">11h 30m</p>
                                    </li>
                                    <li>
                                        <p class="dest-title">To</p>
                                        <p class="dest-name">HND</p>
                                    </li>
                                </ul>
                                <p class="desination-class">Economy</p>
                                <p class="destination-date">25 Oct 2025</p>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="destination-box">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="destination-img">
                                <img src="images/paris.jpg" alt="">
                            </div>
                        </div>
                        <div class="col-md-7 ps-md-0">
                            <div class="p-2 pe-3">
                                <h5 class="destination-price">$685<span>/Person</span></h5>
                                <ul class="destination-route">
                                    <li>
                                        <p class="dest-title">From</p>
                                        <p class="dest-name">ORD</p>
                                    </li>
                                    <li>
                                        <div class="destination-process">
                                            <span><i class="fas fa-plane"></i></span>
                                        </div>
                                        <p class="dest-time">8h 10m</p>
                                    </li>
                                    <li>
                                        <p class="dest-title">To</p>
                                        <p class="dest-name">CDG</p>
                                    </li>
                                </ul>
                                <p class="desination-class">Economy</p>
                                <p class="destination-date">3 Nov 2025</p>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="destination-box">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="destination-img">
                                <img src="images/sydney.jpg" alt="">
                            </div>
                        </div>
                        <div class="col-md-7 ps-md-0">
                            <div class="p-2 pe-3">
                                <h5 class="destination-price">$1,050<span>/Person</span></h5>
                                <ul class="destination-route">
                                    <li>
                                        <p class="dest-title">From</p>
                                        <p class="dest-name">SFO</p>
                                    </li>
                                    <li>
                                        <div class="destination-process">
                                            <span><i class="fas fa-plane"></i></span>
                                        </div>
                                        <p class="dest-time">14h 45m</p>
                                    </li>
                                    <li>
                                        <p class="dest-title">To</p>
                                        <p class="dest-name">SYD</p>
                                    </li>
                                </ul>
                                <p class="desination-class">Economy</p>
                                <p class="destination-date">15 Nov 2025</p>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="destination-box">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="destination-img">
                                <img src="images/madrid.jpg" alt="">
                            </div>
                        </div>
                        <div class="col-md-7 ps-md-0">
                            <div class="p-2 pe-3">
                                <h5 class="destination-price">$640<span>/Person</span></h5>
                                <ul class="destination-route">
                                    <li>
                                        <p class="dest-title">From</p>
                                        <p class="dest-name">MIA</p>
                                    </li>
                                    <li>
                                        <div class="destination-process">
                                            <span><i class="fas fa-plane"></i></span>
                                        </div>
                                        <p class="dest-time">8h 40m</p>
                                    </li>
                                    <li>
                                        <p class="dest-title">To</p>
                                        <p class="dest-name">MAD</p>
                                    </li>
                                </ul>
                                <p class="desination-class">Economy</p>
                                <p class="destination-date">8 Dec 2025</p>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="destination-box">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="destination-img">
                                <img src="images/dubai.jpg" alt="">
                            </div>
                        </div>
                        <div class="col-md-7 ps-md-0">
                            <div class="p-2 pe-3">
                                <h5 class="destination-price">$920<span>/Person</span></h5>
                                <ul class="destination-route">
                                    <li>
                                        <p class="dest-title">From</p>
                                        <p class="dest-name">DFW</p>
                                    </li>
                                    <li>
                                        <div class="destination-process">
                                            <span><i class="fas fa-plane"></i></span>
                                        </div>
                                        <p class="dest-time">14h 20m</p>
                                    </li>
                                    <li>
                                        <p class="dest-title">To</p>
                                        <p class="dest-name">DXB</p>
                                    </li>
                                </ul>
                                <p class="desination-class">Economy</p>
                                <p class="destination-date">20 Dec 2025</p>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="destination-box">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="destination-img">
                                <img src="images/spain.jpg" alt="">
                            </div>
                        </div>
                        <div class="col-md-7 ps-md-0">
                            <div class="p-2 pe-3">
                                <h5 class="destination-price">$643<span>/Person</span></h5>
                                <ul class="destination-route">
                                    <li>
                                        <p class="dest-title">From</p>
                                        <p class="dest-name">LAX</p>
                                    </li>
                                    <li>
                                        <div class="destination-process">
                                            <span><i class="fas fa-plane"></i></span>
                                        </div>
                                        <p class="dest-time">13h:10m</p>
                                    </li>
                                    <li>
                                        <p class="dest-title">To</p>
                                        <p class="dest-name">BCN</p>
                                    </li>
                                </ul>
                                <p class="desination-class">Economy</p>
                                <p class="destination-date">8 Jan 2026</p>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="destination-box">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="destination-img">
                                <img src="images/greece.jpg" alt="">
                            </div>
                        </div>
                        <div class="col-md-7 ps-md-0">
                            <div class="p-2 pe-3">
                                <h5 class="destination-price">$290<span>/Person</span></h5>
                                <ul class="destination-route">
                                    <li>
                                        <p class="dest-title">From</p>
                                        <p class="dest-name">MIA</p>
                                    </li>
                                    <li>
                                        <div class="destination-process">
                                            <span><i class="fas fa-plane"></i></span>
                                        </div>
                                        <p class="dest-time">15h:17m</p>
                                    </li>
                                    <li>
                                        <p class="dest-title">To</p>
                                        <p class="dest-name">ATH</p>
                                    </li>
                                </ul>
                                <p class="desination-class">Economy</p>
                                <p class="destination-date"> 22 Jan 2026</p>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</section>

<section class="container py-5">
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
 