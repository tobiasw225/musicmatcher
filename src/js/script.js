/**
 * @author Tobias Wenzel
 */

$(function() {
	var current_img_path = "";
	
	// init tooltips
	$('.tooltip').tooltipster({
		    theme: 'tooltipster-punk'
	});
	
	/**
	 * load filenames with php?
	 * 
	 */
	function load_filenames (path){
		/**
		 * better: load database with pictures
		 */
					var filenames = [];
							$.post("receive.php", {
							path: path
					}).done(function(data, textStatus, jqXHR) {
						// not sure if that's possible
						filenames = data;
					}).fail(function(jqXHR, textStatus, errorThrown) {
						alert(errorThrown);
					});
	}
	console.log(load_filenames('res'));
	
				//
				// Initialise CropSelect
				//
				

				$('#crop-select').CropSelectJs({
					// Image
					// @todo how to select pic?
					imageSrc : 'res/0001.bin.png',
					
      
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

				$('#crop-select').CropSelectJs('disableAnimatedBorder');

/*

      // Handle file select change
      $('#file-input').on('change', function() {
        if (this.files && this.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#crop-select').CropSelectJs('setImageSrc', e.target.result);
          };
          reader.readAsDataURL(this.files[0]);
        }
      });*/

				// get auch ok und vllt sogar besser (?)
				$('#sendtoomr').click(function(){
					if (current_img_path.length){
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
					
					var scale_factor = $(".crop-image")[0].naturalWidth/original_width;
					
					var src = $('#crop-select').CropSelectJs('getImageSrc');
					
					var width = width_scaled*scale_factor;
					var height = height_scaled*scale_factor;
					
					x = x*scale_factor;
					y = y*scale_factor;

					//console.log(scale_factor);
					//console.log(width, height);				
					//console.log(x, y);
					console.log(src);
					// send it to receive.php for cropping
					$.post("receive.php", {
						x : x,
						y : y,
						width : width,
						height : height,
						src : src
					}).done(function(data, textStatus, jqXHR) {
						$("#myresponse").html(data);
						// set src for further processing
						current_img_path = src;
						$("#resdivwrapper").prop('title','you deserve a cookie. but just one!');
						console.log("done cropping");
					}).fail(function(jqXHR, textStatus, errorThrown) {
						alert(errorThrown);
					});
				});

				$('#select-all-btn').click(function() {
					$('#crop-select').CropSelectJs('selectEverything');
				});
				

			});
