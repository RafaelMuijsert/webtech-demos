<?php

/**
 * Scrape all countries from an external website.
 *
 * PHP version 8
 *
 * @category Webtech_Demo
 * @package  Webtech_Demo
 * @author   Rafael Alexander Muijsert <rafael@muijsert.org>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */


/**
 * Scrape a list of countries.
 *
 * @return array<string>: a list of scraped countries.
 */
function getCountries()
{
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
        $country_name = $country->nodeValue;
        if (is_string($country_name)) {
            array_push($countries, $country_name);
        }
    }
    return $countries;
}
