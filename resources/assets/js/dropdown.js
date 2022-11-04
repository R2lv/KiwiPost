
$.fn.dropdown = function(options) {
    $(this).each(function(i,el) {

        if(!$(el).find(".dropdown-handle").attr("tabindex")) {
            $(el).find(".dropdown-handle").attr("tabindex", '0');
        }

        if(!$(el).find(".dropdown-list-item").attr("tabindex")) {
            $(el).find(".dropdown-list-item").attr("tabindex", '0');
        }

        $(el).find(".dropdown-list-item").keypress(function(e) {
            if(e.keyCode) {
                if(e.keyCode === 13 || e.keyCode === 32) {
                    $(this).click();
                }
            }
        });

        $(el).find(".dropdown-list-item").keydown(function(e) {
            if(e.keyCode) {
                if(e.keyCode === 38) {
                    e.preventDefault();
                    $(this).prev().length&&$(this).prev().focus();
                }
                if(e.keyCode === 40) {
                    e.preventDefault();
                    $(this).next().length&&$(this).next().focus();
                }
                if(e.keyCode === 9) {
                    e.preventDefault();
                    $(el).find(".dropdown-handle").focus();
                    close();
                }
            }
        });

        if(!$(el).data("dropdown")) {
            $(el).find(".dropdown-handle").on("click keypress", ev);
            $(el).find(".dropdown-handle").keydown(function(e) {
                if($(this).parent().find(".dropdown-list-item")) {
                    if(e.keyCode === 38) {
                        ev(e, true);
                        $(this).parent().find(".dropdown-list-item:last").focus();
                    }
                    if(e.keyCode === 40) {
                        ev(e, true);
                        $(this).parent().find(".dropdown-list-item:first").focus();
                    }
                }
            });
            $(el).data("dropdown", true);
        }

        function ev(e, force = false) {
            e.preventDefault();
            if($(el).prop("disabled")) return;

            if(e.keyCode && (e.keyCode !== 13 && e.keyCode !== 32 && e.keyCode !== 38 && e.keyCode !== 40)) {
                return;
            }

            if(force) {
                $(el).addClass("open");
                $(el).trigger("dropdown:open");
                return;
            }
            $(el).toggleClass("open");
            $(el).trigger("dropdown:"+($(el).hasClass("open")?"open":"close"));
        }

        $("html,body").click(function() {
            close();
        });

        $(el).click(function(e) {
            $(".dropdown").not(el).removeClass("open");
            e.stopPropagation();
        });

        function close() {
            if($(el).hasClass("open")) {
                $(el).removeClass("open");
                $(el).trigger("dropdown:close");
            }
        }

        if(options) {
            if(options.autoclose) {
                $(el).find(".dropdown-content").click(function() {
                    close();
                });
            }
        }
    });
};
