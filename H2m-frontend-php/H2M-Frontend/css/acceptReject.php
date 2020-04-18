<?php

$requestId = $_GET['requestId'];
$action = $_GET['action'];

if($action == 1){
    $data = getRequest($AcceptReject."EmployeeRequestId=$requestId"."&AcceptOrDecline=True");
    $message = '
    <div class="alert alert-success" role="alert">
      '.$data['data']['msg'].'
    </div>
    ';
    
}
else if($action == 2){
    $data = getRequest($AcceptReject."EmployeeRequestId=$requestId"."&AcceptOrDecline=True");
    $message = '
    <div class="alert alert-success" role="alert">
      '.$data['data']['msg'].'
    </div>
    ';
}

else if(action == 3){
    $data = getRequest($AcceptReject."EmployeeRequestId="."&AcceptOrDecline=True");

}



?>