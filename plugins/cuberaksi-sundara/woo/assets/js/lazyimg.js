(function ($) {
    $(document).ready(() => {
        //peroduct carousel
        $('[data-elementor-type="loop-item"]').hover(() => {
            // $(this).css('cursor', 'pointer')
        })
        $('[data-elementor-type="loop-item"]').click((e) => {
            // let href = $(e.target).find('.product_title a')

            // if (href.length) location.href = href.attr('href')




        })

      
        setInterval(() => { $('div#ui-datepicker-div').remove() }, 200)

      

       

        // price per person 
        console.log('..>>>') 
        setInterval(() => {
            if ($('.yith-wcbk-mobile-fixed-form .price').length)
                {
                    if ($('.yith-wcbk-mobile-fixed-form .price').text().includes('/person')) {
                        console.log('yes'); 
                    } else {
                        console.log('no')
                        let price_1 = $('.yith-wcbk-mobile-fixed-form .price').text()
                        $('.yith-wcbk-mobile-fixed-form .price')
                            .text(price_1)
                            .append($('<span> /person</span>').css({'font-weight':'400', 'font-size':'17px'}))
                    }
                    
                }   
                
        }, 200);
        


        

        $('[data-elementor-type="loop-item"]').click((e) => {

            // location.href = $(e.target).find('.elementor-heading-title a').attr('href')
            location.href = $(e.target).find('.elementor-icon-list-item a').attr('href')
            // console.log('--title',$(e.target).find('.elementor-heading-title a').attr('href'))
            // console.log('--icon',$(e.target).find('.elementor-icon-list-item a').attr('href'))
        })


        $('[data-elementor-type="loop-item"] .featured-article-bottom').click((e) => {
            // let href = $(e.target).find('a') 
            // if (href.length) location.href = href.attr('href')
        })
        // console.log(href)





        $("img.lazy").each((idx, el) => {
            // console.log(idx,el)
            $(el).attr("src", $(el).attr("data-src"));
            // console.log({ el: $(el), src: $(el).attr('src'), datasrc: $(el).attr('data-src') })
        });

        //tooltip
        let tipData = []
        $('[productid]').each((idx, el) => {
            tipData.push(JSON.parse($(el).attr('tip')).msg)
        })
        // console.log('---',tipData)
        $('.loop-item-title-wrap .elementor-widget-container').each((idx, el) => {
            if (tipData[idx] != "") {
                let a = el.innerHTML
                el.innerHTML = a + ' ' + `<span class="btn-tooltip"><img id="btn-tooltip-${idx}" style="width:18px" src="https://sundaratravelclub.com/wp-content/plugins/cuberaksi-xendit/woo/assets/images/info.svg"/></span>`
                tippy(`#btn-tooltip-${idx}`, {
                    content: tipData[idx] != "" ? tipData[idx] : ' ',
                    animation: 'fade',
                    theme: 'light',
                });
            }

        })

        // $('.elementor-9683').css('display','none')

    })

})(jQuery)
