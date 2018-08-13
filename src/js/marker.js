$(function() {
	
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
	function sleep (time) {
	  return new Promise((resolve) => setTimeout(resolve, time));
	}



	$('#reset-marker-btn').click(function(){
		$('#title_check').prop('checked', false);
		$('#sm_check').prop('checked', false);
		$('#ad_check').prop('checked', false);
		$("#taginput").val('');
		$("#myselectedtags span.tags").each(function() {
			$(this).remove();
		});
	});

	/**
	 * used to submit tags + markers 
	 */
	$('#submit_marker').click(function(){

		var is_title_page = ($('#title_check').prop('checked'));
		var is_sheet_music = ($('#sm_check').prop('checked'));
		var res_id = $('#dbpic').attr('key');
		// collects all tags 
		var tags = [];
		$("#myselectedtags span.tags").each(function() {
			tags.push($(this).text());
		});
		if (is_sheet_music) { 

			
			$.post("php/receive.php", {
				is_title_page : is_title_page,
				is_sheet_music : is_sheet_music,
				res_id : res_id,
				tags : tags
			}).done(function(data, textStatus, jqXHR) {
				bootbox.alert({
				    message: "Vielen Dank. Im nächsten Schritt darfst du die Noten ausschneiden.",
				    backdrop: true,
				});
				// syntax-fehler werden fälschlicherweise angezeigt.
				sleep(sleep_time/4).then(() => {
				location.href = 'crop_notes.php';
				});
			}).fail(function(jqXHR, textStatus, errorThrown) {
				alert(errorThrown);
			});
		} else {
			
			bootbox.alert({
				    message: "Vielen Dank. Die Daten werden eingefügt und du kannst einfach beim nächsten Bild weitermachen.",
				    backdrop: true,
			});
			
			$.post("php/receive.php", {
				is_title_page : is_title_page,
				is_sheet_music : is_sheet_music,
				res_id : res_id
			}).done(function(data, textStatus, jqXHR) {
			// syntax-fehler werden fälschlicherweise angezeigt.
			sleep(sleep_time).then(() => {
							 location.reload();
			});
			
			}).fail(function(jqXHR, textStatus, errorThrown) {
				alert(errorThrown);
			});
		}
	});

	/**
	 * tag-input
	 */
	$(document).on('click', "#tagsearch span.tags", function(event) {
		$(this).prependTo($('#myselectedtags'));
	});
	
	$(document).on('click', "#myselectedtags span.tags", function(event) {
		$(this).prependTo($('#tagsearch'));
	});


	$("#taginput").keydown(function(event) {

		if ((event.keyCode === whitespace) || (event.keyCode === enter)) {
			// bei leerzeichen | enter füge hinzu
			tag = $(this).val().toLowerCase();			
			var tag_span = $(document.createElement("span"));
			tag_span.text(tag);
			tag_span.addClass('tags');
			$(tag_span).prependTo($("#tagsearch"));
			$(this).val('');
		} else {
			$.post("db_funcs.php", {
				tag_like : $(this).val()
			}).done(function(data, textStatus, jqXHR) {
				$("#tagsearch span.tags").each(function() {
				$(this).remove();
				});
				$('#tagsearch').prepend(data);
			
			}).fail(function(jqXHR, textStatus, errorThrown) {
				alert(errorThrown);
			});
			
		}

	});
	// end-of-taglistener


});
