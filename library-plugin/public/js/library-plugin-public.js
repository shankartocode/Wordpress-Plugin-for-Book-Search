(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$(document).ready( function(){
		$('#filter').submit(function(e){
			e.preventDefault();
			var filter = $('#filter');
			$.ajax({
				url:filter.attr('action'),
				data:filter.serialize(), // form data
				type:filter.attr('method'), // POST
				beforeSend:function(xhr){
					filter.find('button').text('Processing...'); // changing the button label
				},
				success:function(data){
					filter.find('button').text('Search Books'); // changing the button label back
					$('#response').html(data); // insert data
					$("div.holder").jPages({
						containerID: "response",
						perPage : 3
					});
				}
			});
			return false;
		});

		$('#instant_search').keyup( function(e){
			e.preventDefault();
			var filterVal = $(this).val();
			if( filterVal.length > 3 ){
				$.ajax({
					url:$(this).attr('data-pull-url'),
					data:{'key': filterVal, 'action':'instancesearch'}, // form data
					type:'POST', // POST
					success:function(data){
						$('#instant-search-show-box').html(data); // insert data
						$('#instant-search-show-box').show();
					}
				});
			} else {
				$('#instant-search-show-box').hide();
			}
		});

		$('#rating_range_fr_to').jRange({
			from: 1,
			to: 5,
			step: 1,
			scale: [1,2,3,4,5],
			format: '%s',
			width: 200,
			showLabels: true,
			isRange : true
		});

		$('#price_min_max').jRange({
			from: 0,
			to: 2000,
			step: 1,
			scale: [0,500,1000,1500,2000],
			format: '%s',
			width: 200,
			showLabels: true,
			isRange : true
		});

		$('#publish_year_from_to').jRange({
			from: 1950,
			to: 2017,
			step: 1,
			scale: [1950,1960,1970,1980,1990,2000,2017],
			format: '%s',
			width: 200,
			showLabels: true,
			isRange : true
		});	
		
		$("div.holder").jPages({
			containerID: "response",
			perPage : 3
		});
	});

})( jQuery );
