/**
 * @author Tobias Wenzel
 */

$(function() {
	


	var current_img_path = "";

	// init tooltips
	$('.tooltip').tooltipster({
		theme : 'tooltipster-punk'
	});


	function load_filenames (path){
					$.post("php/receive.php", {
							path: path
					}).done(function(data, textStatus, jqXHR) {
						var files = JSON.parse("[" + data + "]")[0];
						var rand_index = Math.floor(Math.random() * files.length)   ;
						var abs_filename = files[rand_index].replace("../res", "res");
						init_cs_js_with_picture(abs_filename);
						
					}).fail(function(jqXHR, textStatus, errorThrown) {
						alert(errorThrown);
					});
	}// end-of-function
	
	load_filenames('../res');
	
	function init_with_db_image (){
					$.post("db_funcs.php", {
							init_image: 1
					}).done(function(data, textStatus, jqXHR) {
							init_cs_js_with_picture(data);
					}).fail(function(jqXHR, textStatus, errorThrown) {
						alert(errorThrown);
					});
	}// end-of-function
	//init_with_db_image();
	

		


	// currently not used. could be reused for cropping advertisement.
	// js in cropper.js
	/*	
	$('#sendtoomr').click(function() {
		if (current_img_path.length) {
			console.log(current_img_path);
			$.post("php/omr_processing.php", {
				proc_image : current_img_path
			}).done(function(data, textStatus, jqXHR) {
				$("#myresponse").html(data);
				// reset current_img_path
				current_img_path = "";
				//alert("success");
				//location.href = 'note_correction.php';
			}).fail(function(jqXHR, textStatus, errorThrown) {
				alert(errorThrown);
			});
		}
	});
	*/




});
