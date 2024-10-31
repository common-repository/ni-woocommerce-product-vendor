//alert(niwoopv_ajax_object.niwoopv_ajaxurl);
// JavaScript Document
jQuery(function($){
	$( "#frm_niwoopv_setting" ).submit(function( event ) {
		$(".niwoopv_ajax_content").html("Please wait...");
		event.preventDefault();
		$.ajax({
			
			url:niwoopv_ajax_object.niwoopv_ajaxurl,
			data: $(this).serialize(),
			success:function(data) {
				//alert(JSON.stringify(data));
				$(".niwoopv_ajax_content").html(data);
			},
			error: function(errorThrown){
				console.log(errorThrown);
				//alert("e");
			}
		
		});
		
	});
	//$("#frm_niwoopv_setting").trigger("submit");
});
