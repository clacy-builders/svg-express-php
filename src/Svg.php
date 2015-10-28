<?php
namespace ML_Express\SVG;

use ML_Express\Xml;

class Svg extends Xml
{
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
	 * @param x
	 * <p>The x position of the top left corner of the rectangle.</p>
	 *
	 * @param y
	 * <p>The y position of the top left corner of the rectangle.</p>
	 *
	 * @param width
	 * <p>The width of the rectangle</p>
	 *
	 * @param height
	 * <p>The height of the rectangle.</p>
	 *
	 * @param rx
	 * <p>The x radius of the corners of the rectangle</p>
	 *
	 * @param ry
	 * <p>The y radius of the corners of the rectangle</p>
	 */
	public function rect($x, $y, $width, $height, $rx = null, $ry = null)
	{
		return $this->append('rect')
				->attrib('x', $x)
				->attrib('y', $y)
				->attrib('width', $width)
				->attrib('height', $height)
				->attrib('rx', $rx)
				->attrib('ry', $ry);
	}

	/**
	 * The circle element.
	 *
	 * @param cx
	 * <p>The x position of the center of the circle.</p>
	 *
	 * @param cy
	 * <p>The y position of the center of the circle.</p>
	 *
	 * @param r
	 * <p>The radius of the circle.</p>
	 */
	public function circle($cx, $cy, $r)
	{
		return $this->append('circle')
				->attrib('cx', $cx)
				->attrib('cy', $cy)
				->attrib('r', $r);
	}

	/**
	 * The ellipse element.
	 *
	 * @param cx
	 * <p>The x position of the center of the ellipse.</p>
	 *
	 * @param cy
	 * <p>The y position of the center of the ellipse.</p>
	 *
	 * @param rx
	 * <p>The x radius of the ellipse.</p>
	 *
	 * @param ry
	 * <p>The y radius of the ellipse.</p>
	 */
	public function ellipse($cx, $cy, $rx, $ry)
	{
		return $this->append('ellipse')
				->attrib('cx', $cx)
				->attrib('cy', $cy)
				->attrib('rx', $rx)
				->attrib('ry', $ry);
	}

	/**
	 * The line element.
	 *
	 * @param x1
	 * <p>The x position of point 1.</p>
	 *
	 * @param y1
	 * <p>The y position of point 1.</p>
	 *
	 * @param x2
	 * <p>The x position of point 2.</p>
	 *
	 * @param y2
	 * <p>The y position of point 2.</p>
	 */
	public function line($x1, $y1, $x2, $y2)
	{
		return $this->append('line')
				->attrib('x1', $x1)
				->attrib('y1', $y2)
				->attrib('x2', $x1)
				->attrib('y2', $y2);
	}

	/**
	 * The polyline element.
	 *
	 * @param points string|array
	 * <p>A space separated list of points which x and y coordinates are comma separated.<br>
	 * <code>'1,2 3,4'</code></p>
	 * <p>Otherwise an array (points) of arrays (x and y coordinates).<br>
	 * <code>[[1, 2], [3, 4]]</code></p>
	 */
	public function polyline($points)
	{
		return $this->append('polyline')
				->setPoints($points);
	}

	/**
	 * The polygon element.
	 *
	 * @param points string|array
	 * <p>See the description of <code>polyline()</code></p>
	 */
	public function polygon($points)
	{
		return $this->append('polygon')
				->setPoints($points);
	}

	/**
	 * The path element.
	 *
	 * @param d string
	 * <p>A series of commands. You may use the following methods to build this attribute:<br>
	 * <ul><li><code>moveTo()</code>,
	 * <li><code>lineTo()</code>,
	 * <li><code>hLineTo()</code>,
	 * <li><code>vLineTo()</code>,
	 * <li><code>curveTo()</code>,
	 * <li><code>sCurveTo()</code>
	 * <li><code>qCurveTo()</code>
	 * <li><code>sqCurveTo()</code>
	 * <li><code>arc()</code>
	 * <li><code>closePath()</code>
	 * </ul></p>
	 */
	public function path($d = null)
	{
		return $this->append('path')
				->attrib('d', $d);
	}

	/**
	 * The points attribute.
	 *
	 * @param points string|array
	 * <p>See the description of <code>polyline()</code></p>
	 */
	public function setPoints($points)
	{
		if (is_array($points)) {
			foreach ($points as $point) {
				list($x, $y) = array_values($point);
				$this->addPoint($x, $y);
			}
			return $this;
		}
		return $this->attrib('points', $points, ' ');
	}

	/**
	 * Adds a point to the points listened in the <code>points</code> attribute.
	 *
	 * @param x
	 * <p>The x coordinate.</p>
	 *
	 * @param y
	 * <p>The y coordinate.</p>
	 */
	public function addPoint($x, $y)
	{
		return $this->attrib('points', $x . ',' . $y, ' ', true);
	}

	private function addPathCommand($command, $coords = null, $relative = false)
	{
		$this
				->attrib('d', $relative ? strtolower($command) : $command, ' ', false, false)
				->attrib('d', $coords, ' ', false, false);
		return $this;
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
	 * @param x
	 * <p>The x coordinate to move to.</p>
	 *
	 * @param y
	 * <p>The y coordinate to move to.</p>
	 *
	 * @param relative boolean [optional]
	 * <p>Whether <code>$x</code>, <code>$y</code> are relative or absolute.</p>
	 */
	public function moveTo($x, $y, $relative = false)
	{
		return $this->addPathCommand('M', "$x,$y", $relative);
	}

	/**
	 * The lineto command (<code>L</code> or <code>l</code>).
	 *
	 * @param x
	 * <p>The x coordinate to end the line at.</p>
	 *
	 * @param y
	 * <p>The y coordinate to end the line at.</p>
	 *
	 * @param relative boolean [optional]
	 * <p>Whether <code>$x</code>, <code>$y</code> are relative (to the last point)
	 * or absolute.</p>
	 */
	public function lineTo($x, $y, $relative = false)
	{
		return $this->addPathCommand('L', "$x,$y", $relative);
	}

	/**
	 * The horizontal lineto command (<code>H</code> or <code>h</code>).
	 *
	 * @param x
	 * <p>The x coordinate to end the line at.</p>
	 *
	 * @param relative boolean [optional]
	 * <p>Whether <code>$x</code> is relative (to the last point)
	 * or absolute.</p>
	 */

	public function hLineTo($x, $relative = false)
	{
		return $this->addPathCommand('H', $x, $relative);
	}

	/**
	 * The vertical lineto command (<code>V</code> or <code>v</code>).
	 *
	 * @param y
	 * <p>The y coordinate to end the line at.</p>
	 *
	 * @param relative boolean [optional]
	 * <p>Whether <code>$y</code> is relative (to the last point)
	 * or absolute.</p>
	 */
	public function vLineTo($y, $relative = false)
	{
		return $this->addPathCommand('V', $y, $relative);
	}

	/**
	 * The cubic Bézier curveto command (<code>C</code> or <code>c</code>).
	 *
	 * @param x1
	 * <p>The x coordinate of the control point for the start of the curve.</p>
	 *
	 * @param y1
	 * <p>The y coordinate of the control point for the start of the curve.</p>
	 *
	 * @param x2
	 * <p>The x coordinate of the control point for the end of the curve.</p>
	 *
	 * @param y2
	 * <p>The y coordinate of the control point for the end of the curve.</p>
	 *
	 * @param x
	 * <p>The x coordinate to end the stroke at.</p>
	 *
	 * @param y
	 * <p>The y coordinate to end the stroke at.</p>
	 *
	 * @param relative boolean [optional]
	 * <p>Whether the coordinates are relative (to the last point) or absolute.</p>
	 */
	public function curveTo($x1, $y1, $x2, $y2, $x, $y, $relative = false)
	{
		return $this->addPathCommand('C', "$x1,$y1 $x2,$y2 $x,$y", $relative);
	}

	/**
	 * The smooth cubic Bézier curveto command (<code>S</code> or <code>s</code>).
	 *
	 * @param x2
	 * <p>The x coordinate of the control point for the end of the curve.</p>
	 *
	 * @param y2
	 * <p>The y coordinate of the control point for the end of the curve.</p>
	 *
	 * @param x
	 * <p>The x coordinate to end the stroke at.</p>
	 *
	 * @param y
	 * <p>The y coordinate to end the stroke at.</p>
	 *
	 * @param relative boolean [optional]
	 * <p>Whether the coordinates are relative (to the last point) or absolute.</p>
	 */

	public function sCurveTo($x2, $y2, $x, $y, $relative = false)
	{
		return $this->addPathCommand('S', "$x2,$y2 $x,$y", $relative);
	}

	/**
	 * The quadratic Bézier curveto command (<code>Q</code> or <code>q</code>).
	 *
	 * @param x1
	 * <p>The x coordinate of the control point.</p>
	 *
	 * @param y1
	 * <p>The y coordinate of the control point.</p>
	 *
	 * @param x
	 * <p>The x coordinate to end the stroke at.</p>
	 *
	 * @param y
	 * <p>The y coordinate to end the stroke at.</p>
	 *
	 * @param relative boolean [optional]
	 * <p>Whether the coordinates are relative (to the last point) or absolute.</p>
	 */

	public function qCurveTo($x1, $y1, $x, $y, $relative = false)
	{
		return $this->addPathCommand('Q', "$x1,$y1 $x,$y", $relative);
	}

	/**
	 * The smooth quadratic Bézier curveto command (<code>T</code> or <code>t</code>).
	 *
	 * @param x
	 * <p>The x coordinate to end the stroke at.</p>
	 *
	 * @param y
	 * <p>The y coordinate to end the stroke at.</p>
	 *
	 * @param relative boolean [optional]
	 * <p>Whether <code>$x</code>, <code>$y</code> are relative (to the last point)
	 * or absolute.</p>
	 */
	public function sqCurveTo($x, $y, $relative = false)
	{
		return $this->addPathCommand('T', "$x,$y", $relative);
	}

	/**
	 * The elliptical arc command (<code>A</code> or <code>a</code>).
	 *
	 * @param rx
	 * <p>The x radius of the ellipse.</p>
	 *
	 * @param ry
	 * <p>The y radius of the ellipse.</p>
	 *
	 * @param xAxisRotation
	 * <p>Rotation of the arc.</p>
	 *
	 * @param largeArc boolean
	 * <p>Whether the arc should be greater than or less than 180 degrees.</p>
	 *
	 * @param sweep boolean
	 * <p>Whether the arc should begin moving at negative angles or positive ones.</p>
	 *
	 * @param x
	 * <p>The x coordinate to end the stroke at.</p>
	 *
	 * @param y
	 * <p>The y coordinate to end the stroke at.</p>
	 *
	 * @param relative boolean [optional]
	 * <p>Whether <code>$x</code>, <code>$y</code> are relative (to the last point)
	 * or absolute.</p>
	 */
	public function arc($rx, $ry, $xAxisRotation, $largeArc, $sweep, $x, $y, $relative = false)
	{
		$largeArc = $largeArc ? '1' : '0';
		$sweep = $sweep ? '1' : '0';
		return $this->addPathCommand('A', "$rx $ry $xAxisRotation $largeArc $sweep $x $y",
				$relative);
	}
}
