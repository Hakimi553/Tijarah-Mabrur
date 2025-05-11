//font ranger
var rangeSlider = function(){
  var slider = jQuery('.hss_range_slider'),
      range = jQuery('.hss_range_slider_range'),
      value = jQuery('.hss_range_slider_value');

  slider.each(function(){

    value.each(function(){
      
      var value1 = jQuery(this).next().attr('value');  
      
      jQuery(this).html(value1+'px');     
    });

    range.on('input', function(){
      // jQuery(this).parent().parent().parent().find('.hss_range_slider_value').html(this.value+'px');
      jQuery(this).prev().html(this.value+'px');
    });
  });
};rangeSlider();

/* jQuery(document).ready(function(){
	jQuery( '.zebra_tooltips' ).tooltip({
	    position: {
			my: "center bottom-20",
			at: "center top",
			using: function( position, feedback ) {
			  jQuery( this ).css( position );
			  jQuery( "<div>" )
				.addClass( "arrow" )
				.addClass( feedback.vertical )
				.addClass( feedback.horizontal )
				.appendTo( this );
			}
		  }
	});
}); */