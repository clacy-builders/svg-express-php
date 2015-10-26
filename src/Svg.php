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
	 * <p>The x position of the center of the ellipse.</p>
	 *
	 * @param ry
	 * <p>The y position of the center of the ellipse.</p>
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
	 * <p>A space separated list of points which x and y coordinates are comma separated.<br>
	 * <code>'1,2 3,4'</code></p>
	 * <p>Otherwise an array (points) of arrays (x and y coordinates).<br>
	 * <code>[[1, 2], [3, 4]]</code></p>
	 */
	public function polygon($points)
	{
		return $this->append('polygon')
				->setPoints($points);
	}

	public function path($d = null)
	{
		return $this->append('path')
				->attrib('d', $d);
	}

	/**
	 * The points attribute.
	 *
	 * @param points string|array
	 * <p>See the description of <code>polyline()</code> and <code>polygon()</code></p>
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

	public function closePath()
	{
		return $this->addPathCommand('C');
	}

	public function moveTo($x, $y, $relative = false)
	{
		return $this->addPathCommand('M', "$x,$y", $relative);
	}

	public function lineTo($x, $y, $relative = false)
	{
		return $this->addPathCommand('L', "$x,$y", $relative);
	}

	public function horizLineTo($x, $relative = false)
	{
		return $this->addPathCommand('H', $x, $relative);
	}

	public function vertLineTo($y, $relative = false)
	{
		return $this->addPathCommand('V', $y, $relative);
	}

	public function curveTo($x1, $y1, $x2, $y2, $x, $y, $relative = false)
	{
		return $this->addPathCommand('C', "$x1,$y1, $x2,$y2 $x,$y", $relative);
	}

	public function smoothCurveTo($x2, $y2, $x, $y, $relative = false)
	{
		return $this->addPathCommand('C', "$x2,$y2 $x,$y", $relative);
	}

	public function quadraticCurveTo($x1, $y1, $x, $y, $relative = false)
	{
		return $this->addPathCommand('Q', "$x1,$y1, $x,$y", $relative);
	}

	public function smoothQuadraticCurveTo($x, $y, $relative = false)
	{
		return $this->addPathCommand('T', "$x,$y", $relative);
	}

}
