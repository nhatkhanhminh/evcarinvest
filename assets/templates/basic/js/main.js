! function (s) {
    (s(document).ready((function () {
        s(".preloader-area").delay(500).animate({
            "opacity": "0"
          }, 500, function () {
              s(".preloader-area").css("display", "none");
          }), s(".nic-select").niceSelect(), s(".bg_img").css("background-image", (function () {
            return "url(" + s(this).data("background") + ")"
        }))
    })), s(window).on("load", (function () {})), s(".wow").length) && new WOW({
        boxClass: "wow",
        animateClass: "animated",
        offset: 0,
        mobile: !1,
        live: !0
    }).init();
    var e = s(".header-section");
    s(window).on("scroll", (function () {
        s(window).scrollTop() > 500 ? e.addClass("animated fadeInDown header-fixed") : e.removeClass("animated fadeInDown header-fixed")
    })), s(".navbar li a").on("click", (function () {
        var e = s(this).parent("li");
        e.hasClass("show") ? (e.removeClass("show"), e.find("li").removeClass("show")) : (e.addClass("show"), e.siblings("li").removeClass("show"), e.siblings("li").find("li").removeClass("show"))
    })), s(".dash-user-area li a").on("click", (function () {
        var e = s(this).parent("li");
        e.hasClass("show") ? (e.removeClass("show"), e.find("li").removeClass("show")) : (e.addClass("show"), e.siblings("li").removeClass("show"), e.siblings("li").find("li").removeClass("show"))
    }));
    var i = s(".scrollToTop");
    s(window).on("scroll", (function () {
        s(this).scrollTop() < 500 ? i.removeClass("active") : i.addClass("active")
    })), s(".faq-wrapper .faq-title").on("click", (function (e) {
        var i = s(this).parent(".faq-item");
        i.hasClass("open") ? (i.removeClass("open"), i.find(".faq-content").removeClass("open"), i.find(".faq-content").slideUp(300, "swing")) : (i.addClass("open"), i.children(".faq-content").slideDown(300, "swing"), i.siblings(".faq-item").children(".faq-content").slideUp(300, "swing"), i.siblings(".faq-item").removeClass("open"), i.siblings(".faq-item").find(".faq-title").removeClass("open"), i.siblings(".taq-item").find(".faq-content").slideUp(300, "swing"))
    }))
}(jQuery);