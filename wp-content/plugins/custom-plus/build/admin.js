( function () {
	var mediaUploader;

	document.getElementById( 'og-img-btn' ).addEventListener( 'click', function ( e ) {
		e.preventDefault();

		if ( mediaUploader ) {
			mediaUploader.open();
			return;
		}

		mediaUploader = wp.media( {
			title: 'Select Open Graph Image',
			button: { text: 'Use this image' },
			multiple: false,
		} );

		mediaUploader.on( 'select', function () {
			var attachment = mediaUploader.state().get( 'selection' ).first().toJSON();
			document.getElementById( 'cp_og_image' ).value = attachment.url;
			document.getElementById( 'og-img-preview' ).src = attachment.url;
		} );

		mediaUploader.open();
	} );
} )();
