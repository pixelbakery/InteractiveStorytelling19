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


  function workHours(){
    date_default_timezone_set('America/Chicago');
    $now = new DateTime();
    $begin = new DateTime('8:00');
    $end = new DateTime('17:00');

    if ($now >= $begin && $now <= $end){
      echo 'The office is occupied.';
    }
    else{
      echo 'the office is empty.';
    }
  }


function checkBirthdays(){
  readBirthdays();

  $now = new DateTime();
  $ymdNow = $now->format('Y-m-d');
}

function readBirthdays(){
  /*
   * We need to get a Google_Client object first to handle auth and api calls, etc.
   */
   
  $client = new \Google_Client();
  $client->setApplicationName('My PHP App');
  $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
  $client->setAccessType('offline');

  /*
   * The JSON auth file can be provided to the Google Client in two ways, one is as a string which is assumed to be the
   * path to the json file. This is a nice way to keep the creds out of the environment.
   *
   * The second option is as an array. For this example I'll pull the JSON from an environment variable, decode it, and
   * pass along.
   */
  $jsonAuth = getenv('../pb-website-1531841796308-b6f984ab3355.json');
  $client->setAuthConfig(json_decode($jsonAuth, true));

  /*
   * With the Google_Client we can get a Google_Service_Sheets service object to interact with sheets
   */
  $sheets = new \Google_Service_Sheets($client);

  /*
   * To read data from a sheet we need the spreadsheet ID and the range of data we want to retrieve.
   * Range is defined using A1 notation, see https://developers.google.com/sheets/api/guides/concepts#a1_notation
   */
  $data = [];

  // The first row contains the column titles, so lets start pulling data from row 2
  $currentRow = 2;

  // The range of A2:H will get columns A through H and all rows starting from row 2
  $spreadsheetId = getenv('18d7CaEH2bkG-5jy2CvkVZ4sA_edlPmc-0YuR-r8bTqw');
  $range = 'A2:H';
  $rows = $sheets->spreadsheets_values->get($spreadsheetId, $range, ['majorDimension' => 'ROWS']);
  if (isset($rows['values'])) {
      foreach ($rows['values'] as $row) {
          /*
           * If first column is empty, consider it an empty row and skip (this is just for example)
           */
          if (empty($row[0])) {
              break;
          }

          $data[] = [
              'col-a' => $row[0],
              'col-b' => $row[1],
              'col-c' => $row[2],
              'col-d' => $row[3],
              'col-e' => $row[4],
              'col-f' => $row[5],
              'col-g' => $row[6],
              'col-h' => $row[7],
          ];

          /*
           * Now for each row we've seen, lets update the I column with the current date
           */
          $updateRange = 'I'.$currentRow;
          $updateBody = new \Google_Service_Sheets_ValueRange([
              'range' => $updateRange,
              'majorDimension' => 'ROWS',
              'values' => ['values' => date('c')],
          ]);
          $sheets->spreadsheets_values->update(
              $spreadsheetId,
              $updateRange,
              $updateBody,
              ['valueInputOption' => 'USER_ENTERED']
          );

          $currentRow++;
      }
  }

  print_r($data);
}
