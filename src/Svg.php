<?php

namespace ML_Express\SVG;

use ML_Express\Xml;
use ML_Express\Shared\XLink;
use ML_Express\Shared\XLinkConstants;
use ML_Express\Shared\AddQuery;
use ML_Express\Shared\ClassAttribute;
use ML_Express\Shared\DimensionAttributes;
use ML_Express\Shared\StyleAttribute;
use ML_Express\Shared\TypeAttribute;
use ML_Express\Shared\XmlStylesheet;
use ML_Express\Graphics\Point;
use ML_Express\Graphics\Points;
use ML_Express\Graphics\Angle;

class Svg extends Xml implements XLinkConstants
{
	use XLink, XmlStylesheet,
			AddQuery, DimensionAttributes, ClassAttribute, StyleAttribute, TypeAttribute;

	const MIME_TYPE = 'image/svg+xml';
	const FILENAME_EXTENSION = 'svg';
	const ROOT_ELEMENT = 'svg';

	public static function createSvg($width = null, $height = null, $viewBox = null)
	{
		return static::createRoot('svg')
				->setDimensions($width, $height)
				->attrib('viewbox', $viewBox);
	}

	/**
	 * Appends a rect (rectangle) element.
	 *
	 * @param  Point|array  $corner  The top left corner of the rectangle.
	 * @param  float        $width   The width of the rectangle.
	 * @param  float        $height  The height of the rectangle.
	 * @param  float        $rx      The x radius of the corners of the rectangle.
	 * @param  float        $ry      The y radius of the corners of the rectangle.
	 * @return Svg
	 */
	public function rect($corner, $width, $height, $rx = null, $ry = null)
	{
		return $this->append('rect')
				->setPosition($corner)
				->setDimensions($width, $height)
				->attrib('rx', $rx)
				->attrib('ry', $ry);
	}

	/**
	 * Appends a <code>circle</code> element.
	 *
	 * @param  Point|array  $center  Center of the circle.
	 * @param  float        $r       The radius of the circle.
	 * @return Svg
	 */
	public function circle($center, $r)
	{
		return $this->append('circle')
				->setCenter($center)
				->attrib('r', $r);
	}

	/**
	 * Appends an <code>ellipse</code> element.
	 *
	 * @param  Point|array  $center  The center of the ellipse.
	 * @param  float        $rx      The x radius of the ellipse.
	 * @param  float        $ry      The y radius of the ellipse.
	 * @return Svg
	 */
	public function ellipse($center, $rx, $ry)
	{
		return $this->append('ellipse')
				->setCenter($center)
				->attrib('rx', $rx)
				->attrib('ry', $ry);
	}

	/**
	 * Appends a <code>line</code> element.
	 *
	 * @param  Point|array  $point1
	 * @param  Point|array  $point2
	 * @return Svg
	 */
	public function line($point1, $point2)
	{
		return $this->append('line')
				->pointAttrib($point1, 'x1', 'y1')
				->pointAttrib($point2, 'x2', 'y2');
	}

	/**
	 * Appends a <code>polyline</code> element.
	 *
	 * @param  string|array  $points  A space separated list of points which x and y coordinates
	 *                                are comma separated.
	 *                                Otherwise an array of arrays or <code>Point</code> objects.
	 * @return Svg
	 */
	public function polyline($points = null)
	{
		return $this->append('polyline')
				->setPoints($points);
	}

	/**
	 * Appends a <code>polygon</code> element.
	 *
	 * @param  mixed  $points  A space separated list of points which x and y coordinates
	 *                         are comma separated.
	 *                         Otherwise a <code>Points</code> object, an array of arrays
	 *                         or <code>Point</code> objects.
	 * @return Svg
	 */
	public function polygon($points = null)
	{
		return $this->append('polygon')
				->setPoints($points);
	}

	/**
	 * The <code>polygon</code> element with the <code>points</code> attribute set for a regular
	 * star polygon.
	 *
	 * @param  Point|array  $center
	 * @param  int          $n       Number of corners of the underlying polygon.
	 * @param  float        $radius  Radius of the underlying polygon.
	 * @param  float        $radii
	 * @return Svg
	 */
	public function star($center, $n, $radius, $radii = [])
	{
		return $this->polygon(Points::star(self::point($center), $n, $radius, $radii));
	}


	/**
	 * Appends a <code>path</code> element.
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
	 * @return Svg
	 */
	public function path($d = null)
	{
		return $this->append('path')
				->attrib('d', $d);
	}

	/**
	 * Appends an <code>image</code> element.
	 *
	 * @param  string       $href
	 * @param  Point|array  $position             The top left corner of the image.
	 * @param  mixed        $width
	 * @param  mixed        $height
	 * @param  string       $preserveAspectRatio  See <code>setPreserveAspectRatio()</code>.
	 * @return Svg
	 */
	public function image($href, $position = null,
			$width = null, $height = null, $preserveAspectRatio = null)
	{
		return $this->append('image')
				->setXLinkHref($href)
				->setPosition($position)
				->setDimensions($width, $height)
				->setPreserveAspectRatio($preserveAspectRatio);
	}

	/**
	 * Appends a <code>text</code> element.
	 *
	 * @param  string       $content   You may append <code>tspan</code> or <code>tpath</code>
	 *                                 instead.
	 * @param  Point|array  $position  The position of the first letter. Use <code>setX()</code>,
	 *                                 <code>setY()</code> to append more values.
	 * @param  mixed        $dx        The horizontal offset. One or more values (comma separated
	 *                                 or in an array).
	 * @param  mixed        $dy        The vertical offset. One or more values (comma separated
	 *                                 or in an array).
	 * @param  mixed        $rotate    Makes each character rotate to its respective value, with
	 *                                 remaining characters rotating according to the last value.
	 *                                 A space separated list or an array.
	 * @return Svg
	 */
	public function text($content = '', $position = null, $dx = null, $dy = null, $rotate = null)
	{
		return $this->append('text', $content)
				->setPosition($position)
				->setDxDy($dx, $dy)
				->setRotate($rotate);
	}

	/**
	 * Appends a <code>tspan</code> element.
	 *
	 * @param  string       $content
	 * @param  Point|array  $position  The position of the first letter. Use <code>setX()</code>,
	 *                                 <code>setY()</code> to append more values.
	 * @param  mixed        $dx        The horizontal offset. One or more values (comma separated
	 *                                 or in an array).
	 * @param  mixed        $dy        The vertical offset. One or more values (comma separated
	 *                                 or in an array).
	 * @param  mixed        $rotate    Makes each character rotate to its respective value, with
	 *                                 remaining characters rotating according to the last value.
	 *                                 A space separated list or an array.
	 * @return Svg
	 */
	public function tspan($content, $position = null, $dx = null, $dy = null, $rotate = null)
	{
		return $this->append('tspan', $content)
				->setPosition($position)
				->setDxDy($dx, $dy)
				->setRotate($rotate);
	}

	/**
	 * Appends a <code>textPath</code> element.
	 *
	 * @param  string  $content
	 * @param  string  $href     Fetches an arbitrary path and aligns the characters,
	 *                           that it encircles, along this path.
	 * @return Svg
	 */
	public function textPath($content, $href)
	{
		return $this->append('textPath', $content)->setXLinkHref($href);
	}

	/**
	 * Appends a <code>defs</code> element.
	 *
	 * @return Svg
	 */
	public function defs()
	{
		return $this->append('defs');
	}

	/**
	 * Appends an <code>use</code> element.
	 *
	 * @param  string       $href    A reference to an element/fragment within an SVG document.
	 * @param  Point|array  $corner  The upper-left corner of the region into which the
	 *                               referenced element is placed.
	 * @param  float        $width   The width of the region into which the referenced element
	 *                               is placed.
	 * @param  float        $height  The height of the region into which the referenced element
	 *                               is placed.
	 * @return Svg
	 */
	public function useElem($href, $corner, $width = null, $height = null)
	{
		return $this->append('use')
				->setXLinkHref($href)
				->setPosition($corner)
				->setDimensions($width, $height);
	}

	/**
	 * Appends a <code>g</code> element.
	 *
	 * @return Svg
	 */
	public function g()
	{
		return $this->append('g');
	}

	/**
	 * Appends a <code>title</code> element.
	 *
	 * @param  string  $content
	 * @return Svg
	 */
	public function title($content)
	{
		return $this->append('title', $content);
	}

	/**
	 * Appends a <code>desc</code> element.
	 *
	 * @param  string  $content
	 * @return Svg
	 */
	public function desc($content)
	{
		return $this->append('desc', $content);
	}

	/**
	 * Appends a <code>clipPath</code> element.
	 *
	 * @param  string  $id
	 * @param  string  $clipPathUnits  The coordinate system for the contents of the clip path:
	 *                                 <br><code>Svg::UNITS_USER_SPACE_ON_USE</code> or
	 *                                 <code>Svg::UNITS_OBJECT_BOUNDING_BOX</code>
	 * @return Svg
	 */
	public function clipPath($id, $clipPathUnits = null)
	{
		return $this->append('clipPath')
				->setId($id)
				->attrib('clipPathUnits', $clipPathUnits);
	}

	/**
	 * Appends a <code>mask</code> element.
	 *
	 * @param  string       $id
	 * @param  Point|array  $position
	 * @param  mixed        $width
	 * @param  mixed        $height
	 * @param  string       $maskUnits         The coordinate system for attributes
	 *                                         <code>x</code>, <code>y</code>, <code>width</code>
	 *                                         and <code>height</code>:<br>
	 *                                         <code>Svg::UNITS_USER_SPACE_ON_USE</code> or
	 *                                         <code>Svg::UNITS_OBJECT_BOUNDING_BOX</code>
	 * @param  string       $maskContentUnits  The coordinate system for the contents of the mask:
	 *                                         <br><code>Svg::UNITS_USER_SPACE_ON_USE</code> or
	 *                                         <code>Svg::UNITS_OBJECT_BOUNDING_BOX</code>
	 * @return Svg
	 */
	public function mask($id, $position = null, $width = null, $height = null,
			$maskUnits = null, $maskContentUnits = null)
	{
		return $this->append('mask')
				->setId($id)
				->setPosition($position)
				->setDimensions($width, $height)
				->attrib('maskUnits', $maskUnits)
				->attrib('maskContentUnits', $maskContentUnits);
	}

	/**
	 * Appends a <code>filter</code> element.
	 *
	 * @param  string       $id
	 * @param  Point|array  $position
	 * @param  mixed        $width
	 * @param  mixed        $height
	 * @param  string       $href            Reference to another filter within the same SVG.
	 * @param  string       $filterUnits     see <code>setFilterUnits()</code>.
	 * @param  string       $primitiveUnits  see <code>setPrimitiveUnits()</code>.
	 * @return Svg
	 */
	public function filter($id, $position = null, $width = null, $height = null,
			$href = null, $filterUnits = null, $primitiveUnits = null)
	{
		return $this->append('filter')
				->setId($id)
				->setXLinkHref($href)
				->setPosition($position)
				->setDimensions($width, $height)
				->setFilterUnits($filterUnits)
				->setPrimitiveUnits($primitiveUnits);
	}

	CONST MODE_NORMAL = 'normal';
	CONST MODE_MULTIPLY = 'multiply';
	CONST MODE_SCREEN = 'screen';
	CONST MODE_DARKEN = 'darken';
	CONST MODE_LIGHTEN = 'lighten';

	/**
	 * The <code>feBlend</code> filter primitive.
	 *
	 * @param  string|Svg  $in      See <code>setIn()</code>.
	 * @param  string|Svg  $in2     See <code>setIn()</code>.
	 * @param  string      $mode    One of these keywords:<ul>
	 *                              <li><code>Svg::MODE_NORMAL</code>
	 *                              <li><code>Svg::MODE_MULTIPLY</code>
	 *                              <li><code>Svg::MODE_SCREEN</code>
	 *                              <li><code>Svg::MODE_DARKEN</code>
	 *                              <li><code>Svg::MODE_LIGHTEN</code></ul>
	 * @param  string      $result  See <code>setResult()</code>.
	 * @return Svg
	 */
	public function feBlend($in, $in2, $mode = null, $result = null)
	{
		return $this->append('feBlend')
				->setIn($in)
				->setIn($in2, 'in2')
				->attrib('mode', $mode)
				->setResult($result);
	}

	const TYPE_MATRIX = 'matrix';
	const TYPE_SATURATE = 'saturate';
	const TYPE_HUE_ROTATE = 'hueRotate';
	const TYPE_LUMINANCE_TO_ALPHA = 'luminanceToAlpha';

	/**
	 * The <code>feColorMatrix</code> filter primitive.
	 *
	 * @param  string      $type
	 * @param  mixed       $values
	 * @param  string|Svg  $in      See <code>setIn()</code>.
	 * @param  string      $result  See <code>setResult()</code>.
	 * @return Svg
	 */
	public function feColorMatrix($type, $values = null, $in = null, $result = null)
	{
		return $this->append('feColorMatrix')
				->setIn($in)
				->setType($type)
				->matrixAttrib('values', $values)
				->setResult($result);
	}

	/**
	 * The <code>feComponentTransfer</code> filter primitive.
	 *
	 * @param  string|Svg  $in      See <code>setIn()</code>.
	 * @param  string      $result  See <code>setResult()</code>.
	 * @return Svg
	 */
	public function feComponentTransfer($in = null, $result = null)
	{
		return $this->append('feComponentTransfer')
				->setIn($in)
				->setResult($result);
	}

	const CHANNEL_R = 'R';
	const CHANNEL_G = 'G';
	const CHANNEL_B = 'B';
	const CHANNEL_A = 'A';
	const CHANNEL_RGB = 0;
	const CHANNEL_RGBA = 1;

	protected function feFunc($channel, $type, $tableValues = null,
			$slope = null, $intercept = null, $amplitude = null, $exponent = null, $offset = null)
	{
		if (\is_numeric($channel)) {
			$channel = $channel
					? [self::CHANNEL_R, self::CHANNEL_G, self::CHANNEL_B, self::CHANNEL_A]
					: [self::CHANNEL_R, self::CHANNEL_G, self::CHANNEL_B];
		}
		if (\is_array($channel)) {
			foreach ($channel as $channel) {
				$this->feFunc($channel, $type, $tableValues, $slope, $intercept,
						$amplitude, $exponent, $offset);
			}
			return $this;
		}
		return $this->append('feFunc' . $channel)
				->setType($type)
				->complexAttrib('tableValues', $tableValues, ',')
				->attrib('slope', $slope)
				->attrib('intercept', $intercept)
				->attrib('amplitude', $amplitude)
				->attrib('exponent', $exponent)
				->attrib('offset', $offset);
	}

	public function feFuncIdentity($channel)
	{
		return $this->feFunc($channel, 'identity');
	}

	public function feFuncTable($channel, $tableValues)
	{
		return $this->feFunc($channel, 'table', $tableValues);
	}

	public function feFuncDiscrete($channel, $tableValues)
	{
		return $this->feFunc($channel, 'discrete', $tableValues);
	}

	public function feFuncLinear($channel, $slope, $intercept = null)
	{
		return $this->feFunc($channel, 'linear', null, $slope, $intercept);
	}

	public function feFuncGamma($channel, $amplitude = null, $exponent = null, $offset = null)
	{
		return $this->feFunc($channel, 'gamma', null, null, null, $amplitude, $exponent, $offset);
	}

	/**
	 * The <code>feGaussianBlur</code> filter primitive.
	 *
	 * @param  mixed       $stdDeviation  Standard deviation along both axes, or comma separated
	 *                                    for x-axis and y-axis respectively.
	 * @param  string|Svg  $in            See <code>setIn()</code>.
	 * @param  string      $result        See <code>setResult()</code>.
	 * @return Svg
	 */
	public function feGaussianBlur($stdDeviation = null, $in = null, $result = null)
	{
		return $this->append('feGaussianBlur')
				->setIn($in)
				->complexAttrib('stdDeviation', $stdDeviation)
				->setResult($result);
	}

	/**
	 * The <code>feImage</code> filter primitive.
	 *
	 * @param  string       $href                 The source.
	 * @param  string       $preserveAspectRatio  See <code>setPreserveAspectRatio()</code>.
	 * @param  string       $result
	 * @param  Point|array  $position
	 * @param  mixed        $width
	 * @param  mixed        $height
	 * @return Svg
	 */
	public function feImage($href, $preserveAspectRatio = null,
			$result = null, $position = null, $width = null, $height = null)
	{
		return $this->append('feImage')
				->setXLinkHref($href)
				->setPreserveAspectRatio($preserveAspectRatio)
				->setPosition($position)
				->setDimensions($width, $height)
				->setResult($result);
	}

	/**
	 * The <code>feMerge</code> filter primitive.
	 *
	 * @param  array   $in      The values for the <code>in</code> attributes of the
	 *                          <code>feMergeNode</code> subelements.
	 * @param  string  $result  See <code>setResult()</code>.
	 * @return Svg
	 */
	public function feMerge($in, $result = null)
	{
		$fm = $this->append('feMerge')->setResult($result);
		foreach ($in as $in) {
			$fm->append('feMergeNode')->setIn($in);
		}
		return $fm;
	}

	const OPERATOR_DILATE = 'dilate';
	const OPERATOR_ERODE = 'erode';

	/**
	 * The <code>feMorphology</code> filter primitive.
	 *
	 * @param  mixed       $radius    One or two values (comma separated or in an array).
	 * @param  string      $operator  <code>Svg::OPERATOR_ERODE</code> or
	 *                                <code>Svg::OPERATOR_DILATE</code>.
	 * @param  string|Svg  $in        See <code>setIn()</code>.
	 * @param  string      $result    See <code>setResult()</code>.
	 * @return Svg
	 */
	public function feMorphology($radius = null, $operator = null, $in = null, $result = null)
	{
		return $this->append('feMorphology')
				->setIn($in)
				->complexAttrib('radius', $radius, ',')
				->attrib('operator', $operator)
				->setResult($result);
	}

	/**
	 * The <code>feOffset</code> filter primitive.
	 *
	 * @param  float       $dx      Shift along the x-axis.
	 * @param  float       $dy      Shift along the y-axis.
	 * @param  string|Svg  $in      See <code>setIn()</code>.
	 * @param  string      $result  See <code>setResult()</code>.
	 * @return Svg
	 */
	public function feOffset($dx, $dy, $in = null, $result = null)
	{
		return $this->append('feOffset')
				->setIn($in)
				->attrib('dx', $dx)
				->attrib('dy', $dy)
				->setResult($result);
	}

	/**
	 * Sets the <code>id</code> attribute.
	 *
	 * @param  string  $id
	 * @return Svg
	 */
	public function setId($id)
	{
		return $this->attrib('id', $id);
	}

	public function setViewBox($corner, $width, $height)
	{
		return $this->attrib('viewBox', self::buildViewBox($corner, $width, $height));
	}

	public static function buildViewBox($corner, $width, $height)
	{
		$corner = self::point($corner);
		return "$corner->x $corner->y $width $height";
	}

	const PRESERVE_NONE = 'none';
	const PRESERVE_XMINYMIN = 'xMinYMin';
	const PRESERVE_XMINYMID = 'xMinYMid';
	const PRESERVE_XMINYMAX = 'xMinYMax';
	const PRESERVE_XMIDYMIN = 'xMidYMin';
	const PRESERVE_XMIDYMID = 'xMidYMid';
	const PRESERVE_XMIDYMAX = 'xMidYMax';
	const PRESERVE_XMAXYMIN = 'xMaxYMin';
	const PRESERVE_XMAXYMID = 'xMaxYMid';
	const PRESERVE_XMAXYMAX = 'xMaxYMax';

	/**
	 * Sets the <code>preserveAspectRatio</code> attribute.
	 *
	 * @param  string   $align  One of the following values:<ul>
	 *                          <li><code>Svg::PRESERVE_NONE</code>
	 *                          <li><code>Svg::PRESERVE_XMINYMIN</code>
	 *                          <li><code>Svg::PRESERVE_XMINYMID</code>
	 *                          <li><code>Svg::PRESERVE_XMINYMAX</code>
	 *                          <li><code>Svg::PRESERVE_XMIDYMIN</code>
	 *                          <li><code>Svg::PRESERVE_XMIDYMID</code>
	 *                          <li><code>Svg::PRESERVE_XMIDYMAX</code>
	 *                          <li><code>Svg::PRESERVE_XMAXYMIN</code>
	 *                          <li><code>Svg::PRESERVE_XMAXYMID</code>
	 *                          <li><code>Svg::PRESERVE_XMAXYMAX</code></ul>
	 * @param  boolean  $slice
	 * @param  boolean  $defer
	 * @return Svg
	 */
	public function setPreserveAspectRatio($align, $slice = false, $defer = false)
	{
		return $this->attrib('preserveAspectRatio',
				self::buildPreserveAspectRatio($align, $slice, $defer));
	}

	public static function buildPreserveAspectRatio($align, $slice = false, $defer = false)
	{
		return ($defer ? 'defer ' : '') . $align . ($slice ? ' slice' : '');
	}

	/**
	 * Sets the <code>points</code> attribute.
	 *
	 * @param  string|array  $points  A space separated list of points which x and y coordinates
	 *                                are comma separated.
	 *                                Otherwise an array of arrays or <code>Point</code> objects.
	 * @return Svg
	 */
	public function setPoints($points)
	{
		if (!is_string($points) && !empty($points)) {
			foreach ($points as $point) {
				$this->addPoint($point);
			}
			return $this;
		}
		return $this->complexAttrib('points', $points);
	}

	/**
	 * Adds a point to the points listed in the <code>points</code> attribute.
	 *
	 * @param  Point|array  $point
	 * @return Svg
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
	 *
	 * @return Svg
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
	 * @return Svg
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
	 * @return Svg
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
	 * @return Svg
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
	 * @return Svg
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
	 * @return Svg
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
	 * @return Svg
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
	 * @return Svg
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
	 * @return Svg
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
	 * @return Svg
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
	 * @return Svg
	 */
	public function rectanglePath($corner, $width, $height, $ccw = false)
	{
		return $this->anyPolygonPath(
				Points::rectangle(self::point($corner), $width, $height, $ccw));
	}

	/**
	 * Adds path commands to draw a regular polygon.
	 *
	 * @param  Point|array  $center
	 * @param  int          $n       Number of corners.
	 * @param  float        $radius
	 * @param  boolean      $ccw     Whether to draw counterclockwise or not.
	 * @return Svg
	 */
	public function polygonPath($center, $n, $radius, $ccw = false)
	{
		return $this->anyPolygonPath(Points::polygon(self::point($center), $n, $radius, $ccw));
	}

	/**
	 * Adds path commands to draw a regular star polygon.
	 *
	 * @param  Point|array  $center
	 * @param  int          $n       Number of corners of the underlying polygon.
	 * @param  float        $radius  Radius of the underlying polygon.
	 * @param  float        $radii
	 * @param  boolean      $ccw     Whether to draw counterclockwise or not.
	 * @return Svg
	 */
	public function starPath($center, $n, $radius, $radii = [], $ccw = false)
	{
		return $this->anyPolygonPath(
				Points::star(self::point($center), $n, $radius, $radii, $ccw));
	}

	/**
	 * Adds path commands to draw any polygon.
	 *
	 * @param  Points  $points
	 * @return Svg
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
	 * @return Svg
	 */
	public function circlePath($center, $radius, $ccw = false)
	{
		return $this->ellipsePath($center, $radius, $radius, 0, $ccw);
	}

	/**
	 * Adds path commands to draw an ellipse.
	 *
	 * @param  Point|array  $center
	 * @param  float        $rx
	 * @param  float        $ry
	 * @param  float        $xAxisRotation
	 * @param  boolean      $ccw            Whether to draw counterclockwise or not.
	 * @return Svg
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
	 * @return Svg
	 */
	public function sectorPath($center, $start, $stop, $radius, $ccw = false)
	{
		$start = self::angle($start);
		$stop = self::angle($stop);
		$points = Points::sector(self::point($center), $start, $stop, $radius, $ccw)->points;

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
	 * @return Svg
	 */
	public function ringSectorPath($center, $start, $stop, $radius, $innerRadius, $ccw = false)
	{
		$start = self::angle($start);
		$stop = self::angle($stop);
		$points = Points::ringSector(
				self::point($center), $start, $stop, $radius, $innerRadius, $ccw)->points;

		$largeArc = $stop->radians - $start->radians >= pi();
		return $this->moveTo($points[0])
				->arc($radius, $radius, 0, $largeArc, !$ccw, $points[1])
				->lineTo($points[2])
				->arc($innerRadius, $innerRadius, 0, $largeArc, $ccw, $points[3])
				->closePath();
	}

	/**
	 * Adds path commands to draw a rounded rectangle.
	 *
	 * @param  Point|array  $corner
	 * @param  float        $width
	 * @param  float        $height
	 * @param  float        $radius
	 * @param  boolean      $ccw     Whether to draw counterclockwise or not.
	 * @return Svg
	 */
	public function roundedRectanglePath($corner, $width, $height, $radius, $ccw = false)
	{
		$points = Points::roundedRectangle(
				self::point($corner), $width, $height, $radius, $ccw)->points;
		return $this->moveTo($points[0])
				->arc($radius, $radius, 0, false, !$ccw, $points[1])
				->lineTo($points[2])
				->arc($radius, $radius, 0, false, !$ccw, $points[3])
				->lineTo($points[4])
				->arc($radius, $radius, 0, false, !$ccw, $points[5])
				->lineTo($points[6])
				->arc($radius, $radius, 0, false, !$ccw, $points[7])
				->closePath();
	}

	/**
	 * Sets the <code>dx</code> attribute.
	 *
	 * @param  mixed  $dx  The horizontal offset. One or more values (comma separated or
	 *                     in an array).
	 * @return Svg
	 */
	public function setDx($dx)
	{
		return $this->complexAttrib('dx', $dx);
	}

	/**
	 * Sets the <code>dy</code> attribute.
	 *
	 * @param  mixed  $dy  The vertical offset. One or more values (comma separated or
	 *                     in an array).
	 * @return Svg
	 */
	public function setDy($dy)
	{
		return $this->complexAttrib('dy', $dy);
	}

	/**
	 * Sets dx and dy.
	 *
	 * @param  mixed  $dx  The horizontal offset. One or more values (comma separated or
	 *                     in an array).
	 * @param  mixed  $dy  The vertical offset. One or more values (comma separated or
	 *                     in an array).
	 * @return Svg
	 */
	public function setDxDy($dx, $dy)
	{
		return $this->setDx($dx)->setDy($dy);
	}

	/**
	 * Sets the <code>x</code> attribute.
	 *
	 * @param  mixed  $x  One or more x values (comma separated or in an array).
	 * @return Svg
	 */
	public function setX($x)
	{
		return $this->complexAttrib('x', $x);
	}

	/**
	 * Sets the <code>y</code> attribute.
	 *
	 * @param  mixed  $y  One or more y values (comma separated or in an array).
	 * @return Svg
	 */
	public function setY($y)
	{
		return $this->complexAttrib('y', $y);
	}

	/**
	 * Sets x and y.
	 *
	 * @param  mixed  $x  One or more x values (comma separated or in an array).
	 * @param  mixed  $y  One or more y values (comma separated or in an array).
	 * @return Svg
	 */
	public function setXY($x, $y)
	{
		return $this->setX($x)->setY($y);
	}

	/**
	 * Sets the <code>rotate</code> attribute.
	 *
	 * @param  mixed  Makes each character rotate to its respective value, with remaining
	 *                characters rotating according to the last value. A space separated
	 *                list or an array.
	 * @return Svg
	 */
	public function setRotate($rotate)
	{
		return $this->complexAttrib('rotate', $rotate);
	}

	const UNITS_USER_SPACE_ON_USE = 'userSpaceOnUse';
	const UNITS_OBJECT_BOUNDING_BOX = 'objectBoundingBox';

	/**
	 * Sets the <code>filterUnits</code> attribute.
	 *
	 * @param  string  $primitiveUnits  <ul><li><code>Svg::UNITS_USER_SPACE_ON_USE</code>
	 *                                  <li><code>Svg::UNITS_OBJECT_BOUNDING_BOX</code>
	 * @return Svg
	 */
	public function setFilterUnits($filterUnits)
	{
		return $this->attrib('filterUnits', $filterUnits);
	}

	/**
	 * Sets the <code>primitiveUnits</code> attribute.
	 *
	 * @param  string  $primitiveUnits  <ul><li><code>Svg::UNITS_USER_SPACE_ON_USE</code>
	 *                                  <li><code>Svg::UNITS_OBJECT_BOUNDING_BOX</code>
	 * @return Svg
	 */
	public function setPrimitiveUnits($primitiveUnits)
	{
		return $this->attrib('primitiveUnits', $primitiveUnits);
	}

	const IN_SOURCE_GRAPHIC = 'SourceGraphic';
	const IN_SOURCE_ALPHA = 'SourceAlpha';
	const IN_BACKGROUND_IMAGE = 'BackgroundImage';
	const IN_BACKGROUND_ALPHA = 'BackgroundAlpha';
	const IN_FILL_PAINT = 'FillPaint';
	const IN_STROKE_PAINT = 'StrokePaint';

	/**
	 * Sets the <code>in</code> attribute.
	 *
	 * @param  string|Svg  $in         A reference to a filter primitive (the value of its result
	 *                                 attribute) or one of these keywords:<ul>
	 *                                 <li><code>Svg::IN_SOURCE_GRAPHIC</code>
	 *                                 <li><code>Svg::IN_SOURCE_ALPHA</code>
	 *                                 <li><code>Svg::IN_BACKGROUND_IMAGE</code>
	 *                                 <li><code>Svg::IN_BACKGROUND_ALPHA</code>
	 *                                 <li><code>Svg::IN_FILL_PAINT</code>
	 *                                 <li><code>Svg::IN_STROKE_PAINT</code></ul>
	 * @param  string      $attribute  Name of the attribute: 'in' or 'in2'.
	 * @return Svg
	 */
	public function setIn($in, $attribute = 'in')
	{
		if ($in instanceof Svg) {
			$in = $in->attributes->getAttrib('result');
		}
		return $this->attrib($attribute, $in);
	}

	/**
	 * Sets the <code>result</code> attribute.
	 *
	 * @param  string  $result  A name for the current filter primitive, so it can be referenced.
	 * @return Svg
	 */
	public function setResult($result)
	{
		return $this->attrib('result', $result);
	}

	/**
	 * Sets the <code>tableValues</code> attribute.
	 *
	 * @param  mixed  $tableValues
	 * @return Svg
	 */
	public function setTableValues($tableValues)
	{
		return $this->complexAttrib('tableValues', $tableValues);
	}

	/**
	 * Sets the <code>x</code> and <code>y</code> attributes.
	 *
	 * @param  Point|array  $position
	 * @return Svg
	 */
	public function setPosition($position)
	{
		return $this->pointAttrib($position);
	}

	/**
	 * Sets the <code>cx</code> and <code>cy</code> attributes.
	 *
	 * @param  Point|array  $center
	 * @return Svg
	 */
	public function setCenter($center)
	{
		return $this->pointAttrib($center, 'cx', 'cy');
	}

	/**
	 * Sets coordinates (two attributes belonging together).
	 *
	 * @param  Point|array  $point
	 * @param  string       $xName  Name of the attribute which represents the x value.
	 * @param  string       $yName  Name of the attribute which represents the y value.
	 * @return Svg
	 */
	protected function pointAttrib($point, $xName = 'x', $yName = 'y')
	{
		if (empty($point)) {
			$x = null;
			$y = null;
		}
		elseif (is_array($point)) {
			$x = $point[0];
			$y = $point[1];
		}
		else {
			$x = $point->x;
			$y = $point->y;
		}
		return $this->attrib($xName, $x)->attrib($yName, $y);
	}

	protected function matrixAttrib($name, $matrix, $glue = ' ')
	{
		if (\is_array($matrix)) {
			foreach ($matrix as $key => $value) {
				if (\is_array($value)) {
					$matrix[$key] = \implode($glue, $value);
				}
			}
			$matrix = \implode($glue, $matrix);
		}
		return $this->attrib($name, $matrix);
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
