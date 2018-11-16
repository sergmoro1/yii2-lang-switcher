<h1>Yii2 переключатель языка</h1>

В Yii есть поддержка многоязычности, но она не касается контента.
Контент, обычно, предлагается размещать раздельно. Фактически это разные сайты.

Для блога это не удобно. Проще проводить подстрочный перевод:
<pre>
&lt;p class='ru'&gt;
  Текст на родном языке.
&lt;/p&gt;
&lt;p class='en'&gt;
  Text in native language.
&lt;/p&gt;
</pre>

Как видно, определены два класса: <code>.ru</code>, <code>.en</code>.
При текущем языке - ru-RU, отображаются html-теги с классом <code>.ru</code>, а остальные, теги с классом <code>.en</code> удаляются.
Если нажат переключатель языка, теги с классом <code>.ru удаляются</code>, а <code>.en</code> показываются.

В поля с "коротким" содержимым (например заголовк поста), языковые версии разделены символом "/". 

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

Вызвать виджет в <code>frontend/views/layouts/main.php</code> или в ином <code>layouts</code>:
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
Для этого нужно подключить поведение.
<pre>
public function behaviors()
{
    return [
        'LangSwitcher' =&gt; ['class' =&gt; LangSwitcher::className()],
    ];
}
</pre>

Теперь в представлении <code>frontend/views/post/view.php</code> можно вывести контент следующим образом
<pre>
&lt;?= $model-&gt;excludeByLanguage('content'); ?&gt;
</pre>

а заголовок поста так.
<pre>
&lt;?= $model-&gt;splitByLanguage('title'); ?&gt;
</pre>

Чтобы данные выводились единообразно, в том числе в RSS, нужно в модели <code>common/models/Post.php</code>
определить метод <code>fields</code>
<pre>
public function fields()
{
    return [
        'id', 'author_id', 'slug',
        'title' =&gt; function ($model) { return $model-&gt;splitByLanguage('title'); },
        'content' =&gt; function ($model) { return $model-&gt;excludeByLanguage('content'); },
        'tags', 'status', 'created_at', 'updated_at', 
    ];
}
</pre>

<h2>Статичный контент</h2>
Чтобы применить предложенный подход к статичным страницам, нужно пропустить контент через фильтр <code>excludeByLanguage()</code>.
Для этого нужно, чтобы <code>frontend/controllers/SiteController</code> наследовался от контроллера, определенного в расширении.
<pre>
use sergmoro1\langswitcher\controllers\Controller;

class SiteController extends Controller
{
</pre>

Помните, что в <code>sitemap</code> тоже надо учитывать языковую версию.
