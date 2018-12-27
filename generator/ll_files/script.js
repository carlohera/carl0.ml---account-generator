$(window).on("load", function() {
    "use strict";



    /*================== Delete Image =====================*/
    $('.delete').on("click",function(){
        $(this).parent().slideUp();
        return false;
    });

    /*================== Sidemenu Height =====================*/
    var full_height =  $(window).height();
    var escape_this = $('.dominence-sidemenu .logo').innerHeight() + $('.dominence-sidemenu .dominence-admin').innerHeight();   
    $(".navigation").css({
        'height': (full_height - escape_this),
        'min-height': (full_height - escape_this)
    });


    /*================== Widget Reloading =====================*/
    $(".refresh").on("click", function() {
        $(this).closest('.widget').addClass('loading').find('.loader').addClass('active').delay(3000).queue(function(next){
            $(this).closest('.widget').removeClass('loading').find('.loader').removeClass('active')
            next();
        });
        return false;
    });


    /*================== Full Width The Widget =====================*/
    $('.expend').on("click",function(){
        $(this).closest('.widget').toggleClass('expended');
        return false;
    });  


    /*=================== Accordion ===================*/
    $(".spark-toggles").each(function(){
        $(this).find('.content').hide();
        $(this).find('h2:first').addClass('active').next().slideDown(500).parent().addClass("activate");
        $('h2', this).click(function() {
            if ($(this).next().is(':hidden')) {
                $(this).parent().parent().find("h2").removeClass('active').next().slideUp(500).removeClass('animated fadeInUp').parent().removeClass("activate");
                $(this).toggleClass('active').next().slideDown(500).addClass('animated fadeInUp').parent().toggleClass("activate");
            }
        });
    });


    /*================== Remove Widget =====================*/
    $(".removethis").on("click",function(){
        $(this).closest('.widget').fadeOut();
        setTimeout(function(){
            $(".masonary").isotope('reloadItems').isotope({ sortBy: 'original-order' });
        },1000)
        return false;
    });


    /*================== Search Hide and Show =====================*/
    $(".header-search > a").on("click", function() {
        $(this).parent().find("form").fadeIn();
        return false;
    });
    $('html').on("click",function(){
        $('.header-search form').fadeOut();
    });
    $(".header-search").on("click",function(e){
        e.stopPropagation();
    });



    /*================== Full Screen On and Off =====================*/
    function toggleFullScreen() {
      if (!document.fullscreenElement &&    // alternative standard method
          !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) {  // current working methods
        if (document.documentElement.requestFullscreen) {
          document.documentElement.requestFullscreen();
        } else if (document.documentElement.msRequestFullscreen) {
          document.documentElement.msRequestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
          document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
          document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
      } else {
        if (document.exitFullscreen) {
          document.exitFullscreen();
        } else if (document.msExitFullscreen) {
          document.msExitFullscreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
          document.webkitExitFullscreen();
        }
      }
    }
    $(".full-screen > a").on("click", function() {
        toggleFullScreen(document.body); 
        return false;
    });    



    /*================== Notifications Dropdown =====================*/
    $(".open-dropdown").on("click",function() {
        $(this).parent().find(".dropdown").toggleClass("active");
        return false;
    });
    $('html').on("click",function(){
        $('.dropdown').removeClass('active');
    });
    $(".open-dropdown,.dropdown").on("click",function(e){
        e.stopPropagation();
    });



    /*================== Sidemenu Button =====================*/
    $(".sidemenu-btn").on("click",function() {
        $(".dominence-sidemenu").toggleClass("out");
        $(".collapsed-menu").toggleClass("in");
        $(".dominence-layout").toggleClass("extend");
        setTimeout(function(){
            $(".masonary").isotope('reloadItems').isotope({ sortBy: 'original-order' });
        },1000)
        return false;
    });


     if ($(window).width() < 768) {
        $("html").on("click",function() {
            $(".dominence-sidemenu").removeClass("out");
            $(".collapsed-menu").addClass("in");
            $(".dominence-layout").addClass("extend");
            setTimeout(function(){
                $(".masonary").isotope('reloadItems').isotope({ sortBy: 'original-order' });
            },1000)
        });

        $(".sidemenu-btn,.dominence-sidemenu").on("click",function(e) {
            e.stopPropagation();
        });
    }



    /*================== Settings Panel =====================*/
    $(".settings-btn").on("click",function() {
        $(".settings-panel").toggleClass("active");
        $(".dominence-sidemenu nav").toggleClass("disabled");
        return false;
    });
    $('html').on("click",function(){
        $(".settings-panel").removeClass("active");
        $(".dominence-sidemenu nav").removeClass("disabled");
    });
    $(".settings-btn,.settings-panel").on("click",function(e){
        e.stopPropagation();
    });




    /*================== ON OF TOGGLES =====================*/
    $('.toggle').toggles({on:true});
    $('.toggle.off').toggles({off:true});



    /*================== Side Menu Dropdown =====================*/
    $("nav ul").parent().addClass("menu-item-has-children");
    $("nav li.menu-item-has-children > a").on("click", function() {
        $(this).parent().toggleClass("active").siblings().removeClass("active");
        $(this).next("ul").slideToggle();
        $(this).parent().siblings().find("ul").slideUp();
        return false;
    });


    /*================== Tooltip =====================*/
    $("body").tooltip({ selector: '[data-toggle=tooltip]' });


    /*================== Repeating Animation On Notifications =====================*/
    function delayAnimation () {
        animatedEl.className = 'animated';
        setTimeout(function () {
            animatedEl.className = 'animated'
            setTimeout(delayAnimation, 2400);
        }, 500)
    }


    /*================== Hide Alerts After 2 Seconds =====================*/
    setTimeout(function(){
        $(".alert").slideUp(1000);
    },3000);



    /*================== Get Current Location =====================*/
    $.get("http://ipinfo.io", function (response) {
        $("#address").html("Location: " + response.city + ", " + response.region + ", " + response.country);
    }, "jsonp");


    /*================== To Do List =====================*/
    function toDo(){
        $('ol li .fa-check').on('click',function(){
            $(this).parent().parent().toggleClass('done');
        });
        $('ol li .fa-remove').on('click',function(){
            $(this).parent().parent().slideUp();
            setTimeout(function(){
                $(".masonary").isotope('reloadItems').isotope({ sortBy: 'original-order' });
            },500)
        });
    };

    toDo();

    $('.todo-list form').on("submit", function(e){
        e.preventDefault();
    });
    $('.todo-list form a').on('click',function(){
        var list_new = $('.todo-list form input').val();
        if(list_new !== ''){
            $('.todo-list ol').append("<li>" + list_new + '<span><i class=' + '"fa fa-check color5"' + '></i> <i class=' + '"fa fa-remove color6"' + '></i></span></li>');
            setTimeout(function(){
                $(".masonary").isotope('reloadItems').isotope({ sortBy: 'original-order' });
            },500)
        }
        else{
            alert('Please type something to add.')
        }
        toDo();
        return false;
    });

    /*================== Pageloader =====================*/
    $(".pageloader").fadeOut();

});