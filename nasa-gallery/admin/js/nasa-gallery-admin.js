(function( $ ) {
	'use strict';

	$(document).ready(function(){
		$( '#upload-images' ).on( 'click', function(){

			var dataJSON = {
				'action': 'prefix_ajax_upload_images',
			};

			$.ajax({
				cache: false,
				type: "POST",
				url: ajaxurl,
				data: dataJSON,
				beforeSend: function( xhr ) {
					$('#loader').show();
					$('#upload-images').hide();
				},
				success: function( response ){
					$('#loader').hide();
					$('#response').addClass('notice notice-success');
					$('#response p').text(response);

				},
				error: function( xhr, status, error ) {
					console.log( 'Status: ' + xhr.status );
					console.log( 'Error: ' + xhr.responseText );
					$('#loader').hide();
					$('#response').addClass('notice notice-error');
					$('#response p').text(xhr.responseText);
				}
			});
		});
	});

})( jQuery );
