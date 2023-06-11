<!DOCTYPE html>
<html>
<head>
  <title>Weather Forecast</title>
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
<style>
    
    body {
        background-image: url('https://source.unsplash.com/1600x900/?bluesky');
        background-size: cover;
      }

      .card {
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
  transition: 0.3s;
  width: 30%;
  margin: 10px;
  border-radius: 10px;
  background-color: #ffffff;
  display: inline-block;
  vertical-align: top;
  text-align: center;
  margin-top: 70px;
}


.card:hover {
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
  transform: translateY(-5px);
}

.container {
  padding: 20px;
}

.city {
  font-size: 28px;
  font-weight: bold;
  margin-bottom: 10px;
  color: #263A47;
}

.weather-data {
  margin-bottom: 10px;
}

.weather-data p {
  margin: 0;
  font-size: 18px;
  color: #728495;
  line-height: 1.5;
}

.date {
  font-size: 16px;
  color: #728495;
  line-height: 1.5;
}

.card-row {
  margin-bottom: 30px;
  overflow: auto;
  white-space: nowrap;
}

.search-box {
  position: absolute;
  top: 20px;
  right: 20px;
  
}

label {
  font-size: 20px;
  color: #333;
}

input[type="text"] {
  padding: 10px;
  font-size: 18px;
  border: none;
  border-radius: 5px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

button[type="submit"] {
  padding: 10px 20px;
  background-color: #728495;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 18px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
  cursor: pointer;
}
button[type="submit"]:hover {
  background-color: #263A47;
}
</style>
</head>
<body>
<div class="search-box">
<form id="locationInput" action="shrisha2332330.php" method="post">
            <input type="text" class="search" placeholder="Search locations ..." name="searchQuery" id="searchQuery"/>
            <button type="submit" class="submit" name="search">
                <i class='bx bx-search-alt-2'></i>
            </button>
        </form>
</div>
<!--php-->
<?php
include 'shrisha2332330.php';
?>
</body>
</html>
