<?php

use App\Helpers\Convert;
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
    <form action="#" method="post">
        <label for="currency-amount">Amount:</label>
        <input type="number" value="0" name="currency-amount" min="0" required/>
        <label for="currency-source">Source currency:</label>
        <input type="text" value="USD" name="currency-source" maxlength="3" required/>
        <label for="currency-target">Target currency:</label>
        <input type="text" value="EUR" name="currency-target" maxlength="3" required/>
        <input type="submit" name="currency-convert" value="Convert"/>
    </form>
</main>
<?php
if (isset($_POST['save-exchange-rates']))
    NBP::save_exchange_rates(NBP::get_exchange_rates());
if (isset($_POST['generate-exchange-rates-table']))
    echo NBP::generate_exchange_rates_table();

// Converter form
if (isset($_POST['currency-convert'])) {
    $amount = $_POST['currency-amount'] ?? null;
    $source = $_POST['currency-source'] ?? null;
    $target = $_POST['currency-target'] ?? null;

    if (!is_int(Convert::str_to_int($amount)) || is_null($source) || is_null($target)) {
        echo 'Incorrect data received';
        return;
    }

    echo "Amount: $amount, source: $source, target: $target";
}
?>
</body>

</html>
