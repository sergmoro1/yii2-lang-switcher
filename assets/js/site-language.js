/**
 * Language switcher.
 * @ author <sergmoro1@ya.ru>
 * @license MIT
 * When switcher is called all tags with class .en hides and .ru shows.
 * And vice versa. All depends of current language settings.
 */
var site_language = {
	current: 'en',
	available: ['ru', 'en']
};
site_language.switch = function() {
	$("." + this.current).show();
	for(var i = 0; i < this.available.length; i++) {
		if(this.current != this.available[i])
			$("." + this.available[i]).hide();
	}
}
jQuery(document).ready(function($) {
	site_language.switch();
});
