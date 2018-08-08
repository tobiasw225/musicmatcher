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

    var selectedElement, offset;

    function getMousePostion(evt) {
        var CTM = svg.getScreenCTM();
        return {
          x: (evt.clientX - CTM.e) / CTM.a,
          y: (evt.clientY - CTM.f) / CTM.d
        };
    }

    function startDrag(evt) {

        selectedElement = evt.target;
        console.log("startDrag", selectedElement);
        offset = getMousePostion(evt);
        offset.x -= parseFloat(selectedElement.getAttributeNS(null, "x"));
        offset.y -= parseFloat(selectedElement.getAttributeNS(null, "y"));

    }

    function drag(evt) {
        console.log("function_drag");
        if (selectedElement){
            evt.preventDefault();
            var coord = getMousePostion(evt);
            selectedElement.setAttributeNS(null, "x", coord.x - offset.x);
            selectedElement.setAttributeNS(null, "y", coord.y - offset.y);

        } else {
            console.log("selected element is null!!!");
        }

    }

    function endDrag(evt) {
        selectedElement = null;
    }
}

