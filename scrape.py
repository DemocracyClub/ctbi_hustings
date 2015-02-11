import json

import requests


class HustingsScraper(object):
    def __init__(self):
        self.session = requests.session()

    def get_constituency(self, constituency_id):
        data = {
            'action': 'searchHustings',
            'constitId': constituency_id,
            'constitName': '',
        }

        res = self.session.post(
            "https://ctbielections.org.uk/wp-admin/admin-ajax.php",
            data
        )
        return res.json()

    def get_all_constituencies(self):
        # passing 0 gets all events
        return self.get_constituency(0)

if __name__ == "__main__":
    s = HustingsScraper()
    all_data = s.get_all_constituencies()
    with open('ctbi_hustings.json', 'w') as output:
        output.write(json.dumps(all_data, indent=4))
    