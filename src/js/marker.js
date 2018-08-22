$(function() {
	//$(".xzoom").xzoom();

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
	$('#submit_marker').click(function() {

		var is_title_page = ($('#title_check').prop('checked'));
		var is_sheet_music = 0;
		var ad_count = $("input[type=range]#ad_count").val();
		var sm_count = $("input[type=range]#sm_count").val();


		//console.log(sm_count);
		//console.log(ad_count);
		var res_id = $('#dbpic').attr('key');
		// collects all tags

		var tags = [];
		$(".has-items div").each(function() {
			tags.push($(this).text());
		});
		bootbox.alert({
			message : "Vielen Dank. Die Daten werden eingefügt und du kannst einfach beim nächsten Bild weitermachen.",
			backdrop : true,
		});

		$.post("php/db_funcs.php", {
			is_title_page : is_title_page,
			sm_count : sm_count,
			ad_count : ad_count,
			res_id : res_id,
			tags : tags,
			insert_meta : 1
		}).done(function(data, textStatus, jqXHR) {
			// syntax-fehler werden fälschlicherweise angezeigt.
			
			sleep(sleep_time).then(() => {
				location.reload();
			});

		}).fail(function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		});

	});

	/**
	 * tag-input
	 */

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
	$(document).on('change', "input[type=range]", function(event) {
		var newval = $(this).val();
		$(this).next('span').text(newval);
	});

});
