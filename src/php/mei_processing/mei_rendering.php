<!DOCTYPE html>
<head>
    <title>Example with omr</title>
    <!--/////////////////////-->
    <!-- The Verovio toolkit -->
    <!--/////////////////////-->
    <script src="http://www.verovio.org/javascript/develop/verovio-toolkit.js" type="text/javascript" ></script>
    <!--////////////////////-->
    <!-- We also use jQuery -->
    <!--////////////////////-->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript" ></script>
</head>
<body>
<!--//////////////////////////////////////////////-->
<!-- The div where we are going to insert the SVG -->
<!--//////////////////////////////////////////////-->
<div id="svg_output"/>

<script type="text/javascript">

    ///////////////////////////
    /* Create the vrvToolkit */
    ///////////////////////////
    var vrvToolkit = new verovio.toolkit();

    ////////////////////////////////////
    /* Load the file using a HTTP GET */
    ////////////////////////////////////
    $.ajax({
        url: "http://localhost/musicmatcher/src/Input_files/Example_1.xml"
        , dataType: "text"
        , success: function(data) {
            var svg = vrvToolkit.renderData(data, {});
            console.log("---------" + svg.toString());
            $("#svg_output").html(svg);
        }
    });
</script>
</body>

</html>
