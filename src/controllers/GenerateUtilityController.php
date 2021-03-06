<?php
/**
 * Imager X plugin for Craft CMS
 *
 * Ninja powered image transforms.
 *
 * @link      https://www.spacecat.ninja
 * @copyright Copyright (c) 2020 André Elvan
 */


namespace spacecatninja\imagerx\controllers;

use Craft;
use craft\web\Controller;

use spacecatninja\imagerx\ImagerX as Plugin;

/**
 * Class CacheController
 *
 * @package spacecatninja\imagerx\controllers
 */
class GenerateUtilityController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var array
     */
    protected $allowAnonymous = false;

    // Public Methods
    // =========================================================================

    /**
     * Controller action to generate transforms. Called by geerate transforms utility.
     */
    public function actionGenerateTransforms(): \yii\web\Response
    {
        $request = Craft::$app->getRequest();
        
        $volumes = $request->getParam('volumes');
        $useConfiguredTransforms = $request->getParam('useConfiguredTransforms') === '1';
        $namedTransforms = $request->getParam('namedTransforms');
        
        $hasErrors = false;
        $errors = [];
        if (empty($volumes) || !is_array($volumes)) {
            $hasErrors = true;
            $errors[] = Craft::t('imager-x', 'No volumes selected.');
        }
        
        if (!$useConfiguredTransforms && empty($namedTransforms)) {
            $hasErrors = true;
            $errors[] = Craft::t('imager-x', 'No transforms selected.');
        }
        
        if ($hasErrors) {
            return $this->asJson([
                'success' => false,
                'errors' => $errors
            ]);
        }
        
        try {
            Plugin::$plugin->generate->generateByUtility($volumes, $useConfiguredTransforms, !$useConfiguredTransforms ? $namedTransforms : []);
        } catch (\Throwable $e) {
            Craft::error('An error occured when trying to generate transform jobs from utility: ' . $e->getMessage(), __METHOD__);
            
            return $this->asJson([
                'success' => false,
                'errors' => [
                    $e->getMessage()
                ]
            ]);
        }

        return $this->asJson([
            'success' => true
        ]);
    }

}
