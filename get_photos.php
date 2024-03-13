<?php

// Check if latitude and longitude are provided
if (isset($_POST['latitude']) && isset($_POST['longitude'])) {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Your Google Maps API key
    $api_key = 'AIzaSyBck6XZj5sQ-97B3VYiULzMA7az-sZld4Q';

    // Construct the request URL
    $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=$latitude,$longitude&radius=500&key=$api_key";

    // Send the request to Google Maps API
    $response = file_get_contents($url);

    // Decode JSON response
    $data = json_decode($response, true);

    // Check if there are any results
    if ($data['status'] == 'OK') {
        $photos = [];
        foreach ($data['results'] as $result) {
            if (isset($result['photos'])) {
                foreach ($result['photos'] as $photo) {
                    $photos[] = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference={$photo['photo_reference']}&key=$api_key";
                }
            }
        }

        // Output the photos
        echo "<h2>Photos:</h2>";
        foreach ($photos as $photo) {
            echo "<img src='$photo'><br>";
        }
    } else {
        echo "No photos found for the provided location.";
    }
} else {
    echo "Latitude and Longitude are required.";
}
?>
