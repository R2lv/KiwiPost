require("./bootstrap");
const GMap = require("./vue-plugins/GMap");
let TranslatePlugin = require("./vue-plugins/Translation");

$.fn.ladda = function(k,v) {
    $(this).each(function (i, el) {
        if(!$(el).data("ladda"))
            $(el).data("ladda", Ladda.create(el));

        if(k)
            $(el).data("ladda")[k](v);
    });
};

Vue.component("addresses", require("./components/Addresses.vue"));
Vue.component("parcels", require("./components/Parcels.vue"));
Vue.component("notifications", require("./components/Notifications.vue"));
Vue.component("calculator", require("./components/Calculator.vue"));
Vue.component("faq", require("./components/Faq.vue"));
Vue.component("contact-map", require("./components/ContactMap.vue"));
Vue.component("pricing", require("./components/Pricing.vue"));
Vue.component("shops", require("./components/Shops.vue"));
Vue.component("spinner", require("../../admin-assets/vue/components/Spinner.vue"));

// axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

Vue.use(GMap, {
    'key': 'AIzaSyDp6yWIQ0Z2MoH5fh210l0Qqm3gZ3LW3I4'
});

Vue.use(TranslatePlugin, {
    'ka': require('./locales/ka.json'),
    'en': require('./locales/en.json')
});

$(function() {

    // window.initGModal();

    window.alert = function(content, title, success, cb) {
        _cls = [];
        if(success) _cls.push('success');
        let p = new popup({
            title: title,
            content: `
                <div>${content}</div>
                <div class="popup-footer">
                    <div class="btn-group"> 
                        <button class="btn ok-btn">Ok</button>
                    </div>
                </div>
            `,
            className: ['popup', 'alert', 'noclose'].concat(_cls),
            animation: 'slideDown'
        });
        $(p.root).find(".ok-btn").click(() => {p.exit(); cb&&cb();});
        p.show();
        $(window).trigger("resize");
    };

    Vue.setLanguage($.cookie("lang") || 'ka');
    let app = new (Vue.extend(require("./components/App.vue")))({
        el: "#app"
    });


    $(".scrollspy").each(function(i, el) {
        $(el).click(function(e) {
            e.preventDefault();
            const target = $($(this).data("target"));

            if(target.length) {
                $("html,body").animate({
                    scrollTop: target.position().top - 20
                },'fast');
            }
        });
    });

    $(".slickSlider").slick({
        slidesToShow: 1,
        initialSlide: 1,
        centerMode: true,
        touchMove: false,
        variableWidth: true,
        infinite: false,
    });

    $(".mapSlider").slick({
        slidesToShow: 1,
        initialSlide: 0,
        touchMove: false,
        variableWidth: false,
        infinite: false
    });


    let videoContainer = $("section#video");
    if(videoContainer.length) {
        videoContainer.find(".play-block").click(function () {
            videoContainer.addClass('fullscreen');
            videoContainer.find("video").prop("controls", true);
            videoContainer.find("video").prop("loop", false);
            videoContainer.find("video").prop("muted", false);
            videoContainer.find("video").get(0).currentTime = 0;
        });

        videoContainer.find(".close").click(function () {
            videoContainer.removeClass("fullscreen");
            videoContainer.find("video").prop("controls", false);
            videoContainer.find("video").prop("loop", true);
            videoContainer.find("video").prop("muted", true);
        });
        let video = videoContainer.find("video");
        let videoWrapper = videoContainer.find(".video");

        let ratio = video.width() / video.height();

        $(window).resize(function(e) {
            if(videoWrapper.width()/videoWrapper.height() >= ratio) {
            // if(video.height()>=videoWrapper.height()) {
                video.css({
                    height: "auto",
                    width: '100%'
                });
            } else {
                video.css({
                    height: "100%",
                    width: 'auto'
                });
            }

            if(video.width() > videoWrapper.width()) {
                video.css({
                    left: -(video.width()-videoWrapper.width())/2
                });
            } else {
                video.css({left:'0'});
            }
            if(video.height() > videoWrapper.height()) {
                video.css({
                    top: -(video.height()-videoWrapper.height())/2
                });
            } else {
                video.css({top:'auto'});
            }
        });
    }


    $(window).trigger("resize");

    window.showPopup = function(title, content, autoShow, _class) {
        content = "<span class='close-btn'>&nbsp;</span>" + content;
        if(!_class) _class = [];
        if(title) {
            _class.push('with-title');
        }
        const p = new popup({
            title: title,
            content: content,
            exitOnBackdropClick: true,
            animation: 'slideDown',
            className: ["popup", "noclose", 'geo', 'lower'].concat(_class)
        });

        $(p.root).find(".close-btn").click(function() {
            p.exit();
        });

        autoShow&&p.show();


        return p;
    };

    $(".dropdown:not(.hover):not(.autoclose)").dropdown();
    $(".dropdown.autoclose:not(.hover)").dropdown({
        autoclose: true
    });

    $(".hamburger").hamburger({
        nav: $("#navbar-drawer")
    });

    $("#footer").parallax({
        "imageSrc": "/images/footer-bg.png",
        "speed": 0.5,
        "mirrorContainer": $("#footer")
    });

    $("#search").parallax({
        "imageSrc": "/images/search-bg.jpg",
        "mirrorContainer": $("#search"),
        "positionY": "-50px",
        "overScrollFix": true
    });


    $(".c-page-container > section#page-title").parallax({
        "imageSrc": "/images/c-title-background.png",
        "mirrorContainer": $(".c-page-container > section#page-title"),
        "positionY": "-390px",
        "overScrollFix": true
    });

    $(".c-page-container > section#page-title").parallax({
        "imageSrc": "/images/c-title-background.png",
        "mirrorContainer": $(".c-page-container > section#page-title"),
        "positionY": "-390px",
        "overScrollFix": true
    });

    $("section#page-title.price-title").parallax({
        "imageSrc": "/images/parcels-globe.jpg",
        "mirrorContainer": $("section#page-title.price-title"),
        "positionY": "-390px",
        "overScrollFix": true
    });
    $("section#page-title.faq-title").parallax({
        "imageSrc": "/images/FAQ-bg.jpg",
        "mirrorContainer": $("section#page-title.faq-title"),
        "positionY": "-390px",
        "overScrollFix": true
    });

    $("section#page-title.about-title").parallax({
        "imageSrc": "/images/about-us-title.png",
        "mirrorContainer": $("section#page-title.about-title"),
        "positionY": "-380px",
        "overScrollFix": true
    });
    $("section#page-title.news-lists-bg-title").parallax({
        "imageSrc": "/images/news-form.png",
        "mirrorContainer": $("section#page-title.news-lists-bg-title"),
        "positionY": "-350px",
        "overScrollFix": true
    });



    if(window.data) {
        if(data.alert) {
            alert(data.alert, data.title||"Kiwi post", data.success);

        }


        if($('#alertBosMessage').html().trim() === ''){
            console.log('test');
        }else{
            alert("<p class='upper'>" + $('#alertBosMessage').html().trim() + "</p>");
        }
    }




});