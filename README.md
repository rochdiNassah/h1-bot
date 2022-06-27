### Maintain an up-to-date recon of bug-bounty programs automatically.

#### Features
- Add, delete, or update a program.
- Get notified over slack when a program change is detected.
- Inquiry about a program.

#### Requirements
- `PHP >= 8`, `Redis extension`.

#### Installation
- Clone this repository.
- Run `composer install` within the project's root.
- Adjust `.env.example` values then move it to `.env`.
- Run `composer test`. If the tests didn't pass, this means that some of the project requirements don't meet ;).
- Run `php automationd`. This one is a long running script that will pull and run jobs every 20-minute.

#### Web application routes
- /programs
- /peograms/{id}
- /programs/add
- /programs/{id}/update
- /programs/{id}/delete
- /debug
