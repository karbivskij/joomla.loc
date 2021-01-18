$('.calendar__master').slick({
    infinite: true,
    slidesToShow: 5,
    slidesToScroll: 1,
    dots: false,
    arrows: true,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 5,
                slidesToScroll: 1,
            }
        },
        {
            breakpoint: 820,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }

    ]
});
$('.slider__home').slick({
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true
});
$('.news-slider').slick({
    infinite: true,
    slidesToShow: 2,
    slidesToScroll: 2,
    arrows: true,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
            }
        },
        {
            breakpoint: 820,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }

    ]
});

$('.masters__big-img').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    fade: true,
    infinite: true,
    mobileFirst: true,
    prevArrow: $(".my-slick-prev"),
    nextArrow: $(".my-slick-next"),
    asNavFor: '.masters__small-img'
});
$('.masters__small-img').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    asNavFor: '.masters__big-img',
    dots: false,
    arrows: false,
    centerMode: true,
    focusOnSelect: true

});

$(".btns-m > .btn-select").click(function(){
    $(".btns-m > .btn-select").removeClass("active");
    $(this).addClass("active");
});



$('.toggle-menu').click(function(){
    $('.header__menu').stop().slideToggle( "slow" );
});
$('.mob_x').click(function () {
    $('.header__menu').stop().slideToggle( "slow" );

})
$(window).resize(function() {
    if (window.innerWidth < 820) {
        $('.toggle-menu').css('display', 'block');
        $('.header__menu').css('display', 'none');

    } else {
        $('.toggle-menu').css('display', 'none');
        $('.header__menu').css('display', 'block');
    }

});
if (window.innerWidth < 820) {
    $('.toggle-menu').css('display', 'block');
    $('.header__menu').css('display', 'none');

} else {
    $('.toggle-menu').css('display', 'none');
    $('.header__menu').css('display', 'block');
}



$(".clearable").each(function() {

    var $inp = $(this).find("input:text"),
        $cle = $(this).find(".clearable__clear");

    $inp.on("input", function(){
        $cle.toggle(!!this.value);
    });

    $cle.on("touchstart click", function(e) {
        e.preventDefault();
        $inp.val("").trigger("input");
    });

});

var accItem = document.getElementsByClassName('accordionItem');
var accHD = document.getElementsByClassName('accordionItemHeading');
for (i = 0; i < accHD.length; i++) {
    accHD[i].addEventListener('click', toggleItem, false);
}
function toggleItem() {
    var itemClass = this.parentNode.className;
    for (i = 0; i < accItem.length; i++) {
        accItem[i].className = 'accordionItem close';
    }
    if (itemClass == 'accordionItem close') {
        this.parentNode.className = 'accordionItem open';
    }
}