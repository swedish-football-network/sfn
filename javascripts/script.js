/*-------------------------------------------------------------------------
| Global javascript for SFN
|------------------------------------------------------------------------*/

(function($) {
	$('#login-button').on('click', function() {
		var position = $(this).offset();
		console.log(position);
		var props = {
			left: position.left,
			top: position.top + $(this).height
		};
		$('#login-modal').css(props).toggle();
	});
}) (jQuery);