<?php

add_shortcode( 'flight_scraper_by_airport', function ($attributes){
  $API_KEY = get_option('aviation_stack_api_key', '');

  if ($API_KEY === '') {
    return 'Please enter your Aviation stack API key';
  }

  // Get the shortcode attributes 
  $attributes = shortcode_atts(array(
    'airport_iata' => '',
  ), $attributes);

    // Validate the API key
  if (!$attributes['airport_iata']) {
    return 'Please provide airport IATA code.';
  }

  ?>

  <div>
    <form id="airportForm">
      <input type="hidden" name="action" value="fetch_flights">
      <input type="hidden" name="airport" value="<?php echo $attributes['airport_iata']; ?>">
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
