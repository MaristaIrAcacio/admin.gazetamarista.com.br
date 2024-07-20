/*
 * Menu Canvas Swipe
 *
 * Licensed under the Apache License 2.0
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Author: Erick Monteiro [http://www.erickmonteiro.com.br]
 */
var MenuOffCanvasSwipe = (function(window, document)
{

	// check 3d transform support, thanks https://gist.github.com/lorenzopolidori/3794226
	function has3dTransform()
	{
		var el         = document.createElement('p'),
			has3d,
			transforms = {
				'webkitTransform': '-webkit-transform',
				'msTransform'    : '-ms-transform',
				'MozTransform'   : '-moz-transform',
				'transform'      : 'transform'
			};

		// Add it to the body to get the computed style
		document.body.insertBefore(el, null);

		for( var t in transforms )
		{
			if( el.style[t] !== undefined )
			{
				el.style[t] = 'translate3d(1px,1px,1px)';
				has3d       = window.getComputedStyle(el).getPropertyValue(transforms[t]);
			}
		}

		document.body.removeChild(el);

		return (has3d !== undefined && has3d.length > 0 && has3d !== "none");
	}

	var
		body              = $('body'),
		menu              = $('.menu-navegacao-off-left'),
		overlay           = $('.menu-principal-off-overlay'),
		btn_abrir_menu    = $('.btn-abrir-menu-navegacao-off'),
		menu_is_open      = false,

		// Config
		menuWidth         = 250,
		menuOffsetInicial = '-260',
		offsetMax         = 20,
		overlayOpacity    = 0.6,
		browserWidthMax   = 640,

		// Browser check
		hasTouch          = ( ('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch ) ? true : false,
		translateZ        = has3dTransform() ? ' translateZ(0)' : '';

	// Construct
	var MenuOffCanvasSwipe = function(options)
	{
		// Events
		$(window).on(hasTouch ? 'touchstart' : 'mousedown', this._touchstart.bind(this));
		$(window).on(hasTouch ? 'touchmove' : 'mousemove', this._touchmove.bind(this));
		$(window).on(hasTouch ? 'touchend' : 'mouseup', this._touchend.bind(this));
		btn_abrir_menu.on('click', function(e)
		{
			e.preventDefault();
			MenuOffCanvasSwipe.prototype._openCloseMenu(menu_is_open === true ? 'close' : 'open');
		});
	};

	MenuOffCanvasSwipe.prototype = {

		initiated        : false, // It is started
		x_menu           : 10, // starting point
		x_moved          : 0, // distance moved
		x_original       : null, // original X
		overlay_opacity  : 0, // overlay opacity
		target_is_overlay: false, // overlay opacity

		_touchstart: function(e)
		{
			// Ativa só se estiver na tamanho da tela correta
			if( (window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth) > browserWidthMax )
			{
				return;
			}

			if( this.initiated ) return;

			//console.log('touchstart');

			var point = hasTouch ? e.originalEvent.touches[0] : e;

			this.initiated       = true;
			this.pointX          = point.pageX;
			this.pointY          = point.pageY;
			this.stepsX          = 0;
			this.stepsY          = 0;
			this.directionLocked = false;

			// If it exceeded the maximum offset and the menu is closed, so give the control back to the browser
			if( this.pointX > offsetMax && !menu_is_open )
			{
				this.initiated = false;
				return;
			}

			this.target_is_overlay = $(point.target).hasClass('menu-principal-off-overlay');
			this.x_menu            = menu.offset().left;
			this.x_original        = -this.x_menu + this.pointX;
			menu[0].style.cssText += '-webkit-transition-duration:0s; transition-duration:0s;';
			overlay[0].style.cssText += '-webkit-transition-duration:0s; transition-duration:0s;';
		},

		_touchmove: function(e)
		{
			if( !this.initiated ) return;

			//console.log('touchmove');

			var point = hasTouch ? e.originalEvent.touches[0] : e;

			this.stepsX += Math.abs(point.pageX - this.pointX);
			this.stepsY += Math.abs(point.pageY - this.pointY);

			// We take a 10px buffer to figure out the direction of the swipe
			if( this.stepsX < 10 && this.stepsY < 10 )
			{
				return;
			}

			// We are scrolling vertically, so skip SwipeView and give the control back to the browser
			if( !this.directionLocked && this.stepsY > this.stepsX )
			{
				this.initiated = false;
				return;
			}

			e.preventDefault();
			this.directionLocked = true;

			if( this.x_original )
			{
				var nx       = parseInt(point.pageX) - this.x_original;
				this.x_moved = nx - this.x_menu;
				this.x_menu  = nx;

				this.overlay_opacity = (menuWidth + nx) / 200;
				this.overlay_opacity = (this.overlay_opacity > overlayOpacity) ? overlayOpacity : this.overlay_opacity;

				if( overlay[0].style.left != '0px' )
				{
					overlay[0].style.left = 0;
				}
				overlay[0].style.opacity = this.overlay_opacity;

				this._moveMenu(( nx > 0 ) ? 0 : nx);
			}
		},

		_touchend: function(e)
		{
			if( !this.initiated ) return;

			//console.log('touchend');

			var point = hasTouch ? e.originalEvent.changedTouches[0] : e;

			// Choose direction based on x_moved
			if( this.x_moved > 0 )
			{
				this._openCloseMenu('open');
			}
			else if( this.x_moved < 0 )
			{
				this._openCloseMenu('close');
			}

			// If not moved and menu is closed
			if( this.x_moved === 0 && !menu_is_open )
			{
				this._openCloseMenu('close');
			}

			// If click on overlay
			if( this.x_moved === 0 && this.target_is_overlay )
			{
				e.preventDefault();
				this._openCloseMenu('close');
			}

			this.x_original = null;
			this.x_moved    = 0;
			this.initiated  = false;
		},

		_moveMenu: function(x)
		{
			menu[0].style.cssText += '-webkit-transform:translate(' + x + 'px,0)' + translateZ + '; -moz-transform:translate(' + x + 'px,0)' + translateZ + '; -ms-transform:translate(' + x + 'px,0)' + translateZ + '; -o-transform:translate(' + x + 'px,0)' + translateZ + '; transform:translate(' + x + 'px,0)' + translateZ + ';';
		},

		_openCloseMenu: function(openclose)
		{
			var position = 'translate(' + (openclose == 'open' ? 0 : menuOffsetInicial) + 'px,0)' + translateZ;

			menu[0].style.cssText += '-webkit-transition-duration:300ms; transition-duration:300ms; -webkit-transform:' + position + '; -moz-transform:' + position + '; -ms-transform:' + position + '; -o-transform:' + position + '; transform:' + position + ';';
			overlay[0].style.cssText += '-webkit-transition-duration:100ms; transition-duration:100ms;';

			if( openclose == 'open' )
			{
				menu_is_open             = true;
				overlay[0].style.left    = 0;
				overlay[0].style.opacity = overlayOpacity;
				body.addClass('site-lateral-aberto');
			}
			else
			{
				menu_is_open             = false;
				overlay[0].style.opacity = '0';
				overlay[0].style.left    = '-100%';
				body.removeClass('site-lateral-aberto');
			}
		}

	};

	// Return construct
	return MenuOffCanvasSwipe;

})(window, document);
