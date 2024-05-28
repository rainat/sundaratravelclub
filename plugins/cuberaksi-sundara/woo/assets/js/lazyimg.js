(function ($) {
    $(document).ready(() => {
        //peroduct carousel
        $('[data-elementor-type="loop-item"]').hover(() => {
            $(this).css('cursor', 'pointer')
        })
        $('[data-elementor-type="loop-item"]').click((e) => {
            let href = $(e.target).find('.product_title a')
            
            if (href.length) location.href = href.attr('href')
            
           


        })

        $('[data-elementor-type="loop-item"] .featured-article-bottom').click((e) => {
            let href = $(e.target).find('a') 
            if (href.length) location.href = href.attr('href')
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
