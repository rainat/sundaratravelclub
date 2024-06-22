(function ($) {
	$(document).ready(() => {
		$(
			"#yith-top-form .yith_wcbk_booking_product_form_widget.yith-wcbk-mobile-fixed-form",
		).css({
			position: "relative",
		});
		$("#yith-wcbk-booking-persons").addClass("cuber-nohide");
		$("#yith-top-form p.price").css("display", "none");
		$(
			"#yith-top-form label.yith-wcbk-form-section__label.yith-wcbk-booking-form__label",
		).css("display", "none");

		$("#yith-top-form .cuber-duration-track").css("display", "none");
		$("#yith-top-form .cuber-detail-end").css("display", "none");

		$("#yith-top-form .product.yith-wcbk-widget-booking-form").css(
			"max-width",
			"100%",
		);

		$("#yith-top-form .yith-wcbk-booking-form").addClass(
			"flex gap-4 w-[58%]",
		);
		$(
			"#yith-top-form .yith-wcbk-form-section-dates-wrapper.yith-wcbk-form-section-wrapper",
		).addClass("flex gap-4");
		$("#yith-top-form #wrap-login-book").addClass("w-1/5 rounded-full");
		$("#yith-top-form form.cart")
			.css("display", "flex")
			.addClass("gap-4 justify-between");
		$("#yith-top-form #wrap-login-book").before(
			'<div class="flex flex-col gap-2"><span class="price-desktop price-desc-add text-[24px] text-[#BFB198] font-semibold text-right">...</span><span class="tax-desc text-[10px] text-[#8C8C8C] leading-none text-right">@ ... includes taxes & fees</span></div>',
		);
		// $('#yith-top-form .cuber-nohide').css('display','block')
		setInterval(function () {
			// // let price = $('#yith-top-form .woocommerce-Price-amount.amount').text()
			// let price = $('#yith-top-form p.price').text()

			// price = price.substr(0, price.length - 8)
			// // console.log(price)
			// let val_price = price.replace('$', '').replace(',', '')

			// let formatted_price = new Intl.NumberFormat('en-US', {
			// 	style: 'currency', currency: 'USD'
			// }).format(val_price).replace('.00', '')
			// console.log(val_price,formatted_price)
			// if (formatted_price!='$NaN') {
			// 	if(formatted_price!='$0')
			// 	$('#yith-top-form .price-desc-add').text(formatted_price)
			// 	$('#yith-top-form .tax-desc').text(`@ ${formatted_price} includes taxes & fees`)
			// }
			let formatted_price = $("#yith-top-form p.price").text();
			if (formatted_price.includes("/ person"))
				formatted_price = formatted_price.replace("/ person", "");
			$("#yith-top-form .price-desc-add").text(formatted_price);
			$("#yith-top-form .tax-desc").text(
				`@ ${formatted_price} includes taxes & fees`,
			);
		}, 200);

		// plus minus input number
		var person = $("input#yith-wcbk-booking-persons");
		$(person).after(
			'<div class="plusminus"><div class="minus">-</div><div class="plus">+</div></div>',
		);

		var maxsc = Number($(".slot-count-data").attr("data-slotcount"));
		$("div.minus").click(function () {
			var $input = $("input#yith-wcbk-booking-persons");
			var count = parseInt($input.val()) - 1;
			count = count < 1 ? 1 : count;

			$input.val(count);
			$input.change();
			$($input).attr("value", count);
			// console.log('minus', $input)
			// return false;
		});

		$("div.plus").click(function () {
			var $input = $("input#yith-wcbk-booking-persons");
			count = parseInt($input.val()) + 1;
			// console.log(maxsc, count)
			if (count > maxsc) {
				count = maxsc;
				$.toast({
					heading: "Max Person",
					text: "Sorry max person allowed reach.",
					showHideTransition: "fade",
					icon: "error",
				});
			} else {
				$input.val(count);
				$input.change();
				$($input).attr("value", count);
			}

			// console.log('plus', $input)
			// return false;
		});

		//sticky footer moved to galery under

		// var x = window.matchMedia("(max-width: 700px)")
		// if (x.matches) {
		// 	$('.yith_wcbk_booking_product_form_widget.yith-wcbk-mobile-fixed-form').css('display', 'none')
		// }

		// $('#mobile-book-now-top a').click((e) => {
		// 	e.preventDefault()

		// 	$('.yith_wcbk_booking_product_form_widget.yith-wcbk-mobile-fixed-form').css('display', 'block')
		// 	setTimeout(() => {
		// 		$('.yith_wcbk_booking_product_form_widget.yith-wcbk-mobile-fixed-form').addClass('is-open')
		// 	}, 300)

		// 	$('.yith-wcbk-mobile-fixed-form__close').click(() => {
		// 		$('.yith_wcbk_booking_product_form_widget.yith-wcbk-mobile-fixed-form').css('display', 'none')
		// 	})

		// })

		$("button[comingsoon=1]").css({ cursor: "not-allowed" });
		$("button[comingsoon=1]").click((e) => {
			e.preventDefault();
		});

		// $("input#yith-wcbk-booking-persons[name='persons']").attr('disabled', 'disabled')
	});
})(jQuery);
