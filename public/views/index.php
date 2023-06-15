<?php

use App\Helpers\NBP;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Task">
    <title>Task</title>
</head>

<body>
<main>
    <form action="#" method="post">
        <input type="submit" name="save-exchange-rates" value="Save exchange rates"/>
        <input type="submit" name="generate-exchange-rates-table" value="Generate exchange rates table"/>
    </form>
</main>
<?php
if (isset($_POST['save-exchange-rates']))
    NBP::save_exchange_rates(NBP::get_exchange_rates());
if (isset($_POST['generate-exchange-rates-table']))
    echo NBP::generate_exchange_rates_table();

?>
</body>

</html>
