# CTBI hustings scraper

The CTBI have a [hustings database](https://ctbielections.org.uk/view-hustings/) that exposes a JSON API only accessible via a POST request.

The data is terrible and so it has to be added by hand.

This script helps with that.

Run 

    php letsgo.php


It will prompt you of details of events from the page. It will ask if you have delbt with them. It will save seen events in a file.

After running, commit the changes to "eventsDone.log"


