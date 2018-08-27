/*$(function () {
    $("#sidebar").load("http://127.0.0.1:8000/Input_files/test_html/ersch.html", function () {
        alert("Load was performed.");
    });


});*/
$(function() {

	function get_hocr(res_id) {

		$.post("http://localhost:8000/php/db_funcs.php", {
			get_hocr : 1,
			res_id : res_id
		}).done(function(data, textStatus, jqXHR) {
			console.log(data);
			load_hocr(data);
		}).fail(function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		});

	}
	// has to be in function to be called after post (without promise)
	function load_hocr(url){
		$("#sidebar").load(url);
	}
	// post request -> 0 ~ random hocr 
	var res_id = 0;
	get_hocr(res_id);
	

});




function edit_content() {
    add_attr();
    console.log(document.getElementsByClassName("ocr_line"));
    document.getElementsByClassName("ocr_line").contentEditable = true;
}

function add_attr() {

    console.log("in add_attr function");
    var ocr_line_elements = document.getElementsByClassName("ocr_line");
    console.log(ocr_line_elements.length);
    for (var i = 0; i < ocr_line_elements.length; i++) {
        console.log("in loop add_attr");
        console.log(ocr_line_elements[i]);
        ocr_line_elements[i].setAttribute("onmouseover", "mouse_over(this)");
        ocr_line_elements[i].setAttribute("onmouseout", "mouse_out(this)");

    }


}

function mouse_over(element) {
  console.log("in mouse_over");
  element.setAttribute("contenteditable","true");
  element.style.backgroundColor = "lightblue";
}


function mouse_out(element) {
  console.log("in mouse out");
    element.style.backgroundColor = "#ECF5E4";

}