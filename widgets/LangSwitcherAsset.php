<?php
/**
 * @author <sergmoro1@ya.ru>
 * @license MIT
 */

namespace sergmoro1\langswitcher\widgets;

use Yii;
use yii\web\AssetBundle;
use yii\web\View;

class LangSwitcherAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
		'js/site-language.js',
    ];
    public $depends = [
    ];
    
    public static function register($view)
    {
		$cookies = Yii::$app->request->cookies;
		$language = $cookies->getValue('language', substr(Yii::$app->language, 0, 2));
        $view->registerJs("site_language.current = '$language';", View::POS_END);
		parent::register($view);
	}
}