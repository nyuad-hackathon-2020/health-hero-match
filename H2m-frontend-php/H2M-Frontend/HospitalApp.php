<?php 
require_once("layout.php");
if(isset($_GET["hospitalApp"])){
  
Head();

Navbar();

$resp=file_get_contents("http://localhost:57984/Application?requestid=".$_GET["hospitalApp"]);
$requestInfo=json_decode($resp);
?>

<div class="hero-wrap hero-wrap-2 min-height-hero-img" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
		<?php Animation() ?>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-start">
          <div class="col-md-12 ftco-animate text-center mb-5 fadeInUp ftco-animated">
            <h1 class="mb-3 bread"><?php echo $requestInfo->specialityName ?></h1>
          </div>
        </div>
      </div>
    </div>
    <!-- //string(103) "{"count":5,"htmlpost":null,"hospitalName":"New York","specialityName":"Surgury","email":"nyHos@ny.usa"}" -->
    <section class="ftco-section ftco-candidates ftco-candidates-2 bg-light">
    	<div class="container">
    		<div class="row">
    			<div class="col-lg-12">
    				<div class="row">
		    			<div class="col-md-12">
		    				<div class="team d-md-flex p-4 bg-white">
		        			<div class="img" style="background-image: url(images/hospital-1.jpg);"></div>
		        			<div class="text pl-md-4">
                   <a href="http://maps.google.com/?q=<?php echo $requestInfo->latitude.",".$requestInfo->longitude?>" target="_blank" class="btn btn-info align-items-end float-right mt-2">Show on maps</a>
		        				<span class="location mb-0"><?php echo $_GET['hospitalCityCountry'] ?></span>
		        				<h2><?php echo $requestInfo->hospitalName ?></h2>
			        			<span class="position"><?php echo $requestInfo->specialityName ?></span>
                                <p class="mb-2"><?php echo ( $requestInfo->htmlpost );?></p>
                                <div>
                                    <form action="Apply.php" method="GET">
                                    <button type="submit" class="btn btn-primary float-right px-4">
                                        Apply
                                    </button>
                                    <input type="hidden" name="HospitalRequestId" value="<?php echo $_GET["hospitalApp"] ?>">
                                    <input type="hidden" name="UserId" value="<?php echo $userId ?>">
                                    <button type="button" id="showModal" class="btn btn-light float-right mr-3" data-toggle="modal" data-target="#NearbyHotels">
                                        Nearby Hotels
                                    </button>
                                </form>
                                </div>
		        			</div>
		        		</div>
		    			</div>
		    		</div>
		    		
		    	</div>
		    	
    		</div>
    	</div>
    </section>
  
<?php
    Hotels();
    Footer();
    Scripts();
    
}
