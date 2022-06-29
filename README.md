# What is this?
This is a simple bug-hunting automation system that runs pre-created jobs and notify you over slack when something interesting is detected.\
Now, the only available feature is checking HackerOne programs every 20-minute and notify you if a new program has launched.

### Installation
- Clone this repository.
- `cd` to the project's root then run `composer install`.
- Adjust environment variables in `.env.example` then move it to `.env`.
- Run `php automationd`. This one is a long-running script that will run the jobs every (n) minutes and notify you over slack when needed.
