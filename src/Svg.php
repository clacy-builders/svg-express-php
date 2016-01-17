<?php

namespace ML_Express\SVG;

use ML_Express\Xml;
use ML_Express\Shared\XLink;
use ML_Express\Shared\XLinkConstants;
use ML_Express\Shared\ClassAttribute;
use ML_Express\Shared\StyleAttribute;
use ML_Express\Graphics\Point;
use ML_Express\Graphics\Points;
use ML_Express\Graphics\Angle;

class Svg extends Xml implements XLinkConstants
{
	use XLink, ClassAttribute, StyleAttribute;

	const MIME_TYPE = 'image/svg+xml';
	const FILENAME_EXTENSION = 'svg';
	const ROOT_ELEMENT = 'svg';

	public static function createSvg($width = null, $height = null, $viewBox = null)
	{
		$class = get_called_class();
		return (new $class('svg'))
				->attrib('width', $width)
				->attrib('height', $height)
				->attrib('viewbox', $viewBox);
	}

	/**
	 * The rect (rectangle) element.
	 *
	 * @param  Point|array  $corner  The top left corner of the rectangle.
	 * @param  float        $width   The width of the rectangle.
	 * @param  float        $height  The height of the rectangle.
	 * @param  float        $rx      The x radius of the corners of the rectangle.
	 * @param  float        $ry      The y radius of the corners of the rectangle.
	 */
	public function rect($corner, $width, $height, $rx = null, $ry = null)
	{
		$corner = self::point($corner);
		return $this->append('rect')
				->attrib('x', $corner->x)
				->attrib('y', $corner->y)
				->attrib('width', $width)
				->attrib('height', $height)
				->attrib('rx', $rx)
				->attrib('ry', $ry);
	}

	/**
	 * The circle element.
	 *
	 * @param  Point|array  $center  Center of the circle.
	 * @param  float        $r       The radius of the circle.
	 */
	public function circle($center, $r)
	{
		$center = self::point($center);
		return $this->append('circle')
				->attrib('cx', $center->x)
				->attrib('cy', $center->y)
				->attrib('r', $r);
	}

	/**
	 * The ellipse element.
	 *
	 * @param  Point|array  $center  The center of the ellipse.
	 * @param  float        $rx      The x radius of the ellipse.
	 * @param  float        $ry      The y radius of the ellipse.	 *
	 */
	public function ellipse($center, $rx, $ry)
	{
		$center = self::point($center);
		return $this->append('ellipse')
				->attrib('cx', $center->x)
				->attrib('cy', $center->y)
				->attrib('rx', $rx)
				->attrib('ry', $ry);
	}

	/**
	 * The line element.
	 *
	 * @param  Point|array  $point1
	 * @param  Point|array  $point2
	 */
	public function line($point1, $point2)
	{
		$point1 = self::point($point1);
		$point2 = self::point($point2);
		return $this->append('line')
				->attrib('x1', $point1->x)
				->attrib('y1', $point1->y)
				->attrib('x2', $point2->x)
				->attrib('y2', $point2->y);
	}

	/**
	 * The polyline element.
	 *
	 * @param  string|array  $points  A space separated list of points which x and y coordinates
	 *                                are comma separated.
	 *                                Otherwise an array of arrays or <code>Point</code> objects.
	 */
	public function polyline($points = null)
	{
		return $this->append('polyline')
				->setPoints($points);
	}

	/**
	 * The polygon element.
	 *
	 * @param  string|array  $points  A space separated list of points which x and y coordinates
	 *                                are comma separated.
	 *                                Otherwise an array of arrays or <code>Point</code> objects.
	 */
	public function polygon($points = null)
	{
		return $this->append('polygon')
				->setPoints($points);
	}

	/**
	 * The path element.
	 *
	 * @param  string  $d  A series of commands. You may use the following methods to build
	 *                     this attribute:<ul><li><code>moveTo()</code>,
	 *                     <li><code>lineTo()</code>,
	 *                     <li><code>hLineTo()</code>,
	 *                     <li><code>vLineTo()</code>,
	 *                     <li><code>curveTo()</code>,
	 *                     <li><code>sCurveTo()</code>
	 *                     <li><code>qCurveTo()</code>
	 *                     <li><code>sqCurveTo()</code>
	 *                     <li><code>arc()</code>
	 *                     <li><code>closePath()</code></ul>
	 */
	public function path($d = null)
	{
		return $this->append('path')
				->attrib('d', $d);
	}

	/**
	 * The text element.
	 *
	 * @param content string [optional]
	 * <p>You may append <code>tspan</code> or <code>tpath</code> instead.</p>
	 *
	 * @param x mixed [optional]
	 * <p>One or more x values (comma separated or in an array).</p>
	 *
	 * @param y mixed [optional]
	 * <p>One or more y values (comma separated or in an array).</p>
	 *
	 * @param dx mixed [optional]
	 * <p>The horizontal offset. One or more values (comma separated or in an array).</p>
	 *
	 * @param dy mixed [optional]
	 * <p>The vertical offset. One or more values (comma separated or in an array).</p>
	 *
	 * @param rotate string|array [optional]
	 * <p>makes each character rotate to its respective value, with remaining characters rotating
	 * according to the last value. A space separated list or an array.</p>
	 */
	public function text($content = '', $x = null, $y = null, $dx = null, $dy = null,
			$rotate = null)
	{
		return $this->append('text', $content)
				->setXY($x, $y)
				->setDxDy($dx, $dy)
				->setRotate($rotate);
	}

	/**
	 * The tspan element.
	 *
	 * @param content string
	 *
	 * @param x mixed [optional]
	 * <p>One or more x values (comma separated or in an array).</p>
	 *
	 * @param y mixed [optional]
	 * <p>One or more y values (comma separated or in an array).</p>
	 *
	 * @param dx mixed [optional]
	 * <p>The horizontal offset. One or more values (comma separated or in an array).</p>
	 *
	 * @param dy mixed [optional]
	 * <p>The vertical offset. One or more values (comma separated or in an array).</p>
	 *
	 * @param rotate string|array [optional]
	 * <p>makes each character rotate to its respective value, with remaining characters rotating
	 * according to the last value. A space separated list or an array.</p>
	 */
	public function tspan($content, $x = null, $y = null, $dx = null, $dy = null, $rotate = null)
	{
		return $this->append('tspan', $content)
				->setXY($x, $y)
				->setDxDy($dx, $dy)
				->setRotate($rotate);
	}

	/**
	 * The textPath element.
	 *
	 * @param content string
	 *
	 * @param href string
	 * <p>Fetches an arbitrary path and aligns the characters, that it encircles,
	 * along this path.</p>
	 */
	public function textPath($content, $href)
	{
		return $this->append('textPath', $content)->setXLinkHref($href);
	}

	/**
	 * The <code>defs</code> element.
	 */
	public function defs()
	{
		return $this->append('defs');
	}

	/**
	 * The <code>use</code> element.
	 *
	 * @param href string
	 * <p>A reference to an element/fragment within an SVG document.</p>
	 *
	 * @param x int|float [optional]
	 * <p>The x-axis coordinate of the upper-left corner of the region into which the
	 * referenced element is placed.</p>
	 *
	 * @param y int|float [optional]
	 * <p>The y-axis coordinate of the upper-left corner of the region into which the
	 * referenced element is placed.</p>
	 *
	 * @param width int|float [optional]
	 * <p>The width of the region into which the referenced element is placed.</p>
	 *
	 * @param height int|float [optional]
	 * <p>The height of the region into which the referenced element is placed.</p>
	 */
	public function useElem($href, $x = null, $y = null, $width = null, $height = null)
	{
		return $this->append('use')
				->setXLinkHref($href)
				->setXY($x, $y)
				->attrib('width', $width)
				->attrib('height', $height);
	}

	/**
	 * The g element.
	 */
	public function g()
	{
		return $this->append('g');
	}

	/**
	 * The <code>title</code> element.
	 *
	 * @param content string
	 */
	public function title($content)
	{
		return $this->append('title', $content);
	}

	/**
	 * The <code>desc</code> element.
	 *
	 * @param content string
	 */
	public function desc($content)
	{
		return $this->append('desc', $content);
	}

	/**
	 * The points attribute.
	 *
	 * @param  string|array  $points  A space separated list of points which x and y coordinates
	 *                                are comma separated.
	 *                                Otherwise an array of arrays or <code>Point</code> objects.
	 */
	public function setPoints($points)
	{
		if (!is_string($points)) {
			foreach ($points as $point) {
				$this->addPoint($point);
			}
			return $this;
		}
		return $this->complexAttrib('points', $points);
	}

	/**
	 * Adds a point to the points listened in the points attribute.
	 *
	 * @param  Point|array  $point
	 */
	public function addPoint($point)
	{
		$point = self::point($point);
		return $this->complexAttrib('points', $point->x . ',' . $point->y);
	}

	private function addPathCommand($command, $coords = null, $relative = false)
	{
		return $this
				->complexAttrib('d', $relative ? strtolower($command) : $command)
				->complexAttrib('d', $coords);
	}

	/**
	 * The close path command (<code>Z</code>).
	 */
	public function closePath()
	{
		return $this->addPathCommand('Z');
	}

	/**
	 * The moveto command (<code>M</code> or <code>m</code>).
	 *
	 * @param  Point|array  $point     The point to move to.
	 * @param  booolean     $relative  Whether x, y of <code>$point</code> are relative
	 *                                 or absolute.
	 */
	public function moveTo($point, $relative = false)
	{
		$point = self::point($point);
		return $this->addPathCommand('M', "$point->x,$point->y", $relative);
	}

	/**
	 * The lineto command (<code>L</code> or <code>l</code>).
	 *
	 * @param  Point|array  $point     The point to end the line at.
	 * @param  boolean      $relative  Whether x, y of <code>$point</code> are relative
	 *                                 (to the last point) or absolute.
	 */
	public function lineTo($point, $relative = false)
	{
		$point = self::point($point);
		return $this->addPathCommand('L', "$point->x,$point->y", $relative);
	}

	/**
	 * The horizontal lineto command (<code>H</code> or <code>h</code>).
	 *
	 * @param  float    $x         The x coordinate to end the line at.
	 * @param  boolean  $relative  Whether <code>$x</code> is relative (to the last point)
	 *                             or absolute.
	 */
	public function hLineTo($x, $relative = false)
	{
		return $this->addPathCommand('H', $x, $relative);
	}

	/**
	 * The vertical lineto command (<code>V</code> or <code>v</code>).
	 *
	 * @param  float    $y         The y coordinate to end the line at.
	 * @param  boolean  $relative  Whether <code>$y</code> is relative (to the last point)
	 *                             or absolute.
	 */
	public function vLineTo($y, $relative = false)
	{
		return $this->addPathCommand('V', $y, $relative);
	}

	/**
	 * The cubic Bézier curveto command (<code>C</code> or <code>c</code>).
	 *
	 * @param  Point|array  $control1  The control point for the start of the curve.
	 * @param  Point|array  $control2  The control point for the end of the curve.
	 * @param  Point|array  $point     The y coordinate to end the stroke at.
	 * @param  boolean      $relative  Whether the coordinates are relative (to the last point)
	 *                                 or absolute.
	 */
	public function curveTo($control1, $control2, $point, $relative = false)
	{
		$control1 = self::point($control1);
		$control2 = self::point($control2);
		$point = self::point($point);
		return $this->addPathCommand('C',
				"$control1->x,$control1->y $control2->x,$control2->y $point->x,$point->y",
				$relative);
	}

	/**
	 * The smooth cubic Bézier curveto command (<code>S</code> or <code>s</code>).
	 *
	 * @param  Point|array  $control2  The control point for the end of the curve.
	 * @param  Point|array  $point     The point to end the stroke at.
	 * @param  boolean      $relative  Whether the coordinates are relative (to the last point)
	 *                                 or absolute.
	 */
	public function sCurveTo($control2, $point, $relative = false)
	{
		$control2 = self::point($control2);
		$point = self::point($point);
		return $this->addPathCommand('S',
				"$control2->x,$control2->y $point->x,$point->y", $relative);
	}

	/**
	 * The quadratic Bézier curveto command (<code>Q</code> or <code>q</code>).
	 *
	 * @param  Point|array  $control   The control point.
	 * @param  Point|array  $point     The point to end the stroke at.
	 * @param  boolean      $relative  Whether the coordinates are relative (to the last point)
	 *                                 or absolute.
	 */
	public function qCurveTo($control, $point, $relative = false)
	{
		$control = self::point($control);
		$point = self::point($point);
		return $this->addPathCommand('Q',
				"$control->x,$control->y $point->x,$point->y", $relative);
	}

	/**
	 * The smooth quadratic Bézier curveto command (<code>T</code> or <code>t</code>).
	 *
	 * @param  Point|array  $point     The point to end the stroke at.
	 * @param  boolean      $relative  Whether x, y of <code>$point</code> are relative
	 *                                 (to the last point) or absolute.
	 */
	public function sqCurveTo($point, $relative = false)
	{
		$point = self::point($point);
		return $this->addPathCommand('T', "$point->x,$point->y", $relative);
	}

	/**
	 * The elliptical arc command (<code>A</code> or <code>a</code>).
	 *
	 * @param  float        $rx             The x radius of the ellipse.
	 * @param  float        $ry             The y radius of the ellipse.
	 * @param  float        $xAxisRotation  Rotation of the arc.
	 * @param  boolean      $largeArc       Whether the arc should be greater than or less
	 *                                      than 180 degrees.
	 * @param  boolean      $sweep          Whether the arc should begin moving at negative angles
	 *                                      or positive ones.
	 * @param  Point|array  $point          The point to end the stroke at.
	 * @param  boolean      $relative       Whether x, y of <code>$point</code> are relative
	 *                                      (to the last point) or absolute.
	 */
	public function arc($rx, $ry, $xAxisRotation, $largeArc, $sweep, $point, $relative = false)
	{
		$point = self::point($point);
		$largeArc = $largeArc ? '1' : '0';
		$sweep = $sweep ? '1' : '0';
		return $this->addPathCommand('A',
				"$rx $ry $xAxisRotation $largeArc $sweep $point->x,$point->y", $relative);
	}

	/**
	 * Adds path commands to draw a rectangle.
	 *
	 * @param  Point|array  $corner  The top left corner.
	 * @param  float        $width
	 * @param  float        $height
	 * @param  boolean      $ccw     Whether to draw counterclockwise or not.
	 */
	public function rectanglePath($corner, $width, $height, $ccw = false)
	{
		return $this->anyPolygonPath(Points::create($ccw)
				->rectangle(self::point($corner), $width, $height));
	}

	/**
	 * Adds path commands to draw a regular polygon.
	 *
	 * @param  Point|array  $center
	 * @param  int          $n       Number of corners.
	 * @param  float        $radius
	 * @param  boolean      $ccw     Whether to draw counterclockwise or not.
	 */
	public function polygonPath($center, $n, $radius, $ccw = false)
	{
		return $this->anyPolygonPath(Points::create()->ccw($ccw)
				->polygon(self::point($center), $n, $radius));
	}

	/**
	 * Adds path commands to draw a regular star polygon.
	 *
	 * @param  Point|array  $center
	 * @param  int          $n       Number of corners of the underlying polygon.
	 * @param  float        $radius  Radius of the underlying polygon.
	 * @param  float        $radii
	 * @param  boolean      $ccw     Whether to draw counterclockwise or not.
	 */
	public function starPath($center, $n, $radius, $radii, $ccw = false)
	{
		return $this->anyPolygonPath(Points::create()->ccw($ccw)
				->star(self::point($center), $n, $radius, $radii));
	}

	/**
	 * Adds path commands to draw any polygon.
	 *
	 * @param Points $points
	 */
	public function anyPolygonPath(Points $points)
	{
		$points = $points->points;
		$this->moveTo($points[0]);
		$count = count($points);
		for ($i = 1; $i < $count; $i++) {
			$this->lineTo($points[$i]);
		}
		return $this->closePath();
	}

	/**
	 * Adds path commands to draw a circle.
	 *
	 * @param  Point|array  $center
	 * @param  float        $radius
	 * @param  boolean      $ccw     Whether to draw counterclockwise or not.
	 */
	public function circlePath($center, $radius, $ccw = false)
	{
		return $this->ellipsePath($center, $radius, $radius, 0, $ccw);
	}

	/**
	 * Adds path commands to draw an ellipse.
	 * @param  Point|array[]  $center
	 * @param  float          $rx
	 * @param  float          $ry
	 * @param  float          $xAxisRotation
	 * @param  boolean        $ccw            Whether to draw counterclockwise or not.
	 */
	public function ellipsePath($center, $rx, $ry, $xAxisRotation = 0, $ccw = false)
	{
		$center = self::point($center);
		$angle = self::angle($xAxisRotation);
		$point1 = Point::create($center->x + $rx, $center->y)->rotate($center, $angle);
		$point2 = Point::create($center->x - $rx, $center->y)->rotate($center, $angle);
		$sweep = !$ccw;
		return $this->moveTo($point1)
				->arc($rx, $ry, $xAxisRotation, false, $sweep, $point2)
				->arc($rx, $ry, $xAxisRotation, false, $sweep, $point1);
	}

	/**
	 * Adds path commands to draw a sector of a circle.
	 *
	 * @param  Point|array  $center
	 * @param  Angle|float  $start
	 * @param  Angle|float  $stop    Must be greater than <code>$start</code>.
	 * @param  float        $radius
	 * @param  boolean      $ccw     Whether to draw counterclockwise or not.
	 */
	public function sectorPath($center, $start, $stop, $radius, $ccw = false)
	{
		$start = self::angle($start);
		$stop = self::angle($stop);
		$points = Points::create()->ccw($ccw)
				->sector(self::point($center), $start, $stop, $radius)->points;

		$largeArc = $stop->radians - $start->radians >= pi();
		return $this->moveTo($points[0])
				->lineTo($points[1])
				->arc($radius, $radius, 0, $largeArc, !$ccw, $points[2])
				->closePath();
	}

	/**
	 * Adds path commands to draw a sector of a circle.
	 *
	 * @param  Point|array  $center
	 * @param  Angle|float  $start
	 * @param  Angle|float  $span
	 * @param  float        $radius       Must be greater than <code>$start</code>.
	 * @param  float        $innerRadius
	 * @param  boolean      $ccw          Whether to draw counterclockwise or not.
	 */
	public function ringSectorPath($center, $start, $stop, $radius, $innerRadius, $ccw = false)
	{
		$start = self::angle($start);
		$stop = self::angle($stop);
		$points = Points::create()->ccw($ccw)
				->ringSector(self::point($center), $start, $stop, $radius, $innerRadius)->points;

		$largeArc = $stop->radians - $start->radians >= pi();
		return $this->moveTo($points[0])
				->arc($radius, $radius, 0, $largeArc, !$ccw, $points[1])
				->lineTo($points[2])
				->arc($innerRadius, $innerRadius, 0, $largeArc, $ccw, $points[3])
				->closePath();
	}

	/**
	 * The dx attribute.
	 *
	 * @param dx mixed
	 * <p>The horizontal offset. One or more values (comma separated or in an array).</p>
	 */
	public function setDx($dx)
	{
		return $this->complexAttrib('dx', $dx);
	}

	/**
	 * The dy attribute.
	 *
	 * @param dy mixed
	 * <p>The vertical offset. One or more values (comma separated or in an array).</p>
	 */
	public function setDy($dy)
	{
		return $this->complexAttrib('dy', $dy);
	}

	/**
	 * Sets dx and dy.
	 *
	 * @param dy mixed
	 * <p>The vertical offset. One or more values (comma separated or in an array).</p>
	 *
	 * @param dx mixed
	 * <p>The horizontal offset. One or more values (comma separated or in an array).</p>
	 */
	public function setDxDy($dx, $dy)
	{
		return $this->setDx($dx)->setDy($dy);
	}

	/**
	 * The x attribute.
	 *
	 * @param x mixed
	 * <p>One or more x values (comma separated or in an array).</p>
	 */
	public function setX($x)
	{
		return $this->complexAttrib('x', $x);
	}

	/**
	 * The y attribute.
	 *
	 * @param y mixed
	 * <p>One or more y values (comma separated or in an array).</p>
	 */
	public function setY($y)
	{
		return $this->complexAttrib('y', $y);
	}

	/**
	 * Sets x and y.
	 *
	 * @param x mixed
	 * <p>One or more x values (comma separated or in an array).</p>
	 *
	 * @param y mixed
	 * <p>One or more y values (comma separated or in an array).</p>
	 */
	public function setXY($x, $y)
	{
		return $this->setX($x)->setY($y);
	}

	/**
	 * The rotate attribute.
	 *
	 * @param rotate string|array
	 * <p>makes each character rotate to its respective value, with remaining characters rotating
	 * according to the last value. A space separated list or an array.</p>
	 */
	public function setRotate($rotate)
	{
		return $this->complexAttrib('rotate', $rotate);
	}

	private static function point($point)
	{
		return is_array($point) ? Point::create($point[0], $point[1]) : $point;
	}

	private static function angle($angle)
	{
		return is_scalar($angle) ? Angle::byDegrees($angle) : $angle;
	}
}
