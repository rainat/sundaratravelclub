(function ($) {
	$(document).ready(() => {
		$('img.lazy').each((idx,el) => {
			// console.log(idx,el)
			$(el).attr('src', $(el).attr('data-src'))
			// console.log({ el: $(el), src: $(el).attr('src'), datasrc: $(el).attr('data-src') })
 				

		})

		
	}) 		
  		
  		
        

})(jQuery);