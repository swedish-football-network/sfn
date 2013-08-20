/*-------------------------------------------------------------------------
| Global javascript for SFN
|------------------------------------------------------------------------*/

(function($) {
		$("#roster_pane").hide();
		$("#info_pane").show();
		$("#stats_pane").hide();
	$("#roster_button").click(function(){
		if($(this).hasClass("button") == true){
			$(".active_button").removeClass("active_button").addClass("button");
			$(this).removeClass("button").addClass("active_button");
		}
		$("#roster_pane").show();
		$("#info_pane").hide();
		$("#stats_pane").hide();

	})
	$("#info_button").click(function(){
		if($(this).hasClass("button") == true){
			$(".active_button").removeClass("active_button").addClass("button");
			$(this).removeClass("button").addClass("active_button");
		}
		$("#roster_pane").hide();
		$("#info_pane").show();
		$("#stats_pane").hide();
	})
	$("#stats_button").click(function(){
		if($(this).hasClass("button") == true){
			$(".active_button").removeClass("active_button").addClass("button");
			$(this).removeClass("button").addClass("active_button");
		}
		$("#roster_pane").hide();
		$("#info_pane").hide();
		$("#stats_pane").show();
	})

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

	/**
	 * TABLESORTER CODE
	 * Only run if the tablesorter plugin has been loaded by WordPress
	 *
	 */
	//if( $().tablesorter ) {
		$(".team-roster").tablesorter();
		$("#tabell_div table tbody tr td").each(function(){
			if($("#hiddenteamforjscript").text() == $(this).text()){
				$(this).parent().css("background","#94A8C5");
			};
		});
	//}
}) (jQuery);