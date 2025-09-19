<!DOCTYPE html>
<html lang="en">

<head>
  <title>Flights</title>

<?php include("header.php"); ?>



<!-- Flight search result-->
<section class="flight-result-bg pt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
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
              </div>
            </div>
          </div>
        </div>

      </div>
      <?php include("booking-airline-form.php"); ?>  
    </div>
  </div>
</section>




<?php include("footer.php"); ?>

