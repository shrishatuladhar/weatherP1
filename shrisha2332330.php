<?php
// Database configuration
$hostname = "localhost"; // MySQL server hostname
$username = "root"; // MySQL username
$password = ""; // MySQL password
$dbname = "weather_app"; // MySQL database name

// Create a new MySQL connection
$conn = new mysqli($hostname, $username, $password, $dbname);

// Check if the MySQL connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to retrieve weather data for a city using the Weatherbit API and store it in the database
function getWeatherDatas($city, $api_key, $conn) {
  // Check if the MySQL connection is valid
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Delete any existing weather data for the searched city
  $stmt = $conn->prepare("DELETE FROM weather_data WHERE city = ?");
  $stmt->bind_param("s", $city);
  $stmt->execute();

  // Define the start and end dates for the API request (7 days ago until today)
  $start_date = date("Y-m-d", strtotime("-7 days"));
  $end_date = date("Y-m-d");

  // Construct the API request URL using the provided city and API key
  $url = "https://api.weatherbit.io/v2.0/history/daily?city=" . $city . "&start_date=".$start_date."&end_date=".$end_date."&key=".$api_key;

  // Use cURL to make the API request
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $result = curl_exec($ch);

  // Check if the API request was successful
  if ($result === false) {
    die("Curl error: " . curl_error($ch));
  }

  // Parse the JSON response from the API into a PHP array
  $data = json_decode($result, true);

  // Prepare a MySQL statement to insert the weather data into the database
  $stmt = $conn->prepare("INSERT INTO weather_data (city, date, temp, humidity, pressure, wind_speed) VALUES (?, ?, ?, ?, ?, ?)");

  // Loop through each day in the API response and insert its weather data into the database
  foreach ($data["data"] as $day) {
    $date = $day["datetime"];
    $temp = $day["temp"];
    $humidity = $day["rh"];
    $pressure = $day["pres"];
    $wind_speed = $day["wind_spd"];

    $stmt->bind_param("ssiiii", $city, $date, $temp, $humidity, $pressure, $wind_speed);
    $stmt->execute();
  }

  // Close the MySQL statement and cURL connection
  $stmt->close();
  curl_close($ch);
}


// Check if a city was submitted via the search form
$city = "";
if (isset($_POST['search'])) {
  $city = $_POST['searchQuery'];
  $api_key = "beab4338ffda4e809d50296a8dab6f7b"; // Weatherbit API key

  // Call the getWeatherData function to retrieve the weather data for the searched city and store it in the database
  getWeatherDatas($city, $api_key, $conn);

  // Update the $sql query to retrieve data for the searched city instead of Wealden
  $sql = "SELECT * FROM weather_data WHERE city='" . $city . "' AND date >= DATE(NOW()) - INTERVAL 7 DAY ORDER BY date DESC";
} else {
  $sql = "SELECT * FROM weather_data WHERE city='Wealden' AND date >= DATE(NOW()) - INTERVAL 7 DAY ORDER BY date DESC";
}

$result = mysqli_query($conn, $sql);

// Display the weather data on the webpage
if ($result->num_rows > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    echo "<div class='card'>";
    echo "<div class='container'>";
    echo "<div class='city'>" . $row["city"] . "</div>";
    echo "<div class='date'>" . date("F j, Y", strtotime($row["date"])) . "</div>";
    echo "<div class='weather-data'>";
    echo "<p>Temperature: " . $row["temp"] . "°C</p>";
    echo "<p>Humidity: " . $row["humidity"] . "%</p>";
    echo "<p>Pressure: " . $row["pressure"] . " hPa</p>";
    echo "<p>Wind Speed: " . $row["wind_speed"] . " km/h</p>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
  }
} else {
  echo "No results found.";
}


include 'index(2332330).php';
$conn->close();


?>
