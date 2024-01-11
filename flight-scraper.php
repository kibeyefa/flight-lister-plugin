<?php

add_shortcode( 'flight_scraper', function (){
  $API_KEY = get_option('aviation_stack_api_key', '');

  if ($API_KEY === '') {
    return 'Please enter your Aviation stack API key';
  }

  ?>

  <div>
    <form class="airportForm">
      <input type="hidden" name="action" value="fetch_flights">
      <input type="text" name="airport" placeholder="Enter Airport IATA" required>
      <select name="option" id="flight-option">
        <option value="arrival">Arrivals</option>
        <option value="departure">Departures</option>
      </select>

      <input type="submit" value="Check flights" style="background: <?php echo esc_attr(get_option('flight_lister_color', ''));  ?>">
    </form>


    <div id="loader" style="display: none; margin-top: 10px; border-top: 16px solid <?php echo esc_attr(get_option('flight_lister_color', '')); ?>;">

    </div>
    <div id="returnContent" class="flight-container"></div>
  </div>

  <?php
});


function flight_scraper(){
  $airportIATA = $_REQUEST['airport'];
  $option = $_REQUEST['option'];
  $API_KEY = get_option('aviation_stack_api_key', '');

  if ($option === 'arrival') {
    $queryString = http_build_query([
      'access_key' => $API_KEY,
      'arr_iata' => $airportIATA
    ]);
  } else {
    $queryString = http_build_query([
      'access_key' => $API_KEY,
      'dep_iata' => $airportIATA
    ]);
  }

  $ch = curl_init(sprintf('%s?%s', 'http://api.aviationstack.com/v1/flights', $queryString));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);

  if (curl_errno($ch)) {
    $error = array('error' => 'Internal server: ' . curl_error($ch));
    // Handle the error as needed
    echo json_encode($error);
    wp_send_json_error($error, 500 );
    
  } else {
    // Decode the JSON response
    $data = json_decode($response, true);

    // Check for API errors
    if (isset($data['error'])) {
      $apiError = array('error' => 'API error: ' . $data['error']['info']);
      // Handle the API error as needed
      wp_send_json_error($apiError, 500 );
    } else {
      // Data fetched successfully
      wp_send_json_success($data, 200);
      // You can now work with the $data array
    }
  }

  curl_close($ch);
}

add_action( 'wp_ajax_fetch_flights', 'flight_scraper');
add_action( 'wp_ajax_nopriv_fetch_flights', 'flight_scraper');