<?php
/**
 * @author - Sergey Morozov <sergmoro1@ya.ru>
 * @license - MIT
 * 
 * Language switcher.
 */

namespace sergmoro1\langswitcher\controllers;

use Yii;
use yii\web\Controller;

class LanguageController extends Controller {
	
    private static $variants = ['ru' => 'en', 'en' => 'ru'];
	
    /**
     * Language switcher.
     */
    public function actionSwitch()
    {
		// reading
		$cookies = Yii::$app->request->cookies;
		$language = self::$variants[$cookies->getValue('language', 'ru')];
		// writing
		$cookies = Yii::$app->response->cookies;
		$cookies->add(new \yii\web\Cookie([
			'name' => 'language',
			'value' => $language,
		]));
        return $this->redirect(Yii::$app->request->referrer);
	}
}

