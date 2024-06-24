(function ($) {
    // var completeLoaded = 0
    $(document).ready(() => {
        // $('.preloader-content').append('<div class="cube-loader cube-loader-color"></div><p class="cube-loader-percentage"></p>')
        // var loaderInterval = setInterval(() => {
        //     completeLoaded = completeLoaded + 5
        //     $('.cube-loader-percentage').text(completeLoaded + ' %')
        //     if (completeLoaded >= 100) {
        //         clearInterval(loaderInterval)
        //         completeLoaded = 0
        //     }
        // }, 100)
        //peroduct carousel
        $('[data-elementor-type="loop-item"]').hover(() => {
            // $(this).css('cursor', 'pointer')
        });
        $('[data-elementor-type="loop-item"]').click((e) => {
            // let href = $(e.target).find('.product_title a')
            // if (href.length) location.href = href.attr('href')
        });

        //tab custom
        $('[data-widget-number="213"] button').click((e) => {

            if ($(e.currentTarget).attr("data-tab-index") >= "4") {
                // console.log('yes')
                setTimeout(() => {
                    $(
                        '[data-widget-number="213"] .e-n-tabs-heading',
                    ).scrollLeft(100);
                    // clearInterval(interval)
                }, 400);
            }
        });

        var TabWidthButtons = {
            totalWidth: 0,
            elementsWidth: []
        };
        $('[data-widget-number="118"] button').each((idx, el) => {
            TabWidthButtons.totalWidth = TabWidthButtons.totalWidth + $(el).width()
            TabWidthButtons.elementsWidth[idx] = TabWidthButtons.totalWidth + 20 * (idx + 1)
        })



        $('[data-widget-number="118"] button').click((e) => {
            console.log(TabWidthButtons)
            if ($(e.currentTarget).attr("data-tab-index") >= "3") {
                // let wTarget = e.currentTarget.offsetWidth

                setTimeout(() => {
                    let wHeading = $(
                        '[data-widget-number="118"] .e-n-tabs-heading'
                    ).width()
                    $(
                        '[data-widget-number="118"] .e-n-tabs-heading',
                    ).scrollLeft(TabWidthButtons.elementsWidth[Number($(e.currentTarget).attr("data-tab-index")) - 2]);

                }, 400);
            }
        });

        $("input#yith-wcbk-booking-persons").on("keydown", (e) => {
            e.preventDefault();
        });
        setInterval(() => {
            $("div#ui-datepicker-div").remove();
        }, 200);

        // price per person
        console.log("..>>>");
        setInterval(() => {
            if ($(".yith-wcbk-mobile-fixed-form .price").length) {
                if (
                    $(".yith-wcbk-mobile-fixed-form .price")
                        .text()
                        .includes("/ person")
                ) {
                    // console.log('yes');
                    if ($("#yith-wcbk-booking-persons").val() > 1) {
                        let prc = $(".yith-wcbk-mobile-fixed-form .price")
                            .text()
                            .replace("/ person", "");

                        $(".yith-wcbk-mobile-fixed-form .price").text(prc);
                    }
                } else {
                    // console.log('no')
                    let price_1 = $(
                        ".yith-wcbk-mobile-fixed-form .price",
                    ).text();
                    if ($("#yith-wcbk-booking-persons").val() <= 1)
                        $(".yith-wcbk-mobile-fixed-form .price")
                            .text(price_1)
                            .append(
                                $("<span> / person</span>").css({
                                    "font-weight": "400",
                                    "font-size": "17px",
                                }),
                            );
                }
            }
        }, 200);

        //slots customize
        var elementSoldOut = $("#single-slots-box .elementor-icon-box-title");
        var elementSoldOutItems = $(".slots-box");

        if ($(elementSoldOut).text().includes("SOLD OUT")) {
            $(elementSoldOut).css("font-size", "16px");
            $("#single-slots-box").css("height", "60px");
            $("#single-slots-box .elementor-widget-container").css({
                display: "flex",
                "align-items": "center",
            });
        }

        $(elementSoldOutItems).each((idx, el) => {
            let found = $(el).find(".elementor-icon-box-title");

            if ($(found).text().includes("SOLD OUT")) {
                $(found).css({
                    "font-size": "12px",
                    "line-height": "12px",
                });
                $(found)
                    .find("a")
                    .css({ "font-size": "12px", "line-height": "12px" });
                $(el).css("height", "60px");
                $(el).find(".elementor-widget-container").css({
                    display: "flex",
                    "align-items": "center",
                });
            }
        });

        $('[data-elementor-type="loop-item"]').click((e) => {
            // location.href = $(e.target).find('.elementor-heading-title a').attr('href')
            // console.log($(e.target).find('.elementor-icon-list-item a').attr('href'))
            // location.href = $(e.target).find('.elementor-icon-list-item a').attr('href')
            // console.log('--title',$(e.target).find('.elementor-heading-title a').attr('href'))
            // console.log('--icon',$(e.target).find('.elementor-icon-list-item a').attr('href'))
        });

        $('[data-elementor-type="loop-item"] .featured-article-bottom').click(
            (e) => {
                // let href = $(e.target).find('a')
                // if (href.length) location.href = href.attr('href')
            },
        );
        // console.log(href)

        $("img.lazy").each((idx, el) => {
            // console.log(idx,el)
            $(el).attr("src", $(el).attr("data-src"));
            // console.log({ el: $(el), src: $(el).attr('src'), datasrc: $(el).attr('data-src') })
        });

        //tooltip
        let tipData = [];
        $("[productid]").each((idx, el) => {
            tipData.push(JSON.parse($(el).attr("tip")).msg);
        });
        // console.log('---',tipData)
        $(".loop-item-title-wrap .elementor-widget-container").each(
            (idx, el) => {
                if (tipData[idx] != "") {
                    let a = el.innerHTML;
                    el.innerHTML =
                        a +
                        " " +
                        `<span class="btn-tooltip"><img id="btn-tooltip-${idx}" style="width:18px" src="https://sundaratravelclub.com/wp-content/plugins/cuberaksi-xendit/woo/assets/images/info.svg"/></span>`;
                    tippy(`#btn-tooltip-${idx}`, {
                        content: tipData[idx] != "" ? tipData[idx] : " ",
                        animation: "fade",
                        theme: "light",
                    });
                }
            },
        );

        // $('.elementor-9683').css('display','none')
    });
})(jQuery);
