<?php 
require_once("layout.php");

Head();

Navbar();
function ApplicationPost($speciality,$hospitalName,$count,$country,$city,$hospitalAppId,$isApplied, $distance, $isPeak){
	if($isPeak){
		$isPeak = '<h2 class="mr-3 text-black" style=""><span style="
		background: red;
		color: #fff;
		padding: 0 14px;
		border-radius: 7px;
	">Having a Peak</span></h2>';
	}	
	else{
		$isPeak = "";
	}

	$url="HospitalApp.php?hospitalApp=$hospitalAppId&hospitalCityCountry=$city , $country"
    ?>
            <div class="col-md-12 ftco-animate fadeInUp ftco-animated">
                <div class="job-post-item p-4 d-block d-lg-flex align-items-center">
                    <div class="one-third mb-4 mb-md-0">
		                <div class="job-post-item-header align-items-center">
						<?php echo $isPeak ?>
						<h2 class="mr-3 text-black"><span ><?php echo $speciality ?></span></h2>
						 <h10 class="mr-3 text-black"><span><?php echo $hospitalName ?></span></h10>
		                </div>
		                <div class="job-post-item-body d-block d-md-flex">
		                  <div class="mr-3">
							  <span class="icon-layers"></span> <span><?php echo $count ?></span>
							</div>
							<div class="mr-3">
							<span class="icon-road"></span>
							   <span><?php echo $distance ?> KM</span>
							</div>
		                  <div>
							  <span class="icon-my_location"></span>
							   <span><?php echo $city ?> , <?php echo $country ?></span>


							</div>
		                </div>
		              </div>

		              <div class="one-forth ml-auto d-flex align-items-center mt-4 md-md-0">
		              	<div>
			                <a href="#" class="icon text-center d-flex justify-content-center align-items-center icon mr-2">
			                	<span class="icon-heart"></span>
			                </a>
						</div>
						<?php if($isApplied){
							?>
						
						<span class="btn btn-dark disabled py-2">Applied ✔</span>
						<?php 
						}else{ ?>
						<a href="<?php echo $url ?>" class="btn btn-primary py-2">Apply Job</a>
						<?php 
						}
						?>
		              </div>
                </div>
            </div>
    <?php
    
}
?>
<div class="hero-wrap hero-wrap-2" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
	  <?php Animation() ?>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-start">
          <div class="col-md-12 ftco-animate text-center mb-5">
            <h1 class="mb-3 bread">Hospital Demands</h1>
          </div>
        </div>
      </div>
    </div>

		<section class="ftco-section bg-light">
			<div class="container">
				<div class="row">
					<div class="col-lg-9 pr-lg-4">
						<div class="row">
					<?php 
					//24.495970, 54.383114
					//lon=-74.007081&lat=40.750385&docID=
					$lon=54.367895;
					$lat=24.469822;
                    $resp=file_get_contents("http://localhost:57984/GetRequestsSorted?lon=$lon&lat=$lat&docID=".$userId);
                    $response=json_decode($resp);
                    $posts=$response->data;
                    foreach ($posts as $data) {
                        $post=$data->request;
                        ApplicationPost($post->speciality,$post->hospitalName,$post->count,$post->country,$post->city,$post->hospitalAppId,$post->isApplied, $data->distance,$post->isPeak);
                    }                    
                    ?>



		        </div>
		        <div class="row mt-5">
		          <div class="col text-center">
		            <div class="block-27">
		              <ul>
		                <li><a href="#">&lt;</a></li>
		                <li class="active"><span>1</span></li>
		                <li><a href="#">2</a></li>
		                <li><a href="#">3</a></li>
		                <li><a href="#">4</a></li>
		                <li><a href="#">5</a></li>
		                <li><a href="#">&gt;</a></li>
		              </ul>
		            </div>
		          </div>
		        </div>
		      </div>
		      <div class="col-lg-3 sidebar">
		        <div class="sidebar-box bg-white p-4 ftco-animate">
		        	<h3 class="heading-sidebar">Browse Category</h3>
		        	<form action="#" class="search-form mb-3">
                <div class="form-group">
                  <span class="icon icon-search"></span>
                  <input type="text" class="form-control" placeholder="Search...">
                </div>
              </form>
		        	<form action="#" class="browse-form">
							  <label for="option-job-1"><input type="checkbox" id="option-job-1" name="vehicle" value="" checked> Doctors</label><br>
							  <label for="option-job-2"><input type="checkbox" id="option-job-2" name="vehicle" value="">Nurses</label><br>
							  
							</form>
		        </div>

		        <div class="sidebar-box bg-white p-4 ftco-animate">
		        	<h3 class="heading-sidebar">Select Location</h3>
		        	<form action="#" class="search-form mb-3">
                <div class="form-group">
                  <span class="icon icon-search"></span>
                  <input type="text" class="form-control" placeholder="Search...">
                </div>
              </form>
		        	<form action="#" class="browse-form">
							  <label for="option-location-1"><input type="checkbox" id="option-location-1" name="vehicle" value="" checked> Dubai , UAE</label><br>
							  <label for="option-location-1"><input type="checkbox" id="option-location-1" name="vehicle" value="" checked> Abu Dhabi , UAE</label><br>
							  <label for="option-location-2"><input type="checkbox" id="option-location-2" name="vehicle" value=""> New York, USA</label><br>
							  <label for="option-location-3"><input type="checkbox" id="option-location-3" name="vehicle" value="">Shanghai , China</label><br>
							  <label for="option-location-4"><input type="checkbox" id="option-location-4" name="vehicle" value=""> Beijing , China</label><br>
							  <label for="option-location-5"><input type="checkbox" id="option-location-5" name="vehicle" value=""> Milan , Italy</label><br>
							  <label for="option-location-6"><input type="checkbox" id="option-location-6" name="vehicle" value=""> Riyadh , Saudi Arab</label><br>
							</form>
		        </div>

		       
		      </div>
				</div>
			</div>
		</section>


<?php
    Footer();
    Scripts();
?>