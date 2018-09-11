


function save_content() {
    delete_attr();
    var a = document.body.appendChild(document.createElement("a"));
    a.download = "export.html";
    a.href = "data:text/html," + document.getElementById("sidebar").innerHTML;
    a.click();
    
}

	function save_hocr() {
		var res_id = $("#image_element").attr('key');
		var path = $("#sidebar").attr('href');
		var hocr = document.getElementById("sidebar").innerHTML;
		$.post("http://localhost:8000/php/db_funcs.php", {
			save_hocr : 1,
			res_id : res_id,
			hocr: hocr,
			path: path
		}).done(function(data, textStatus, jqXHR) {
			console.log(data);
			//// load new hocr. this has to be tested. leave it out for now. 
			//$("#sidebar").load(data, function () {});
		}).fail(function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		});
	}



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
        console.log("in loop true");
        ocr_line_elements[i].setAttribute("onmouseover", "mouse_over(this)");
        ocr_line_elements[i].setAttribute("onmouseout", "mouse_out(this)");


    }
}

function delete_attr(){
    var ocr_line_elements = document.getElementsByClassName("ocr_line");
    for (var i = 0; i < ocr_line_elements.length; i++) {
        console.log("in loop false");
        ocr_line_elements[i].removeAttribute("onmouseover");
        ocr_line_elements[i].removeAttribute("onmouseout");
        ocr_line_elements[i].setAttribute("contenteditable", "false");
 //        ocr_line_elements[i].style.backgroundColor = "White";

    }

}


function mouse_over(element) {
    console.log("in mouse_over");
    element.setAttribute("contenteditable", "true");
    element.style.backgroundColor = "lightblue";
}


function mouse_out(element) {
    console.log("in mouse out");
    element.style.backgroundColor = "#ECF5E4";

}