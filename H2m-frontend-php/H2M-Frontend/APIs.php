<?php
    $baseURL = "http://localhost:57984/";
    $hospitalProfile = $baseURL .  "GetHospital?ID=";
    $profile = $baseURL ."MyProfile?userId=";
    $Peak = $baseURL ."Peak?";
    $AcceptReject = $baseURL . "AcceptRejectApplications?";



    function getRequest($url){
        $data = file_get_contents($url);
        return json_decode($data,true);
    }



?>