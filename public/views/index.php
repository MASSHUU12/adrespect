<?php

use App\Helpers\Convert;
use App\Helpers\DB;
use App\Helpers\Helpers;
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
    <?php # Form with database actions?>
    <form action="#" method="post">
        <input type="submit" name="save-exchange-rates" value="Save exchange rates"/>
        <input type="submit" name="generate-exchange-rates-table" value="Generate exchange rates table"/>
        <input type="submit" name="generate-currency-conversions-list" value="Generate currency conversions table"/>
    </form>
    <?php # Form for currency conversion?>
    <form action="#" method="post">
        <label for="currency-amount">Amount:</label>
        <input type="text" value="0"
               name="currency-amount" minlength="1"
               maxlength="32" title="The data entered must be a number"
               pattern="^[+-]?\d*\.?\d+$"
               required/>
        <label for="currency-source">Source currency:</label>
        <input type="text" value="USD"
               name="currency-source" maxlength="3"
               title="Source currency must be a valid currency code"
               pattern="^[A-Za-z]{3}$"
               required/>
        <label for="currency-target">Target currency:</label>
        <input type="text" value="EUR"
               name="currency-target" maxlength="3"
               title="Target currency must be a valid currency code"
               pattern="^[A-Za-z]{3}$"
               required/>
        <input type="submit" name="currency-convert" value="Convert"/>
    </form>
</main>
<?php
/**
 * Get currency exchange rates and save in the database
 */
if (isset($_POST['save-exchange-rates'])) {
    NBP::save_exchange_rates(NBP::get_exchange_rates());
}

/**
 * Download currency exchange rates from the database and create HTML table
 */
if (isset($_POST['generate-exchange-rates-table'])) {
    echo NBP::generate_exchange_rates_table();
}

/**
 * Convert from one currency to another
 */
if (isset($_POST['currency-convert'])) {
    $amount = $_POST['currency-amount'] ?? null;
    $source = $_POST['currency-source'] ?? null;
    $target = $_POST['currency-target'] ?? null;

    // Check if the data received is valid
    if (filter_var($amount, FILTER_VALIDATE_FLOAT) === false ||
        !Helpers::is_currency_code_valid($source) ||
        !Helpers::is_currency_code_valid($target)) {
        echo 'Incorrect data received';
        return;
    }

    // Connect to the database
    if (!DB::connect()) {
        echo 'Connection with database failed.';
        return;
    }

    // Prepare the SQL query
    $sql = 'SELECT code, mid FROM exchange_rates WHERE code IN (
        :source, :target
    ) ORDER BY FIELD(
        code, :source, :target
    )';
    $params = [':source' => $source, ':target' => $target];

    // Execute the query and fetch the result
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

    // Convert the currency
    $converted = Convert::currency((float)$amount, $db_source_mid, $db_target_mid);

    // Insert the conversion into the database
    CurrencyConversionsModel::insert([$source, $amount, $target, $converted]);

    echo "Source: $amount $db_source_name, converted: $converted $db_target_name";
}

/**
 * Download latest currency conversions from the database and create ordered list
 */
if (isset($_POST['generate-currency-conversions-list'])) {
    $out = [];

    // Retrieve the currency conversions from the database
    foreach (CurrencyConversionsModel::get(10, ['conversion_date'], false)->fetchAll(PDO::FETCH_ASSOC) as $elem) {
        $source_amount = $elem['source_currency_amount'];
        $source_code = $elem['source_currency_code'];
        $target_amount = $elem['target_currency_amount'];
        $target_code = $elem['target_currency_code'];
        $conversion_date = $elem['conversion_date'];

        // Format the conversion information
        $out[] = "$conversion_date | $source_amount $source_code => $target_amount $target_code";
    }

    // Generate an ordered list
    echo Helpers::generate_list($out);
}
?>
</body>

</html>
