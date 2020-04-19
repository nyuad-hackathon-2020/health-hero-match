<?php 
require_once("layout.php");

Head(false);

Navbar(true);

$resp=file_get_contents("http://localhost:57984/specialities");
$list=json_decode($resp);
?>
    <!-- write your html here -->
    <div class="hero-wrap hero-wrap-2" data-stellar-background-ratio="0.5">
        <div class="overlay" style="z-index: -1;">
            <?php Animation() ?>
        </div>

        <div class="container">
            <div class="row no-gutters slider-text align-items-end justify-content-start">
                <div class="col-md-12 ftco-animate text-center mb-5">
                    <h1 class="mb-3 bread">Post A Demand</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row">

                <div class="col-md-12 col-lg-12 mb-12">
                    <form action="createDemand.php" method="post" class="p-5 bg-white">
                        <input type="hidden" name="HospitalId" value="<?php echo $hospitalId ?>">
                        <div class="row form-group mb-4">
                            <div class="col-md-12">
                                <h3>Speciality</h3></div>
                            <div class="col-md-12 mb-3 mb-md-0">
                                <select name="SpecialityId" class="form-control">
                                    <?php foreach ($list as $opt) {
?>
                                        <option value="<?php echo $opt->id?>">
                                            <?php echo $opt->name?>
                                        </option>

                                        <?php 
}?>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group mb-4">
                            <div class="col-md-12">
                                <h3>Count</h3></div>
                            <div class="col-md-12 mb-3 mb-md-0">
                                <input type="number" name="count" class="form-control">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <h3>Demand Post</h3></div>
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
            </div>
        </div>
    </section>
    <script>
        CKEDITOR.replace('editor');
    </script>
    <?php
    Footer();
    Scripts();
?>