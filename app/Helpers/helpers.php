<?php

  function convert_date($value) {
    return date('H:i:s - d M Y', strtotime($value));
  };
  //
  function validate_boolean($value){
    if($value == 1) {
      return true;
    }else{
      return false;
    };
  };
  function validate_checkThings($value,$value1){
    if($value == $value1) {
      return true;
    }else{
      return false;
    };
  };
  function validate_transactionStatus($value){
    if($value == "finished") {
      return true;
    }else{
      return false;
    };
  };
  function validate_valueIn($value,$inArray){
    if(in_array($value,$inArray)) {
      return 1;
    }else{
      return 0;
    };
  };
  function objectToArray($object){
    $array = json_decode(json_encode($object), true);
    return $array;
  };
  function count_interval($start,$end){
    $startTimeStamp = strtotime($start);
    $endTimeStamp = strtotime($end);

    $timeDiff = abs($endTimeStamp - $startTimeStamp);

    $numberDays = $timeDiff/86400;  // 86400 seconds in one day

    // and you might want to convert to integer
    $numberDays = intval($numberDays);

    return $numberDays;
  };
  function rupiah($angka){
	
    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
    return $hasil_rupiah;
   
  }

?>