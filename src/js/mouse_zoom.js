var f = function () {

    var button_zoom_in = document.getElementById("button_zoom_in");
    var button_zoom_out = document.getElementById("button_zoom_out");
    var imageElement = document.getElementById("image_element");

    var width, height, ration, curLeft, curTop;
    var zoom = 50;

    function set_values() {
        console.log("-------set_values");
        console.log("image_element", imageElement);
        console.log("width", window.getComputedStyle(imageElement, null).getPropertyValue("width"));
        console.log("height", window.getComputedStyle(imageElement, null).getPropertyValue("height"));
        console.log("left", window.getComputedStyle(imageElement, null).getPropertyValue("left"));
        console.log("top", window.getComputedStyle(imageElement, null).getPropertyValue("top"));
        width = parseInt(window.getComputedStyle(imageElement, null).getPropertyValue("width"));
        height = parseInt(window.getComputedStyle(imageElement, null).getPropertyValue("height"));
        ration = height / width;
        curLeft = parseInt(window.getComputedStyle(imageElement, null).getPropertyValue("left"));
        curTop = parseInt(window.getComputedStyle(imageElement, null).getPropertyValue("top"));

    }

    function zoom_in(event) {
        console.log("zoom_in function");
        set_values();
        imageElement.style.width = width + (zoom * ration) + "px";
        imageElement.style.height = height + (zoom * ration) + "px";
        imageElement.style.left = curLeft - ((zoom * ration) / 2) + "px";
        imageElement.style.top = curTop - ((zoom * ration) / 2) + "px";

        event.preventDefault();
    }

    function zoom_out(event) {
        console.log("zoom_out function");
        set_values();
        imageElement.style.width = width - (zoom * ration) + "px";
        imageElement.style.height = height - (zoom * ration) + "px";
        imageElement.style.left = curLeft + ((zoom * ration) / 2) + "px";
        imageElement.style.top = curTop + ((zoom * ration) / 2) + "px";

        event.preventDefault();

    }

    button_zoom_out.addEventListener("click", zoom_out, false);
    button_zoom_in.addEventListener("click", zoom_in, false);
};

window.addEventListener("load", f, false);