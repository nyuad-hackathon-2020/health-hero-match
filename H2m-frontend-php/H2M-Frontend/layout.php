<?php 
$userId=2;
$hospitalId=3;
function Head($added=true){
    ?>
    <!DOCTYPE html>
<html lang="en">
 <head>
    <title>Health Hero Match</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

<?php if($added){ 
  ?>
  <!--===============================================================================================-->	
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
  <!--===============================================================================================-->
 <?php 
}
?>
    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/custom.css">
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

  </head>
  <body>
<?php
}

function Navbar($isHospital=false){
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container-fluid px-md-4	">
	      <a class="navbar-brand" href="index.php"><img style="width: 450px;margin-left: -25px;" src="images/logo.png" /></a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
            <li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
            <?php if(!$isHospital){ ?>
              <li class="nav-item"><a href="HospitalD.php" class="nav-link">Hospital Demands</a></li>
              <li class="nav-item"><a href="profile.php" class="nav-link">My Profile</a></li>
            <?php 
            }
            else{
            ?>
              <li class="nav-item"><a href="profile-hospital.php" class="nav-link">My Profile</a></li>
              <li class="nav-item cta mr-md-1"><a href="newdemand.php" class="nav-link">Add a Request</a></li>
            <?php 
            }
            ?>
	          <li class="nav-item cta mr-md-1"><a href="new-post.html" class="nav-link">Logout</a></li>
	          

	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->
    <?php
}


function Footer(){
    ?>

<footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4 ml-md-4">
              <h2 class="ftco-heading-2">Account</h2>
              <ul class="list-unstyled">
                <li><a href="#" class="pb-1 d-block">My Account</a></li>
                <li><a href="#" class="pb-1 d-block">Sign In</a></li>
                <li><a href="#" class="pb-1 d-block">Create Account</a></li>
                <li><a href="#" class="pb-1 d-block">Checkout</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Have a Questions?</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, Abu Dhabi, UAE</span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+971 555 555 5555</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">support@H2M.com</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright H2M &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart text-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          </div>
        </div>
      </div>
    </footer>
<?php
}


function Animation(){
echo '
<style>
body{
  background: #3399ff;
}


.circle{
  position: absolute;
  border-radius: 50%;
  background: white;
  animation: ripple 15s infinite;
  box-shadow: 0px 0px 1px 0px #508fb9;
}

.small{
  width: 200px;
  height: 200px;
  left: -100px;
  bottom: 300px;
}

.medium{
  width: 400px;
  height: 400px;
  left: -200px;
  bottom: 200px;
}

.large{
  width: 600px;
  height: 600px;
  left: -300px;
  bottom: 100px;
}

.xlarge{
  width: 800px;
  height: 800px;
  left: -400px;
  bottom: 0px;
}

.xxlarge{
  width: 1000px;
  height: 1000px;
  left: -500px;
  bottom: -100px;
}

.shade1{
  opacity: 0.2;
}
.shade2{
  opacity: 0.5;
}

.shade3{
  opacity: 0.7;
}

.shade4{
  opacity: 0.8;
}

.shade5{
  opacity: 0.9;
}

@keyframes ripple{
  0%{
    transform: scale(0.8);
  }
  
  50%{
    transform: scale(1.2);
  }
  
  100%{
    transform: scale(0.8);
  }
}
</style>
';


echo '
<div class="circle xxlarge shade1"></div>
<div class="circle xlarge shade2"></div>
<div class="circle large shade3"></div>
<div class="circle mediun shade4"></div>
<div class="circle small shade5"></div>
';

}

function Scripts(){
    ?>
      <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
</body>
</html>
    <?php 
}
function Hotel($location,$hotelName,$link,$id){
  ?>
       <div class="col-md-12">
                    <div class="team d-md-flex p-4 bg-white">
                      <div
                        class="img hotel-img-size mb-0"
                        style="
                          background-image: url(images/hotel-<?php echo $id?>.jpg);
                        "
                      >
                      </div>
                       <div class="text pl-md-4">
                        <span class="location mb-0"><?php echo $location ?></span>
                        <h2><?php echo $hotelName ?>
                                  <a class="btn btn-info float-right" target="_blank" href="<?php echo $link ?>">More info</a></h2>
                     </div>
                    </div>
                    </div>
  <?php
}
function Hotels(){
  ?>
   <!-- Modal -->
   <div
    class="modal fade"
    id="NearbyHotels"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Nearby Hotels</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <section
            class="ftco-section ftco-candidates ftco-candidates-2 py-2 bg-light"
          >
            <div class="container">
              <div class="row">
                <div class="col-lg-12">
                  <div class="row">
                      <?php Hotel("Abu Dhabi , UAE","Four Seasons Hotel","https://www.booking.com/hotel/ae/four-seasons-abu-dhabi-at-al-maryah-island.html",1);
                    ?>
                     <?php Hotel("Abu Dhabi , UAE","Corniche Hotel Abu Dhabi","https://www.booking.com/hotel/ae/corniche-hotel-abu-dhabi.html",2);
                    ?>
                    <?php Hotel("Abu Dhabi , UAE","Ivory Hotel Apartments ","https://www.booking.com/hotel/ae/ivory-apartments.html",3);
                    ?>
                    
                  </div>
                </div>
              </div>
            </div>
          </section>
          <button type="button" class="btn btn-secondary float-right mt-4" data-dismiss="modal">
          Close
        </button>
        </div>
      </div>
    </div>
  </div>
  <?php
}
function Contact(){
  ?>
   <!-- Modal -->
   <div
    class="modal fade"
    id="Contact"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Nearby Hotels</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <section
            class="ftco-section ftco-candidates ftco-candidates-2 py-2 bg-light"
          >
            <div class="container">
              <div class="row">
                <div class="col-lg-12">
                  <div class="row">
                  <div class="col-md-12">
                    <div class="team d-md-flex p-4 bg-white">
                      <div
                        class="img hotel-img-size mb-0"
                        style="
                          background-image: url(images/person_1.jpg);
                        "
                      >
                      </div>
                       <div class="text pl-md-4">
                        <span class="location mb-0">Dubai , UAE</span>
                        <h2>Amr Darawsheh 
                                  <a class="btn btn-info float-right" target="_blank" href="profile.php">Show Profile</a></h2>
                                  <span class="position">+971 2 9832125</span>
                                  <span class="position" style="text-transform: lowercase;">amr.1999@live.com </span>   
                        <div class="mt-3">
                        <h2>Contact Amr Darawsheh by sending an email:</h2>
                        <textarea name="editor" ></textarea>
                        <button type="button" class="btn btn-info float-right mt-4">
                            Send
                          </button>
                        </div>
                     </div>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <button type="button" class="btn btn-secondary float-right mt-4" data-dismiss="modal">
          Close
        </button>
        </div>
      </div>
    </div>
  </div>
  <script>
   CKEDITOR.replace( 'editor' );
  </script>
  <?php
}
?>