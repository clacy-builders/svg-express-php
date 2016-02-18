<?php
require_once '../../allIncl.php';

use \ML_Express\SVG\Svg;
use \ML_Express\Graphics\Point; ?>
<style>
svg {
	background-color: #ac8;
}
path {
	fill: #fc0;
	fill-opacity: 1;
	stroke-width: 0;
}
circle {
	fill: #693;
	fill-opacity: 0.5;
}
text {
	font-family: consolas, open source, monospace;
	font-size: 10px;
}
</style>
<?php
$center = Point::create(60, 60);
foreach ([false, true] as $ccw) {
	for ($start = 0; $start < 360; $start += 15) {
		for ($span = 15; $span < 360; $span += 15) {
			$svg = Svg::createSub('svg')->attrib('width', 120)->attrib('height', 120);
			$svg->circle($center, 55);
			$svg->path()
					->ringSectorPath($center, $start, $start + $span, 50, 40, $ccw)
					->sectorPath($center, $start, $start + $span, 30, $ccw);
			$svg->text($start . '+' . $span . ($ccw ? ' ccw' : ''), [10, 110]);
			print $svg->getMarkup();
		}
	}
}