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
<?php
if (isset($_POST['delete-db']))
    echo 'delete';
if (isset($_POST['save-exchange-rates']))
    print_r(NBP::get_exchange_rates());
?>
<main>
    <form action="#" method="post">
        <input type="submit" name="delete-db" value="Delete db"/>
        <input type="submit" name="get-exchange-rates" value="Save exchange rates"/>
    </form>
</main>
</body>

</html>
