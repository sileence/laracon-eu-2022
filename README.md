# Refactoring to SOLID in Laravel

This repository contains the demo from my talk in [Laracon EU](https://laracon.eu/) 2022.

## Installation instructions

1. Clone the repository: `git clone git@github.com:sileence/laracon-eu-2022.git`
2. Go to the directory: `cd laracon-eu-2022`
3. Copy/paste the environment file: `cp .env.example .env`
4. Run `composer install`
5. Run `php artisan key:generate`
6. Create the SQLite database file: `touch database/database.sqlite`
7. Run the migrations and the seeders: `php artisan migrate && php artisan db:seed`
8. Start the server with `php artisan serve`
9. Open the project in your favorite browser: `http://127.0.0.1:8000/`
10. Go to the first branch: `git checkout step0`
11. Explore the next branches to see the changes, i.e.: `git checkout step1`
12. [Follow me on Twitter](https://twitter.com/sileence) for more interesting demos and tips.

## Thanks to 

* [LendInvest](http://lendinvest.com/) for giving me the support to prepare and present the talk in record time.
If you're looking for new career opportunities, please visit the [careers page](https://www.lendinvest.com/careers/).
* [Marek Lenik](https://github.com/criography) for contributing the design and frontend code of this demo project.

## Terminal aliases

Add the following shortcuts to your ZSH configuration file to move quickly between branches, see and compare their changes:

```
step() {
   git checkout step-$1
}

fstep() {
   git reset --hard && git clean -df && git checkout step-$1
}

compare() {
   git diff step-$1...step-$2
}

changes() {
   git diff step-$1...step-$2 --name-only
}
```
