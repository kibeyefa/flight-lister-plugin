# flight-lister-plugin
A wordpress plugin than scrapes flight data from aviation stack.

Welcome to My Flight Lister WordPress Plugin using AviationStack API, your go-to solution for integrating aviation data seamlessly into your WordPress website. This plugin comes equipped with three powerful shortcodes, allowing you to display detailed information about real time flight data, and lists them in a table (Note,it lists just the first 100). Additionally, you can conveniently store your Aviation Stack API key in the admin settings for smooth data retrieval.

#### Installation
- Download: Grab the plugin zip file from the [GitHub repository](https://github.com/kibeyefa/flight-lister-plugin/) or [using this link](https://dev-kibeyefa.pantheonsite.io/wp-content/uploads/2024/01/flight-lister.zip).
- Upload: Navigate to your WordPress admin panel, head to Plugins > Add New, click “Upload Plugin,” and select the downloaded zip file.
- Activate: Once uploaded, activate the plugin from the Plugins page.

#### Configuration
- Get your API Key from aviation stack. [Get yours here](https://aviationstack.com/signup/)
- Admin Settings: Access the WordPress admin dashboard, click on “Settings,” and select “Flight Lister.”
- API Key: Enter your Aviation Stack API key in the designated field.
- Save Changes: Don’t forget to click “Save Changes” to store your API key securely.

#### Shortcodes
###### 1. Flight Scraper
This shortcode lets you type in an airport’s IATA code and choose if you want to view arriving or departing flights. See example below

> [flight_scraper]

###### 2. Flight scraper by Airport
This shortcode lets you set a default airport and then view either arriving or departing flights. See example below

> [flight_scraper_by_airport airport_iata="MAN"]

###### 3. Flight scraper default
This shortcode lets you set a choose a country, and it displays a list of ariports within that country for you to choose from, and then displays either arriving or departing flights. See example below

> [flight_scraper_default]

Feel free to embed these shortcodes in any post or page to showcase dynamic aviation data on your WordPress site. Ensure your API key is correctly configured in the plugin settings for accurate data retrieval.

#### Support and Issues
Encountering issues or have questions? Visit the GitHub repository for support, bug reports, or feature requests. Your feedback is valuable!

Thank you for choosing the Aviation Stack WordPress Plugin! Elevate your website with aviation insights.
