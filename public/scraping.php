<?php
/**
 * Demo page used to demonstrate web scraping.
 * 
 * PHP version 8
 *
 * @category Webtech_Demo
 * @package  Webtech_Demo
 * @author   Rafael Alexander Muijsert <rafael@muijsert.org>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */

$URL = "http://www.scrapethissite.com/pages/simple/";

$curl = curl_init($URL);
if ($curl === false) {
    die("Could not initialize cURL");
}
/* Return response as a string. */
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
/* Follow any encountered redirects. */
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

/* Send the request to the destination. */
$response = curl_exec($curl);
if ($response === false || $response === true) {
    die("Could not read response");
}

/* Create an empty DOM. */
$dom = new DOMDocument();

/* Prevent warnings from malformed HTML pages. */
$previous_state = libxml_use_internal_errors(true);

/* Parse the HTML from response. */
$dom->loadHTML($response);

/* Reset to previous setting. */
libxml_clear_errors();
libxml_use_internal_errors($previous_state);

$xpath = new DOMXPath($dom);
/* Retrieve all h3 elements with a country-name class. */
$countryElements = $xpath->query("//h3[contains(@class, 'country-name')]");
if ($countryElements === false) {
    die("Could not read countries from response");
}

$countries = [];
foreach ($countryElements as $country) {
    /* Extract the node value (i.e.: country name string) */
    array_push($countries, $country->nodeValue);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Webtech Demo</title>
    <link rel="stylesheet" href="/css/main.css" type="text/css">
    <link rel="stylesheet" href="/css/partial/style.css" type="text/css">
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
  </head>
  <body>
    <?php require_once "../src/components/header.php" ?>
    <?php require_once "../src/components/navbar.php" ?>
    <main>
      <div class="container">
        <h1>Webscraping</h1>
        <p>Select a country</p>
        <select name="countries">
        <?php foreach ($countries as $country): ?>
          <option><?php echo $country; ?></option>
        <?php endforeach; ?>
        </select>
      </div>
    </main>
    <?php require_once "../src/components/footer.php" ?>
  </body>
</html>
