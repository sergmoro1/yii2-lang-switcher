<?php
/**
 * Language Switcher
 * @author Pitt Phunsanit (modified <sergmoro1@ya.ru>)
 * @website http://plusmagi.com
 */
 
namespace sergmoro1\langswitcher\widgets;
 
use Yii;
use yii\base\Widget;
use yii\web\Cookie;
 
class LangSwitcher extends Widget
{
    private static $languages = [
        'ru' => 'ru-RU',
        'en' => 'en-US',
    ];
 
    public function init()
    {
        parent::init();
        // read cookies
        if(isset(Yii::$app->request->cookies)) {
            $cookies = Yii::$app->request->cookies;
            //  set current language by cookie
            Yii::$app->language = self::$languages[
                $cookies->getValue('language', 'ru')
            ];
        }
    }
}
