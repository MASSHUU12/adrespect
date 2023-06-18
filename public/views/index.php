<?php

use App\Helpers\Convert;
use App\Helpers\DB;
use App\Helpers\NBP;
use App\Models\CurrencyConversionsModel;
use App\Models\ExchangeRatesModel;

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
if (isset($_POST['save-exchange-rates'])) {
    NBP::save_exchange_rates(NBP::get_exchange_rates());
}
if (isset($_POST['generate-exchange-rates-table'])) {
    echo NBP::generate_exchange_rates_table();
}

// Converter form
if (isset($_POST['currency-convert'])) {
    $amount = $_POST['currency-amount'] ?? null;
    $source = $_POST['currency-source'] ?? null;
    $target = $_POST['currency-target'] ?? null;

    $amount_as_int = Convert::str_to_int($amount);

    if (!is_int($amount_as_int) || is_null($source) || is_null($target)) {
        echo 'Incorrect data received';
        return;
    }

    if (!DB::connect()) {
        echo 'Connection with database failed.';
        return;
    }

    $sql = 'SELECT code, mid FROM exchange_rates WHERE code IN (
        :source, :target
    ) ORDER BY FIELD(
        code, :source, :target
    )';
    $params = [':source' => $source, ':target' => $target];

    $result = ExchangeRatesModel::query($sql, $params)->fetchAll();
    ExchangeRatesModel::disconnect();

    // If one (or more) currencies not found, return error
    if (count($result) < 2) {
        echo 'Source or target are invalid.';
        return;
    }

    $db_source_mid = $result[0][1];
    $db_source_name = $result[0][0];
    $db_target_mid = $result[1][1];
    $db_target_name = $result[1][0];
    $converted = Convert::currency($amount_as_int, $db_source_mid, $db_target_mid);

    CurrencyConversionsModel::insert([$source, $amount, $target, $converted]);

    echo "Source: $amount $db_source_name, converted: $converted $db_target_name";
}
?>
</body>

</html>
