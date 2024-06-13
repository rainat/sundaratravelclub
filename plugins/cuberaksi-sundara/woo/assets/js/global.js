(function ($) {

	$(document).ready(() => {
		// $('.yith_wcbk_booking_product_form_widget').css('position', 'fixed')
		//triger click on desktop
		$('#yith-form-fake').click(() => {
			// $('#hidingme').css('display','block')
			$('.yith_wcbk_booking_product_form_widget').css({ 'top': '15%', 'left': '40%' })
			
			
		})
		$('#btn-yith-form-fake').click(() => {
			// $('#hidingme').css('display','block')
			$('.yith_wcbk_booking_product_form_widget').css({ 'top': '15%', 'left': '40%' })
			
		}) 

		if ($('#booking .elementor-button-text')) 
			$('#booking .elementor-button-text').text($('#mobile-book-now').text());

		if (typeof productme !== undefined) {

				
				
			if ($('.woocommerce-notices-wrapper').children().length > 0) {

				if ($('.woocommerce-notices-wrapper .woocommerce-message').text().includes('Request for booking confirmation sent')) {
					location.href = location.origin + "/my-account/bookings?confirm=yes"
				}
				
				const interval = setInterval(() => {
					if (elementorProFrontend.modules.popup) {
						
						elementorProFrontend.modules.popup.showPopup({ id: 6717 }); 
						// console.log('founded', $('.woocommerce-notices-wrapper .woocommerce-message').text())
						$('#woo-msg-notice').html($('#woo-msg-notice').html().replace("{{message_notice}}", $('.woocommerce-notices-wrapper .woocommerce-message').text()))	
						clearInterval(interval);

						

					}
				}, 100)

				//elementorProFrontend.modules.popup.showPopup({ id: 6717 });  
				//$('#woo-notice-dialog').click()

				
			}
			
				
		}

		$("img.lazy").each((idx, el) => {
			// console.log(idx,el)
			$(el).attr("src", $(el).attr("data-src"));
			// console.log({ el: $(el), src: $(el).attr('src'), datasrc: $(el).attr('data-src') })
		});

		if (typeof timelineObj !== "undefined")
			if (!timelineObj.timeline_off) {
				$("#timeline-product").hide();
				$("#timeline-product-line").hide();
			}

		if ($(".twae-timeline").length > 0) {
			let children = $(".twae-timeline").children()
			let length = Object.keys(timelineArr).length
			for (let i = 1; i <= length; i++) {
				// console.log(children[i])
				if (timelineArr[`d${i}`] === false) {

					children[i - 1].style.display = 'none'
				}
			}
			
		}

		


		let times = $(".yith-wcbk-booking-form__label");
		if (times) {
			let founded = times.filter((idx, val) => {
				// console.log({val,idx})
				return val.outerText === "Time";
			});

			// console.log({founded})

			if (founded.length) {
				// console.log({ time: 'there' })
				$(
					".yith-wcbk-form-section.yith-wcbk-form-section-duration.yith-wcbk-form-section-duration--type-customer",
				).css({ display: "none" });

				$(".yith-wcbk-booking-form").css({ "margin-bottom": "20px" });
			}
		}

		if ($(".button.wc-forward").text() === "View basket") {
			$(".button.wc-forward").css("display", "none");
		}

		// $('.yith-wcbk-booking-real-duration').on('change', function (e) {
		// 	setTimeout(function () {
		// 		let bdi = $('bdi')
		// 		console.log(e.target.value, bdi[length(bdi) - 1].outerText)
		// 	}, 1000);

		// })

		// if (productme.cat === "Bangkok Helicopter") {
		// 	// let booking_times = []
		// 	// let c = 0
		// 	// for (let i = 6; i <= 18; i++) {
		// 	// 	booking_times[c] = i < 10 ? "0" + i + ":00" : i + ":00"
		// 	// 	c++
		// 	// }
		// 	let min = 6
		// 	let max = 18

		// console.log(productme)

		function generateTime() {
			if (typeof productme !== "undefined") {

				let minHour = 0;
				let maxHour = 23;
				if (productme.cat.includes("Bangkok Helicopter")) {
					minHour = 6;
					maxHour = 18;
				}

				if (productme.cat.includes("Car Rent")) {
					minHour = 9;
					maxHour = 17;
				}

				if (productme.cat.includes("Bali")) {
					minHour = 8;
					maxHour = 23;
				}

				if (productme.cat.includes("Labuhan Bajo")) {
					minHour = 15;
					maxHour = 23;
				}

				let checkin = $('.yith-booking-checkin > .yith-booking-meta__value')

				if (checkin.length > 0) {
					let tmpVal = $('.yith-booking-checkin > .yith-booking-meta__value').text()
					minHour = Number(tmpVal.substr(0, 2))
					
				}

				let checkout = $('.yith-booking-checkout > .yith-booking-meta__value')
				
				if (checkout.length > 0) {
					let tmpVal = $('.yith-booking-checkout > .yith-booking-meta__value').text()
					maxHour = Number(tmpVal.substr(0, 2))
					
				}

				// console.log({a:minHour,b:maxHour})


				let interval = setInterval(() => {
					let options = $("select[name='from-time']");
					// console.log(options[0])
					// console.log(productme)

					if (options[0])
						if (true) {
							// console.log(options[0])
							clearInterval(interval);

							$("select[name='from-time']").remove();
							let txt =
								'<select id="" name="from-time" class="yith-wcbk-booking-date yith-wcbk-booking-start-date-time">';

							txt = txt + '<option value="">Select Time</option>';

							for (let i = minHour; i <= maxHour; i++) {
								let hh = i < 10 ? "0" + i + ":00" : i + ":00";
								txt =
									txt +
									`<option value="${hh}">${hh}</option>`;
							}

							txt = txt + "</select>";
							// $(".yith-wcbk-select-alt__container").append(txt)
							$(
								".yith-wcbk-form-section-dates-date-time > .yith-wcbk-form-section__content",
							).append(txt);
						}
				}, 500);
			}
		}

		if ($("select[name='from-time']")) {
			// console.log($("select[name='from-time']"))
			generateTime();

			$(".yith-wcbk-booking-start-date").on("change", () => {
				generateTime();
			});
		}

		let cookie = Cookies.get("__currency__cb");
		let currency_text = "$";
		if (typeof cookie !== "undefined") {
			switch (cookie) {
				case "USD":
					currency_text = "$";
					break;
				case "IDR":
					currency_text = "Rp";
					break;
				
			}
		}

		let cu = document.querySelector(
			"#change-currency > div > div > a > span > span",
		);
		// console.log(cu)
		if (cu) {
			cu.textContent = currency_text;
		}

		// console.log('asd', cu)

		// let c = setInterval(() => {
		// 	let bdi1 = document.querySelector(`#product-${productme.ID} bdi`)
		// 	let bdi2 = document.querySelector('#price-bottom span.woocommerce-Price-amount.amount')
		// 	// console.log({a:bdi1.outerText,b:bdi2.textContent})
		// 	if (bdi2.textContent !== bdi1.outerText) {

		// 		bdi2.textContent = bdi1.outerText

		// 	}
		// }, 500)

		if (typeof peopletwo === 'string') {
			// if (peopletwo === 'active')
			// $('input.yith-wcbk-booking-persons').attr('step', '2')
		}
		
		//accordion deskripsi
		// $('[data-id="e176e3e"]').addClass('flex flex-row justify-between').append('<i aria-hidden="true" class="fa-toggle fas fa-plus btn-deskripsi mr-3"></i>')

		// if ($('[data-id="30905ce"]').css('display') !== 'none') {
		// 	if ($('.btn-deskripsi').hasClass('fa-plus')) {
		// 		$('.btn-deskripsi').removeClass('fa-plus').addClass('fa-minus')	
		// 	} 
		// }

		// $('.btn-deskripsi').click(() => {
		// 	//content deskripsi
		// 	$('[data-id="30905ce"]').slideToggle("slow")
		// 	if ($('.btn-deskripsi').hasClass('fa-plus')) {
		// 		$('.btn-deskripsi').removeClass('fa-plus').addClass('fa-minus')	
		// 	} else {
		// 		$('.btn-deskripsi').removeClass('fa-minus').addClass('fa-plus')	
		// 	} 

			
		// })

		//accordion highlight
		// $('[data-id="a73a1ca"]').addClass('flex flex-row justify-between').append('<i aria-hidden="true" class="fa-toggle fas fa-plus btn-highligto mr-3"></i>')

		// if ($('[data-id="69b75b6"]').css('display') !== 'none') {
		// 	if ($('.btn-highligto').hasClass('fa-plus')) {
		// 		$('.btn-highligto').removeClass('fa-plus').addClass('fa-minus')	
		// 	} 
		// }

		// $('.btn-highligto').click(() => {
		// 	//content deskripsi
		// 	// $('[data-id="a424ae3"]').slideToggle("slow")
		// 	$('[data-id="69b75b6"]').slideToggle("slow")
		// 	if ($('.btn-highligto').hasClass('fa-plus')) {
		// 		$('.btn-highligto').removeClass('fa-plus').addClass('fa-minus')	
		// 	} else {
		// 		$('.btn-highligto').removeClass('fa-minus').addClass('fa-plus')	
		// 	} 
			
		// })
	

		// $('.swiper-slide[data-swiper-slide-index="5"]').remove()
		// console.log('delete 5')
		

		//accordion meetingpoin
		// $('.wrap-lt-sc').addClass('flex flex-row justify-between').append('<i aria-hidden="true" class="fa-toggle fas fa-plus btn-meetingpoint mr-3 " style="font-size:16px;"></i>')

		// if ($('.wrap-map-sc').css('display') !== 'none') {
		// 	if ($('.btn-meetingpoint').hasClass('fa-plus')) {
		// 		$('.btn-meetingpoint').removeClass('fa-plus').addClass('fa-minus')	
		// 	} 
		// }

		// $('.btn-meetingpoint').click(() => {
		// 	//wrap meetingpoin
		// 	$('.wrap-map-sc').slideToggle("slow")
		// 	if ($('.btn-meetingpoint').hasClass('fa-plus')) {
		// 		$('.btn-meetingpoint').removeClass('fa-plus').addClass('fa-minus')	
		// 	} else {
		// 		$('.btn-meetingpoint').removeClass('fa-minus').addClass('fa-plus')	
		// 	} 
		// })

		//detail product yith 
		// let intval1 = setInterval(()=>{
		// console.log('loop')
		// if ($('.woocommerce-Price-amount.amount').length>0) {
		// 	let price = $('.woocommerce-Price-amount.amount')[0].textContent
		// 	let person = $('[name="persons"]').val()

		//     $('#detail-people').html(person)

		//     $('#detail-price').html(price)			
		//    	$('#detail-total').html(price)			
		// 	console.log(price,person)
		// clearInterval(intval1)
		// }
	
		// },100)
		if ($('span.yith-wcbk-booking-duration__label').length)
			var duration = Number($('span.yith-wcbk-booking-duration__label')[0].textContent.replace(' days', ''))

		function renderDetailPrices() {

			if (document.querySelectorAll('.woocommerce-Price-amount.amount').length > 0) {

				// duration = $('.yith-wcbk-booking-real-duration').val()
				
				// let duration = pduration
				let idme = `yith-wcbk-booking-hidden-from${productme.ID}`

				if ($(`#${idme}`).val()) {
					let dt = new Date($(`#${idme}`).val())

					dt.setDate(dt.getDate() + duration)

					$('#to-date-cuber').val(dt.toLocaleDateString("en-US", { year: 'numeric', month: 'long', day: 'numeric' })).css('padding-left', '30px')	
				}
				

				let length = document.querySelectorAll('.product .woocommerce-Price-amount.amount').length
				let price = document.querySelectorAll('.product .woocommerce-Price-amount.amount')[length - 1].textContent
				
				// console.log(Array.from(document.querySelectorAll('.product .woocommerce-Price-amount.amount')).map((itm) => {
				// 	return {
				// 		value: itm.textContent
				// 	}
				// }))

				$('[name="persons"]').attr('style', 'padding-left:30px!important')
				let person = $('[name="persons"]').val()
				let cost_title = 'Additional charge people'
				let cost = extra_cost_people.product_price 
				let cost_currency = new Intl.NumberFormat('en-US', {
					style: 'currency', currency: 'USD'
				}).format(cost).replace('.00', '')

				$('#detail-people').html(person)
				let val_price = price.replace('$', '').replace(',', '')

				if ((person % extra_cost_people.min_persons) === 0) {
					$('#detail-price').html(new Intl.NumberFormat('en-US', {
						style: 'currency', currency: 'USD'
					}).format(val_price).replace('.00', ''))		
				} else {
					$('#detail-price').html(new Intl.NumberFormat('en-US', {
						style: 'currency', currency: 'USD'
					}).format(val_price - cost).replace('.00', ''))		
				}

				// if (person === 2) {
				$('#detail-price').html(new Intl.NumberFormat('en-US', {
					style: 'currency', currency: 'USD'
				}).format(val_price).replace('.00', ''))		
				// }
			

				$('#detail-total').html(price)
				// console.log(person, extra_cost_people.min_persons, person % extra_cost_people.min_persons)
				if ((person % extra_cost_people.min_persons) > 0) {
					if (person > extra_cost_people.min_persons) {
						$('#detail-cost').html(cost_title)	
						$('#detail-cost-price').html(cost_currency)								
					} else {
						$('#detail-cost').html('')								
						$('#detail-cost-price').html('')								
					}
				} else {
					$('#detail-cost').html('')								
					$('#detail-cost-price').html('')								
				}
				// console.log(price,person)
				// clearInterval(intval1)
			}
		}

		function renderIncludeTaxText() {
			if ($('.itaxfee').length <= 0)
				$('.yith_wcbk_booking_product_form_widget p.price').append('<div class="itaxfee">Includes taxes and fees</div>')	
		}

	
		// $(`#product-${productme.ID} p.price`).css('display', 'none')

		function renderDetailPrices2(){
			let a = $('.product p.price')
			if (a.length)
				{
					let price = $(a).text()
					let priceText = price.substr(0,price.length-8)
					$('#detail-price').html('')
					$('#detail-price').html(priceText)
					$('#detail-total').html('')	
					$('#detail-total').html(priceText)
				}
		}
		
		setInterval(() => {
			// renderDetailPrices()	
			renderDetailPrices2()
			renderIncludeTaxText()
		}, 300)
		

		$('#yith-wcbk-booking-persons').on('change', () => {
			// renderDetailPrices()
		})

		$('#yith-wcbk-booking-start-date-8566--formatted').click(() => {
			// renderDetailPrices()
		})

		//click swiper to product
		// let hrefswipers = $('[data-elementor-type="loop-item"] h2.product_title a')
		// let indexArr = 0
		// let loopitems = $('[data-elementor-type="loop-item"]')
		$('[data-elementor-type="loop-item"]').hover(() => {
			// $(this).css('cursor', 'pointer')
		})
		$('[data-elementor-type="loop-item"]').click((e) => {
			
			// location.href = $(e.target).find('.elementor-heading-title a').attr('href')
			// location.href = $(e.target).find('.elementor-icon-list-item a').attr('href')
			// console.log('--',$(e.target).find('.elementor-icon-list-item a'))
		})

		//if inclusions empty
		if (!inclusions[0]) $('#inc').toggle() 

		if (!inclusions[1]) $('#non-inc').toggle() 
		
		// .click(()=>{

		// }) 
		// 'h2.product_title a')
		function refreshprice() {
			var formData = new FormData()
			// 			product_id: 8566
			// duration: 1
			// from: 2024-04-06
			// from_date: 2024-04-06
			// persons: 8
			// request: get_booking_data
			// action: yith_wcbk_frontend_ajax_action
			// context: frontend
			// 			formData.append('action','yith_wcbk_frontend_ajax_action')
			// 			formData.append('product_id','')
			// 			formData.append('duration','')
			// 			formData.append('from','')
			// 			formData.append('from_date','')
			// 			formData.append('persons','')
			// 			formData.append('request','get_booking_data')
			// 			formData.append('context','')

			// 			$.ajax({
			// 				type: 'POST',
			// 				url: ajaxurl,
			// 				data: formData,
			// 				enctype: 'multipart/form-data',
			// 				success: function (data) {
			// 					console.log(data)
			// 				}
			// 			});
		}
		// $('form.cart input[name="persons"]').after(`<button id='plus-person'>+</button><button id='minus-person'>-</button>`)
		// $('#plus-person').click(function (e) {
		// 	e.preventDefault();
		// 	document.querySelector('form.cart input[name="persons"]').stepUp()
		// 	refreshprice()
		// });	
		// $('#minus-person').click(function (e) {
		// 	e.preventDefault();
		// 	document.querySelector('form.cart input[name="persons"]').stepDown()
		// 	refreshprice()
		// });	
		
	});

	// let val1 = setInterval(()=>{
	// 		if ($('.swiper-slide[data-swiper-slide-index="4"]').length) {
	// 			clearInterval(val1)
	// 			$('.swiper-slide[data-swiper-slide-index="4"]').remove()
	// 			$('.swiper-slide[data-swiper-slide-index="5"]').remove()
	// 			$('.swiper-slide[data-swiper-slide-index="6"]').remove()
	// 			console.log('.....')
	// 		}	
	// 	},50)


	// 

})(jQuery);

// const div_section = document.querySelector('#div_section');

// const observer = new MutationObserver((mutationsList, observer) => {
//     for(const mutation of mutationsList) {
//         // if (mutation.type === 'childList') {
//         //     console.log('A child node has been added or removed.');
//         //     const nodes = mutation.addedNodes;
//         //     nodes.forEach(node => {
//         //         node.addEventListener('mouseover', eventMouseOver);
//         //     });
//         // }

//     }
// });

// observer.observe(div_section, { 
//     attributes: true, 
//     childList: true, 
//     subtree: true }
// );


