<?php 
	$phone = "+1-888-652-6021";
	$email = "help@reservationquickhub.com";
	$domainname_url ="reservationquickhub.com";
	$domainname = "Reservation Quick Hub";
?>

<?php
  $headerClass = '';
  if (basename($_SERVER['SCRIPT_NAME']) === 'index.php') {
    $headerClass = 'header-pos';
  }
?>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- <meta name="robots" content="noindex, nofollow"> -->
	<!-- Favicon icon -->
    <link rel="shortcut icon" type="image/png" href="images/favicon.png"> 
    <!-- Custom css -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Bootstrap v5.0 -->
    <!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <!-- Owl Carousel v2.3.4 -->
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="css/owl.theme.default.min.css">
    <!-- Font Awesome Free 6.7.2 -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> -->
	<!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
	<!-- Animation -->
	<!-- <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"> -->
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
	
</head>
<body>
<header class="<?= $headerClass ?>"> 
	<div class="container">
		<nav class="navbar navbar-expand-lg navbar-light navlr-pad">
		    <a  href="./">
		    	<img src="images/logo.png" alt="" class="logo">
		    </a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" id="navbarSupportedContent">
		    	<?php
                    $nav1=$nav2=$nav3=$nav4=$nav5="";
                    $tt=explode("/",$_SERVER['PHP_SELF']);
                    $len=count($tt)-1;
                    $cur_page=$tt[$len];
                    switch($cur_page)
                    {
                    case "index.php":
                    $nav1='active';
                    break;
                    case "about-us.php":
                    $nav2='active';
                    break;
                    case "flights.php":
                    $nav3='active';
                    break;
                    case "destination.php":
                    $nav4='active';
                    break;
                    case "packages.php":
                    $nav5='active';
                    break;
                    case "activities.php":
                    $nav6='active';
                    break;
                    case "contact-us.php":
                    $nav7='active';
                    break;
                    }
                ?>
		      <ul class="navbar-nav mx-auto">
		         <li class="nav-item">
		            <a class="nav-link <?php echo $nav1; ?>" href="./">Home</a>
		         </li>
		         <li class="nav-item">
			        <a class="nav-link <?php echo $nav2; ?>" href="about-us.php">About Us</a>
			      </li>
			      <li class="nav-item">
			        <a class="nav-link <?php echo $nav3; ?>" href="flights.php">Flights</a>
			      </li>
			      <li class="nav-item">
			        <a class="nav-link <?php echo $nav4; ?>" href="destination.php">Destination</a>
			      </li>
			      <li class="nav-item">
			        <a class="nav-link <?php echo $nav5; ?>" href="packages.php">Packages</a>
			      </li>
			      <li class="nav-item">
			        <a class="nav-link <?php echo $nav6; ?>" href="activities.php">Activities</a>
			      </li>
			      <li class="nav-item">
			        <a class="nav-link <?php echo $nav7; ?>" href="contact-us.php">Contact Us</a>
			      </li>
		      </ul>
		      <a href="tel:<?php echo $phone; ?>" class="header-btn">Call Us : <?php echo $phone; ?></a>
		    </div>
		</nav>
	</div>	
</header>
<!-- Header -->

<?php include("breadcrumb.php") ?>