$(function() {
	/**
	 * Everything concerning PDFs
	 */


	var pageNum = 1;
	var pdfScale = 1;
	var shownPdf;

	function renderPage(page) {
		var scale = pdfScale;
		// render with global pdfScale variable
		var viewport = page.getViewport(scale);
		var canvas = document.getElementById('the-canvas');
		var context = canvas.getContext('2d');
		canvas.height = viewport.height;
		canvas.width = viewport.width;
		var renderContext = {
			canvasContext : context,
			viewport : viewport
		};
		page.render(renderContext);
	}

	function displayPage(pdf, num) {
		pdf.getPage(num).then(function getPage(page) {
			renderPage(page);
		});
	}

	function init_pdf(pdf_url, pdf_id) {

		var pdfDoc = PDFJS.getDocument(pdf_url).then(function getPdfHelloWorld(pdf) {
			displayPage(pdf, 1);
			shownPdf = pdf;
		});
		$("#pdf-canvas").attr('key', pdf_id);

	}

	function load_rand_pdf_image_from_db() {
		/**
		 *
		 */
		$.post("db_funcs.php", {
			init_image : 1
		}).done(function(data, textStatus, jqXHR) {
			var res = data.split(',');
			var pdf_path = res[1].replace('.pdf', '');
			init_pdf(pdf_path, res[0]);

		}).fail(function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		});
	}

	//
	//load_rand_pdf_image_from_db();

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

});
