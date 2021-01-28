<?php
/**
 * @package    Grav.Common.Page
 *
 * @copyright  Copyright (C) 2015 - 2018 Trilby Media, LLC. All rights reserved.
 * @license    MIT License; see LICENSE file for details.
 */

namespace Grav\Common\Page\Medium;

trait VectorImageMediumTrait 
{
    /**
     * Resize media by setting attributes
     *
     * @param  int $width
     * @param  int $height
     * @return $this
     */
	 
	private function appendUnit($value) {
		if (is_numeric($value)) return $value."px";
		elseif (empty($value)) return "auto";
		else return $value;
	}
	 
    public function resize($width = null, $height = null)
    {
		if ($height === null && strpos($width,"%") > 0) $height = $width;
        $this->styleAttributes['width'] = $this->appendUnit($width);
        $this->styleAttributes['height'] = $this->appendUnit($height);

        return $this;
    }
	
	public function width($width = null)
    {
        $this->styleAttributes['width'] = $this->appendUnit($width);
		$this->styleAttributes['height'] = "auto";

        return $this;
    }
	
	public function height($height = null)
    {
		$this->styleAttributes['width'] = "auto";
        $this->styleAttributes['height'] = $this->appendUnit($height);

        return $this;
    }

    /**
     * Find the viewbox element in the SVG file and determine size
     *
     * @param  int  $multiplier Multiplies the size read in the SVG file
     * @return      $this
     */
	public function auto($multiplier = 0) {
		$imageFile = $this->items['filepath'];
		$data = fread($fp = fopen($imageFile, 'r'), 64);
		fclose($fp);
		preg_match('/<svg.*?viewBox="([\d\.]+)[ ]([\d\.]+)[ ]([\d\.]+)[ ]([\d\.]+).*/i', file_get_contents($imageFile), $matches);
		if (empty($matches) || count($matches) < 4) return $this;
		$this->styleAttributes['width'] = $matches[3]*$multiplier."px";
        $this->styleAttributes['height'] = "auto";
		return $this;
	}
}
