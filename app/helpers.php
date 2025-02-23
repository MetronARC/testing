<?php

if (!function_exists('isValidPhoneNumber')) {
  function isValidPhoneNumber($phoneNumber)
  {
    // Define a regular expression pattern for valid phone numbers
    $pattern = '/^\+?[0-9]{1,3}[-\s]?[0-9]{1,14}$/';

    // Use the preg_match function to check if the phone number matches the pattern
    return preg_match($pattern, $phoneNumber) === 1;
  }
}

if (!function_exists('isValidURL')) {
  function isValidURL($url)
  {
    // Remove whitespace from the URL
    $url = trim($url);

    // Use a regular expression to validate the URL format
    // This regex is a basic one and might not catch all edge cases.
    // You can modify it based on your specific requirements.
    $pattern = '/^(https?|ftp):\/\/[^\s\/$.?#].[^\s]*$/i';

    return (bool)preg_match($pattern, $url) && filter_var($url, FILTER_VALIDATE_URL);
  }
}

if (!function_exists('isValidYear')) {
  function isValidYear($year)
  {
    // Validate input as an integer
    $year = filter_var($year, FILTER_VALIDATE_INT);

    // Check if the input is an integer and falls within a reasonable range
    if ($year !== false && $year >= 1000 && $year <= date('Y')) {
      return true;
    } else {
      return false;
    }
  }
}

if (!function_exists('cdnUrl')) {
  function cdnUrl($url = '')
  {
    return env('CDN_URL') . $url;
  }
}

if (!function_exists('isDigit')) {
  function isDigit($digit)
  {
    if (is_int($digit)) {
      return true;
    } elseif (is_string($digit)) {
      return ctype_digit($digit);
    } else {
      // booleans, floats and others
      return false;
    }
  }
}

if (!function_exists('extractVideoID')) {
  // Function to extract the YouTube video ID from a URL
  function extractVideoID($url)
  {
    // Updated regular expression pattern to match YouTube video URLs
    $pattern = '/(?<=v=|\/videos\/|embed\/|youtu.be\/|\/v\/|\/e\/|watch\?v=|watch\?feature=player_embedded&v=|%2Fvideos%2F|embed%20%2F|youtu.be%20%2F|%2Fv%2F|%2Fe%2F|embed\?cid=|v=)([a-zA-Z0-9_-]{11})/';

    // Use preg_match to find the video ID in the URL
    if (preg_match($pattern, $url, $matches)) {
      $videoId = $matches[1];
      return $videoId;
    } else {
      return null;
    }
  }
}

if (!function_exists('addZeroBeforeNumber')) {
  function addZeroBeforeNumber($number, $length = 2)
  {
    // Use str_pad to add a leading zero
    $numberWithZero = str_pad($number, $length, '0', STR_PAD_LEFT);

    return $numberWithZero;
  }
}
