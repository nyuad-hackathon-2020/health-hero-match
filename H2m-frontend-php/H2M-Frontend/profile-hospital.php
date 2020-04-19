<?php 
require_once("layout.php");
include("APIs.php");


Head();

Navbar(true);

$message = '
';


if(isset($_POST['acceptRequest'])){
    
    $requestId = $_POST['requestId'];
    $data = getRequest($AcceptReject."EmployeeRequestId=$requestId"."&AcceptOrDecline=True");
    $message = '
    <div class="alert alert-success text-dark" role="alert">
      '.$data['data']['msg'].'
    </div>
    ';
    
}
else if(isset($_POST['rejctRequest'])){
    
    $requestId = $_POST['requestId'];
    $data = getRequest($AcceptReject."EmployeeRequestId=$requestId"."&AcceptOrDecline=False");
    $message = '
    <div class="alert alert-success" role="alert">
      '.$data['data']['msg'].'
    </div>
    ';
}

else if(isset($_POST['closeRequest'])){

    $requestId = $_POST['requestId'];
    $data = getRequest($CancelHospitalRequest.$requestId);
    $message = '
    <div class="alert alert-success" role="alert" style="color: #000000;">
      '.$data['data']['msg'].'
    </div>
    ';

}


$data = getRequest($hospitalProfile . "3");
$name = "";
$email = "";
$city = "45";
$country = "45";
$myRequests = [];
$newRequests = [];
$peak = "";

if($data['code'] == 200){
    $data = $data['data'];
    $name = $data["hospitalInfo"]["name"];
    $email = $data["hospitalInfo"]["email"];
    $city = $data["hospitalInfo"]["city"];
    $country =$data["hospitalInfo"]["country"];

    if($data['isPeak'] == true){
        $peak = '
        <div style="float: right;" class="col-md-4">
            <div class="alert alert-danger">
                <div class="container">
                <b>Surge Alert:</b> Your area is currently experiencing a surge of cases!
                </div>
            </div>
        </div>';
    }
    else{

    }

    $i = count($data['leftPos'])-1;
    foreach($data["requests"] as $request){
        $myRequests[] = array(
            'id' => $request['id'],
            'speciality' => $request['speciality']['name'],
            'enabled' => $request['enabled'],
            'count' => $request['count'],
            'left' => $data['leftPos'][$i]
        );
        $i--;
    }

    foreach($data["newRequests"] as $request){
        $timestamp = strtotime($request['time']);
        $new_date = date("d-m-Y", $timestamp);
        $newRequests[] = array(
            'id' => $request['id'],
            'userName' => $request['user']['name'],
            'status' => $request['status'],
            'time' => $new_date,
            'speciality' => $request['speciality']['name'],
            'requestId' => $request['requestId']
        );
    }

}
else{
    echo "SERVER ERROR";
}

$myReqs = "";
$color="";
foreach($myRequests as $request){
    if($request['enabled'] == 1){
        $enabled = "Waiting";
        $clooose = "<input type='submit' name='closeRequest' value='Close' class='btn-cancle'>";
        $color="pending";
    }
    else{
        $enabled = "Completed";
        $clooose = "";
        $color="done";
    }
    $myReqs .= '
    <form method="post">
        <tr class="row100 body">
            <td class="cell100 column5">'.$request["id"].'</td>
            <td class="cell100 column5">'.$request["speciality"].'</td>
            <td class="cell100 column5">'.$request["count"].'</td>
            <td class="cell100 column5">'.$request["left"].'</td>
            <td class="cell100 column5"> <span class="btn btn-'.$color.' btn-block">'.$enabled.'</span></td>
            <td class="cell100 column5"><form method="post"><input hidden name="requestId" value="'.$request["id"].'"> '.$clooose.'</form></td>
        </tr>
        </form>
    ';
}

$newReqs = "";
foreach($newRequests as $request){
    if($request['status'] == 0){
        $status = '<input type="submit" class="btn btn-success mr-3 px-3 float-left" value="✔" name="acceptRequest"> <input type="submit" class="btn btn-danger float-right" value="❌" name="rejectRequest">';
    }
    else{
        $status = "<span class='btn btn-success btn-block'>Accepted</span>";
    }
    $newReqs .= '
    <form method="post">
        <tr class="row100 body">
            <td class="cell100 column5">'.$request["id"].'</td>
            <td class="cell100 column5">'.$request["userName"].'</td>
            <td class="cell100 column5">'.$request["speciality"].'</td>
            <td class="cell100 column5">'.$request["time"].'</td>
            <td class="cell100 column5">'.$request["requestId"].'</td>
            <td class="cell100 column5 text-center"><form method="post"><input hidden value="'.$request["id"].'" name="requestId">'.$status.'</div></td>
            <td class="cell100 column5"> <button type="button" id="showModal" class="btn btn-light float-right mr-3" data-toggle="modal" data-target="#Contact">
            Contanct
        </button></td>

        </tr>
    </form>
    ';
}

?>

    <div class="hero-wrap img ftco-candidates-2">
<style>

.alert {
    border: 0;
    border-radius: 0;
    padding: 20px 15px !important;
    line-height: 20px;
    font-weight: 300;
    color: #fff;
}

.alert.alert-danger {
    background-color: #f55145;
    color: #fff;
}

</style>
    <div class="overlay" style="z-index: -1;"><?php Animation() ?></div>
        <div class="container">
            <div class="row d-md-flex no-gutters slider-text align-items-center justify-content-center" style="padding-top: 200px;height: auto;">
                <div class="col-md-12">
                <?php echo $message ?>
                    <div class="team d-md-flex p-4 bg-white" style="border-radius: 17px 17px 0 0px; margin-bottom: 0">
                        <div class="img" style="background-image: url(images/ny-hospital.jpg);"></div>
                        <div class="text pl-md-4 col-md-6">
                            <span class="location mb-0"><?php echo $city.", ".$country ?></span>
                            <h2><?php echo $name ?> Hospital</h2>
                            <span class="position">+971 2 5546325</span>
                            <span class="position"><?php echo $email ?> </span>
                            <p class="mb-2" style="color: #000000"></p>
                            <span class="seen">Last Request 3 hours ago</span>
                        </div>
                        <?php echo $peak; ?>
                    </div>
                </div>
            </div>

            <div class="p-5 bg-white rounded shadow mb-5">
                <!-- Lined tabs-->
                <ul id="myTab2" role="tablist" class="nav nav-tabs nav-pills with-arrow lined flex-column flex-sm-row text-center">
                    <li class="nav-item flex-sm-fill">
                        <a id="home2-tab" data-toggle="tab" href="#home2" role="tab" aria-controls="home2" aria-selected="true" class="nav-link text-uppercase font-weight-bold mr-sm-3 rounded-0 active">My Demands</a>
                    </li>
                    <li class="nav-item flex-sm-fill">
                        <a id="profile2-tab" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile2" aria-selected="false" class="nav-link text-uppercase font-weight-bold mr-sm-3 rounded-0">New Requests</a>
                    </li>
                </ul>
                <div id="myTab2Content" class="tab-content">
                    <div id="home2" role="tabpanel" aria-labelledby="home-tab" class="tab-pane fade px-4 py-5 active show">

                        <div class="table profile" style="background: #fff;">

                            <div class="table100 ver1 m-b-110">
                                <div class="table100-head">
                                    <table>
                                        <thead>
                                            <tr class="row100 head" style="Background: linear-gradient(to right, #1274fe 0%, #384e9f 100%);">
                                                <th class="cell100 column5">ID</th>
                                                <th class="cell100 column5">Type</th>
                                                <th class="cell100 column5">All Positions</th>
                                                <th class="cell100 column5">No of applicants</th>
                                                <th class="cell100 column5">Status</th>
                                                <th class="cell100 column5">Close</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="table100-body js-pscroll ps ps--active-y">
                                    <table>
                                        <tbody>
                                        <?php echo $myReqs ?>


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
                    <div id="profile2" role="tabpanel" aria-labelledby="profile-tab" class="tab-pane fade px-4 py-5">

                        <div class="table profile" style="background: #fff;">

                            <div class="table100 ver1 m-b-110">
                                <div class="table100-head">
                                    <table>
                                        <thead>
                                            <tr class="row100 head" style="Background: linear-gradient(to right, #1274fe 0%, #384e9f 100%);">
                                                <th class="cell100 column5">ID</th>
                                                <th class="cell100 column5">Name</th>
                                                <th class="cell100 column5">Type</th>
                                                <th class="cell100 column5">Time</th>
                                                <th class="cell100 column5">RequestId</th>
                                                <th class="cell100 column5">Status</th>
                                                <th class="cell100 column5">Contact</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="table100-body js-pscroll ps ps--active-y">
                                    <table>
                                        <tbody>
                                        <?php echo $newReqs ?>


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
                <!-- End lined tabs -->
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
    Contact();
    Footer();
    Scripts();
?>