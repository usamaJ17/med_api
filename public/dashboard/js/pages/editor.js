//[editor Javascript]

//Project:	Rhythm Admin - Responsive Admin Template
//Primary use:   Used only for the wysihtml5 Editor 


//Add text editor
    $(function () {
    "use strict";

    // Replace the <textarea id="editor1"> with a CKEditor
	// instance, using default configuration.
	// CKEDITOR.replace('editor1');
	// CKEDITOR.replace('editor2');
	new FroalaEditor("#editor1", {
		height: 300 // Set height to 300 pixels
	  });
	
	//bootstrap WYSIHTML5 - text editor
	// $('.textarea').wysihtml5();		
	
  });

