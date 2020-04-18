<?php
    $baseURL = "http://localhost:57984/";
    $hospitalProfile = $baseURL .  "GetHospital?ID=";
    $profile = $baseURL ."GetProfile?";
    $Peak = $baseURL ."Peak?";



    function getRequest($url){
        $data = file_get_contents($url);
        return json_decode($data,true);
    }



?>