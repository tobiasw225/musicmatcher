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
	function sleep(time) {
		return new Promise((resolve) => setTimeout(resolve, time));
	}


	$('#reset-marker-btn').click(function() {
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
	$('#submit_marker').click(function() {

		var is_title_page = ($('#title_check').prop('checked'));
		var is_sheet_music = 0;
		var ad_count = $("input[type=range]#ad_count").val();
		var sm_count = $("input[type=range]#sm_count").val();
		
		if (sm_count > 0) {
			// not nec. since > 1 == true, just for to make things clear
			// is_sheet_music should become sm_count in db
			is_sheet_music = 1;
		}
		console.log(sm_count);
		console.log(ad_count);
		var res_id = $('#dbpic').attr('key');
		// collects all tags
		var tags = [];
		$("#myselectedtags span.tags").each(function() {
			tags.push($(this).text());
		});
		bootbox.alert({
			message : "Vielen Dank. Die Daten werden eingefügt und du kannst einfach beim nächsten Bild weitermachen.",
			backdrop : true,
		});

		$.post("php/receive.php", {
			is_title_page : is_title_page,
			is_sheet_music : is_sheet_music,
			sm_count: sm_count,
			ad_count: ad_count,
			res_id : res_id
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
	
	
	// handle sliders
	$(document).on('change', "input[type=range]", function(event) {
		var newval=$(this).val();
		$(this).next('span').text(newval);
	});
	
	// pdf viewer
	/*
	 - * change viewport-scale to zoom in
	 * - theoretisch könnte man die pdfs auch ganz lassen,
	 * allerdings wollen wir die dateien vielleicht ja auch so haben, dass wir Sachen markieren können.
	 * 
	 */
	// Initialize and load the PDF
	/*
	function showPDF(pdf_url) {
		PDFJS.disableWorker = true;
		PDFJS.getDocument(url).then(function getPdfHelloWorld(pdf) {

			pdf.getPage(1).then(function getPageHelloWorld(page) {
				var scale = 2.0;
				var viewport = page.getViewport(scale);

				var canvas = document.getElementById('the-canvas');
				var context = canvas.getContext('2d');
				canvas.height = viewport.height;
				canvas.width = viewport.width;

				page.render({
					canvasContext : context,
					viewport : viewport
				});
			});
		});
		
	}*/
   		var pageNum = 1;
         var pdfScale = 1; // make pdfScale a global variable
         var shownPdf; // another global we'll use for the buttons
	      var url = 'test_files/res/bub_gb_1UMvAAAAMAAJ_Page_0x2ddf.pdf';

         function renderPage(page) {
            var scale = pdfScale; // render with global pdfScale variable
            var viewport = page.getViewport(scale);
            var canvas = document.getElementById('the-canvas');
            var context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            var renderContext = {
               canvasContext: context,
               viewport: viewport
            };
            page.render(renderContext);
         }

         function displayPage(pdf, num) {
            pdf.getPage(num).then(function getPage(page) { renderPage(page); });
         }

         var pdfDoc = PDFJS.getDocument(url).then(function getPdfHelloWorld(pdf) {
            displayPage(pdf, 1);
            shownPdf = pdf;
         });





	$('#the-canvas').mousedown(function(event) {
		switch (event.which) {
		case 1:
			pdfScale = pdfScale + 0.25;
			displayPage(shownPdf, pageNum);
			break;
		case 3:
			if (pdfScale <= 0.25) {
				return;
			}
			pdfScale = pdfScale - 0.25;
			displayPage(shownPdf, pageNum);
			break;
		default:
			alert('You have a strange Mouse!');
		}
	}); 







});
