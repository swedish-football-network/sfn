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

	/**
	 * TABLESORTER CODE
	 * Only run if the tablesorter plugin has been loaded by WordPress
	 *
	 */
	if( $().tablesorter ) {
		var head = $("#roster table tbody").find("tr:first-child").html();
		head = "<thead><tr>"+head+"</tr></thead>";
		$("#roster table tbody").find("tr:first-child").remove();
		$("#roster table tbody").before(head);
		$("#roster table thead td").each(function(index) {
			var content = $(this).text();
		  	var thisTD = this;
		  	var newElement = $("<th></th>");
		  	$.each(this.attributes, function(index) {
				$(newElement).attr(thisTD.attributes[index].name, thisTD.attributes[index].value);
		  	});
		  	$(this).after(newElement).remove();
			$(newElement).text(content);
		});
		$("#roster table").tablesorter();
		$("#tabell_div table tbody tr td").each(function(){
			if($("#hiddenteamforjscript").text() == $(this).text()){
				$(this).parent().css("background","#94A8C5");
			};
		});
	}
}) (jQuery);