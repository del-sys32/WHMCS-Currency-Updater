<?php
require_once('settings.php');

//The currency to find.
$getCurrency = $defCurrency;

$query = "SELECT `id`, `currency` FROM `{$clientsTable}` WHERE `currency`={$getCurrency}";

$results = $mysqli->query($query);
$results = $results->fetch_all();

$total = 0;

/*
First update existing customers using DKK, to use currency 105.
This means we can run the system over and over, so if it fails we dont have to manually go over everything again.
*/
foreach ($results as $result) {
	//Update the table.
	$currency = "UPDATE `{$clientsTable}` SET currency='{$failsafe}' WHERE `id`= {$result['0']}";
	$currency = $mysqli->query($currency);

	//Update total.
	$total++;
}

echo "Updated: " . $total . " clients from default currency, to new currency. Run until this says 0.";

echo '<br><a href="step2.php">Start step 2</a>';