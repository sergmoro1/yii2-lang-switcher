<?php
/**
 * @author - Sergey Morozov <sergmoro1@ya.ru>
 * @license - MIT
 * 
 * Behavior is helped clean up an opposite language version of content.
 */
namespace sergmoro1\langswitcher;

use Yii;
use yii\base\Behavior;

class LangSwitcher extends Behavior
{
    private static $languages = ['ru' => 0, 'en' => 1];
    private static $opposite = ['ru' => 'en', 'en' => 'ru'];
    private static $translatedTags = '(h1|h2|h3|h4|div|p|ul|ol|blockquote)';    

    /**
     * Language version (e.g. title) delimited by '/'. 
     * Methord split string and choose needed version.
     * 
     * @param model $attribute
     * @param needed $language version
     * @return string attribute value by languge
     */
    public function splitByLanguage($attribute = 'title', $language = null)
    {
        $language = $language ? $language : $this->language;
        $vals = explode('/', $this->owner->$attribute);
        return (count(self::$languages) == count($vals))
            ? trim($vals[self::$languages[$language]])
            : $this->owner->$attribute;
    }

    /**
     * Exclude opposite language tags from a content.
     * 
     * @param model $attribute
     * @return text clearing from tags with opposite language class 
     */
    public function excludeByLanguage($attribute = 'excerpt')
    {
        return preg_replace('/<' . 
            self::$translatedTags . ' class="'. self::$opposite[$this->language] .'">(.+)<\/' . 
            self::$translatedTags . '>/isU', '', $this->owner->$attribute);
    }

    public function getLanguage()
    {
        return substr(Yii::$app->language, 0, 2);
    }
}
