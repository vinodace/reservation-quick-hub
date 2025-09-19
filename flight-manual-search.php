<!DOCTYPE html>
<html>

<head>
  <title>Tour and Travel Website</title>

<?php include("header.php"); ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Duffel Flight Search</title>
</head>
<body>
<section class="banner-bg">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        
      </div>
    </div>
  </div>
</section>

  <h3>Flight Search</h3>
  <form method="POST" action="search.php">
    <label>Origin (IATA): <input type="text" name="origin" value="LHR" required></label><br>
    <label>Destination (IATA): <input type="text" name="destination" value="JFK" required></label><br>
    <label>Departure Date: <input type="date" name="departure_date" required></label><br>
    <label>Return Date: <input type="date" name="return_date" required></label><br>
    <label>Adults: <input type="number" name="adults" value="1" min="1"></label><br>
    <label>Cabin Class:
      <select name="cabin_class">
        <option value="economy" selected>Economy</option>
        <option value="business">Business</option>
        <option value="first">First</option>
      </select>
    </label><br><br>
    <button type="submit">Search Flights</button>
  </form>




<?php include("footer.php"); ?>

<script>
  
</script> 
</body>
</html> 