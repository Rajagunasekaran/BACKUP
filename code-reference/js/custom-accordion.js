jQuery(".project-title").click(function() {
        var $content = $(this).next(".project-information"),//contentarea to toggle
            $container = $(this).parent(".project-overview");//parent wraper

        $('.project-overview').each(function(i, elem) {
            if (!$(elem).is($container)) {
                $(elem).find(".project-information").slideUp('slow');
                $(elem).removeClass("is-opened");
            }
        });

        if ($container.hasClass("is-opened")) {
            $content.slideUp('slow');
            $container.removeClass("is-opened");
        } else {
            $content.slideDown('slow');
            $container.addClass("is-opened");
        }
    });
