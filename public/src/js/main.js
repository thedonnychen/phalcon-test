import '../scss/main.scss';

var PagesClass 		= require('./classes/PagesClass');
var onloadClasses 	= [];

PagesClass.default.init(); // common class

// Loads different classes depending on the page
let classes = document.body.className.replace(/-/g, '_').split(/\s+/);
for( let className of classes ){
	className = className.charAt(0).toUpperCase() + className.slice(1); // capitalize the Page name

	// the try catch statements prevents an fatal error (in case the class doesn't exists)
	try{
		// require the class file
		// example: require(`./classes/HomeClass`);
		let importedClassModule = require(`./classes/${className}Class`);

		// and instantiate a new class
		importedClassModule.default.init();

		onloadClasses.push( importedClassModule );
	} catch( error ){ }
}

// these are the classes/methods that will be called once the page has finished loading
(function ($) {
    "use strict";
    $(document).ready(function () {
    	for(let key in onloadClasses){

    		// the try catch statements prevents an fatal error (finalize method doesn't exists)
    		try{
    			onloadClasses[key].default.finalize(); 

    			// delete the class from the array (no need to maintain it)
    			delete onloadClasses[key];
    		} catch( error ){ }

    	}
    });
})(jQuery);