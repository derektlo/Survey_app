$('document').ready(function() {
	
	//Quotes rotation
	var quoteList		= $('.quote').find('span');
	var quoteUserList	= $('.quote-user').find('span');
	var startInterval = 1;
	var endInterval	= parseInt(quoteList.size()) - 1;

	if(quoteList.size() > 0) {
		window.setInterval(function() {
		
			if(startInterval > endInterval) startInterval = 0;
		
			quoteList.hide();
			quoteUserList.hide();
			quoteList.eq(startInterval).fadeIn('slow');
			quoteUserList.eq(startInterval).fadeIn('slow');
		
			startInterval++;
		
		}, 5000);
	}
	
});