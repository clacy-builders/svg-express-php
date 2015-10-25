<?php

namespace ML_Express\HTML5;

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../vendor/ml-express/xml/src/Xml.php';
require_once __DIR__ . '/../vendor/ml-express/xml/tests/Express_TestCase.php';
require_once __DIR__ . '/../src/Svg.php';

use ML_Express\Express_TestCase;
use ML_Express\SVG\Svg;

class SvgTest extends Express_TestCase
{
	public function provider()
	{
		return array(
				// rect()
				array(
						Svg::createSub()->rect(4.5, 3.5, 2, 3.2, 0.2, 0.5),
						'<rect x="4.5" y="3.5" width="2" height="3.2" rx="0.2" ry="0.5"/>'
				),
				array(
						Svg::createSub()->rect(4.5, 3.5, 2, 3.2),
						'<rect x="4.5" y="3.5" width="2" height="3.2"/>'
				),
				// circle()
				array(
						Svg::createSub()->circle(4.5, 3.5, 3.2),
						'<circle cx="4.5" cy="3.5" r="3.2"/>'
				),
				// ellipse()
				array(
						Svg::createSub()->ellipse(4.5, 3.5, 2, 3.2),
						'<ellipse cx="4.5" cy="3.5" rx="2" ry="3.2"/>'
				),
				// polygon()
				array(
						Svg::createSub()->polygon('2,2 2,4 4,4 4,6 6,6'),
						'<polygon points="2,2 2,4 4,4 4,6 6,6"/>'
				),
				array(
						Svg::createSub()->polygon([[2, 2], [2, 4], [4, 4], [4, 6], [6, 6]]),
						'<polygon points="2,2 2,4 4,4 4,6 6,6"/>'
				),
				array(
						Svg::createSub()->polygon([['x' => 2, 'y' => 2], ['x' => 2, 'y' => 4]]),
						'<polygon points="2,2 2,4"/>'
				),
				// polyline()
				array(
						Svg::createSub()->polyline('2,2 2,4 4,4 4,6 6,6'),
						'<polyline points="2,2 2,4 4,4 4,6 6,6"/>'
				),
				array(
						Svg::createSub()->polyline([[2, 2], [2, 4], [4, 4], [4, 6], [6, 6]]),
						'<polyline points="2,2 2,4 4,4 4,6 6,6"/>'
				),
				array(
						Svg::createSub()->polyline([['x' => 2, 'y' => 2], ['x' => 2, 'y' => 4]]),
						'<polyline points="2,2 2,4"/>'
				),
				// setPoints()
				array(
						Svg::createSub()->polyline('2,2 2,4')->setPoints('4,4 4,6 6,6'),
						'<polyline points="2,2 2,4 4,4 4,6 6,6"/>'
				),
				array(
						Svg::createSub()->polyline('2,2 2,4')->setPoints([[4, 4], [4, 6], [6, 6]]),
						'<polyline points="2,2 2,4 4,4 4,6 6,6"/>'
				),
				array(
						Svg::createSub()->polyline('2,2 2,4')->setPoints([['x' => 4, 'y' => 4]]),
						'<polyline points="2,2 2,4 4,4"/>'
				),
				// addPoint()
				array(
						Svg::createSub()->polyline('2,2 2,4')->addPoint(4, 4),
						'<polyline points="2,2 2,4 4,4"/>'
				),
				array(
						Svg::createSub()->polyline('')->addPoint(4, 4),
						'<polyline points="4,4"/>'
				),
		);
	}
}