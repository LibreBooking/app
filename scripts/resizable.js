
// script.aculo.us Resizables.js

// Copyright(c) 2007 - Orr Siloni, Comet Information Systems http://www.comet.co.il/en/
//
// Resizable.js is freely distributable under the terms of an MIT-style license.
// For details, see the script.aculo.us web site: http://script.aculo.us/

var Resizables = {
	instances: [],
	observers: [],
	
	register: function(resizable) {
		if(this.instances.length == 0) {
			this.eventMouseUp   = this.endResize.bindAsEventListener(this);
			this.eventMouseMove = this.updateResize.bindAsEventListener(this);
			
			Event.observe(document, "mouseup", this.eventMouseUp);
			Event.observe(document, "mousemove", this.eventMouseMove);
		}
		this.instances.push(resizable);
	},
	
	unregister: function(resizable) {
		this.instances = this.instances.reject(function(d) { return d==resizable });
		if(this.instances.length == 0) {
			Event.stopObserving(document, "mouseup", this.eventMouseUp);
			Event.stopObserving(document, "mousemove", this.eventMouseMove);
		}
	},
	
	activate: function(resizable) {
		if(resizable.options.delay) { 
			this._timeout = setTimeout(function() {
				Resizables._timeout = null; 
				Resizables.activeResizable = resizable; 
			}.bind(this), resizable.options.delay); 
		} else {
			this.activeResizable = resizable;
		}
	},
	
	deactivate: function() {
		this.activeResizable = null;
	},
	
	updateResize: function(event) {
		if(!this.activeResizable) return;
		var pointer = [Event.pointerX(event), Event.pointerY(event)];
		// Mozilla-based browsers fire successive mousemove events with
		// the same coordinates, prevent needless redrawing (moz bug?)
		if(this._lastPointer && (this._lastPointer.inspect() == pointer.inspect())) return;
		this._lastPointer = pointer;
		
		this.activeResizable.updateResize(event, pointer);
	},
	
	endResize: function(event) {
		if(this._timeout) { 
		  clearTimeout(this._timeout); 
		  this._timeout = null; 
		}
		if(!this.activeResizable) return;
		this._lastPointer = null;
		this.activeResizable.endResize(event);
		this.activeResizable = null;
	},
	
	addObserver: function(observer) {
		this.observers.push(observer);
		this._cacheObserverCallbacks();
	},
  
	removeObserver: function(element) {  // element instead of observer fixes mem leaks
		this.observers = this.observers.reject( function(o) { return o.element==element });
		this._cacheObserverCallbacks();
	},
	
	notify: function(eventName, resizable, event) {  // 'onStart', 'onEnd', 'onResize'
		if(this[eventName+'Count'] > 0)
			this.observers.each( function(o) {
				if(o[eventName]) o[eventName](eventName, resizable, event);
			});
		if(resizable.options[eventName]) resizable.options[eventName](resizable, event);
	},
	
	_cacheObserverCallbacks: function() {
		['onStart','onEnd','onResize'].each( function(eventName) {
			Resizables[eventName+'Count'] = Resizables.observers.select(
				function(o) { return o[eventName]; }
			).length;
		});
	}
}

var Resizable = Class.create();
Resizable._resizing = {};

Resizable.prototype = {
	initialize: function(element){
		var defaults = {
			handle: false,
			snap: false,  // false, or xy or [x,y] or function(x,y){ return [x,y] }
			delay: 0,
			minHeight: false,
			minwidth: false,
			maxHeight: false,
			maxWidth: false
		}
		
		this.element = $(element);
		
		var options = Object.extend(defaults, arguments[1] || {});
		if(options.handle && typeof options.handle == 'string')
			this.handle = $(options.handle);
		if(!this.handle) this.handle = this.element;
		
		this.options  = options;
		this.dragging = false;
		
		this.eventMouseDown = this.initResize.bindAsEventListener(this);
		Event.observe(this.handle, "mousedown", this.eventMouseDown);
		
		Resizables.register(this);
	},
	
	destroy: function() {
		Event.stopObserving(this.handle, "mousedown", this.eventMouseDown);
	},
	
	currentDelta: function() {
		return([
			parseInt(Element.getStyle(this.element,'width') || '0'),
			parseInt(Element.getStyle(this.element,'height') || '0')]);
	},
	
	initResize: function(event) {
		if(typeof Resizable._resizing[this.element] != 'undefined' &&
			Resizable._resizing[this.element]) return;
		if(Event.isLeftClick(event)) {
			// abort on form elements, fixes a Firefox issue
			var src = Event.element(event);
			if((tag_name = src.tagName.toUpperCase()) && (
				tag_name=='INPUT' || tag_name=='SELECT' || tag_name=='OPTION' ||
				tag_name=='BUTTON' || tag_name=='TEXTAREA')) return;
			
			this.pointer = [Event.pointerX(event), Event.pointerY(event)];
			this.size = [parseInt(this.element.getStyle('width')) || 0, parseInt(this.element.getStyle('height')) || 0];
			
			Resizables.activate(this);
			Event.stop(event);
		}
	},
	
	startResize: function(event) {
		this.resizing = true;
		if(this.options.zindex) {
			this.originalZ = parseInt(Element.getStyle(this.element,'z-index') || 0);
			this.element.style.zIndex = this.options.zindex;
		}
		Resizables.notify('onStart', this, event);
		Resizable._resizing[this.element] = true;
	},
	
	updateResize: function(event, pointer) {
		if(!this.resizing) this.startResize(event);
		
		Resizables.notify('onResize', this, event);
		
		this.draw(pointer);
		if(this.options.change) this.options.change(this);
		
		// fix AppleWebKit rendering
		if(Prototype.Browser.WebKit) window.scrollBy(0,0);
		Event.stop(event);
	},
	
	finishResize: function(event, success) {
		this.resizing = false;
		Resizables.notify('onEnd', this, event);
		if(this.options.zindex) this.element.style.zIndex = this.originalZ;
		Resizable._resizing[this.element] = false;
		Resizables.deactivate(this);
	},
	
	endResize: function(event) {
		if(!this.resizing) return;
		this.finishResize(event, true);
		Event.stop(event);
	},
	
	draw: function(point) {
		var p = [0,1].map(function(i){ 
			return (this.size[i] + point[i] - this.pointer[i]);
		}.bind(this));
		
		if(this.options.snap) {
			if(typeof this.options.snap == 'function') {
				p = this.options.snap(p[0],p[1],this);
			} else {
				if(this.options.snap instanceof Array) {
				p = p.map( function(v, i) {
				return Math.round(v/this.options.snap[i])*this.options.snap[i] }.bind(this))
			} else {
				p = p.map( function(v) {
				return Math.round(v/this.options.snap)*this.options.snap }.bind(this))
			}
		}}
		
		if (this.options.minWidth && p[0] <= this.options.minWidth) p[0] = this.options.minWidth;
		if (this.options.maxWidth && p[0] >= this.options.maxWidth) p[0] = this.options.maxWidth;
		if (this.options.minHeight && p[1] <= this.options.minHeight) p[1] = this.options.minHeight;
		if (this.options.maxHeight && p[1] >= this.options.maxHeight) p[1] = this.options.maxHeight;
		
		var style = this.element.style;
		if((!this.options.constraint) || (this.options.constraint=='horizontal')){
			style.width = p[0] + "px";
		}
		if((!this.options.constraint) || (this.options.constraint=='vertical')){
			style.height = p[1] + "px";
		}
		
		if(style.visibility=="hidden") style.visibility = ""; // fix gecko rendering
	}
};
