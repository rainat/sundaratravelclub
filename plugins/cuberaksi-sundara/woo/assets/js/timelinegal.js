(function ($) {
	$(document).ready(() => {
		$('div.elementor-element.elementor-element-a305e87.elementor-widget.elementor-widget-heading > div > h2').css('display','none')
		if (typeof galleries !== undefined) {
			// console.log({ galleries })

			function doPopupGallery(slideData) {
				if (elementorProFrontend.modules.popup) {
						
					elementorProFrontend.modules.popup.showPopup({ id: 7977 });
					const dataSlide = galleries[`day${slideData.day}`][slideData.gal]

					let flag = slideData.day - 1
					// let itenary = document.querySelectorAll('.elementor-testimonial__text')[flag].firstChild.textContent
					let itenary = galleries[`day${slideData.day}`][`${slideData.gal}`].title

					// console.log(itenary)

					let title = $('#title-itenary h2').text()
					$('#title-itenary h2').text(title.replace('{title_itenary}', itenary))

					function populateImages(index, mode) {
						let tmp = ''
						dataSlide.gallery.map((img) => {
							if (mode === 'full')
								// 			tmp = tmp + `<li class="splide__slide">
								//   <a data-fslightbox='gallery' href='${img.full}'><img
								//     src='${img.full}'
								//     alt=""
								//   /></a>
								// </li>`
								tmp = tmp + `<li class="splide__slide">
            <img
              src='${img.full}'
              alt=""
            />
          </li>`


							if (mode === 'thumbnail')
								tmp = tmp + `<li class="thumbnail">
         <img src="${img.thumbnail}" alt="" />
       </li> `

						})
						return tmp
					}

					// let content = `<div class="gal-slider">` + populateImages(slideNum, 'full') + `</div>
					// <div class="gal-slider-nav">` + populateImages(slideNum, 'thumbnail') + `</div>`

					let content = `<section id="main-slider" class="splide" aria-label="My Sundara Gallery">
      <div class="splide__track">
        <ul class="splide__list">` + populateImages(0, 'full') +
        
						`</ul>
      </div>
    </section>

    <ul id="thumbnails" class="thumbnails">` + populateImages(0, 'thumbnail') +
      
						`</ul>`

					$('#gallery-content').html(content)
				}	
			}
			
			function populate_itenary(index) {

				function populate_description(description) {
					return `<p class="ht-addinfo__text">${description}</p>`
					// return `<p class="ht-addinfo__text"></p>`
				}

				function populate_gallery_link(gallery, day, idx) {
					if (gallery) return `<a class='gallery-link ' data-slide='{"day":"${day}","gal":"${idx}"}'  href='javascript:void(0);'>View Imaged Gallery > </a>`
					return '';
				}
				console.log('index',index)
				if (galleries[`day${index}`]) {
					let results = '';
					galleries[`day${index}`].map((itm, idx) => {
						console.log({populate_itenary:1,idx,galleries,itm})
						img = itm.icon ? `<img src='${itm.icon}' width='20'>` : ' '
						results = results + `<div class="ht-addinfo">
    <div class="ht-addinfo__col ht-addinfo__img">${img}</div> <div class="ht-addinfo__col ht-addinfo__desc">
        <p class="ht-addinfo__title">${itm.title}</p>` + populate_description(itm.description) + populate_gallery_link(itm.gallery, index, idx) + '</div></div>'
					})
					return results
				}
				return '';
			}	
			// ``
			//timeline
			// console.log({galleries})
			const gal = $('.timeline[data-gol="itenary"] .container .content').each((index, el) => {
				console.log('.timeline[data-gol="itenary"] .container .content',index,el)
				// const children = $(el).append(populate_itenary(index+1))  
				if (galleries[`day${index + 1}`]) {
							 console.log('not summary',index)
							 $(el).append(populate_itenary(index + 1))  
				}	
					// $(el).html(children)
					// if ($(el).parent().parent().attr('data-gol') == 'itenary'){
						
						// $(el).append(populate_itenary(index + 1))  
					// }
				//
				
			})

			const galn = $('.elementor-testimonial__text').each((index, el) => {
				console.log('.elementor-testimonial__text',el)
				const children = $(el).html() + '<div style="padding-left:10px">' + populate_itenary(index + 1) + '</div>'
				if (galleries[`day${index + 1}`]) 
					$(el).html(children)
				//
				
			})

			$('.gallery-link').click((e) => {
				const slideData = JSON.parse($(e.target).attr('data-slide'))
				// console.log({ slideData })
				
				doPopupGallery(slideData)
				

				var splide = new Splide("#main-slider", {
					width: '100%',
					// height: 400,
					heightRatio: 0.5,
					pagination: true,
					cover: true
				});

				var thumbnails = document.getElementsByClassName("thumbnail");
				var current;

				for (var i = 0; i < thumbnails.length; i++) {
					initThumbnail(thumbnails[i], i);
				}

				function initThumbnail(thumbnail, index) {
					thumbnail.addEventListener("click", function () {
						splide.go(index);
					});
				}

				splide.on("mounted move", function () {
					var thumbnail = thumbnails[splide.index];

					if (thumbnail) {
						if (current) {
							current.classList.remove("is-active");
						}

						thumbnail.classList.add("is-active");
						current = thumbnail;
					}
				});

				splide.mount();

				
				// var lightbox = new FsLightbox();
				// lightbox.props.sources = galleries[`day${slideNum}`].images.map((img)=>{ return img.full_image_url })
				// lightbox.props.type = "image";
				// lightbox.open()

				// console.log(lightbox)
				// refreshFsLightbox();
			})



			//mobile day 1 ... day5...
			// if (window.innerWidth<768)
			// {
			// 	let labelBig = []
			// 	let els = document.querySelectorAll('.twae-label-big')
			//   Array.from(els).map((el,idx)=>{
			// 		labelBig = [...labelBig,el.textContent]
			// 		el.style.display = 'none'
			// 		document.querySelectorAll('.twae-title')[idx].innerHTML = `<div class='twae-label-big'>${el.textContent}</div>`
			// 		$('.twae-label-big').css('color','#c0b299')
			// 	})

			// 	console.log(labelBig)

		  	
			// }

			function doPopupGallerySummary(slideData,title) {
				if (elementorProFrontend.modules.popup) {
						
					elementorProFrontend.modules.popup.showPopup({ id: 7977 });
					const dataSlide = slideData

					// let flag = slideData.day - 1
					// // let itenary = document.querySelectorAll('.elementor-testimonial__text')[flag].firstChild.textContent
					// let itenary = galleries[`day${slideData.day}`][`${slideData.gal}`].title

					// console.log(itenary)

					// let title = $('#title-itenary h2').text()
					$('#title-itenary h2').text(title.replace('{title_itenary}', title))

					function populateImages(index, mode) {
						let tmp = ''
						dataSlide.map((img) => {
							if (mode === 'full')
								// 			tmp = tmp + `<li class="splide__slide">
								//   <a data-fslightbox='gallery' href='${img.full}'><img
								//     src='${img.full}'
								//     alt=""
								//   /></a>
								// </li>`
								tmp = tmp + `<li class="splide__slide">
            <img
              src='${img.url}'
              alt=""
            />
          </li>`


							if (mode === 'thumbnail')
								tmp = tmp + `<li class="thumbnail">
         <img src="${img.sizes.thumbnail}" alt="" />
       </li> `

						})
						return tmp
					}

					// let content = `<div class="gal-slider">` + populateImages(slideNum, 'full') + `</div>
					// <div class="gal-slider-nav">` + populateImages(slideNum, 'thumbnail') + `</div>`

					let content = `<section id="main-slider" class="splide" aria-label="My Sundara Gallery">
      <div class="splide__track">
        <ul class="splide__list">` + populateImages(0, 'full') +
        
						`</ul>
      </div>
    </section>

    <ul id="thumbnails" class="thumbnails">` + populateImages(0, 'thumbnail') +
      
						`</ul>`

					$('#gallery-content').html(content)
				}	
			}
		  
				$('.gallery-summary-link').click((e) => {
				const slideData = JSON.parse($(e.target).attr('data-slide'))
				// console.log({ slideData })
				
				doPopupGallerySummary(slideData,$(e.target).attr('title'))
				
				var splide = new Splide("#main-slider", {
					width: '100%',
					// height: 400,
					heightRatio: 0.5,
					pagination: true,
					cover: true
				});

				var thumbnails = document.getElementsByClassName("thumbnail");
				var current;

				for (var i = 0; i < thumbnails.length; i++) {
					initThumbnail(thumbnails[i], i);
				}

				function initThumbnail(thumbnail, index) {
					thumbnail.addEventListener("click", function () {
						splide.go(index);
					});
				}

				splide.on("mounted move", function () {
					var thumbnail = thumbnails[splide.index];

					if (thumbnail) {
						if (current) {
							current.classList.remove("is-active");
						}

						thumbnail.classList.add("is-active");
						current = thumbnail;
					}
				});

				splide.mount();

				
				
			})
		
			
				
		
			
		}
	})
})(jQuery)

