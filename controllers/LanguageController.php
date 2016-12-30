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
	
    private static $opposite = ['ru' => 'en', 'en' => 'ru'];
	// tags that can be used with .ru and .en classes
	private static $translatedTags = '(h1|h2|h3|h4|p|ul|ol|blockquote)';	
	
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
		return $this->redirect($url ? $url : Yii::$app->request->referrer);
	}

	/**
	 * set new traslatedTags
	 */
	public function setTags($tags)
	{
		self::$translatedTags = $tags;
	}

	/**
	 * clean up all tags with opposite languge
	 */
	public function renderContent($content)
	{
		$cookies = Yii::$app->request->cookies;
		$language = $cookies->getValue('language', 'ru');
		return preg_replace('/<' . 
			self::$translatedTags . ' class="'. self::$opposite[$language] .'">(.+)<\/' . 
			self::$translatedTags . '>/isU', '', parent::renderContent($content));
	}
}

