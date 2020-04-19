<?php 
require_once("layout.php");
$resp=null;
if(isset($_POST['HospitalId'])){
    $postdata = http_build_query(
        array(
            'HospitalId' => $_POST['HospitalId'],
            'SpecialityId' => $_POST['SpecialityId'],
            'count' => $_POST['count'],
            'htmlPost' => $_POST['editor'],
        )
    );
    
    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-Type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );
    
    $context  = stream_context_create($opts);
    
    $result = file_get_contents('http://localhost:57984/NewDemand', false, $context);
    $requestInfo=json_decode($result);
    
    $color="primary";
    $head="Well done!";
    $body="You created a demand successfully!";
    if($requestInfo->code!=200){
        $color="danger";
        $head="Something went wrong";
        $body="Please try to post a demand again";
    }
}

Head();


?>
<!-- write your html here -->
<div class="hero-wrap hero-wrap-2 fixed-top" data-stellar-background-ratio="0.5">
      <div class="overlay position-fixed"><?php Animation(); ?></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-start">
          <div class="col-md-12 ftco-animate text-center mb-5 fadeInUp ftco-animated">
          <div class="alert alert-<?php echo $color ?>" role="alert">
  <h4 class="alert-heading"><?php echo $head ?></h4>
  <p class="text-dark"><?php echo $body ?></p>
  <hr>
  <div>
       <a href="profile-hospital.php" class="btn btn-info">Continue</a>
    </div>

</div>
          </div>
        </div>
      </div>
    </div>

<?php
    Scripts();
?>