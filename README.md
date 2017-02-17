# laglab.spacestate.api

Collection of PHP scripts that run the spaceapi infra for laglab.org
http://spaceapi.net/
https://spacedirectory.org/

# state.lag.php
Internal page at the lab that forwards the request to state.laglab.org
Has a button that can be manually pressed or by the space-button esp8266 and shows the current/new state.

# state.laglab.org.php
External page that requires a 'secretkey' to accept requests. Generates the spaceapi.json to include the new state.
Also displays the current state.


#autoclose.state.lag.php
Script to (if needed) automatically close the space on the internal site.
Run as a cron-job
