<section class="">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-sm-12 col-lg-auto">
				<div class="cta-bg">
					<img src="images/customer-service.png" alt="" class="cta-img">
					<h2 class="cta-hding text-center"> Speak to our Expert <span><i class="fa-solid fa-phone-volume"></i> <?php echo $phone; ?></span></h2>
				</div>	
			</div>
		</div>
	</div>
</section>
<footer id="footer">
	<div class="container">
		<div class="row justify-content-between pb-5">
			<div class="col-12 col-md-3">
				<img src="images/logo.png" alt="" class="footer-logo">
				<ul class="socialicon">
					<li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
					<li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
					<li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
					<li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
				</ul>
				<p class="footer-text pt-2">Explore the world with ease <br> We're just a call away</p>
				<address class="footer-address mt-2">
					<div class="d-flex align-items-center gap-3">
					 	<i class="fa-solid fa-phone-volume"></i> <?php echo $phone; ?>
					</div> 
				</address>
			</div>
			<div class="col-6 col-md-3">
				<h2 class="footer-hding">Main Links</h2>
				<ul class="footer-list">
					<li><a href="about-us.php">About Us</a></li>
					<li><a href="flights.php">Flights</a></li>
					<li><a href="destination.php">Destination</a></li>
					<li><a href="packages.php">Packages</a></li>
					<li><a href="activities.php">Activities</a></li>
					<li><a href="contact-us.php">Contact Us</a></li>
					
				</ul>
			</div>
			<div class="col-6 col-md-3">
				<h2 class="footer-hding">Other Links</h2>
				<ul class="footer-list">
					<li><a href="disclaimer.php">Disclaimer</a></li>
					<li><a href="privacy-policy.php">Privacy Policy</a></li>
					<li><a href="terms-and-conditions.php">Terms & Conditions</a></li>
				</ul>
			</div>
			<div class="col-sm-6 col-md-3">
				<div class="d-flex justify-content-md-end mt-4 mt-md-0 mt-sm-2">
					<div>
						<h2 class="footer-hding">Contact Us</h2>

						<address class="footer-address">
							<div class="d-flex align-items-center gap-3 mb-3">
							 	<i class="fa-solid fa-house"></i> 3612 Windshire Dr Springfield, IL 62704, USA
							</div> 
							<div class="d-flex align-items-center gap-3 mb-3">
							 	<i class="fa-solid fa-envelope"></i> <?php echo $email; ?>
							</div> 	
						</address>
						
					</div>
				</div>		
			</div>
			
		</div>
	</div>	
	<div class="copyright-bg">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p class="copyright text-center">Copyright © <script>document.write(new Date().getFullYear())</script> <?php echo $domainname_url ?>. All rights reserved</p>
				</div>
			</div>
		</div>
	</div>	
</footer>

<script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
<!-- <script type="text/javascript" src="js/bootstrap.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
<script type="text/javascript" src="js/owl.carousel.min.js"></script>
<script type="text/javascript">

	$('#top-trending').owlCarousel({
		  //items: 1,
		  loop: true,
		  //center:true,
		  singleItem:true,
		  navigation : true, // Show next and prev buttons
	      slideSpeed : 300,
	      paginationSpeed : 400,
	      dots: false,
	      nav: true, // Show next and prev buttons
	      navText: ['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>'],
	      responsiveClass:true,
		  slideBy: 1,
		  margin: 25,
		  autoplay: true,
		  autoplayTimeout: 3000,
		  autoplayHoverPause: true,
		   responsive:{
			  0:{
			  items:1
			  },
			  768:{
			  items:3
			  },
			  992:{
			  items:4
			  }
			}
	});  

	$('#testimonial_carousel').owlCarousel({
		 loop: true,
	    items: 1,
	    dots: true,
	    dotsData: true, // Enables your custom image dots
	    nav: false,
	    margin: 25,
	    autoplay: false,
	    autoplayHoverPause: true,
	    responsive: {
	        0: { items: 1 },
	        768: { items: 1 },
	        992: { items: 1 }
	    }
	});     

	// click dota image to change carousel 
	$(document).on('click', '.owl-dot', function() {
	    var index = $(this).index();
	    $('.owl-carousel').trigger('to.owl.carousel', [index, 300]);
	});

	// Top Destination
	$('#top-destination').owlCarousel({
        loop:true,
        margin:10,
        dots: false,
        nav: true, // Show next and prev buttons
    
        navText: ['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>'],
        autoplay: true,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            768:{
                items:2,
                nav:false
            },
            1000:{
                items:3,
                nav:true,
                loop:false
            }
        }
    })
</script>
<script>
	
	$(document).ready(function () {
	    function checkScroll() {
	        if ($(window).scrollTop() > 0) {
	            $("header").addClass("stickey-header");
	        } else {
	            $("header").removeClass("stickey-header");
	        }
	    }

	    // Run on page load
	    checkScroll();

	    // Run on scroll
	    $(window).scroll(function () {
	        checkScroll();
	    });
	});
</script>

<script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/Flip.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollTrigger.min.js"></script>
<!-- ScrollSmoother requires ScrollTrigger -->
<script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollSmoother.min.js"></script>

<script>
 // use a script tag or an external JS file
 document.addEventListener("DOMContentLoaded", (event) => {
  gsap.registerPlugin(Flip,ScrollTrigger,ScrollSmoother)
   gsap.to('.vr-radius-img2 img', {
		scrollTrigger: {
			trigger: '.vr-radius-img2', // start the animation when ".box" enters the viewport (once)
			start: "top top",
			x: 0,
	      y: 0,
	      scrub: true
		},
		borderRadius: "15px",
    	x: 0,
    	y: 0,         // move image near bottom
    	scale: 1,         // shrink a bit
    	ease: "power1.out"
		
	});
  
	   gsap.to('.box', {
	   		scrollTrigger: {
	   			trigger: ".box",
	   			start: "top top",
	   			// x: 0,
	   			// y:0,
	   			scrub: true

	   		},
	   		x: -500,
	   		y: 600,
	   		scale: 1,        // shrink a bit
	    	ease: "power1.out",
	    	rotation:45,
	    	onComplete: explodeBoxes
	   })
	   function explodeBoxes() {
		  const container = document.querySelector('.destination-img');
		  const bigBox = document.querySelector('.box');
		  const rect = bigBox.getBoundingClientRect();

		  for (let i = 0; i < 7; i++) {
		    const small = document.createElement('div');
		    small.classList.add('small-box');
		    small.style.left = rect.left + rect.width / 2 + "px";
		    small.style.top = rect.top + rect.height / 2 + "px";
		    container.appendChild(small);

		    gsap.to(small, {
		      x: (Math.random() - 0.5) * 400,
		      y: (Math.random() - 0.5) * 400,
		      scale: 0.5,
		      opacity: 0,
		      duration: 1,
		      ease: "power3.out",
		      delay: i * 0.05
		    });
		  }
		}
 });

</script>

<script>
	$(document).ready(function(){
	    $(".add-traveller-btn").click(function(){
	    	var travellerCount = $("#traveller-table tbody tr").length + 1;
	        $("#traveller-table tbody").append(
	            `<tr>
	              <td align="middle">Traveler ${travellerCount}</td>
	              <td width="150">
	                <label class="traveller-form-lbl">First Name</label>
	                <input type="text" name="first-name" class="traveller-form-field">
	              </td>
	              <td width="150">
	                <label class="traveller-form-lbl">Middle Name</label>
	                <input type="text" name="middle-name" class="traveller-form-field">
	              </td>
	              <td width="150">
	                <label class="traveller-form-lbl">Last Name</label>
	                <input type="text" name="last-name" class="traveller-form-field">
	              </td>
	              <td>
	                <label class="traveller-form-lbl">Gender</label>
	                <select name="gender" class="traveller-form-field">
	                  <option>Male</option>
	                  <option>Female</option>
	                </select>
	              </td>
	              <td>
	                <label class="traveller-form-lbl">Date of Birth</label>
	                <select name="gender" class="traveller-form-field">
	                  <?php 
	                    for($i =1; $i <=10; $i++) {
	                      echo "<option value='$i'>$i</option>";    
	                    }
	                  ?>
	                </select>
	              </td>
	              <td>
	                <label class="traveller-form-lbl">Month</label>
	                <select name="month" class="traveller-form-field">
	                  <option>Jan</option>
	                  <option>Feb</option>
	                </select>
	              </td>
	              <td>
	                <label class="traveller-form-lbl">Year</label>
	                <select name="month" class="traveller-form-field">
	                  <?php 
	                    for($b=1980; $b <=2025; $b++) {
	                      echo "<option value='$b'>$b</option>";
	                    }
	                  ?>
	                </select>
	              </td>
	              <td width="30" valign="middle">
	                  <button class="remove-traveller-tr"><i class="fa-solid fa-minus"></i></button>
	              </td>
	            </tr>`
	        );
	    });
	});

	$(document).on("click", ".remove-traveller-tr", function(){
	    $(this).closest("tr").remove();
	});

</script>

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<!-- <script src="js/flight-search.js"></script> -->
<!-- <script src="js/countries.js"></script> -->

</body>
</html>