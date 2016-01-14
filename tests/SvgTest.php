<?php

namespace ML_Express\SVG\Tests;

require_once 'vendor/ml-express/xml/allIncl.php';
require_once 'vendor/ml-express/xml/tests/Express_TestCase.php';
require_once 'vendor/ml-express/graphics/allIncl.php';
require_once 'src/Svg.php';

use ML_Express\Tests\Express_TestCase;
use ML_Express\Graphics\Angle;
use ML_Express\Graphics\Point;
use ML_Express\Graphics\Points;
use ML_Express\SVG\Svg;

class SvgTest extends Express_TestCase
{
	public function provider()
	{
		return array(
				// rect()
				array(
						Svg::createSub()->rect([4.5, 3.5], 2, 3.2, 0.2, 0.5),
						'<rect x="4.5" y="3.5" width="2" height="3.2" rx="0.2" ry="0.5"/>'
				),
				array(
						Svg::createSub()->rect([4.5, 3.5], 2, 3.2),
						'<rect x="4.5" y="3.5" width="2" height="3.2"/>'
				),
				// circle()
				array(
						Svg::createSub()->circle([4.5, 3.5], 3.2),
						'<circle cx="4.5" cy="3.5" r="3.2"/>'
				),
				// ellipse()
				array(
						Svg::createSub()->ellipse([4.5, 3.5], 2, 3.2),
						'<ellipse cx="4.5" cy="3.5" rx="2" ry="3.2"/>'
				),
				// line()
				array(
						Svg::createSub()->line([0.1, 1.2], [2.3, 3.4]),
						'<line x1="0.1" y1="1.2" x2="2.3" y2="3.4"/>'
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
				// polyline()
				array(
						Svg::createSub()->polyline('2,2 2,4 4,4 4,6 6,6'),
						'<polyline points="2,2 2,4 4,4 4,6 6,6"/>'
				),
				array(
						Svg::createSub()->polyline([[2, 2], [2, 4], [4, 4], [4, 6], [6, 6]]),
						'<polyline points="2,2 2,4 4,4 4,6 6,6"/>'
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
						Svg::createSub()->polyline('2,2 2,4')->setPoints([Point::create(4, 4)]),
						'<polyline points="2,2 2,4 4,4"/>'
				),
				// addPoint()
				array(
						Svg::createSub()->polyline('2,2 2,4')->addPoint([4, 4]),
						'<polyline points="2,2 2,4 4,4"/>'
				),
				array(
						Svg::createSub()->polyline('')->addPoint([4, 4]),
						'<polyline points="4,4"/>'
				),
				array(
						Svg::createSub()->polyline('')->addPoint(Point::create(4, 4)),
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
								->moveTo([20, 20])
								->vLineTo(40)
								->hLineTo(40)
								->vLineTo(20)
								->closePath(),
						'<path d="M 20,20 V 40 H 40 V 20 Z"/>'
				),
				array(
						Svg::createSub()->path()
								->moveTo([20, 20])
								->vLineTo(20, true)
								->hLineTo(20, true)
								->vLineTo(-20, true)
								->closePath(),
						'<path d="M 20,20 v 20 h 20 v -20 Z"/>'
				),
				array(
						Svg::createSub()->path()
								->moveTo([20, 20], true)
								->lineTo([20, 40])
								->lineTo([20, 0], true)
								->lineTo([0, -20], true)
								->lineTo([-20, 0], true)
								->closePath(),
						'<path d="m 20,20 L 20,40 l 20,0 l 0,-20 l -20,0 Z"/>'
				),
				// curveTo()
				array(
						Svg::createSub()->path()
								->moveTo([20, 40])
								->curveTo([60, 0], [80, 80], [120, 40])
								->curveTo([40, 40], [-40, 60], [0, 100], true),
						'<path d="M 20,40 C 60,0 80,80 120,40 c 40,40 -40,60 0,100"/>'
				),
				// sCurveTo()
				array(
						Svg::createSub()->path()
								->moveTo([100, 100])
								->curveTo([140, 60], [160, 60], [200, 100])
								->sCurveTo([240, 160], [200, 200])
								->sCurveTo([-60, 40], [-100, 0], true)
								->sCurveTo([-40, -60], [0, -100], true),
						'<path d="M 100,100 C 140,60 160,60 200,100 S 240,160 200,200 '
						. 's -60,40 -100,0 s -40,-60 0,-100"/>'
				),
				// qCurveTo()
				array(
						Svg::createSub()->path()
								->moveTo([100, 100])
								->qCurveTo([150, 50], [200, 100])
								->qCurveTo([250, 150], [200, 200])
								->qCurveTo([-50, 50], [-100, 0], true)
								->qCurveTo([-50, -50], [0, -100], true),
						'<path d="M 100,100 Q 150,50 200,100 Q 250,150 200,200 '
						. 'q -50,50 -100,0 q -50,-50 0,-100"/>'
				),
				// sqCurveTo()
				array(
						Svg::createSub()->path()
								->moveTo([100, 100])
								->qCurveTo([150, 50], [200, 100])
								->sqCurveTo([200, 200])
								->sqCurveTo([-100, 0], true)
								->sqCurveTo([0, -100], true),
						'<path d="M 100,100 Q 150,50 200,100 T 200,200 t -100,0 t 0,-100"/>'
				),
				// arc()
				array(
						Svg::createSub()->path()
								->moveTo([400, 300])
								->arc(80, 60, 45, 1, 1, [500, 300])
								->arc(80, 60, 45, 0, 0, [-100, 0], true)
								->arc(80, 60, 45, 1, 0, [500, 300])
								->arc(80, 60, 45, 0, 1, [-100, 0], true),
						'<path d="M 400,300 A 80 60 45 1 1 500,300 a 80 60 45 0 0 -100,0 '
						. 'A 80 60 45 1 0 500,300 a 80 60 45 0 1 -100,0"/>'
				),
				// text(), setX(), setY(), setDx(), setDy(), setXY(), setDxDy(), setRotate()
				array(
						Svg::createSub()->text('lorem ipsum', 20, 100),
						'<text x="20" y="100">lorem ipsum</text>'
				),
				array(
						Svg::createSub()->text('lorem ipsum', [20, 30, 40], [100, 105]),
						'<text x="20 30 40" y="100 105">lorem ipsum</text>'
				),
				array(
						Svg::createSub()->text('lorem ipsum', 10, 10, [2, 3, 4], [1, 2]),
						'<text x="10" y="10" dx="2 3 4" dy="1 2">lorem ipsum</text>'
				),
				array(
						Svg::createSub()->text('lorem ipsum', 10, 10, null, null, [15, 30, 45]),
						'<text x="10" y="10" rotate="15 30 45">lorem ipsum</text>'
				),
				// tspan()
				array(
						Svg::createSub()->tspan('lorem ipsum', 10, 40,
								[2, 3, 4], [1, 2], [15, 30, 45]),
						'<tspan x="10" y="40" dx="2 3 4" dy="1 2" rotate="15 30 45">' .
								'lorem ipsum</tspan>'
				),
				// textPath()
				array(
						Svg::createSub()->textPath('lorem ipsum', '#path'),
						'<textPath xlink:href="#path">lorem ipsum</textPath>'
				),
				// useElem()
				array(
						Svg::createSub()->useElem('#circle', 20, 30, 40, 50),
						'<use xlink:href="#circle" x="20" y="30" width="40" height="50"/>'
				),
				// defs()
				array(
						Svg::createSub()->defs()->circle([0, 0], 20)->attrib('id', 'circle'),
						"<defs>\n\t<circle cx=\"0\" cy=\"0\" r=\"20\" id=\"circle\"/>\n</defs>"
				),
				// g()
				array(
						Svg::createSub()->g()->circle([0, 0], 20),
						"<g>\n\t<circle cx=\"0\" cy=\"0\" r=\"20\"/>\n</g>"
				),
				// title(), desc()
				array(
						Svg::createSub()->title('Foo Bar')->getRoot()->desc('lorem ipsum'),
						"<title>Foo Bar</title>\n<desc>lorem ipsum</desc>"
				),
		);
	}

	public function testAnyPolygonPath()
	{
		$this->assertExpectedMarkup(Svg::createSub()->path()->anyPolygonPath(
				Points::create()->polygon(Point::create(10, 20), 4, 100)),
				'<path d="M 10,-80 L 110,20 L 10,120 L -90,20 Z"/>');
	}

	public function rectanglePathProvider()
	{
		return array(
				array(
						Svg::createSub()->path()->rectanglePath([10, 20], 100, 80),
						'<path d="M 10,20 L 110,20 L 110,100 L 10,100 Z"/>'
				),
				array(
						Svg::createSub()->path()->rectanglePath([10, 20], 100, 80, true),
						'<path d="M 10,20 L 10,100 L 110,100 L 110,20 Z"/>'
				)
		);
	}

	/**
	 * @dataProvider rectanglePathProvider
	 */
	public function testRectanglePath($xml, $expectedMarkup)
	{
		$this->assertExpectedMarkup($xml, $expectedMarkup);
	}

	public function polygonPathProvider()
	{
		return array(
				array(
						Svg::createSub()->path()->polygonPath([10, 20], 4, 100),
						'<path d="M 10,-80 L 110,20 L 10,120 L -90,20 Z"/>'
				),
				array(
						Svg::createSub()->path()->polygonPath([10, 20], 4, 100, true),
						'<path d="M 10,-80 L -90,20 L 10,120 L 110,20 Z"/>'
				)
		);
	}

	/**
	 * @dataProvider polygonPathProvider
	 */
	public function testPolygonPath($xml, $expectedMarkup)
	{
		$this->assertExpectedMarkup($xml, $expectedMarkup);
	}

	public function starPathProvider()
	{
		return array(
				array(
						Svg::createSub()->path()->starPath([10, 20], 2, 100, 0.5),
						'<path d="M 10,-80 L 60,20 L 10,120 L -40,20 Z"/>'
				),
				array(
						Svg::createSub()->path()->starPath([10, 20], 2, 100, 0.5, true),
						'<path d="M 10,-80 L -40,20 L 10,120 L 60,20 Z"/>'
				),
				array(
						Svg::createSub()->path()->starPath([10, 20], 1, 100, [0.5, 1, 0.5]),
						'<path d="M 10,-80 L 60,20 L 10,120 L -40,20 Z"/>'
				),
				array(
						Svg::createSub()->path()->starPath([10, 20], 1, 100, [0.5, 1, 0.5], true),
						'<path d="M 10,-80 L -40,20 L 10,120 L 60,20 Z"/>'
				)
		);
	}

	/**
	 * @dataProvider starPathProvider
	 */
	public function testStarPath($xml, $expectedMarkup)
	{
		$this->assertExpectedMarkup($xml, $expectedMarkup);
	}

	public function circlePathProvider()
	{
		return array(
				array(
						Svg::createSub()->path()->circlePath([10, 20], 100),
						'<path d="M 110,20 A 100 100 0 0 1 -90,20 A 100 100 0 0 1 110,20"/>'
				),
				array(
						Svg::createSub()->path()->circlePath([10, 20], 100, true),
						'<path d="M 110,20 A 100 100 0 0 0 -90,20 A 100 100 0 0 0 110,20"/>'
				)
		);
	}

	/**
	 * @dataProvider circlePathProvider
	 */
	public function testCirclePath($xml, $expectedMarkup)
	{
		$this->assertExpectedMarkup($xml, $expectedMarkup);
	}

	public function ellipsePathProvider()
	{
		return array(
				array(
						Svg::createSub()->path()->ellipsePath([10, 20], 100, 50),
						'<path d="M 110,20 A 100 50 0 0 1 -90,20 A 100 50 0 0 1 110,20"/>'
				),
				array(
						Svg::createSub()->path()->ellipsePath([10, 20], 100, 50, 90, true),
						'<path d="M 10,120 A 100 50 90 0 0 10,-80 A 100 50 90 0 0 10,120"/>'
				)
		);
	}

	/**
	 * @dataProvider ellipsePathProvider
	 */
	public function testEllipsePath($xml, $expectedMarkup)
	{
		$this->assertExpectedMarkup($xml, $expectedMarkup);
	}

	public function sectorPathProvider()
	{
		$a = [];
		foreach ([30, 60, 215] as $i => $degrees) {
			$angle = Angle::byDegrees($degrees);
			$a[] = array(
					'a' => $angle,
					's' => $angle->sin * 50 + 20,
					'c' => $angle->cos * 50 + 10
			);
		}
		return array(
				array(
						Svg::createSub()->path()->sectorPath([10, 20], 30, 60, 50),
						"<path d=\"M 10,20 L {$a[0]['c']},{$a[0]['s']} " .
						"A 50 50 0 0 1 {$a[1]['c']},{$a[1]['s']} Z\"/>"
				),
				array(
						Svg::createSub()->path()->sectorPath([10, 20], 30, 215, 50),
						"<path d=\"M 10,20 L {$a[0]['c']},{$a[0]['s']} " .
						"A 50 50 0 1 1 {$a[2]['c']},{$a[2]['s']} Z\"/>"
				),
				array(
						Svg::createSub()->path()->sectorPath([10, 20], 30, 60, 50, true),
						"<path d=\"M 10,20 L {$a[1]['c']},{$a[1]['s']} " .
						"A 50 50 0 0 0 {$a[0]['c']},{$a[0]['s']} Z\"/>"
				),
				array(
						Svg::createSub()->path()->sectorPath([10, 20], 60, 30, 50),
						"<path d=\"M 10,20 L {$a[1]['c']},{$a[1]['s']} " .
						"A 50 50 0 0 0 {$a[0]['c']},{$a[0]['s']} Z\"/>"
				)
		);
	}

	/**
	 * @dataProvider sectorPathProvider
	 */
	public function testSectorPath($xml, $expectedMarkup)
	{
		$this->assertExpectedMarkup($xml, $expectedMarkup);
	}
}