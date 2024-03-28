(function ($,document,window) {
	$(document).ready(()=>{
		$('.priceinfo123').css('display','none')	
	    $($('.priceinfo123')[1]).css('display','block')	

	    $('.wp_google_login').css('display','none')
   		var gl = $('.wp_google_login').html()
   		$('.wp_google_login').remove()
   		$('.e-woocommerce-login-anchor').css('display','block')	

   		$('.e-woocommerce-form-login-submit').wrap("<div id='wrap-login-custom' class='flex flex-col md:flex-row lg:flex-row gap-2 '></div>")
   		$('#wrap-login-custom').append(gl)
   		$('.wp_google_login').addClass('w-full md:h-full md:mt-0 md:basis-1/2 lg:h-full lg:mt-0 lg:basis-1/2')
   		$('.wp_google_login__button-container').css('margin-top','0px').addClass('md:grow lg:grow')
   		$('.e-woocommerce-form-login-submit').addClass('w-full md:basis-1/2 lg:basis-1/2').css('width','100%')



   		//rearrange form
   		
   		$('.e-woocommerce-login-anchor').css('display','none')

   		const first = document.querySelector('.e-checkout__column.e-checkout__column-start').outerHTML;
   		const second = document.querySelector('.e-checkout__column.e-checkout__column-end').outerHTML;
   		const payment = document.querySelector('#payment').outerHTML

   		
   		document.querySelector('.e-checkout__container').innerHTML = `${second} ${first}`

   		document.querySelector('#payment').outerHTML =''
   		document.querySelector('#customer_details').innerHTML = document.querySelector('#customer_details').innerHTML + `<div style='margin-top:2em'> </div>${payment}`
	})
	
})(jQuery,document,window)