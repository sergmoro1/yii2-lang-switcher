<a href='#en_readme_md'>readme.md in English</a>

<h1>Yii2 переключатель языка</h1>

В Yii есть поддержка многоязычности, но она не касается контента.
Контент, обычно, предлагается размещать раздельно. Фактически это разные сайты.

Для блога, например, это не удобно. 
Проще проводить подстрочный перевод:
<pre>
&lt;p class='ru'&gt;
  Текст на родном языке.
&lt;/p&gt;
&lt;p class='en'&gt;
  Text in native language.
&lt;/p&gt;
</pre>

Как видно, определены два класса: <code>.ru</code>, <code>.en</code>.
При текущем языке - ru-RU, отображаются html-теги с классом <code>.ru</code> и остальные, 
а теги с классом <code>.en</code> скрываются.
Если нажат переключатель языка, теги с классом <code>.ru скрываются</code>, а <code>.en</code> показываются.

Именно этот подход и реализован этим небольшим расширением, рассчитанным на поддержку двух языков.

<h2>Установка</h2>

В каталоге приложения:

<pre>
$ composer require sergmoro1/yii2-lang-switcher "dev-master"
</pre>

<h2>Использование</h2>

Зарегистрировать виджет в приложении - <code>common/config/main.php</code>:
<pre>
&lt;?php
return [
  ...
  'bootstrap' =&gt; [
    'LangSwitcher',
  ],
  ...
  'modules' =&gt; [
    'langswitcher' =&gt; ['class' =&gt; 'sergmoro1\langswitcher\Module'],
  ],
  ...
  'components' =&gt; [
    'LangSwitcher' =&gt; ['class' =&gt; 'sergmoro1\langswitcher\widgets\LangSwitcher'],
  ],
];
</pre>

Вызвать виджет в <code>frontend/views/layouts/main.php</code> или <code>backend/views/layouts/main.php</code>:
<pre>
...
use sergmoro1\langswitcher\widgets\LangSwitcher;
...
&lt;body&gt;
&lt;?= LangSwitcher::widget(); ?&gt;
</pre>

В меню или любом подходящем месте разместить переключатель:
<pre>
&lt;?php echo Html::a('rus|eng', ['langswitcher/language/switch']); ?&gt;
</pre>

В модели нужно предусмотреть выборку данных, соответствующих текущему языку.
Например так:
<pre>
private static $opposite = ['ru' =&lg; 'en', 'en' =&lg; 'ru'];

/**
 * @return text clearing from tags with opposite language class 
 * @param language
 */
public function excludeByLanguage($attribute)
{
  $cookies = Yii::$app-&lg;request-&lg;cookies;
  $language = $cookies-&lg;getValue('language', 'ru');
  return preg_replace('/&lt;(p|ul|ol|blockquote) class="'. self::$opposite[$language] .'"&lg;(.+)&lt;\/(p|ul|ol|blockquote)&lg;/isU', '', $this-&lg;$attribute);
}
</pre>

<h1><a name='en_readme_md'></a>Yii2 language switcher</h1>

Yii has multi-language support, but there are not about content.
Content, ordinary, should be on a different sites.

But, for blog, it's not convenient. 
Simpler translate right in place: 
<pre>
&lt;p class='ru'&gt;
  Текст на родном языке.
&lt;/p&gt;
&lt;p class='en'&gt;
  Text in native language.
&lt;/p&gt;
</pre>

So, two classes have defined: <code>.ru</code>, <code>.en</code>.
For current languge - ru-RU, will show html-tags with class <code>.ru</code> and others, 
and tags with class <code>.en</code> hide.
If has pressed languge switcher, tags with <code>.ru</code> hide and with <code>.en</code> shows.

This approach is implemented in this little extension for two languages.

Languages can be arbitrary.

<h2>Installation</h2>

In app directory:

<pre>
$ composer require sergmoro1/yii2-lang-switcher "dev-master"
</pre>

<h2>Usage</h2>
Register widget in app - <code>common/config/main.php</code>:
<pre>
&lt;?php
return [
  ...
  'bootstrap' =&gt; [
    'LangSwitcher',
  ],
  ...
  'modules' =&gt; [
    'langswitcher' =&gt; ['class' =&gt; 'sergmoro1\langswitcher\Module'],
  ],
  ...
  'components' =&gt; [
    'LangSwitcher' =&gt; ['class' =&gt; 'sergmoro1\langswitcher\widgets\LangSwitcher'],
  ],
];
</pre>

Call widget in <code>frontend/views/layouts/main.php</code> or <code>backend/views/layouts/main.php</code>:
<pre>
...
use sergmoro1\langswitcher\widgets\LangSwitcher;
...
&lt;body&gt;
&lt;?= LangSwitcher::widget(); ?&gt;
</pre>

In menu place the switcher:
<pre>
&lt;?php echo Html::a('rus|eng', ['langswitcher/language/switch']); ?&gt;
</pre>

In a model should be provided getting content for current language.
For example:
<pre>
private static $opposite = ['ru' =&lg; 'en', 'en' =&lg; 'ru'];

/**
 * @return text clearing from tags with opposite language class 
 * @param language
 */
public function excludeByLanguage($attribute)
{
  $cookies = Yii::$app-&lg;request-&lg;cookies;
  $language = $cookies-&lg;getValue('language', 'ru');
  return preg_replace('/&lt;(p|ul|ol|blockquote) class="'. self::$opposite[$language] .'"&lg;(.+)&lt;\/(p|ul|ol|blockquote)&lg;/isU', '', $this-&lg;$attribute);
}
</pre>
