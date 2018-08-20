$(function(){
    $("#sidebar").load("http://127.0.0.1:8000/Input_files/test_html/ersch.html", function () {
        alert("Load was performed.");
    });

});

function edit_content() {
    add_attr();
    console.log( document.getElementsByClassName("ocr_line"));
    document.getElementsByClassName("ocr_line").contentEditable = true;

    
}

function add_attr() {

    console.log("in add_attr function");
    var ocr_line_elements =  document.getElementsByClassName("ocr_line");
    console.log(document.getElementsByClassName("ocr_line").length);
    for (var i = 0; i < ocr_line_elements.length; i++) {
             console.log("in loop add_attr");
             console.log(ocr_line_elements.length);
             ocr_line_elements[i].setAttribute("onmouseover", "mouse_over(this)");
             ocr_line_elements[i].setAttribute("onmouseout", "mouse_out(this)");

    }


}