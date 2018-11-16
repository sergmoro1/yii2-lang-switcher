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

    /**
     * Switch on exact language.
     */
    public function actionEn($url = null) { return $this->language('en', $url); }
    public function actionRu($url = null) { return $this->language('ru', $url); }

    private function language($selector, $url)
    {
        // reading
        $cookies = Yii::$app->request->cookies;
        if($cookies->getValue('language', 'ru') == $selector) {
            $referrer = Yii::$app->request->referrer;
            return $this->redirect($url ? $url : ($referrer ? $referrer : Url::home()));
        } else
            return $this->redirect(['switch', 'url' => $url]);
    }
}

