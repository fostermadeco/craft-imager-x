<?php
/**
 * Imager X plugin for Craft CMS
 *
 * Ninja powered image transforms.
 *
 * @link      https://www.spacecat.ninja
 * @copyright Copyright (c) 2020 André Elvan
 */

namespace spacecatninja\imagerx\effects;

use spacecatninja\imagerx\services\ImagerService;
use Imagine\Gd\Image as GdImage;
use Imagine\Imagick\Image as ImagickImage;
use Imagine\Imagick\Imagick;

class TintEffect implements ImagerEffectsInterface
{

    /**
     * @param GdImage|ImagickImage        $imageInstance
     * @param array|string|int|float|null $params
     */
    public static function apply($imageInstance, $params)
    {
        if (ImagerService::$imageDriver === 'imagick') {
            if (\is_array($params)) {
                /** @var ImagickImage $imageInstance */
                $imagickInstance = $imageInstance->getImagick();
                $tint = new \ImagickPixel($params[0]);
                $opacity = new \ImagickPixel($params[1]);
    
                $imagickInstance->tintImage($tint, $opacity);
            }
        }
    }
}
