$(function() {

	/**
	 * Everything concerning tags, and marking res.
	 */
	
	// key-map
	rightclick = 3;
	leftclick = 1;
	middleclick = 2;

	enter = 13;
	hash_tag = 191;
	whitespace = 32;
	backspace = 8;
	delete_key = 46;

	// sleep time expects milliseconds
	var sleep_time = 5000;
	function sleep(time) {
		return new Promise((resolve) => setTimeout(resolve, time));
	}


	$('#reset-marker-btn').click(function() {
		$('#title_check').prop('checked', false);
		$('#sm_check').prop('checked', false);
		$('#ad_check').prop('checked', false);
		$("#taginput").val('');
		//$(".has-items div").remove();
	});

	/**
	 * used to submit tags + markers
	 */
	
	function submit_markers(){
				var is_title_page = ($('#title_check').prop('checked'));
		var is_sheet_music = 0;
		var ad_count = $("input[type=range]#ad_count").val();
		var sm_count = $("input[type=range]#sm_count").val();


		var res_id = $('#image_element').attr('key');
		// collects all tags
		var tags = [];
		$(".has-items div").each(function() {
			tags.push($(this).text());
		});
		$.post("php/db_funcs.php", {
			is_title_page : is_title_page,
			sm_count : sm_count,
			ad_count : ad_count,
			res_id : res_id,
			tags : tags,
			insert_meta : 1
		}).done(function(data, textStatus, jqXHR) {

		}).fail(function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		});
		
	}
	
	$('#continue_with_ocr_btn').click(function() {
		var res_id = $('#dbpic').attr('key');
		bootbox.alert({
			message : "...Weiter gehts mit OCR. Viel Spaß!",
			backdrop : true,
		});
		
		submit_markers();

		$.post("php/text_correction.php", {
			res_id : res_id
		}).done(function(data, textStatus, jqXHR) {
		// give the message above some time to load. 
		sleep(sleep_time/2).then(() => {
			window.location = "http://localhost:8000/php/text_correction.php";
		});
			
			
		}).fail(function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		});

	});
	
	
	$('#stay_on_marker_page_btn').click(function() {
		
		bootbox.alert({
			message : "Vielen Dank! Du kannst einfach beim nächsten Bild weitermachen.",
			backdrop : true,
		});
		submit_markers();
		
		sleep(sleep_time/2).then(() => {
			location.reload();
		});
	});
	
	/**
	 * tag-input
	 */

	function get_associated_tags () {
		var res_id = $("#image_element").attr('key');
		$.post("http://localhost:8000/php/db_funcs.php", {
			get_associated_tags : 1,
			res_id: res_id
		}).done(function(data, textStatus, jqXHR) {
			if (data.length) {
				$("#res_has_tags").html();
				$("#res_has_tags").html("Diese Begriffe wurden bis jetzt damit verbunden:<br />"+data);
			}
		}).fail(function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		});
	}
	
	get_associated_tags();

	function init_selectize_tag_search() {
		$.post("http://localhost:8000/php/db_funcs.php", {
			get_all_tags : 1
		}).done(function(data, textStatus, jqXHR) {
			fill_selectize(data);

		}).fail(function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		});

	}

	function fill_selectize(tags_string) {
		var options = [];
		var tags = tags_string.trim().split(' ');
		var tag_num = tags.length;

		for (var i = 0; i < tag_num; i++) {
			options.push({
				id : i,
				tag : tags[i]
			});
		}
		$('#select-tags').selectize({
			maxItems : null,
			maxOptions : 100,
			valueField : 'id',
			labelField : 'tag',
			searchField : 'tag',
			sortField : 'tag',
			options : options,
			create : false
		});
	}

	init_selectize_tag_search();

	// handle sliders
	var max_val = 10;
	$(document).on('change', "input[type=range]", function(event) {
		var newval = $(this).val();
		if (parseInt(newval)>= 10) {
			$(this).next('span').text('>10');
		} else {
			$(this).next('span').text(newval);

		}
	});

});
