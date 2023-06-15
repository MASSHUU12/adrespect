# Task

A page that allows saving downloaded exchange rates from the NBP to a database and displaying them in a table.
In addition, it allows converting a given amount from a selected currency to another and saving the results of the conversion to the database.

<!-- TOC -->
* [Task](#task)
  * [Installation](#installation)
      * [Enabling Apache module](#enabling-apache-module)
      * [Database setup (Docker)](#database-setup-docker)
  * [Testing](#testing)
<!-- TOC -->

* PHP 8+
* MySQL
* XAMPP (or other Apache server)
* Docker

## Installation

1. Clone the repository `git clone https://github.com/MASSHUU12/adrespect.git`
2. Copy the `.env.example` file and rename it to `.env`
3. Setup database (see [below](#database-setup-docker))
4. Enable Apache module for URL rewriting (see [below](#enabling-apache-module))
5. Start the server
6. Navigate to the `localhost:80`

### Enabling Apache module

1. In XAMPP open the `httpd.conf` file located in the `apache\conf`
2. Search for the following line and remove the `#`:

```txt
#LoadModule rewrite_module modules/mod_rewrite.so
```

### Database setup (Docker)

1. From the root folder run `docker compose up`
2. If necessary, adjust the database connection in the `.env` file

## Testing

Tests are located in `tests/` directory.

To run tests use `./vendor/bin/phpunit tests`, if it doesn't work first run `composer dumpautoload` and try again.
