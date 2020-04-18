<?php 
require_once("layout.php");
if(isset($_GET["hospitalApp"])){

Head();

Navbar();

$resp=file_get_contents("http://localhost:57984/Application?requestid=".$_GET["hospitalApp"]);
$requestInfo=json_decode($resp);

?>
<!-- write your html here -->
<div class="hero-wrap hero-wrap-2 min-height-hero-img" style="background-image: url(&quot;images/bg_1.jpg&quot;); background-position: 50% 399.5px;" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-start">
          <div class="col-md-12 ftco-animate text-center mb-5 fadeInUp ftco-animated">
          	<p class="breadcrumbs mb-0"><span class="mr-3"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Canditates</span></p>
            <h1 class="mb-3 bread">Hire Your Best Candidates</h1>
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
		        				<span class="location mb-0"><?php echo $_GET['hospitalCityCountry'] ?></span>
		        				<h2><?php echo $requestInfo->hospitalName ?></h2>
			        			<span class="position"><?php echo $requestInfo->specialityName ?></span>
                                <p class="mb-2"><?php echo ( $requestInfo->htmlpost );?></p>
                                <div>
                                    <form action="Apply.php" method="GET">
                                    <button type="submit" class="btn btn-primary float-right">
                                        Apply
                                    </button>
                                    <input type="hidden" name="HospitalRequestId" value="<?php echo $_GET["hospitalApp"] ?>">
                                    <input type="hidden" name="UserId" value="<?php echo $userId ?>">
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
    Footer();
    Scripts();
}

?>