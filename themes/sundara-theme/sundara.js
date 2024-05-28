(function($){
    $(document).ready(()=>{
    	document.addEventListener("DOMContentLoaded", function() {
            var mapIframe = document.querySelector("#map iframe");
            if (mapIframe) {
                var src = new URL(mapIframe.src);
                src.searchParams.set("zoom", "18");
                mapIframe.src = src.toString();
            }
        });

        //Url Back to history
        $('.back-history a').click((event)=> {
            event.preventDefault();
            if (history.state.position > 0) history.back();
            else location.href = location.origin
        });
    
        /*Mobile stick footer Product detail*/
        const $section = $('.product-hero-banner'),
            $secTarget = $('.yith-wcbk-mobile-fixed-form'),
            sectionOffset = $section.offset().top;
        $(window).on('scroll', ()=> {
            const scrollPosition = $(this).scrollTop();
            if (scrollPosition <= 100) {
                $secTarget.removeClass('active');
            } else {
                $secTarget.addClass('active');
            }
        });

        // $('#sharelink').on('click', function() {
        //     var text = window.location; 
        //     var $temp = $('<textarea>');
        //     $('body').append($temp);
        //     $temp.val(text).select();
        //     document.execCommand('copy');
        //     $temp.remove();
        //     // Update the button text to "Copied!"
        //     $(this).text('Copied!');
        //     // Add the "clicked" class to the button
        //     $(this).addClass('clicked');
        // });
    });
})(jQuery)
//test