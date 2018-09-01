$(function() {

	function get_hocr() {
		// since image is loaded first, just take it's key
		var res_id = $("#image_element").attr('key');
		console.log(res_id); 
		
		$.post("http://localhost:8000/php/db_funcs.php", {
			get_hocr : 1,
			res_id : res_id
		}).done(function(data, textStatus, jqXHR) {
			load_hocr(data);
		}).fail(function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		});
	}

	
	function load_hocr(url){
		$("#sidebar").load(url, function () {
        	//alert("Load was performed.");
    	});
	}

	get_hocr();


});

