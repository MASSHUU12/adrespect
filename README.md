# Task

A page that allows saving downloaded exchange rates from the NBP to a database and displaying them in a table.
In addition, it allows converting a given amount from a selected currency to another and saving the results of the conversion to the database.

<!-- TOC -->
* [Task](#task)
  * [Prerequisites](#prerequisites)
  * [Installation](#installation)
<!-- TOC -->

## Prerequisites

* PHP 8+
* MySQL
* XAMPP (or other Apache server)

## Installation

1. Clone the repository `git clone https://github.com/MASSHUU12/adrespect.git`
2. Enable Apache module for URL rewriting:
    * In XAMPP open the `httpd.conf` file located in the `apache\conf`
    * Search for the following line and remove the `#`:
        ```txt
        #LoadModule rewrite_module modules/mod_rewrite.so
        ```
3. Start the server
4. Navigate to the `localhost:80`
