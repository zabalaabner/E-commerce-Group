jQuery(document).ready(function($){	$('.head-nav .menu').slicknav({label: '' , prependTo: 'header#head'});	$('.head-nav ul li').hover(function(){		$('.sub-menu:first, .children:first',this).stop(true,true).slideDown('fast');	},	function(){		$('.sub-menu:first, .children:first',this).stop(true,true).slideUp('fast');	});	function head_margin() {		//$('.head-logo').css('margin-top',$('.head-top').outerHeight());	}	$(window).bind('scroll', function () {	    if ($(window).scrollTop() > 0) {	        $('#head').addClass('fixed')	    } else  {	        $('#head').removeClass('fixed');	    }	});					var Page = (function() {			var $navArrows = $( '#nav-arrows' ),				slitslider = $( '#slider' ).slitslider( {					//autoplay: true,				} ),				init = function() {					initEvents();									},				initEvents = function() {							// add navigation events							$navArrows.children( ':last' ).on( 'click', function() {								slitslider.next();								return false;							} );							$navArrows.children( ':first' ).on( 'click', function() {																slitslider.previous();								return false;							} );													};				return { init : init };		})();		Page.init();		/**		 * Notes: 		 * 		 * example how to add items:		 */		/*				var $items  = $('<div class="sl-slide sl-slide-color-2" data-orientation="horizontal" data-slice1-rotation="-5" data-slice2-rotation="10" data-slice1-scale="2" data-slice2-scale="1"><div class="sl-slide-inner bg-1"><div class="sl-deco" data-icon="t"></div><h2>some text</h2><blockquote><p>bla bla</p><cite>Margi Clarke</cite></blockquote></div></div>');				// call the plugin's add method		ss.add($items);		*/	});