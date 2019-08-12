<?php
function getSeason(){
  date_default_timezone_set('America/Chicago');
  $currentMonth = date("m");

  IF ($currentMonth>="03" && $currentMonth<="05")
    $season = "spring";
  ELSEIF ($currentMonth>="06" && $currentMonth<="08")
    $season = "summer";
  ELSEIF ($currentMonth>="09" && $currentMonth<="11")
    $season = "fall";
  ELSE
    $season = "winter";

  return $season;
}

function isWorkday(){
  date_default_timezone_set('America/Chicago');
  echo $currentDay;
  IF($currentDay != "Saturday" && $currentDay != "Sunday"){
    return true;
  }
  ELSE
    return false;
  }

  function sunPosition(){
    date_default_timezone_set('America/Chicago');
    $current_time = date('H:i');
    $latitude = 40.813600;
    $longitude = -96.702610;
    $sunrise = date_sunrise(time(),SUNFUNCS_RET_STRING,$latitude,$longitude,90,-5);
    $sunset = date_sunset(time(),SUNFUNCS_RET_STRING,$latitude,$longitude,90,-5);
$arr_time = DateTime::createFromFormat('H:i', $current_time);

$arr_set = DateTime::createFromFormat('H:i', $sunset);
$arr_dusk = date('H', $arr_set);
$arr_rise = DateTime::createFromFormat('H:i', $sunrise);
 if ($arr_time > $arr_rise && $arr_time < $arr_set)
{
   echo 'the sun is up.</br>';
}
else {
  echo 'the sun is down.</br>';
}
    // Lisbon, Portugal:
    // Latitude: 38.4 North, Longitude: 9 West
    // Zenith ~= 90, offset: +1 GMT

    echo("Lincoln, NE: Date: " . date("D M d Y H:i"));
    echo "<br>Sunset time: " . $sunset;
    echo "<br>Sunrise time: " . $sunrise;
    echo "<br>Dusk End time: " . date('H:i',strtotime('+85 minutes',strtotime($sunset)));
    echo "<br>Dawn Start time: " . date('H:i',strtotime('-85 minutes',strtotime($sunrise)));
  }
