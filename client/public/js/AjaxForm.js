var AjaxForm = function( form, callback, bind ) {
	
	this.form = $(form);
	this.callback = callback instanceof Function ? callback.bind( bind || this ) : this.redirectCallback;
	
	if ( form ) {
		form.addEvent("submit", function(e) {
			new Event(e).stop();
			
			var request = new Request.JSON({
				url : form.get("action"),
				onComplete : callback.pass(form)
			});
			
			request.post( this.getParams() );
		}.bind(this) );
		
	} else {
		alert(20);
		return;
	}
}

AjaxForm.redirectCallback = function(e) {
	if ( e.result ) {
		window.location.href = e.target.get("action");
	} else {
		AjaxForm.displayErrors(e.messages);
	}
}

AjaxForm.displayErrors = function(messages) {
	var errors = $('errors-shape');
	
	for ( var elName in messages ) {
		errors.appendChild( new Element("li", {
			text : messages[elName][0]
		}) );
		break;
	}
}

AjaxForm.refreshCallback = function(e) {
	if ( e.result ) {
		window.location.href = window.location.href;
	} else {
		AjaxForm.displayErrors(e.messages);
	}
}

AjaxForm.prototype.getParams = function() {
	var result = {};
	this.form.getElements("input, select, textarea").each( function(element) {
		result[element.get("name")]=element.get("value");
	});
	
	return result;
}
