(function ($) {
	$(document).ready(() => {
		$('img.lazy').each((idx, el) => {
			// console.log(idx,el)
			$(el).attr('src', $(el).attr('data-src'))
			// console.log({ el: $(el), src: $(el).attr('src'), datasrc: $(el).attr('data-src') })
 				

		})
		if (timelineObj)
			if (!timelineObj.timeline_off) {
				$('#timeline-product').hide()
				$('#timeline-product-line').hide()
			}


		let times = $('.yith-wcbk-booking-form__label')
		if (times) {
			let founded = times.filter((idx, val) => {
				// console.log({val,idx})
				return val.outerText === 'Time'
			})

			// console.log({founded})

			if (founded.length) {
				// console.log({ time: 'there' })
				$(".yith-wcbk-form-section.yith-wcbk-form-section-duration.yith-wcbk-form-section-duration--type-customer").css({ 'display': 'none' })

				$(".yith-wcbk-booking-form").css({ 'margin-bottom': '20px' })
			}	
		}
		

		if ($(".button.wc-forward").text() === 'View basket') {
			$(".button.wc-forward").css('display', 'none')	
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

		// 	// console.log(booking_times)

		function generateTime() {
			let minHour = 0
			let maxHour = 23
			if (productme.cat.includes("Bangkok Helicopter")) {
				minHour = 6
				maxHour = 18
			}

			if (productme.cat.includes("Car Rent")) {
				minHour = 9
				maxHour = 17
			}
		
			if (productme.cat.includes("Bali")) {
				minHour = 8
				maxHour = 23
			}
			
			if (productme.cat.includes("Labuhan Bajo")) {
				minHour = 15
				maxHour = 23
			}

			let interval = setInterval(() => {
				let options = $("select[name='from-time']")
				if (options[0])
					if (options[0].length > 1) {
						clearInterval(interval)
					
						$("select[name='from-time']").remove()	
						let txt = '<select id="" name="from-time" class="yith-wcbk-booking-date yith-wcbk-booking-start-date-time">' 
				
						txt = txt + '<option value="">Select Time</option>'

						for (let i = minHour; i <= maxHour; i++) {
							let hh = i < 10 ? '0' + i + ":00" : i + ":00"
							txt = txt + `<option value="${hh}">${hh}</option>`	
						}
				
						txt = txt + '</select>'
						$(".yith-wcbk-select-alt__container").append(txt)	
					
					}	
			}, 500)
			
		}

		if ($("select[name='from-time']")) {

			generateTime();

			$('.yith-wcbk-booking-start-date').on('change', () => {
				generateTime()
			})
		}		

		
		
			let c = setInterval(() => {
				let bdi1 = document.querySelector(`#product-${productme.ID} bdi`)
				let bdi2 = document.querySelector('#price-bottom span.woocommerce-Price-amount.amount')
				// console.log({a:bdi1.outerText,b:bdi2.textContent})
				if (bdi2.textContent !== bdi1.outerText) {

					bdi2.textContent = bdi1.outerText
					
				}
			}, 500)
		
		
		

		
		

		
	}) 		
  		
  		
        

})(jQuery);




