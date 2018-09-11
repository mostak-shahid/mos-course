jQuery(document).ready(function($) {
	var n = 0;
	$('body').find('.mos-course-time').each(function( number ) {
		n++;
		var time = $(this).html();
		$(this).after('<div class="mos-course-countdown-wrap"><div class="mos-course-countdown header">Next course: </div><div class="mos-course-countdown countdown-'+n+'"></div><!--/.mos-course-time--></div><!--/.mos-course-countdown-wrap-->');
		$(this).hide();
		$('.mos-course-countdown.countdown-'+n).timeTo({
			//callback: alert(n);,
			timeTo: new Date(time),
			displayDays: 2,
		    //theme: "black",
		    displayCaptions: true,
		    fontSize: 16,
		    captionSize: 8,
		    // languages: {
		    //     pl: {days: 'dni', hours: 'godziny', min: 'minuty', sec: 'secundy'}
		    // },
		    // lang: 'pl'
		});
	});
});