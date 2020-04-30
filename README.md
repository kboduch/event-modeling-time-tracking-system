To run application via `symfony serve` (Install `symfony` https://github.com/symfony/cli first)
* copy `.env` to `.env.local` and update `EVENTS_DIRECTORY` with valid dir path.
* start application with `symfony serve` command
* `curl --location --request POST 'http://127.0.0.1:8000/timesheets/saulgoodman-2008-04-12-breaking-bad/reject'`

To run dockerized application:
* create `../time_tracking_system_events` folder and run `docker-compose up`
* `curl --location --request POST 'http://127.0.0.1:8000/timesheets/saulgoodman-2008-04-12-breaking-bad/reject'`
