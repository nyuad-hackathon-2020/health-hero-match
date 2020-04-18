<?php 
require_once("layout.php");

Head();

Navbar();

?>

    
    <div class="hero-wrap img">
      <div class="overlay"></div>
      <div class="container">
      	<div class="row d-md-flex no-gutters slider-text align-items-center justify-content-center">
	        <div class="col-md-10 d-flex align-items-center ftco-animate">
	        	<div class="text text-center pt-5 mt-md-5">
	            <h1 class="mb-5">We deploy healthcare heroes to the front-line!</h1>
							<div class="ftco-counter ftco-no-pt ftco-no-pb">
			        	<div class="row">
				          <div class="col-md-4 d-flex justify-content-center counter-wrap ftco-animate">
				            <div class="block-18">
				              <div class="text d-flex">
				              	<div class="icon mr-2">
				              		<span class="flaticon-visitor"></span>
				              	</div>
				              	<div class="desc text-left">
					                <strong class="number" data-number="350">0</strong>
					                <span>Doctors</span>
				                </div>
				              </div>
				            </div>
				          </div>
				          <div class="col-md-4 d-flex justify-content-center counter-wrap ftco-animate">
				            <div class="block-18 text-center">
				              <div class="text d-flex">
				              	<div class="icon mr-2">
									  <span class="icon-hospital-o"></span>
				              	</div>
				              	<div class="desc text-left">
					                <strong class="number" data-number="46">0</strong>
					                <span>Hospitals</span>
					              </div>
				              </div>
				            </div>
				          </div>
				          <div class="col-md-4 d-flex justify-content-center counter-wrap ftco-animate">
				            <div class="block-18 text-center">
				              <div class="text d-flex">
				              	<div class="icon mr-2">
				              		<span class="flaticon-resume"></span>
				              	</div>
				              	<div class="desc text-left">
					                <strong class="number" data-number="864">0</strong>
					                <span>Number of matches</span>
					              </div>
				              </div>
				            </div>
				          </div>
				        </div>
			        </div>
					
	          </div>
	        </div>
			</div>
			
			<div class="row">
    			<div class="col-md-12">
    				<div class="category-wrap">
    					<div class="row no-gutters">
							<div class="col-md-2">
								<a href="profile-hospital.php">
									<div class="top-category text-center no-border-left">
										<h3>Request</h3>
										<span class="icon flaticon-contact"></span>
										<p><span class="number">120</span> <span>Available Doctors</span></p>
									</div>
								</a>
								</div>
							
								<div class="col-md-2">
								<a href="hospitald.php">
									<div class="top-category text-center">
										<h3>Apply</h3>
										<span class="icon flaticon-stethoscope"></span>
										<p><span class="number">143</span> <span>Open Requests</span></p>
									</div>
								</a>
								</div>
    					</div>
    				</div>
    			</div>
			</div>
			
			
      </div>
    </div>


<?php
    Footer();
    Scripts();
?>