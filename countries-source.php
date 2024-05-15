<?php

// Fetch countries data from API
$countriesData = file_get_contents('https://api.first.org/data/v1/countries');
$countriesData = json_decode($countriesData, true);

// Extract country names
$countries = array_column($countriesData['data'], 'country');

// Shuffle the array
shuffle($countries);

// Select the first 30 countries
$selectedCountries = array_slice($countries, 0, 30);