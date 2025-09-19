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

