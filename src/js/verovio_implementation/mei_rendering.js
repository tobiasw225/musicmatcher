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
        set_attribute();

    }
});

function set_attribute() {

    var svg_header = document.getElementsByTagName("svg")[0];
    svg_header.setAttributeNS(null, "onload", "makeDraggable(evt)");
    console.log("element_note", svg_header);

}

function makeDraggable(evt) {

    var svg = evt.target;
    svg.addEventListener('mousedown', startDrag);
    svg.addEventListener('mousemove', drag);
    svg.addEventListener('mouseup', endDrag);

    var selectedElement;

    function startDrag(evt) {

        selectedElement = evt.target;
        console.log("startDrag", selectedElement);

    }

    function drag(evt) {
        console.log("function_drag");
        if (selectedElement){
            evt.preventDefault();
            var x = parseFloat(selectedElement.getAttributeNS(null, "x"));
            //console.log("x= ", x);
            if (x) {
                console.log("zaschliv x =", x);
                selectedElement.setAttributeNS(null, "x", x + 100);
            }

        } else {
            console.log("selected element is null!!!");
        }

    }

    function endDrag(evt) {
        selectedElement = null;
    }
}

