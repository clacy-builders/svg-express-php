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
				// path()
				array(
						Svg::createSub()->path('M 20,20 V 40 H 40 V 20 Z'),
						'<path d="M 20,20 V 40 H 40 V 20 Z"/>'
				),
				// moveTo(), lineTo(), vLineTo(), hLineTo(), closePath()
				array(
						Svg::createSub()->path()
								->moveTo(20, 20)
								->vLineTo(40)
								->hLineTo(40)
								->vLineTo(20)
								->closePath(),
						'<path d="M 20,20 V 40 H 40 V 20 Z"/>'
				),
				array(
						Svg::createSub()->path()
								->moveTo(20, 20)
								->vLineTo(20, true)
								->hLineTo(20, true)
								->vLineTo(-20, true)
								->closePath(),
						'<path d="M 20,20 v 20 h 20 v -20 Z"/>'
				),
				array(
						Svg::createSub()->path()
								->moveTo(20, 20, true)
								->lineTo(20, 40)
								->lineTo(20, 0, true)
								->lineTo(0, -20, true)
								->lineTo(-20, 0, true)
								->closePath(),
						'<path d="m 20,20 L 20,40 l 20,0 l 0,-20 l -20,0 Z"/>'
				),
				// curveTo()
				array(
						Svg::createSub()->path()
								->moveTo(20, 40)
								->curveTo(60, 0, 80, 80, 120, 40)
								->curveTo(40, 40, -40, 60, 0, 100, true),
						'<path d="M 20,40 C 60,0 80,80 120,40 c 40,40 -40,60 0,100"/>'
				),
				// sCurveTo()
				array(
						Svg::createSub()->path()
								->moveTo(100, 100)
								->curveTo(140, 60, 160, 60, 200, 100)
								->sCurveTo(240, 160, 200, 200)
								->sCurveTo(-60, 40, -100, 0, true)
								->sCurveTo(-40, -60, 0, -100, true),
						'<path d="M 100,100 C 140,60 160,60 200,100 S 240,160 200,200 '
						. 's -60,40 -100,0 s -40,-60 0,-100"/>'
				),
				// qCurveTo()
				array(
						Svg::createSub()->path()
								->moveTo(100, 100)
								->qCurveTo(150, 50, 200, 100)
								->qCurveTo(250, 150, 200, 200)
								->qCurveTo(-50, 50, -100, 0, true)
								->qCurveTo(-50, -50, 0, -100, true),
						'<path d="M 100,100 Q 150,50 200,100 Q 250,150 200,200 '
						. 'q -50,50 -100,0 q -50,-50 0,-100"/>'
				),
				// sqCurveTo()
				array(
						Svg::createSub()->path()
								->moveTo(100, 100)
								->qCurveTo(150, 50, 200, 100)
								->sqCurveTo(200, 200)
								->sqCurveTo(-100, 0, true)
								->sqCurveTo(0, -100, true),
						'<path d="M 100,100 Q 150,50 200,100 T 200,200 t -100,0 t 0,-100"/>'
				),
				// arc()
				array(
						Svg::createSub()->path()
								->moveTo(400, 300)
								->arc(80, 60, 45, 1, 1, 500, 300)
								->arc(80, 60, 45, 0, 0, -100, 0, true)
								->arc(80, 60, 45, 1, 0, 500, 300)
								->arc(80, 60, 45, 0, 1, -100, 0, true),
						'<path d="M 400,300 A 80 60 45 1 1 500 300 a 80 60 45 0 0 -100 0 '
						. 'A 80 60 45 1 0 500 300 a 80 60 45 0 1 -100 0"/>'
				),

				// text(), setX(), setY(), setDx(), setDy()
				array(
						Svg::createSub()->text('lorem ipsum', 20, 100),
						'<text x="20" y="100">lorem ipsum</text>'
				),
				array(
						Svg::createSub()->text('lorem ipsum', [20, 30, 40], [100, 105]),
						'<text x="20,30,40" y="100,105">lorem ipsum</text>'
				),
				array(
						Svg::createSub()->text('lorem ipsum', 10, 10, [2, 3, 4], [1, 2]),
						'<text x="10" y="10" dx="2,3,4" dy="1,2">lorem ipsum</text>'
				),
		);
	}
}