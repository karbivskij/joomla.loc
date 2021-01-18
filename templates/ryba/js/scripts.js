
jQuery(window).on('load', function(){
	fixed_header();

	jQuery('#addservice').on('hide.bs.modal', function (e) {
		jQuery('.modal-backdrop').remove();
	})

	

	jQuery('.calendar__master').slick({
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
	jQuery('.slider__home').slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true
	});
	jQuery('.news-slider').slick({
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
	jQuery('.masters__big-img').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true,
		fade: true,
		infinite: true,
		mobileFirst: true,
		prevArrow: jQuery(".my-slick-prev"),
		nextArrow: jQuery(".my-slick-next"),
		asNavFor: '.masters__small-img'
	});
	jQuery('.masters__small-img').slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		asNavFor: '.masters__big-img',
		dots: false,
		arrows: false,
		centerMode: true,
		focusOnSelect: true

	});


	jQuery(".btns-m > .btn-select").click(function(){
		jQuery(".btns-m > .btn-select").removeClass("active");
		jQuery(this).addClass("active");
	});
	jQuery('.toggle-menu').click(function(){
		jQuery('.header__menu').stop().slideToggle( "slow" );
	});
	jQuery('.mob_x').click(function () {
		jQuery('.header__menu').stop().slideToggle( "slow" );

	})
	if (window.innerWidth < 820) {
		jQuery('.toggle-menu').css('display', 'block');
		jQuery('.header__menu').css('display', 'none');

	} else {
		jQuery('.toggle-menu').css('display', 'none');
		jQuery('.header__menu').css('display', 'block');
	}
	jQuery(".clearable").each(function() {

		var jQueryinp = jQuery(this).find("input:text"),
			$cle = jQuery(this).find(".clearable__clear");

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
			accItem[i].className = 'accordionItem close_';
		}
		if (itemClass == 'accordionItem close_') {
			this.parentNode.className = 'accordionItem open_';
		}
	}
	
	
	


	jQuery('.cd-faq-trigger').on('click', function(event){
		event.preventDefault();
		jQuery(this).next('.cd-faq-content').slideToggle(200).end().parent('li').toggleClass('content-visible');
	});

	
	
	jQuery(window).on("scroll", function () {
		fixed_header();
	});


	let fields = document.querySelectorAll('.field__file');
    Array.prototype.forEach.call(fields, function (input) {
      let label = input.nextElementSibling,
        labelVal = label.querySelector('.field__file-fake').innerText;
 
      input.addEventListener('change', function (e) {
        let countFiles = '';
        if (this.files && this.files.length >= 1)
          countFiles = this.files.length;
        if (countFiles)
          label.querySelector('.field__file-fake').innerText = 'Выбрано файлов: ' + countFiles;
        else
          label.querySelector('.field__file-fake').innerText = labelVal;
      });
    });


	jQuery('div.thumbnail-item').mouseenter(function(e) {
		x = e.pageX - $(this).offset().left;
		y = e.pageY - $(this).offset().top;
		jQuery(this).css('z-index','15')
			.children("div.tooltip")
			.css({'top': y + 10,'left': x + 20,'display':'block'});
		}).mousemove(function(e) {			
			x = e.pageX - $(this).offset().left;
			y = e.pageY - $(this).offset().top;
			jQuery(this).children("div.tooltip").css({'top': y + 10,'left': x + 20});
		}).mouseleave(function() {
			jQuery(this).css('z-index','1')
			.children("div.tooltip")
			.animate({"opacity": "hide"}, "fast");
		});





	
});

jQuery(window).resize(function() {
	if (window.innerWidth < 820) {
		jQuery('.toggle-menu').css('display', 'block');
		jQuery('.header__menu').css('display', 'none');

	} else {
		jQuery('.toggle-menu').css('display', 'none');
		jQuery('.header__menu').css('display', 'block');
	}

});



function fixed_header(){
	let scrolled = jQuery(this).scrollTop();
	let h_top = jQuery('header').height();
	if( scrolled > h_top ) {
		jQuery('header').addClass('scrolled');
	}   
	if( scrolled <= h_top ) {     
		jQuery('header').removeClass('scrolled');
	}
}

function goPreloader($type){
	
};


/*!
 * datepair.js v0.4.16 - A javascript plugin for intelligently selecting date and time ranges inspired by Google Calendar.
 * Copyright (c) 2018 Jon Thornton - http://jonthornton.github.com/Datepair.js
 * License: MIT
 */

!function(a,b){"use strict";function c(a,b){var c=b||{};for(var d in a)d in c||(c[d]=a[d]);return c}function d(a,c){if(h)h(a).trigger(c);else{var d=b.createEvent("CustomEvent");d.initCustomEvent(c,!0,!0,{}),a.dispatchEvent(d)}}function e(a,b){return h?h(a).hasClass(b):a.classList.contains(b)}function f(a,b){this.dateDelta=null,this.timeDelta=null,this._defaults={startClass:"start",endClass:"end",timeClass:"time",dateClass:"date",defaultDateDelta:0,defaultTimeDelta:36e5,anchor:"start",parseTime:function(a){return h(a).timepicker("getTime")},updateTime:function(a,b){h(a).timepicker("setTime",b)},setMinTime:function(a,b){h(a).timepicker("option","minTime",b)},parseDate:function(a){return a.value&&h(a).datepicker("getDate")},updateDate:function(a,b){h(a).datepicker("update",b)}},this.container=a,this.settings=c(this._defaults,b),this.startDateInput=this.container.querySelector("."+this.settings.startClass+"."+this.settings.dateClass),this.endDateInput=this.container.querySelector("."+this.settings.endClass+"."+this.settings.dateClass),this.startTimeInput=this.container.querySelector("."+this.settings.startClass+"."+this.settings.timeClass),this.endTimeInput=this.container.querySelector("."+this.settings.endClass+"."+this.settings.timeClass),this.refresh(),this._bindChangeHandler()}var g=864e5,h=a.Zepto||a.jQuery;f.prototype={constructor:f,option:function(a,b){if("object"==typeof a)this.settings=c(this.settings,a);else if("string"==typeof a&&"undefined"!=typeof b)this.settings[a]=b;else if("string"==typeof a)return this.settings[a];this._updateEndMintime()},getTimeDiff:function(){var a=this.dateDelta+this.timeDelta;return!(a<0)||this.startDateInput&&this.endDateInput||(a+=g),a},refresh:function(){if(this.startDateInput&&this.startDateInput.value&&this.endDateInput&&this.endDateInput.value){var a=this.settings.parseDate(this.startDateInput),b=this.settings.parseDate(this.endDateInput);a&&b&&(this.dateDelta=b.getTime()-a.getTime())}if(this.startTimeInput&&this.startTimeInput.value&&this.endTimeInput&&this.endTimeInput.value){var c=this.settings.parseTime(this.startTimeInput),d=this.settings.parseTime(this.endTimeInput);c&&d&&(this.timeDelta=d.getTime()-c.getTime(),this._updateEndMintime())}},remove:function(){this._unbindChangeHandler()},_bindChangeHandler:function(){h?h(this.container).on("change.datepair",h.proxy(this.handleEvent,this)):this.container.addEventListener("change",this,!1)},_unbindChangeHandler:function(){h?h(this.container).off("change.datepair"):this.container.removeEventListener("change",this,!1)},handleEvent:function(a){this._unbindChangeHandler(),e(a.target,this.settings.dateClass)?""!=a.target.value?(this._dateChanged(a.target),this._timeChanged(a.target)):this.dateDelta=null:e(a.target,this.settings.timeClass)&&(""!=a.target.value?this._timeChanged(a.target):this.timeDelta=null),this._validateRanges(),this._updateEndMintime(),this._bindChangeHandler()},_dateChanged:function(a){if(this.startDateInput&&this.endDateInput){var b=this.settings.parseDate(this.startDateInput),c=this.settings.parseDate(this.endDateInput);if(b&&c)if("start"==this.settings.anchor&&e(a,this.settings.startClass)){var d=new Date(b.getTime()+this.dateDelta);this.settings.updateDate(this.endDateInput,d)}else if("end"==this.settings.anchor&&e(a,this.settings.endClass)){var d=new Date(c.getTime()-this.dateDelta);this.settings.updateDate(this.startDateInput,d)}else if(c<b){var f=e(a,this.settings.startClass)?this.endDateInput:this.startDateInput,h=this.settings.parseDate(a);this.dateDelta=0,this.settings.updateDate(f,h)}else this.dateDelta=c.getTime()-b.getTime();else if(null!==this.settings.defaultDateDelta){if(b){var i=new Date(b.getTime()+this.settings.defaultDateDelta*g);this.settings.updateDate(this.endDateInput,i)}else if(c){var j=new Date(c.getTime()-this.settings.defaultDateDelta*g);this.settings.updateDate(this.startDateInput,j)}this.dateDelta=this.settings.defaultDateDelta*g}else this.dateDelta=null}},_timeChanged:function(a){if(this.startTimeInput&&this.endTimeInput){var b=this.settings.parseTime(this.startTimeInput),c=this.settings.parseTime(this.endTimeInput);if(!b||!c)return void(null!==this.settings.defaultTimeDelta?(this.timeDelta=this.settings.defaultTimeDelta,b?(c=this._setTimeAndReturn(this.endTimeInput,new Date(b.getTime()+this.settings.defaultTimeDelta)),this._doMidnightRollover(b,c)):c&&(b=this._setTimeAndReturn(this.startTimeInput,new Date(c.getTime()-this.settings.defaultTimeDelta)),this._doMidnightRollover(b,c))):this.timeDelta=null);if("start"==this.settings.anchor&&e(a,this.settings.startClass))c=this._setTimeAndReturn(this.endTimeInput,new Date(b.getTime()+this.timeDelta)),this._doMidnightRollover(b,c);else if("end"==this.settings.anchor&&e(a,this.settings.endClass))b=this._setTimeAndReturn(this.startTimeInput,new Date(c.getTime()-this.timeDelta)),this._doMidnightRollover(b,c);else{this._doMidnightRollover(b,c);var d,f;if(this.startDateInput&&this.endDateInput&&(d=this.settings.parseDate(this.startDateInput),f=this.settings.parseDate(this.endDateInput)),+d==+f&&c<b){var g=e(a,this.settings.endClass)?this.endTimeInput:this.startTimeInput,h=e(a,this.settings.startClass)?this.endTimeInput:this.startTimeInput,i=this.settings.parseTime(g);this.timeDelta=0,this.settings.updateTime(h,i)}else this.timeDelta=c.getTime()-b.getTime()}}},_setTimeAndReturn:function(a,b){return this.settings.updateTime(a,b),this.settings.parseTime(a)},_doMidnightRollover:function(a,b){if(this.startDateInput&&this.endDateInput){var c=this.settings.parseDate(this.endDateInput),d=this.settings.parseDate(this.startDateInput),e=b.getTime()-a.getTime(),f=b<a?g:-1*g;null!==this.dateDelta&&this.dateDelta+this.timeDelta<=g&&this.dateDelta+e!=0&&(f>0||0!=this.dateDelta)&&(e>=0&&this.timeDelta<0||e<0&&this.timeDelta>=0)&&("start"==this.settings.anchor?(this.settings.updateDate(this.endDateInput,new Date(c.getTime()+f)),this._dateChanged(this.endDateInput)):"end"==this.settings.anchor&&(this.settings.updateDate(this.startDateInput,new Date(d.getTime()-f)),this._dateChanged(this.startDateInput))),this.timeDelta=e}},_updateEndMintime:function(){if("function"==typeof this.settings.setMinTime){var a=null;"start"==this.settings.anchor&&(!this.dateDelta||this.dateDelta<g||this.timeDelta&&this.dateDelta+this.timeDelta<g)&&(a=this.settings.parseTime(this.startTimeInput)),this.settings.setMinTime(this.endTimeInput,a)}},_validateRanges:function(){return this.startTimeInput&&this.endTimeInput&&null===this.timeDelta?void d(this.container,"rangeIncomplete"):this.startDateInput&&this.endDateInput&&null===this.dateDelta?void d(this.container,"rangeIncomplete"):void(!this.startDateInput||!this.endDateInput||this.dateDelta+this.timeDelta>=0?d(this.container,"rangeSelected"):d(this.container,"rangeError"))}},a.Datepair=f}(window,document),function(a){a&&(a.fn.datepair=function(b){var c;return this.each(function(){var d=a(this),e=d.data("datepair"),f="object"==typeof b&&b;e||(e=new Datepair(this,f),d.data("datepair",e)),"remove"===b&&(c=e.remove(),d.removeData("datepair",e)),"string"==typeof b&&(c=e[b]())}),c||this},a("[data-datepair]").each(function(){var b=a(this);b.datepair(b.data())}))}(window.Zepto||window.jQuery);


/*!
 * datepair.js v0.4.16 - A javascript plugin for intelligently selecting date and time ranges inspired by Google Calendar.
 * Copyright (c) 2018 Jon Thornton - http://jonthornton.github.com/Datepair.js
 * License: MIT
 */

!function(a,b){"use strict";function c(a,b){var c=b||{};for(var d in a)d in c||(c[d]=a[d]);return c}function d(a,c){if(h)h(a).trigger(c);else{var d=b.createEvent("CustomEvent");d.initCustomEvent(c,!0,!0,{}),a.dispatchEvent(d)}}function e(a,b){return h?h(a).hasClass(b):a.classList.contains(b)}function f(a,b){this.dateDelta=null,this.timeDelta=null,this._defaults={startClass:"start",endClass:"end",timeClass:"time",dateClass:"date",defaultDateDelta:0,defaultTimeDelta:36e5,anchor:"start",parseTime:function(a){return h(a).timepicker("getTime")},updateTime:function(a,b){h(a).timepicker("setTime",b)},setMinTime:function(a,b){h(a).timepicker("option","minTime",b)},parseDate:function(a){return a.value&&h(a).datepicker("getDate")},updateDate:function(a,b){h(a).datepicker("update",b)}},this.container=a,this.settings=c(this._defaults,b),this.startDateInput=this.container.querySelector("."+this.settings.startClass+"."+this.settings.dateClass),this.endDateInput=this.container.querySelector("."+this.settings.endClass+"."+this.settings.dateClass),this.startTimeInput=this.container.querySelector("."+this.settings.startClass+"."+this.settings.timeClass),this.endTimeInput=this.container.querySelector("."+this.settings.endClass+"."+this.settings.timeClass),this.refresh(),this._bindChangeHandler()}var g=864e5,h=a.Zepto||a.jQuery;f.prototype={constructor:f,option:function(a,b){if("object"==typeof a)this.settings=c(this.settings,a);else if("string"==typeof a&&"undefined"!=typeof b)this.settings[a]=b;else if("string"==typeof a)return this.settings[a];this._updateEndMintime()},getTimeDiff:function(){var a=this.dateDelta+this.timeDelta;return!(a<0)||this.startDateInput&&this.endDateInput||(a+=g),a},refresh:function(){if(this.startDateInput&&this.startDateInput.value&&this.endDateInput&&this.endDateInput.value){var a=this.settings.parseDate(this.startDateInput),b=this.settings.parseDate(this.endDateInput);a&&b&&(this.dateDelta=b.getTime()-a.getTime())}if(this.startTimeInput&&this.startTimeInput.value&&this.endTimeInput&&this.endTimeInput.value){var c=this.settings.parseTime(this.startTimeInput),d=this.settings.parseTime(this.endTimeInput);c&&d&&(this.timeDelta=d.getTime()-c.getTime(),this._updateEndMintime())}},remove:function(){this._unbindChangeHandler()},_bindChangeHandler:function(){h?h(this.container).on("change.datepair",h.proxy(this.handleEvent,this)):this.container.addEventListener("change",this,!1)},_unbindChangeHandler:function(){h?h(this.container).off("change.datepair"):this.container.removeEventListener("change",this,!1)},handleEvent:function(a){this._unbindChangeHandler(),e(a.target,this.settings.dateClass)?""!=a.target.value?(this._dateChanged(a.target),this._timeChanged(a.target)):this.dateDelta=null:e(a.target,this.settings.timeClass)&&(""!=a.target.value?this._timeChanged(a.target):this.timeDelta=null),this._validateRanges(),this._updateEndMintime(),this._bindChangeHandler()},_dateChanged:function(a){if(this.startDateInput&&this.endDateInput){var b=this.settings.parseDate(this.startDateInput),c=this.settings.parseDate(this.endDateInput);if(b&&c)if("start"==this.settings.anchor&&e(a,this.settings.startClass)){var d=new Date(b.getTime()+this.dateDelta);this.settings.updateDate(this.endDateInput,d)}else if("end"==this.settings.anchor&&e(a,this.settings.endClass)){var d=new Date(c.getTime()-this.dateDelta);this.settings.updateDate(this.startDateInput,d)}else if(c<b){var f=e(a,this.settings.startClass)?this.endDateInput:this.startDateInput,h=this.settings.parseDate(a);this.dateDelta=0,this.settings.updateDate(f,h)}else this.dateDelta=c.getTime()-b.getTime();else if(null!==this.settings.defaultDateDelta){if(b){var i=new Date(b.getTime()+this.settings.defaultDateDelta*g);this.settings.updateDate(this.endDateInput,i)}else if(c){var j=new Date(c.getTime()-this.settings.defaultDateDelta*g);this.settings.updateDate(this.startDateInput,j)}this.dateDelta=this.settings.defaultDateDelta*g}else this.dateDelta=null}},_timeChanged:function(a){if(this.startTimeInput&&this.endTimeInput){var b=this.settings.parseTime(this.startTimeInput),c=this.settings.parseTime(this.endTimeInput);if(!b||!c)return void(null!==this.settings.defaultTimeDelta?(this.timeDelta=this.settings.defaultTimeDelta,b?(c=this._setTimeAndReturn(this.endTimeInput,new Date(b.getTime()+this.settings.defaultTimeDelta)),this._doMidnightRollover(b,c)):c&&(b=this._setTimeAndReturn(this.startTimeInput,new Date(c.getTime()-this.settings.defaultTimeDelta)),this._doMidnightRollover(b,c))):this.timeDelta=null);if("start"==this.settings.anchor&&e(a,this.settings.startClass))c=this._setTimeAndReturn(this.endTimeInput,new Date(b.getTime()+this.timeDelta)),this._doMidnightRollover(b,c);else if("end"==this.settings.anchor&&e(a,this.settings.endClass))b=this._setTimeAndReturn(this.startTimeInput,new Date(c.getTime()-this.timeDelta)),this._doMidnightRollover(b,c);else{this._doMidnightRollover(b,c);var d,f;if(this.startDateInput&&this.endDateInput&&(d=this.settings.parseDate(this.startDateInput),f=this.settings.parseDate(this.endDateInput)),+d==+f&&c<b){var g=e(a,this.settings.endClass)?this.endTimeInput:this.startTimeInput,h=e(a,this.settings.startClass)?this.endTimeInput:this.startTimeInput,i=this.settings.parseTime(g);this.timeDelta=0,this.settings.updateTime(h,i)}else this.timeDelta=c.getTime()-b.getTime()}}},_setTimeAndReturn:function(a,b){return this.settings.updateTime(a,b),this.settings.parseTime(a)},_doMidnightRollover:function(a,b){if(this.startDateInput&&this.endDateInput){var c=this.settings.parseDate(this.endDateInput),d=this.settings.parseDate(this.startDateInput),e=b.getTime()-a.getTime(),f=b<a?g:-1*g;null!==this.dateDelta&&this.dateDelta+this.timeDelta<=g&&this.dateDelta+e!=0&&(f>0||0!=this.dateDelta)&&(e>=0&&this.timeDelta<0||e<0&&this.timeDelta>=0)&&("start"==this.settings.anchor?(this.settings.updateDate(this.endDateInput,new Date(c.getTime()+f)),this._dateChanged(this.endDateInput)):"end"==this.settings.anchor&&(this.settings.updateDate(this.startDateInput,new Date(d.getTime()-f)),this._dateChanged(this.startDateInput))),this.timeDelta=e}},_updateEndMintime:function(){if("function"==typeof this.settings.setMinTime){var a=null;"start"==this.settings.anchor&&(!this.dateDelta||this.dateDelta<g||this.timeDelta&&this.dateDelta+this.timeDelta<g)&&(a=this.settings.parseTime(this.startTimeInput)),this.settings.setMinTime(this.endTimeInput,a)}},_validateRanges:function(){return this.startTimeInput&&this.endTimeInput&&null===this.timeDelta?void d(this.container,"rangeIncomplete"):this.startDateInput&&this.endDateInput&&null===this.dateDelta?void d(this.container,"rangeIncomplete"):void(!this.startDateInput||!this.endDateInput||this.dateDelta+this.timeDelta>=0?d(this.container,"rangeSelected"):d(this.container,"rangeError"))}},a.Datepair=f}(window,document);

