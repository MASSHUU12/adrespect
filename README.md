# Task

A page that allows saving downloaded exchange rates from the NBP to a database and displaying them in a table.
In addition, it allows converting a given amount from a selected currency to another and saving the results of the
conversion to the database.

<!-- TOC -->

* [Task](#task)
    * [Prerequisites](#prerequisites)
    * [Installation](#installation)
        * [Enabling Apache module](#enabling-apache-module)
        * [Database setup (Docker)](#database-setup-docker)
        * [Code formatting](#code-formatting)
    * [CLI](#cli)
    * [Testing](#testing)
    * [Troubleshooting](#troubleshooting)

<!-- TOC -->

## Prerequisites

* PHP 8+
* MySQL
* XAMPP (or other Apache server)
* Docker

## Installation

1. Clone the repository `git clone https://github.com/MASSHUU12/adrespect.git`
2. Copy the `.env.example` file and rename it to `.env`
3. Setup database (see [below](#database-setup-docker))
4. Run migration using `php cli.php migrate:fresh`
5. Enable Apache module for URL rewriting (see [below](#enabling-apache-module))
6. Start the server
7. Navigate to the `localhost:80`

### Enabling Apache module

1. In XAMPP open the `httpd.conf` file located in the `apache\conf`
2. Search for the following line and remove the `#`:

```txt
#LoadModule rewrite_module modules/mod_rewrite.so
```

### Database setup (Docker)

1. From the root folder run `docker compose up`
2. If necessary, adjust the database connection in the `.env` file

### Code formatting

This project uses [PHP-CS-Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer)
to format the code.

Instructions on how to use this and integrate with the IDE can be
found [here](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer#editor-integration).

## CLI

The project is supplied, with a basic CLI, the following describes its functions:

* `env:validate`: Validates environment configuration
* `migrate:fresh`: Resets the database to its initial state

## Testing

Tests are located in `tests/` directory.

To run tests use `composer run tests` or `./vendor/bin/phpunit tests`.

If it doesn't work first run `composer dumpautoload` and try again.

## Troubleshooting

If you're getting warning:
`Warning: The lock file is not up to date with the latest changes in composer.json.` use `composer update --lock`
