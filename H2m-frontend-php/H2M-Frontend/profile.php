<?php 
require_once("layout.php");
require_once("APIs.php");


Head();

Navbar();

$message = "";

if(isset($_POST['closeRequest'])){

    $requestId = $_POST['requestId'];
    $data = getRequest($CancelDoctorRequest.$requestId);
    $message = '
    <div class="alert alert-success" role="alert">
      '.$data['data']['msg'].'
    </div>
    ';

}


$data = getRequest($profile . $userId);

$userInfo = $data['userInfo'];
$name = $userInfo["name"];
$email = $userInfo["email"];
$city = $userInfo["city"]["name"];
$country =$userInfo["country"]["name"];


$specialties = "";
foreach($data['specialtiesList'] as $spec){
    $specialties .= '<span class="position">'.$spec.'</span>';
}

$requests = "";
foreach($data['requests'] as $request){
    $status = $request['status'];
    if($status == 1){
        $status = '<span class="btn btn-done btn-block">Accepted</span>';
        $cancel = "";
    }
    else if($status == -1){
        $status = '<span class="btn btn-cancelled btn-block">Declined</span>';
        $cancel = "";
    }
    else{
        $status = '<span class="btn btn-pending btn-block">Pending</span>';
        $cancel = '<input type="submit" name="closeRequest" value="Cancel" class="btn btn-cancle">';
    }
    $timestamp = strtotime($request['time']);
    $new_date = date("d-m-Y", $timestamp);

    $requests .= '<tr class="row100 body">
        <td class="cell100 column5">'.$request['id'].'</td>
        <td class="cell100 column1">'.$request['name'].'</td>
        <td class="cell100 column5">'.$data['specialtiesList'][0].'</td>
        <td class="cell100 column5">'.$new_date.'</td>
        <td class="cell100 column5">'.$status.'</td>
        <td class="cell100 column5"><form method="post"><input hidden name="requestId" value="'.$request['id'].'">'.$cancel.'</form></td>
    </tr>
    ';
}



?>
    <div class="hero-wrap img ftco-candidates-2">
        <div class="overlay" style="z-index: -1;"><?php Animation() ?></div>
        <div class="container">
            <div class="row d-md-flex no-gutters slider-text align-items-center justify-content-center" style="padding-top: 200px;height: auto;">
                <div class="col-md-12">
                <?php echo $message ?>
                    <div class="team d-md-flex p-4 bg-white" style="border-radius: 17px 17px 0 0px; margin-bottom: 0">
                        <div class="img" style="background-image: url(images/person_1.jpg);"></div>
                        <div class="text pl-md-4">
                            <span class="location mb-0"><?php echo $city.", ".$country ?></span>
                            <h2><?php echo $name ?></h2>
                            
                            <span class="position">+971 2 5546325</span>
                            <span class="position"><?php echo $email ?></span>
                            <p class="mb-2" style="color: #000000"></p>
                            <span class="seen">Last Contribute 2 days ago</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                <div class="table profile" style="padding: 50px;background: #fff;">

<div class="table100 ver1 m-b-110">
    <div class="table100-head">
        <table>
            <thead>
                <tr class="row100 head" style="Background: linear-gradient(to right, #1274fe 0%, #384e9f 100%);">
                    <th class="cell100 column5">ID</th>
                    <th class="cell100 column1">Hospital name</th>
                    <th class="cell100 column5">Type</th>
                    <th class="cell100 column5">Time</th>
                    <th class="cell100 column5">Status</th>
                    <th class="cell100 column5">Cancle</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="table100-body js-pscroll ps ps--active-y">
        <table>
            <tbody>
                <?php echo $requests ?>
            </tbody>
        </table>
        <div class="ps__rail-x" style="left: 0px; bottom: -374.4px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 374.4px; height: 585px; right: 5px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 188px; height: 294px;"></div>
        </div>
    </div>
</div>

</div>
</div>
            </div>

           

        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script>
        $('.js-pscroll').each(function() {
            var ps = new PerfectScrollbar(this);

            $(window).on('resize', function() {
                ps.update();
            })
        });
    </script>

    <script src="js/table.js"></script>

    <?php
    Footer();
    Scripts();
?>