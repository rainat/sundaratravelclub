jQuery(document).ready(($) => {
    // $('.timeline[data-gol="itenary"] .content').each((idx, el) => {
    //     el.querySelector('h3').style = 'display:none'



    // })
    const accordionBtns = document.querySelectorAll("button.accordion");

    accordionBtns.forEach((accordion, idx) => {
        // if (idx === 0) accordion.classList.toggle("is-open");
        accordion.onclick = function () {
            this.classList.toggle("is-open");

            let content = this.nextElementSibling;
            // console.log(content);

            if (content.style.maxHeight) {
                //this is if the accordion is open
                content.style.maxHeight = null;
                // content.style.paddingTop = '1rem'


            } else {
                //if the accordion is currently closed
                content.style.maxHeight = (content.scrollHeight + 20) + "px";
                // console.log(content.style.maxHeight);
            }
        };
    });

})