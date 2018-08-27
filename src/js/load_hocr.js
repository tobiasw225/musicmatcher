$(function() {

	function get_rand_hocr(res_id) {
		// post request -> will be with 
		
		
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
        	alert("Load was performed.");
    	});
	}
	var res_id = 0;
	get_rand_hocr(res_id);
	

});

