/*-------------------------------------------------------------------------
| Global javascript for SFN
|------------------------------------------------------------------------*/

(function($) {
	$('#login-button').on('click', function(e) {
		e.stopPropagation();
		var position = $(this).offset();
		var props = {
			left: position.left,
			top: position.top + $(this).height() + 25 //Buttons position + height + height of css arrow and its padding
		};
		$('#login-modal').css(props).toggle();
	});

	$('#login-modal').on('click', function(e) {
		e.stopPropagation(); // Prevent click on the modal to cause the modal to hide
	});

	$('body').click(function(e){
    $('#login-modal').hide();
	});
}) (jQuery);