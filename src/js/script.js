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
						// not sure if that's possible
				
						var files = JSON.parse("[" + data + "]")[0];
						var rand_index = Math.floor(Math.random() * files.length)   ;
						//console.log(files.length);
						console.log(files[rand_index]);
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
						// not sure if that's possible
							init_cs_js_with_picture(data);
						
					}).fail(function(jqXHR, textStatus, errorThrown) {
						alert(errorThrown);
					});
	}// end-of-function

	//init_with_db_image();
	
	function init_cs_js_with_picture(path){
		$('#crop-select').CropSelectJs({
		//
		// Initialise CropSelect
		//
		imageSrc : path,
		// What to do when the selected area is resized
		selectionResize : function(data) {
			$('#scaled-width').html(data.widthScaledToImage);
			$('#scaled-height').html(data.heightScaledToImage);
		},
		// What to do when the selected area is moved
		selectionMove : function(data) {
			$('#scaled-x').html(data.xScaledToImage);
			$('#scaled-y').html(data.yScaledToImage);
		}
	});
		
	}


	
	//$('#crop-select').CropSelectJs('disableAnimatedBorder');




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

	$('#cropmypicture').click(function() {
		// get data from picture
		var x = $('#crop-select').CropSelectJs('getSelectionBoxX');
		var y = $('#crop-select').CropSelectJs('getSelectionBoxY');
		var width_scaled = $('#crop-select').CropSelectJs('getSelectionBoxWidth');
		var height_scaled = $('#crop-select').CropSelectJs('getSelectionBoxHeight');

		var original_height = $(".crop-image")[0].height;
		var original_width = $(".crop-image")[0].width;

		var scale_factor = $(".crop-image")[0].naturalWidth / original_width;

		var src = $('#crop-select').CropSelectJs('getImageSrc');

		var width = width_scaled * scale_factor;
		var height = height_scaled * scale_factor;

		x = x * scale_factor;
		y = y * scale_factor;
		// send it to receive.php for cropping

		$.post("php/receive.php", {
			x : x,
			y : y,
			width : width,
			height : height,
			src : src
		}).done(function(data, textStatus, jqXHR) {
			$("#myresponse").html(data);
			// set src for further processing
			current_img_path = src;
			$("#resdivwrapper").prop('title', 'you deserve a cookie. but just one!');
			console.log("done cropping");
		}).fail(function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		});
	});

	$('#select-all-btn').click(function() {
		$('#crop-select').CropSelectJs('selectEverything');
	});





});
