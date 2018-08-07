///////////////////////////
/* Create the vrvToolkit */
///////////////////////////
var vrvToolkit = new verovio.toolkit();

////////////////////////////////////
/* Load the file using a HTTP GET */
////////////////////////////////////
$.ajax({
    url: "http://172.17.0.2/Input_files/Example_from_omr.xml"
    , dataType: "text"
    , success: function (data) {
        var svg = vrvToolkit.renderData(data, {});
        //  console.log("---------" + svg.toString());
        $("#svg_output").html(svg);
        set_attribute(svg);

    }
});

function set_attribute(svg) {
    var svg_header = document.getElementsByTagName("svg")[0];
    var ns = "http://www.w3.org/2000/svg";
    svg_header.setAttributeNS(ns, "onload", "makeDraggable(evt)");
    console.log("svg_header", svg_header);

}

function makeDraggable(evt){
    var svg_event = evt.target;
    svg_event.addEventListener("mousedown", startDrag);
    svg_event.addEventListener("mousemove", drag);
    svg_event.addEventListener("mouseup", endDrag);
    svg_event.addEventListener("mouseleave", endDrag);
}