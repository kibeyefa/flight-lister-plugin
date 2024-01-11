<?php

add_shortcode( 'flight_scraper_default', function (){
  $API_KEY = get_option('aviation_stack_api_key', '');

  if ($API_KEY === '') {
    return 'Please enter your Aviation stack API key';
  }

  ?>

  <div>
    <form id="airportFormDefault">
      <input type="hidden" name="action" value="fetch_flights">
      <div class="flight-form-flex">
        <div class="flight-form-group">
          <select name="country" id="country" required>
            <option value="null">Select country</option>
          </select>
        </div>
        
        <div class="flight-form-group">
          <select name="airport" id="airport">
            <option value="null">Choose airport</option>
          </select>
        </div>
        
        <div class="flight-form-group">
          <select name="option" id="flight-option">
            <option value="arrival">Arrivals</option>
            <option value="departure">Departures</option>
          </select>
        </div>
        <input type="submit" value="Check flights" style="background: <?php echo esc_attr(get_option('flight_lister_color', ''));  ?>">
      </div>
    </form>

    <div id="flight-error" class="flight-display-none"></div>
    <div id="loader" style="display: none; margin-top: 10px; border-top: 16px solid <?php echo esc_attr(get_option('flight_lister_color', '')); ?>;">
    </div>
    <div id="returnContent" class="flight-container"></div>
  </div>

  <?php
});


// function flight_scraper_default(){
//   $airportIATA = $_REQUEST['airport'];
//   $option = $_REQUEST['option'];
//   $API_KEY = get_option('aviation_stack_api_key', '');

//   if ($option === 'arrival') {
//     $queryString = http_build_query([
//       'access_key' => $API_KEY,
//       'arr_iata' => $airportIATA
//     ]);
//   } else {
//     $queryString = http_build_query([
//       'access_key' => $API_KEY,
//       'dep_iata' => $airportIATA
//     ]);
//   }

//   $ch = curl_init(sprintf('%s?%s', 'http://api.aviationstack.com/v1/flights', $queryString));
//   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//   $json = curl_exec($ch);
//   curl_close($ch);

//   $flights = json_decode($json, true);
//   // $url = "http://api.aviationstack.com/v1/flights?access_key={$API_KEY}&arr_iata={$airport_iata}&limit=100";
//   // $response = json_decode(file_get_contents($url));


//   wp_send_json_success($flights, 200);

// }

// add_action( 'wp_ajax_fetch_flights', 'flight_scraper');
// add_action( 'wp_ajax_nopriv_fetch_flights', 'flight_scraper');

// function fetch_countries(){

// }

// add_action('wp_ajax_fetch_countries', 'fetch_countries');
// add_action('wp_ajax_nopriv_fetch_countries', 'fetch_countries');



// function fetch_airports(){

// }

// add_action('wp_ajax_fetch_airports', 'fetch_airports');
// add_action('wp_ajax_nopriv_fetch_airports', 'fetch_airports');