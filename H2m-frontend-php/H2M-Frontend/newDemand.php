<?php 
require_once("layout.php");

Head(false);

Navbar(true);

$resp=file_get_contents("http://localhost:57984/specialities");
$list=json_decode($resp);
?>
<!-- write your html here -->
<div class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-start">
          <div class="col-md-12 ftco-animate text-center mb-5">
          	<p class="breadcrumbs mb-0"><span class="mr-3"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Job Post</span></p>
            <h1 class="mb-3 bread">Post A Job</h1>
          </div>
        </div>
      </div>
    </div>

		<section class="ftco-section bg-light">
      <div class="container">
        <div class="row">
       
          <div class="col-md-12 col-lg-8 mb-5">
          
			     <form action="createDemand.php" method="post" class="p-5 bg-white">
                     <input type="hidden" name="HospitalId" value="<?php echo $hospitalId ?>">
              <div class="row form-group mb-4">
                <div class="col-md-12"><h3>Speciality</h3></div>
                <div class="col-md-12 mb-3 mb-md-0">
                <select name="SpecialityId" class="form-control">
                    <?php foreach ($list as $opt) {
?> 
                <option value="<?php echo $opt->id?>"><?php echo $opt->name?></option>

<?php 
}?>
                </select>
                </div>
              </div>
                 <div class="row form-group mb-4">
                <div class="col-md-12"><h3>Count</h3></div>
                <div class="col-md-12 mb-3 mb-md-0">
                  <input type="number" name="count" class="form-control">
                </div>
              </div>

              

              <div class="row form-group">
                <div class="col-md-12"><h3>Demand Post</h3></div>
                <div class="col-md-12 mb-3 mb-md-0">
                  <textarea name="editor" class="form-control" id="" cols="30" rows="5"></textarea>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <input type="submit" value="Post" class="btn btn-primary  py-2 px-5">
                </div>
              </div>

  
            </form>
          </div>

          <div class="col-lg-4">
            <div class="p-4 mb-3 bg-white">
              <h3 class="h5 text-black mb-3">Contact Info</h3>
              <p class="mb-0 font-weight-bold">Address</p>
              <p class="mb-4">203 Fake St. Mountain View, San Francisco, California, USA</p>

              <p class="mb-0 font-weight-bold">Phone</p>
              <p class="mb-4"><a href="#">+1 232 3235 324</a></p>

              <p class="mb-0 font-weight-bold">Email Address</p>
              <p class="mb-0"><a href="#"><span class="__cf_email__" data-cfemail="671e081215020a060e0b2703080a060e094904080a">[email&#160;protected]</span></a></p>

            </div>
            
            <div class="p-4 mb-3 bg-white">
              <h3 class="h5 text-black mb-3">More Info</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa ad iure porro mollitia architecto hic consequuntur. Distinctio nisi perferendis dolore, ipsa consectetur</p>
              <p><a href="#" class="btn btn-primary  py-2 px-4">Learn More</a></p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <script>
                                CKEDITOR.replace( 'editor' );

    </script>
<?php
    Footer();
    Scripts();
?>