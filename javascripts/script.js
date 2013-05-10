/*-------------------------------------------------------------------------
| Global javascript for SFN
|------------------------------------------------------------------------*/

(function($) {
	$('#login-button').on('click', function() {
		var position = $(this).offset();
		var props = {
			left: position.left,
			top: position.top + $(this).height() + 25 //Buttons position + height + height of css arrow and its padding
		};
		$('#login-modal').css(props).toggle();
	});
}) (jQuery);