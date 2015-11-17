# SVG Express PHP

SVG Express PHP is a library for creating SVG documents.
It's work in progress and far from complete.

## Installation using Composer

SVG Express for PHP requires PHP 5.4 or newer.

Add the following to your project's `composer.json` file:

```json
{
    "minimum-stability": "dev",
    "require": {
        "ml-express/svg": "dev-master@dev"
    }
}
```

Run `composer install` or `composer update`.

## Basic usage

```php
 '2015-01', 'clicks' => '501'],
        ['month' => '2015-02', 'clicks' => '560'],
        ['month' => '2015-03', 'clicks' => '543'],
        ['month' => '2015-04', 'clicks' => '607'],
        ['month' => '2015-05', 'clicks' => '646'],
        ['month' => '2015-06', 'clicks' => '645']
);

$svg = Svg::createSvg(400, 400);
$svg->append('style')->appendText(".bgr {
            fill: #cde;
        }
        .graph {
            fill: none;
            stroke-width: 3px;
            stroke: #593;
        }
        .solid {
            fill: #593;
            fill-opacity: 0.5;
        }
        .labels {
            font-size: 16px;
            font-family: tahoma, verdana, sans-serif;
            fill: 333;
            stroke: none;
        }");
$group = $svg->g();
$group->rect(0, 0, 400, 400)->setClass('bgr');
$solid = $group->polygon()->setClass('solid');
$solid->setPoints([[350, 330], [50, 330]]);
$graph = $group->polyline()->setClass('graph');
$labels1 = $group->text()->setClass('labels');
$labels2 = $group->text()->setClass('labels');
foreach ($dbRows as $i => $row) {
    $x = 50 + $i * 60;
    $y = (1000 - $row['clicks']) / 2;
    $solid->addPoint($x, $y);
    $graph->addPoint($x, $y);
    $labels1->tspan($row['clicks'], $x - 10, $y - 15);
    $labels2->tspan(
            strftime('%b', (new DateTime($row['month']))->getTimestamp()),
            $x - 10, 350);
}

print $svg->getMarkup();
```
```html
<?xml version="1.0" encoding="UTF-8" ?>
<svg width="400" height="400">
    <style>
        .bgr {
            fill: #cde;
        }
        .graph {
            fill: none;
            stroke-width: 3px;
            stroke: #593;
        }
        .solid {
            fill: #593;
            fill-opacity: 0.5;
        }
        .labels {
            font-size: 16px;
            font-family: tahoma, verdana, sans-serif;
            fill: 333;
            stroke: none;
        }
    </style>
    <g>
        <rect x="0" y="0" width="400" height="400" class="bgr"/>
        <polygon points="350,330 50,330 50,249.5 110,220 170,228.5 230,196.5 290,177 350,177.5" class="solid"/>
        <polyline points="50,249.5 110,220 170,228.5 230,196.5 290,177 350,177.5" class="graph"/>
        <text class="labels">
            <tspan x="40" y="234.5">501</tspan>
            <tspan x="100" y="205">560</tspan>
            <tspan x="160" y="213.5">543</tspan>
            <tspan x="220" y="181.5">607</tspan>
            <tspan x="280" y="162">646</tspan>
            <tspan x="340" y="162.5">645</tspan>
        </text>
        <text class="labels">
            <tspan x="40" y="350">Jan</tspan>
            <tspan x="100" y="350">Feb</tspan>
            <tspan x="160" y="350">Mar</tspan>
            <tspan x="220" y="350">Apr</tspan>
            <tspan x="280" y="350">May</tspan>
            <tspan x="340" y="350">Jun</tspan>
        </text>
    </g>
</svg>
```
