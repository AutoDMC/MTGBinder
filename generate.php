<?php
require __DIR__ . '/vendor/autoload.php';

use League\Csv\Reader;
use MTGCli\CachedScryfall;

$scry = new CachedScryfall();
// Load collection.csv
$csv = Reader::createFromPath('collection.csv', 'r');
$csv->setHeaderOffset(0);

$table = "<thead><tr><th>Name</th><th>Set</th><th>F?</th><th>Colors</th><th>Mana Cost</th><th>Type</th><th>Price</th></tr></thead><tbody>";
$totalValue = 0;
foreach ($csv->getRecords() as $record) {
    $set = $record['Set ID'];
    $additionalParameters = '';

    if (substr($record['Set ID'], 0, 4) === "PRM-") {
        $additionalParameters = 'is:promo+-is:digital';
        $set = null;
    }
    $cardinfo = $scry->identifyByName($record['Card'], $set, $additionalParameters)['data'][0];
    dump($cardinfo);

    $foil = '<td></td>';
    $price = $cardinfo['prices']['usd'];
    if ($record['Foil'] === 'FOIL') {
        $foil = '<td>F</td>';
        $price = $cardinfo['prices']['usd_foil'];
    }

    $colorIdentity = '';
    foreach ($cardinfo['color_identity'] as $color) {
        $colorIdentity .= $color;
    }

    $tableLine = <<<TABLELINE
<tr>
    <td><a class="cardlink" href="{$cardinfo['scryfall_uri']}">{$cardinfo['name']}</a></td>
    <td>{$cardinfo['set']}</td>
    {$foil}
    <td>{$colorIdentity}</td>
    <td>{$cardinfo['mana_cost']}</td>
    <td>{$cardinfo['type_line']}</td>
    <td>{$price}</td>
</tr>
TABLELINE;

    $table .= $tableLine;
    $totalValue = $totalValue + $price;
}

$table .= "</tbody><tfoot><tr><td colspan='6' align='right'>Total Value&nbsp;</td><td>{$totalValue}</td></tr>";

ob_start();
include('template.php');
$output = ob_get_contents();
ob_end_clean();

file_put_contents('index.html', $output);