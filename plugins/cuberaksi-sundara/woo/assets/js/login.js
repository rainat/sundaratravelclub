// (function ($) {
var isTrue =
	jQuery('[data-id="50aa2e0"]').attr("data-widget_type") == "image.default"
		? true
		: false;
if (isTrue) jQuery('[data-id="50aa2e0"]').css("display", "none");
// })(jQuery);

jQuery(document).ready(($) => {
	let login = $($('.wp_google_login')[0]).html()
	// $($('.eael-lr-form-loader-wrapper')[0]).after(login)
	$($('.eael-lr-footer')[0]).after('<div style="margin-top:15px;"></div>' + login)

})