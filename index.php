<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="5" >
    <link rel="stylesheet" type="text/css" href="stylehome.css" media="screen"/>

	<title> WaterLevel </title>

</head>
<body>

    <h1>Water Level Monitoring</h1><br><br>
        <div style="width:60%;height:20%;text-align:center;">
            <marquee>Weather forecast</marquee>
        </div>
<div class="weatherWidget" ></div> 
<script>
   window.weatherWidgetConfig =  window.weatherWidgetConfig || [];
   window.weatherWidgetConfig.push({
       selector:".weatherWidget",
       apiKey:"6H5S8ALSAYDQMP365ZS2ETK7F",
       location:"Chandigarh, India", //Enter an address
       unitGroup:"metric", //"us" or "metric"
       forecastDays:5, //how many days forecast to show
       title:"Chandigarh, India", //optional title to show in the 
       showTitle:true, 
       showConditions:true
   });
  
   (function() {
   var d = document, s = d.createElement('script');
   s.src = 'https://www.visualcrossing.com/widgets/forecast-simple/weather-forecast-widget-simple.js';
   s.setAttribute('data-timestamp', +new Date());
   (d.head || d.body).appendChild(s);
   })();
</script>

<?php
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "waterlevel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, sensor, waterlevel, reading_time FROM sensordata ORDER BY id DESC"; /*select items to display from the sensordata table in the data base*/

echo '<table cellspacing="5" cellpadding="5">
      <tr> 
        <th>ID</th> 
        <th>Date and Time</th> 
        <th>Sensor</th> 
        <th>Water level</th>      
      </tr>';
 
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_id = $row["id"];
        $row_reading_time = $row["reading_time"];
        $row_sensor = $row["sensor"];
        $row_waterlevel = $row["waterlevel"];
        
        // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
       // $row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time - 1 hours"));
      
        // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 4 hours"));
      
        echo '<tr> 
                <td>' . $row_id . '</td> 
                <td>' . $row_reading_time . '</td> 
                <td>' . $row_sensor . '</td> 
                <td>' . $row_waterlevel . '</td> 
              </tr>';
    }
    $result->free();
}

$conn->close();
?> 
</table>

</body>
</html>