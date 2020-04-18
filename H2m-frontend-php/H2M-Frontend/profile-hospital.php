<?php 
require_once("layout.php");
include("APIs.php");


Head();

Navbar();

$data = getRequest($hospitalProfile . "3");
$name = "";
$email = "";
$city = "";
$country = "";
$myRequests = [];
$newRequests = [];

if($data['code'] == 200){
    $data = $data['data'];
    $name = $data["hospitalInfo"]["name"];
    $email = $data["hospitalInfo"]["email"];
    $city = $data["hospitalInfo"]["city"];
    $country =$data["hospitalInfo"]["country"];

    $i = 0;
    foreach($data["requests"] as $request){
        $myRequests[] = array(
            'id' => $request['id'],
            'speciality' => $request['speciality']['name'],
            'enabled' => $request['enabled'],
            'count' => $request['count'],
            'left' => $request['count'] - $data['leftPos'][$i]
        );
    }

    foreach($data["newRequests"] as $request){
        $newRequests[] = array(
            'id' => $request['id'],
            'userName' => $request['user']['name'],
            'status' => $request['status'],
            'time' => $request['time'],
            'speciality' => $request['speciality']['name']
        );
    }

}
else{
    echo "shit";
}


print_r($myRequests);




?>

    <div class="hero-wrap img ftco-candidates-2">
        <div class="overlay" style="z-index: -1;"></div>
        <div class="container">
            <div class="row d-md-flex no-gutters slider-text align-items-center justify-content-center" style="padding-top: 200px;height: auto;">
                <div class="col-md-12">
                    <div class="team d-md-flex p-4 bg-white" style="border-radius: 17px 17px 0 0px; margin-bottom: 0">
                        <div class="img" style="background-image: url(images/ny-hospital.jpg);"></div>
                        <div class="text pl-md-4">
                            <span class="location mb-0">New York, USA</span>
                            <h2>New York Hospital</h2>
                            <span class="position">+1 212-312-5000</span>
                            <p class="mb-2" style="color: #000000"></p>
                            <span class="seen">Last Request 3 hours ago</span>
                        </div>
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
                                                <th class="cell100 column2">Type</th>
                                                <th class="cell100 column3">All Positions</th>
                                                <th class="cell100 column3">Left Positions</th>
                                                <th class="cell100 column4">Status</th>
                                                <th class="cell100 column5">Close</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="table100-body js-pscroll ps ps--active-y">
                                    <table>
                                        <tbody>
                                            <tr class="row100 body">
                                                <td class="cell100 column2">Doctor</td>
                                                <td class="cell100 column3">5</td>
                                                <td class="cell100 column3">2</td>
                                                <td class="cell100 column4"> <span class="btn-pending">Pending</span></td>
                                                <td class="cell100 column5"><a href="#" class="btn-cancle">Close</a></td>
                                            </tr>
                                            <tr class="row100 body">
                                                <td class="cell100 column2">Doctor</td>
                                                <td class="cell100 column3">20</td>
                                                <td class="cell100 column3">0</td>
                                                <td class="cell100 column4"> <span class="btn-done">Completed</span></td>
                                                <td class="cell100 column5"></td>
                                            </tr>
                                            <tr class="row100 body">
                                                <td class="cell100 column2">Doctor</td>
                                                <td class="cell100 column3">2</td>
                                                <td class="cell100 column3">1</td>
                                                <td class="cell100 column4"> <span class="btn-cancelled">Cancelled</span></td>
                                                <td class="cell100 column5"></td>
                                            </tr>
                                            <tr class="row100 body">
                                                <td class="cell100 column2">Doctor</td>
                                                <td class="cell100 column3">14</td>
                                                <td class="cell100 column3">0</td>
                                                <td class="cell100 column4"> <span class="btn-done">Completed</span></td>
                                                <td class="cell100 column5"></td>
                                            </tr>
                                            <tr class="row100 body">
                                                <td class="cell100 column2">Doctor</td>
                                                <td class="cell100 column3">53</td>
                                                <td class="cell100 column3">0</td>
                                                <td class="cell100 column4"> <span class="btn-done">Completed</span></td>
                                                <td class="cell100 column5"></td>
                                            </tr>

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
                                                <th class="cell100 column1">Name</th>
                                                <th class="cell100 column2">Type</th>
                                                <th class="cell100 column4">Status</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="table100-body js-pscroll ps ps--active-y">
                                    <table>
                                        <tbody>
                                            <tr class="row100 body">
                                                <td class="cell100 column1">Monica Chang</td>
                                                <td class="cell100 column2">Doctor</td>
                                                <td class="cell100 column3"><a href="#" class="btn-done">Accept</a> <a href="#" class="btn-cancle">Cancel</a></td>
                                            </tr>
                                            <tr class="row100 body">
                                                <td class="cell100 column1">Mahmoud Abdelhadi</td>
                                                <td class="cell100 column2">Doctor</td>
                                                <td class="cell100 column3"><a href="#" class="btn-done">Accept</a> <a href="#" class="btn-cancle">Cancel</a></td>
                                            </tr>
                                            <tr class="row100 body">
                                                <td class="cell100 column1">Alexa Spagnola</td>
                                                <td class="cell100 column2">Nurse</td>
                                                <td class="cell100 column3"><a href="#" class="btn-done">Accept</a> <a href="#" class="btn-cancle">Cancel</a></td>
                                            </tr>
                                            <tr class="row100 body">
                                                <td class="cell100 column1">Amr Darawsheh</td>
                                                <td class="cell100 column2">Doctor</td>
                                                <td class="cell100 column3"><a href="#" class="btn-done">Accept</a> <a href="#" class="btn-cancle">Cancel</a></td>
                                            </tr>
                                            <tr class="row100 body">
                                                <td class="cell100 column1">Danish Nihal</td>
                                                <td class="cell100 column2">Doctor</td>
                                                <td class="cell100 column3"><a href="#" class="btn-done">Accept</a> <a href="#" class="btn-cancle">Cancel</a></td>
                                            </tr>

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
    Footer();
    Scripts();
?>