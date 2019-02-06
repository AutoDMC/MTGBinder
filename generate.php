<?php
require __DIR__ . '/vendor/autoload.php';

use League\Csv\Reader;
use MTGCli\CachedScryfall;

$scry = new CachedScryfall();
// Load collection.csv
$csv = Reader::createFromPath('collection.csv', 'r');
$csv->setHeaderOffset(0);

$table = "<tbody>";
$totalValue = 0;

$shortifySetMap = [
    'Wizards Play Network' => 'WPN',
    'Core Set' => 'Core',
];
foreach ($csv->getRecords() as $record) {
    $set = $record['Set ID'];
    $additionalParameters = '';

    if (substr($record['Set ID'], 0, 4) === "PRM-") {
        $additionalParameters = 'is:promo+-is:digital';
        $set = null;
    }
    $cardinfo = $scry->identifyByName($record['Card'], $set, $additionalParameters)['data'][0];
    dump($cardinfo);
    $cardinfo['rarity'] = ucfirst($cardinfo['rarity']);

    $foil = '<td></td>';
    $price = $cardinfo['prices']['usd'];
    if ($record['Foil'] === 'FOIL') {
        $foil = '<td>Yes</td>';
        $price = $cardinfo['prices']['usd_foil'];
    }

    $colorIdentity = '';
    foreach ($cardinfo['color_identity'] as $color) {
        $colorIdentity .= $color;
    }

    // Shortify the set name, for table space
    $setName = $cardinfo['set_name'];
    foreach ($shortifySetMap as $long=>$short) {
        $setName = str_replace($long, $short, $setName);
    }

    $tradeable = "Perhaps";
    if ($record['Quantity'] > 4) {
        $tradeable = 'Yes';
    } elseif ($record['Quantity'] > 1) {
        $tradeable = 'Maybe';
        if ($record['Foil'] == 'FOIL' || $cardinfo['rarity'] == 'Mythic') {
            $tradeable = 'Unlikely';
        }
        if (round($price) > 25) {
            $tradeable = 'Cash';
        }
    } elseif ($record['Quantity'] == 1) {
        $tradeable = 'Remote';
        if ($record['Foil'] == 'FOIL' || $cardinfo['rarity'] == 'Mythic') {
            $tradeable = 'Hell No';
        }
    }

    $tableLine = <<<TABLELINE
<tr>
    <td>{$tradeable}</td>
    <td><a class="cardlink" data-tippy="<div><img src='{$cardinfo['image_uris']['border_crop']}' width='200px'/></div>" data-tippy-placement="top-start" data-tippy-boundary="viewport" href="{$cardinfo['scryfall_uri']}">{$cardinfo['name']}</a></td>
    <td>{$setName}</td>
    <td>{$cardinfo['rarity']}</td>
    {$foil}
    <td>{$record['Quantity']}</td>
    <td>{$colorIdentity}</td>
    <td>{$cardinfo['mana_cost']}</td>
    <td>{$cardinfo['type_line']}</td>
    <td>{$price}</td>
</tr>
TABLELINE;

    $table .= $tableLine;
    $totalValue = $totalValue + ($price * $record['Quantity']);
}

$totalValue = number_format($totalValue, 2);
$table .= "</tbody><tfoot><tr><td colspan='9' align='right'>Total Value&nbsp;</td><td>{$totalValue}</td></tr>";

ob_start();
include('template.php');
$output = ob_get_contents();
ob_end_clean();

file_put_contents('index.html', $output);