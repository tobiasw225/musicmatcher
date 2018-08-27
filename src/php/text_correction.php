<?php 
session_start();
if (!isset($_SESSION['user_name'])){
	$_SESSION['user_name'] = 'guest';
	$_SESSION['user_id'] = 2;
	$_SESSION['user_points'] = 0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Text correction</title>
    <style type="text/css">
       /* body {
            margin: 0;
       }*/

        #sidebar, #image_header, #image_header_tag {
            position: absolute;
        }

		
        #image_header {
            padding: 10px;
        }


       /*
        #header {
            z-index: 4;
            height: 80px;
            background: lightslategray;
            border-bottom: 2px solid #7B5427;
        }

        #header h1 {
            z-index: 4
            padding: 20px;
            margin: 0;
        }
*/
        #sidebar {
            padding-top: 50px;
            padding-left: 20px;
            z-index: 3;
            width: 330px;
            background: #ECF5E4;
            border: 1px solid #231F20;
            overflow: scroll;
            top: 82px; /* Расстояние от верхнего края */

        }

        #image_header_tag {
            z-index: -1;
            top: -93px; /* Расстояние от верхнего края */
            left: 360px; /* Расстояние от левого края */
            bottom: 0;
            right: 0;
        }

        #image_element {
            position: absolute;
            width: 700px;
            height: 800px;
            left: 20px;
            top: -30px;
        }
        #button_zoom_in {
            margin-left: 1100px;
            margin-top: 0px;
            padding: 5px 10px;
        }

        #button_zoom_out {
            margin-left: 1100px;
            margin-top: 10px;
            padding: 5px 13px;
        }

        #edit_content {
            margin-left: 200px;
            margin-top: 10px;
            padding: 5px 13px;
        }

        .button {
            position: relative;
            z-index: 14;
            display: inline-block;
            /* padding: 35px 25px; */
            font-size: 24px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
        }

        .button:hover {
            background-color: #3e8e41
        }

        .button:active {
            z-index: 1	4;
            background-color: #3e8e41;
            box-shadow: 0 5px #666;
            transform: translateY(4px);
        }
    </style>
    <script src="../js/vendor/jquery.js"></script>
    <script src="../js/add_image.js"></script>
	<?php
		include ('../html_snippets/header.php');
		?>


</head>
<body>
		<?php
			include ('../html_snippets/nav_bar.php');
		?>


<div id="sidebar_header">

    <div id="sidebar"></div>
    <button onclick="edit_content()" id="edit_content" class="button">Edit Text</button>
</div>

<button id="button_zoom_in" class="button"> +</button>
<button id="button_zoom_out" class="button"> -</button>


<div id="image_header">
    <div id="image_header_tag">
        <img id="image_element" src="../Input_files/0001.bin.png" alt="wochenblat_image">

    </div>

</div>
</body>
<script src="../js/draggable_element.js"></script>
<script src="../js/mouse_zoom.js"></script>
</html>