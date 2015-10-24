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

	public function circle($cx, $cy, $r)
	{
		return $this->append('circle')
				->attrib('cx', $cx)
				->attrib('cy', $cy)
				->attrib('r', $r);
	}

	public function ellipse($cx, $cy, $rx, $ry)
	{
		return $this->append('circle')
				->attrib('cx', $cx)
				->attrib('cy', $cy)
				->attrib('rx', $rx)
				->attrib('rx', $ry);
	}

	public function line($x1, $y1, $x2, $y2)
	{

	}
}
