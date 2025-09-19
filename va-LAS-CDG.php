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

