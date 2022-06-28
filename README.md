### Maintain an up-to-date recon of bug-bounty programs automatically.

#### Features
- Get notified over slack when a new program is launched on HackerOne.

#### Installation
- Clone this repository.
- Run `composer install` within the project's root.

#### Usage
- Adjust environment variables in `.env.example` then move it to `.env`.
- Run `php automationd`.
- All done! While the daemon script is running, it will pull and run jobs every 20-minute and notify you if something interesting happened.
