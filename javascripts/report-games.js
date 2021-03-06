/**
 * Javascript for reporting games on SFN
 * Author: Hampus Persson
 * @hampusp
 */

(function() {

	function DropDown(el) {
		this.dd = el;
		this.placeholder = this.dd.children('span');
		this.opts = this.dd.find('ul.dropdown > li');
		this.val = '';
		this.index = -1;
		this.initEvents();
	}
	DropDown.prototype = {
		initEvents : function() {
			var obj = this;

			obj.dd.on('click', function(event){
				$(this).toggleClass('active');
				return false;
			});

			obj.opts.on('click',function(){
				var opt = $(this);
				obj.val = opt.text();
				obj.index = opt.index();
				obj.placeholder.text(obj.val);

				$('#report-tools').fadeIn(100);
				$('#game-id').val( opt.find('.pick-game').data('game-id') );
				$('#home-score').val( opt.find('.pick-game').data('home-score') );
				$('#away-score').val( opt.find('.pick-game').data('away-score') );
				$('#time-stamp').val( opt.find('.pick-game').data('game-time') );
			});
		},
		getValue : function() {
			return this.val;
		},
		getIndex : function() {
			return this.index;
		}
	}

	var dd = new DropDown( $('#dd') );

	$(document).click(function() {
		// all dropdowns
		$('.wrapper-dropdown-3').removeClass('active');
	});

}) (jQuery);