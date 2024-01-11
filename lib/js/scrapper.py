import requests
import json


def fetch_and_store_data(api_url, output_file, offset=200):
    params = {'access_key': 'a38fce86f3fd7ab75a5f4586e8bc6841', 'offset': offset}
    response = requests.get(api_url, params)

    if response.status_code == 200:
        data = response.json()

        with open(output_file, 'w') as json_file:
            json.dump(data, json_file, indent=2)


fetch_and_store_data('http://api.aviationstack.com/v1/countries', 'data.json')