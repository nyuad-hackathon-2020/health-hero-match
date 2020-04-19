<?php 
require_once("layout.php");
$resp=null;
if(isset($_GET['UserId'])){
    $resp=file_get_contents("http://localhost:57984/apply?requestid=".$_GET["HospitalRequestId"]."&EmployeeId=".$_GET['UserId']);
    $requestInfo=json_decode($resp);
    $color="primary";
    $head="Well done!";
    $body="You have applied successfully!";
    if($requestInfo->code==208){
        $color="danger";
        $head="You've already applied here";
        $body="Continue to apply apply for more hospitals.";
    }
}

Head();

Navbar();

?>
<!-- write your html here -->
<div class="hero-wrap hero-wrap-2 fixed-top" style="background-image: url(&quot;images/bg_1.jpg&quot;); background-position: 50% 0%;" data-stellar-background-ratio="0.5">
      <div class="overlay position-fixed"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-start">
          <div class="col-md-12 ftco-animate text-center mb-5 fadeInUp ftco-animated">
          <div class="alert alert-<?php echo $color ?>" role="alert">
  <h4 class="alert-heading"><?php echo $head ?></h4>
  <p class="text-dark"><?php echo $body ?></p>
  <hr>
  <div>
       <a href="hospitalD.php" class="btn btn-info">Continue</a>
       <?php 
       if($requestInfo->code!=208) 
        echo '<button type="button" id="showModal" class="btn btn-light  ml-3" data-toggle="modal" data-target="#NearbyHotels">
        Show nearby Hotels
    </button>';
       ?>
    </div>

</div>
          </div>
        </div>
      </div>
    </div>

<?php
    Hotels();
    Footer();
    Scripts();
?>