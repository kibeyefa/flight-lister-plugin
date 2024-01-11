const scraperForm = document.getElementById('airportForm');
const returnContent = document.getElementById('returnContent');
const loader = document.getElementById('loader');

const airportFormDefault = document.getElementById('airportFormDefault');

if (scraperForm !== null) {
  scraperForm.addEventListener('submit', (event) => {
    event.preventDefault();
    loader.style.display = 'block';
    returnContent.innerHTML = '';
    let option = document.getElementById('flight-option').value;
    fetch(flight_obj.ajax_url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: new URLSearchParams(new FormData(scraperForm)),
    })
      .then((response) => {
        // console.log(response.json());
        return response.json();
      })
      .then((jsonResponse) => {
        const table = document.createElement('table');
        const tbody = document.createElement('tbody');
        table.innerHTML = `
        <thead>
          <tr>
            <th>Flight Date</th>
            <th> Est ${
              option == 'departure' ? 'Departure' : 'Arrival'
            } Time</th>
            <th>Airline</th>
            <th>Flight Number</th>
            <th>Status</th>
          </tr>
        </thead> 
        `;
        table.appendChild(tbody);
        console.log(jsonResponse.data);
        let data = jsonResponse.data.data;

        data.forEach((flight) => {
          let flight_date = flight.flight_date;
          let flight_status = flight.flight_status;
          let est_time = `${
            option == 'departure'
              ? flight.departure.estimated
              : flight.arrival.estimated
          }`;
          let airline = flight.airline.name;
          let flight_number = flight.flight.iata;

          let tr = document.createElement('tr');
          tr.innerHTML = `
      <td>${new Date(flight_date).toLocaleDateString()}</td>
      <td>${new Date(est_time).toLocaleString()}</td>
      <td>${airline}</td>
      <td>${flight_number}</td>
      <td class="${flight_status}">${flight_status}</td>
    `;
          tbody.appendChild(tr);
        });
        loader.style.display = 'none';
        returnContent.appendChild(table);

        console.log(jsonResponse.data);
      });
  });
}

//
if (airportFormDefault !== null) {
  const country = document.getElementById('country');
  const airport = document.getElementById('airport');
  const error = document.getElementById('flight-error');

  let country_data;

  const filePath =
    flight_obj.wp_content_url + '/plugins/flight-lister/lib/js/data.json';

  // Fetch the JSON data using the fetch API
  fetch(filePath)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.json();
    })
    .then((jsonData) => {
      // Work with the JSON data
      country_data = jsonData.countries;
      country_innerHTML = '';
      country_data.forEach((country) => {
        country_innerHTML += `
        <option value="${country.code}">${country.name}</option>`;
      });
      country.innerHTML += country_innerHTML;
    })
    .catch((error) => console.error('Error fetching JSON:', error));

  country.addEventListener('change', (e) => {
    let country_code = e.target.value;

    if (country_code !== 'null') {
      if (!error.classList.contains('flight-display-none')) {
        error.classList.add('flight-display-none');
      }

      let country = getSingleCountry(country_data, country_code);
      // console.log(country);
      let airports = country.airports;
      console.log(airports);
      let airport_innerHTML;
      airports.forEach((singleAirport) => {
        airport_innerHTML += `
        <option value="${singleAirport.airport_iata}">${singleAirport.airport_name}</option>
      `;
      });

      airport.innerHTML = airport_innerHTML;
    }
  });

  airportFormDefault.addEventListener('submit', (event) => {
    event.preventDefault();
    loader.style.display = 'block';
    returnContent.innerHTML = '';
    let option = document.getElementById('flight-option').value;
    fetch(flight_obj.ajax_url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: new URLSearchParams(new FormData(airportFormDefault)),
    })
      .then((response) => {
        // console.log(response.json());
        return response.json();
      })
      .then((jsonResponse) => {
        const table = document.createElement('table');
        const tbody = document.createElement('tbody');
        table.innerHTML = `
        <thead>
          <tr>
            <th>Flight Date</th>
            <th> Est ${
              option == 'departure' ? 'Departure' : 'Arrival'
            } Time</th>
            <th>Airline</th>
            <th>Flight Number</th>
            <th>Status</th>
          </tr>
        </thead> 
        `;
        table.appendChild(tbody);
        console.log(jsonResponse.data);
        let data = jsonResponse.data.data;

        data.forEach((flight) => {
          let flight_date = flight.flight_date;
          let flight_status = flight.flight_status;
          let est_time = `${
            option == 'departure'
              ? flight.departure.estimated
              : flight.arrival.estimated
          }`;
          let airline = flight.airline.name;
          let flight_number = flight.flight.iata;

          let tr = document.createElement('tr');
          tr.innerHTML = `
      <td>${new Date(flight_date).toLocaleDateString()}</td>
      <td>${new Date(est_time).toLocaleString()}</td>
      <td>${airline}</td>
      <td>${flight_number}</td>
      <td class="${flight_status}">${flight_status}</td>
    `;
          tbody.appendChild(tr);
        });
        loader.style.display = 'none';
        returnContent.appendChild(table);

        console.log(jsonResponse.data);
      });
  });
}

function getSingleCountry(object, code) {
  let return_country;

  object.forEach((country) => {
    if (country.code === code) {
      // console.log(country);
      return_country = country;
    }
  });

  return return_country;
}
