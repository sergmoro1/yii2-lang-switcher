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
use yii\helpers\Url;

class LanguageController extends Controller {
	
    private static $opposite = ['ru' => 'en', 'en' => 'ru'];
	
    /**
     * Language switcher.
     */
    public function actionSwitch($url = null)
    {
		// reading
		$cookies = Yii::$app->request->cookies;
		$language = self::$opposite[$cookies->getValue('language', 'ru')];
		// writing
		$cookies = Yii::$app->response->cookies;
		$cookies->add(new \yii\web\Cookie([
			'name' => 'language',
			'value' => $language,
		]));
		$referrer = Yii::$app->request->referrer;
		return $this->redirect($url ? $url : ($referrer ? $referrer : Url::home()));
	}
}

