if (typeof Common == 'undefined')
{
	var Common = {};
	Common.getBrowserHeight = function ()
	{
		var viewportheight = 0;
		if (typeof window.innerHeight != 'undefined')
		{
			viewportheight = window.innerHeight;
		}
		else if (typeof document.documentElement != 'undefined' && typeof document.documentElement.clientHeight != 'undefined' && document.documentElement.clientHeight != 0)
		{
			viewportheight = document.documentElement.clientHeight;
		}
		else
		{
			viewportheight = document.getElementsByTagName('body')[0].clientHeight;
		}
		return viewportheight;
	};
	
	Common.getBrowserWidth = function ()
	{
		var viewportwidth = 0;
		if (typeof window.innerWidth != 'undefined')
		{
			viewportwidth = window.innerWidth;
		}
		else if (typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth != 0)
		{
			viewportwidth = document.documentElement.clientWidth;
		}
		else
		{
			viewportwidth = document.getElementsByTagName('body')[0].clientWidth;
		}
		return viewportwidth;
	};
	
	Common.completeSize = function (size)
	{
		var retSize = String(size);
		if (retSize.indexOf('%') == -1 && retSize.indexOf('px') == -1 && retSize != "centered")
		{
			retSize += 'px';
		}
		return retSize;
	};
}

if (typeof PopupManager == 'undefined')
{
	var PopupManager = {};
	PopupManager.array = new Array();
	PopupManager.tpl = new Array();
	PopupManager.n = 0;
	PopupManager.active = null;
	PopupManager.create = function ()
	{
		do
		{
			PopupManager.n += 1;
		} while ($('.popup-window[n="' + PopupManager.n + '"]').size() > 0);
		var n = PopupManager.n;
		var p = new Popup(n);
		PopupManager.array[n] = p;
		return p;
	};
	PopupManager.loadTemplates = function ()
	{};
	
	PopupManager.close = function (n)
	{
		try
		{
			var p = PopupManager.array[n];
			p.close();
			delete PopupManager.array[n];
			return true;
		}
		catch (error)
		{
			return false;
		}
	};
	
	PopupManager.getActive = function ()
	{
		return PopupManager.active;
	};
	
	PopupManager.setActive = function (p)
	{
		PopupManager.active = p;
	};
	
	PopupManager.get = function (n)
	{
		try
		{
			var p = PopupManager.array[n];
			return p;
		}
		catch (error)
		{
			return null;
		}
	};
	
	PopupManager.save = function (p)
	{
		PopupManager.array[p.n] = p;
	};
	
	PopupManager.loadTemplates();
	
}

function Popup(n)
{
	this.drawed = false;
	this.visible = false;
	this.configured = false;
	this.n = n;
	
	this.configure = function (options)
	{
		if (typeof options == "undefined")
		{
			var opt = {};
		}
		else
		{
			opt = options;
		}
		if (typeof opt.type == "undefined")
		{
			return false;
		}
		if (typeof opt.modal == "undefined")
		{
			opt.modal = false;
		}
		if (typeof opt.bg == "undefined")
		{
			opt.bg = 'light';
		}
		if (typeof opt.width == "undefined")
		{
			opt.width = '600px';
		}
		if (typeof opt.height == "undefined")
		{
			opt.height = '400px';
		}
		if (typeof opt.top == "undefined")
		{
			opt.top = "centered";
		}
		if (typeof opt.left == "undefined")
		{
			opt.left = "centered";
		}
		
		this.type = opt.type.toLowerCase();
		this.modal = opt.modal;
		this.bg = opt.bg.toLowerCase();
		this.imp = PopupFactory.get(this.type);
		this.imp.configure(options);
		this.imp.n = this.n;
		this.width = opt.width;
		this.height = opt.height;
		this.left = opt.left;
		this.top = opt.top;
		this.configured = true;
		
	};
	
	this.draw = function ()
	{
		if ($('.popup-container').size() == 0)
		{
			$('body').append('<div class="popup-container"></div>');
		}
		if (this.drawed == false)
		{
			str = '<div class="popup-window" n="' + this.n + '">';
			stylePatch = "";
			if (this.modal)
			{
				if (this.bg == 'transparent')
				{
					bgStyle = ' popup-window-transparent';
				}
				else if (this.bg == 'light')
				{
					bgStyle = ' popup-window-light';
				}
				else if (this.bg == 'dark')
				{
					bgStyle = ' popup-window-dark';
				}
				else
				{
					bgStyle = '';
				}
				str += '<div class="popup-background' + bgStyle + '" style="' + stylePatch + '"></div>';
			}
			
			var style = "position:absolute; min-width:90%; max-width:100%; height:auto;";
			style += stylePatch;
			str += '<div class="popup-body" >' + this.imp.draw() + '</div>';
			str += '</div>';
			
			$('.popup-container').append(str);
			
			PopupManager.setActive(this);
			
			this.imp.load();
			this.bindEvents();
			this.drawed = true;
		}
		else
		{
			this.show();
		}
	};
	
	this.refresh = function ()
	{
		try
		{
			this.imp.refresh();
		}
		catch (error)
		{}
	};
	
	this.bindEvents = function ()
	{
		$(this.getSelector() + ' .popup-body').mouseover(function ()
		{
			var n = $(this).parents('.popup-window').attr('n');
			PopupManager.setActive(PopupManager.get(n));
		});
	};
	
	this.getSelector = function ()
	{
		return '.popup-window[n="' + this.n + '"]';
	};
	
	this.show = function ()
	{
		var obj = $(this.getSelector());
		if (obj.size() > 0)
		{
			obj.show();
		}
		this.visible = true;
	};
	
	this.hide = function ()
	{
		var obj = $(this.getSelector());
		if (obj.size() > 0)
		{
			obj.hide();
		}
		this.visible = false;
	};
	
	this.close = function ()
	{
		var obj = $(this.getSelector());
		if (obj.size() > 0)
		{
			obj.remove();
		}
		if ($('.popup-window').size() == 0)
		{
			$('.popup-container').remove();
		}
		this.drawed = false;
		this.visible = false;
	};
}

if (typeof PopupFactory == 'undefined')
{
	var PopupFactory = {};
	
	PopupFactory.get = function (type)
	{
		if (type == 'legal')
		{
			return new LegalPopup();
		}
		else if (type == 'users')
		{
			return new UsersPopup();
		}
		else if (type == 'image')
		{
			return new imagePopup();
		}
		else if (type == 'error')
		{
			return new errorPopup();
		}
		else if (type == 'noajax')
		{
			return new noAjaxPopup();
		}
	};
}

function UsersPopup()
{
	this.configure = function (options)
	{
		this.url = options.url;
		this.curr_url = options.curr_url;
	};
	
	this.draw = function ()
	{
		return '<div type="login-popup"><div class="login-popup-loading-icon"><img alt="Loading..." src="/core/img/popup/ajax-loader-small.gif" /></div></div>';
	};
	
	this.load = function ()
	{
		$.ajax(
		{
			async: true,
			url: this.url,
			data: {
				curr_url: this.curr_url
			},
			success: function (data)
			{
				$('div[type="login-popup"]:last').html(data);
			},
			error: function (error)
			{}
		});
	};
}

function LegalPopup()
{
	this.configure = function (options)
	{
		this.url = options.url;
	};
	
	this.draw = function ()
	{
		return '<div type="legal-popup"><div class="login-popup-loading-icon"><img alt="Loading..." src="/core/img/popup/ajax-loader-small.gif" /></div></div>';
	};
	
	this.load = function ()
	{
		$.ajax(
		{
			async: true,
			url: this.url,
			success: function (data)
			{
				$('div[type="legal-popup"]:last').html(data);
			},
			error: function (error)
			{}
		});
	};
}

function imagePopup()
{
	this.configure = function (options)
	{
		this.url = options.url;
	};
	
	this.draw = function ()
	{
		return '<div id="image-popup" type="image-popup"><div class="login-popup-loading-icon"><img alt="Loading..." src="/core/img/popup/ajax-loader-small.gif" /></div></div>';
	};
	
	this.load = function ()
	{
		var selector = 'div[type="image-popup"]:last';
		$(selector).html('<div class="img-popup-container-1"><img src="' + this.url + '" width="100%" height="100%"/><div class="img-popup-message"><?=addslashes(<pfw:getvarname name="lang_var.CLICK_IMAGE_TO_CLOSE"/>);?></div></div>');
		$(selector).click(function ()
		{
			PopupManager.getActive().close();
		});
	};
}

function errorPopup()
{
	this.configure = function (options)
	{
		this.url = options.url;
		this.message = options.message;
	};
	
	this.draw = function ()
	{
		return '<div type="error-popup" class="overflow-auto"><div class="login-popup-loading-icon"><img alt="Loading..." src="/core/img/popup/ajax-loader-small.gif" /></div></div>';
	};
	
	this.load = function ()
	{
		$.ajax(
		{
			async: true,
			url: this.url,
			data: {
				message: this.message
			},
			success: function (data)
			{
				$('div[type="error-popup"]:last').html(data);
			},
			error: function (error)
			{}
		});
	};
}

function noAjaxPopup()
{
	this.configure = function (options)
	{
		this.message = options.message;
	};
	
	this.draw = function ()
	{
		return '<div type="error-popup" class="overflow-auto"><div class="login-popup-loading-icon"><img alt="Loading..." src="/core/img/popup/ajax-loader-small.gif" /></div></div>';
	};
	
	this.load = function ()
	{
		$('div[type="error-popup"]:last').html(this.message);
	};
}