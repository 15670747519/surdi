jQuery(document).ready(function() {
    jQuery(".J-nav").slide({
        type: "menu",
        titCell: ".nav > li",
        targetCell: ".sub",
        effect: "slideDown",
        delayTime: 0,
        triggerTime: 0,
        returnDefault: true
    });

	$('.header').on('click', '.wx', function(e) {
		e.preventDefault();
		$(this).find('.qr').toggle('show');
	});
});