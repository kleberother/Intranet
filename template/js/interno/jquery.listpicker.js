$.widget("jquery.listpicker", {      
	options : {
		'dictionary'    : {},
		'selected'      : [],
     	'size'      : 10,
     	'width'     : 500,
     	'multiple'  : true,
		'sourcelistid'      : 'sourcelist',
		'selectedlistid'    : 'selectedlist',
		'sourcetitle'       : 'THE SOURCE',
		'selectedtitle'     : 'THE SELECTED'
	},

	sourcelist : null,
	selectedlist : null,

	_create : function() {
		var self = this;              
	},

	_createDefaultSelectElement : function(elementName, elementId) {
		var self = this;              
		var element = $('<select/>')
			.attr('name',elementName);

		if (self.options.multiple) {
			element.attr('MULTIPLE', 'true');
		}

		var width = (self.options.width - (2 * 10) - 40 ) / 2;

		if (self.options.width) {
			element.css('width',Math.round(width)+'px');
		}

		if (self.options.size) {
			element.attr('size',self.options.size);
		}

		if (elementId) {
			element.attr('id',elementId);
		}

		return element;
	},

	_createOption : function(value, text) {
		var element = $('<option/>')
			.attr('value',value)
			.html(text);

		return element;
	},	

	_init : function() {
		var self = this;

		self.sourcelist = self._createDefaultSelectElement('source[]', self.options.sourcelistid);
		self.selectedlist = self._createDefaultSelectElement('selected[]', self.options.selectedlistid);

		if (self.options.sourcelistid && self.options.selectedlistid) {
			$('#' + self.options.sourcelistid + ' option').live('dblclick',function() {			
				var c = $(this).clone();
				$(self.selectedlist).append(c);
				$(this).remove();
				self.resetselection();
			});

			$('#' + self.options.selectedlistid + ' option').live('dblclick',function() {
				var c = $(this).clone();
				$(self.sourcelist).append(c);
				$(this).remove();
				self.resetselection();
			});
		}

		for (key in self.options.dictionary) {			
			if (self.options.selected.indexOf(key) < 0) {
				self.sourcelist.append( self._createOption(key,self.options.dictionary[key]) );
			} else {
				self.selectedlist.append( self._createOption(key,self.options.dictionary[key]) );
			}
		}

		var options = $('<td/>').append(
			$('<div />')
				.attr('title','.ui-icon-carat-1-e')
				.addClass('ui-state-default ui-corner-all')
				.html('<span class="ui-icon ui-icon-carat-1-e moveUm"></span>')
				.css('margin','2px')
				.click(function(){
					self.selectselection();
				})			
		).append(
			$('<div />')
				.attr('title','.ui-icon-carat-1-w')
				.addClass('ui-state-default ui-corner-all')
				.html('<span class="ui-icon ui-icon-carat-1-w voltaUm"></span>')
				.css('margin','2px').click(function(){
					self.deselectselection();
				})			
		).append(
			$('<div />')
				.attr('title','.ui-icon-arrowstop-1-e')
				.addClass('ui-state-default ui-corner-all')
				.html('<span class="ui-icon ui-icon-arrowstop-1-e moveTodos"></span>')			
				.css('margin','2px').click(function(){
					self.selectall();
				})
		).append(
			$('<div />')
				.attr('title','.ui-icon-arrowstop-1-w')
				.addClass('ui-state-default ui-corner-all')
				.html('<span class="ui-icon ui-icon-arrowstop-1-w voltaTodos"></span>')			
				.css('margin','2px').click(function(){
					self.deselectall();
				})
		);

		var table = $('<table/>')
			.append(
				$('<tr/>')
					.append( $('<td/>').append( 
						$('<div/>')
							.addClass('ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix')
							.html(self.options.sourcetitle) 
							.css({
								'margin-bottom':'4px',
								'font-size':'10px'
							}) 
						))
					.append( $('<td/>').html('&nbsp;'))
					.append( $('<td/>').append( 
						$('<div/>')
							.addClass('ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix')
							.html(self.options.selectedtitle)
							.css({
								'margin-bottom':'4px',
								'font-size':'10px'
							}) 
						))
			)
			.append(
				$('<tr/>')
					.append($('<td/>').append(self.sourcelist))
					.append(options)
					.append($('<td/>').append(self.selectedlist)))
			.css({
					'margin-right':'auto',
					'margin-left':'auto',
					'padding-top':'10px',
					'padding-bottom':'10px'
			})
			.attr('cellspacing','0')
			.attr('cellpadding','0');

		var container = $('<div>')		
			.css({
				'width':self.options.width,
				'position':'relative',
				'display':'block'
			})
			.addClass('ui-widget ui-widget-content ui-dialog ui-corner-all')			
			.append(table)
			.appendTo(self.element);
	},

	resetselection : function(){
		$("option:selected", self.sourcelist).attr('selected', false);
		$("option:selected", self.selectedlist).attr('selected', false);
	},

	undo : function() {
		var self = this;
		self.deselectall();
		for (i in self.options.selected) {
			var query = "option[value='"+self.options.selected[i]+"']";
			$(query, self.sourcelist).appendTo(self.selectedlist);
		}
	},

	deselectall : function(){
		var self = this;
		self._moveall(self.selectedlist, self.sourcelist);		
	},

	_moveall : function(source, target) {
		var self = this;
		$('option', source).each(function(){			
			$(this).appendTo(target);
		});
		self.resetselection();		
	},
	
	selectselection : function() {
		var self = this;
		$('option:selected', self.sourcelist).each(function(){
			var c = $(this).clone();
			$(self.selectedlist).append(c.attr('selected','1'));
			$(this).remove();			
		});
	},

	deselectselection : function() {
		var self = this;
		$('option:selected', self.selectedlist).each(function(){
			var c = $(this).clone();
			$(self.sourcelist).append(c.attr('selected','1'));
			$(this).remove();			
		});
	},

	selectall : function() {
		var self = this;
		self._moveall(self.sourcelist, self.selectedlist);
	},

	selectoption : function(key) {
		var self = this;	
		var query = "option[value='"+key+"']";
		$(query, self.element).appendTo(self.selectedlist);
	},

	deselectoption : function(key) {
		var self = this;	
		var query = "option[value='"+key+"']";
		$(query, self.element).appendTo(self.sourcelist);
	},

	getselected : function() {
		var self = this;
		var values = [];
		$('option', self.selectedlist).each(function() {
			values.push($(this).val());
		});				
		return values;
	},

	getdata : function() {
		var self = this;
		var data = {'include':[], 'exclude':[]};
		
		$('option', self.selectedlist).each(function() {
			data.include.push($(this).val());
		});

		$('option', self.sourcelist).each(function() {
			data.exclude.push($(this).val());
		});

		return data;
	}
});