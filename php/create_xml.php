<?php
// Include database connection
include('../php/db.php');

// Query to fetch all data from the car_details table
$query = "SELECT * FROM car_details";
$result = mysqli_query($con, $query);

// Create a new DOMDocument
$xmlDoc = new DOMDocument();
$xmlDoc->formatOutput = true;

// Create the root element
$root = $xmlDoc->createElement("cars");
$xmlDoc->appendChild($root);

// Loop through each row of the result set
while ($row = mysqli_fetch_assoc($result)) {
    // Create a car element for each row
    $car = $xmlDoc->createElement("car");
    $root->appendChild($car);

    // Add data as child elements to the car element
    foreach ($row as $key => $value) {
        $child = $xmlDoc->createElement($key, $value);
        $car->appendChild($child);
    }

    // Add an 'id' element to the car element
    $id = $xmlDoc->createElement("id", $row['id']);
    $car->appendChild($id);
}

// Save the XML document to a file
$xmlDoc->save("links.xml");

echo "XML file created successfully.";
?>
