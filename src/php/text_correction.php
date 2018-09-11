<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    $_SESSION['user_name'] = 'guest';
    $_SESSION['user_id'] = 2;
    $_SESSION['user_points'] = 0;
}
include ('db_funcs.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Text correction</title>
    <script src="../js/vendor/jquery.js"></script>
    <script src="../js/add_image.js"></script>
    <script src="../js/load_hocr.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/pavel_zoom.css">
    <?php
    include('../html_snippets/header.php');
    ?>


</head>
<body>
<?php
include('../html_snippets/nav_bar.php');
?>


<div id="sidebar_header">

    <div id="sidebar"></div>
    <button onclick="edit_content()" id="edit_content" class="button">Edit Text</button>
    <button onclick="save_content()" id="save_content" class="button">Save Text</button>
</div>

<button id="button_zoom_in" class="button"> +</button>
<button id="button_zoom_out" class="button"> -</button>


<div id="image_header">
    <div id="image_header_tag">
        <!-- <img id="image_element" src="../Input_files/0001.bin.png" alt="wochenblat_image"> -->

        <!-- <img id="image_element" src="../Input_files/0001.bin.png" alt="wochenblat_image">-->
        <img id="image_element" alt="wochenblatt_image" <?php load_last_or_random(); ?>>


    </div>

</div>
</body>
<script src="../js/draggable_element.js"></script>
<script src="../js/mouse_zoom.js"></script>
</html>