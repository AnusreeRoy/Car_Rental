<?php
include('../php/db.php'); // Include your database connection script

if (isset($_GET["q"])) {
    $q = $_GET["q"];
    $hint = "";

    // Search for car models containing the query string in the car_model column
    $sql = "SELECT * FROM car_details WHERE car_model LIKE '%$q%'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $car_model = $row['car_model'];
            $car_id = $row['id'];
            $car_link = "car_details.php?car_id=$car_id"; // Include car_id in the URL
            $hint .= "<a href='$car_link'>" . $car_model . "</a><br>";
        }
    } else {
        $hint = "No matches found";
    }

    echo $hint;
}
?>
