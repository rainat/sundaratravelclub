(function ($) {
	var isTrue =
		$('[data-id="50aa2e0"]').attr("data-widget_type") == "image.default"
			? true
			: false;
	if (isTrue) $('[data-id="50aa2e0"]').css("display", "none");
})(jQuery);
