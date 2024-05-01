<?php
// Load the XML file
$xml = simplexml_load_file("links.xml");

// Check if the query parameter is set
if (isset($_GET["q"])) {
    $q = $_GET["q"];
    $hint = "";

    // Search for car models containing the query string
    foreach ($xml->children() as $car) {
        $car_model = (string)$car->car_model;
        $car_id = (string)$car->id;
        $car_link = "car_details.php?car_id=$car_id"; // Include car_id in the URL

        if (stripos($car_model, $q) !== false) {
            $hint .= "<a href='$car_link'>" . $car_model . "</a><br>";
        }
    }
    // Output search results
    echo $hint === "" ? "No matches found" : $hint;
}
?>
<?php