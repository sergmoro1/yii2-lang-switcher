<h1>Yii2 language switcher</h1>

Yii has multi-language support, but there are not about content. Content, ordinary, should be on a different sites.

But, for blog, it's not convenient. Simpler translate right in place: 
<pre>
&lt;p class='ru'&gt;
  Текст на родном языке.
&lt;/p&gt;
&lt;p class='en'&gt;
  Text in native language.
&lt;/p&gt;
</pre>

So, two classes have defined: <code>.ru</code>, <code>.en</code>.
For current languge - ru-RU, will show html-tags with class <code>.ru</code> 
and tags with class <code>.en</code> cleaned up.
If has pressed languge switcher, tags with <code>.ru</code> cleaned up and with <code>.en</code> shows.

Fields with a "short" length (e.g. "title"), language version divided by "/".

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

Call widget in <code>frontend/views/layouts/main.php</code> or any other layout.
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

In a model should be provided getting data for current language. 
Behavior shoul be connected in a model <code>/common/models/Post.php</code>.
<pre>
public function behaviors()
{
	return [
		'LangSwitcher' =&gt; ['class' =&gt; LangSwitcher::className()],
	];
}
</pre>

Post content can be shown in <code>frontend/views/post/view.php</code>  
<pre>
&lt;?= $model-&gt;excludeByLanguage('content'); ?&gt;
</pre>

and title.
<pre>
&lt;?= $model-&gt;splitByLanguage('title'); ?&gt;
</pre>

Data to be displayed uniformly, including RSS, need in the model <code>common/models/Post.php</code>
to define a method <code>fields</code>
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

<h2>Static content</h2>
To apply the proposed approach to static pages, you need to pass the content through the filter of the <code>excludeByLanguage()</code>.
This requires that <code>frontend/controllers/SiteController</code> inherits from controller defined in the extension.
<pre>use sergmoro1\langswitcher\controllers\Controller;

class SiteController extends Controller
{
</pre>

Remember that in the <code>sitemap</code> is also necessary to take into account the language version.
