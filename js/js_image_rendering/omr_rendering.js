(function($) {
    var Render = function(element, options)
    {
        var elem = $(element);
        var mei;
        var rendEng;
        var startTime;

        // These are variables which can be overridden upon instantiation
        var defaults = {
            debug: false,
            glyphpath: "",
            meipath: "",
            bgimgpath: "",
            bgimgopacity: 0.60,
            apiprefix: "",
            origwidth: null,
            origheight: null,
            dwgLib: "liber",
            width: 1000
        };

        var settings = $.extend({}, defaults, options);

        // These are variables which can not be overridden by the user
        var globals = {
            canvasid: "canvas"
        };

        $.extend(settings, globals);

        /******************************
         *      PUBLIC FUNCTIONS      *
         ******************************/
        // placeholder

        /******************************
         *      PRIVATE FUNCTIONS     *
         ******************************/
        var init = function() {
            // start time
            startTime = new Date();

            // initialize rendering engine
            rendEng = new Toe.View.RenderEngine();

            /*
             * Start asynchronous function calls
             * Get promises and wait for queued functions to finish
             * 1) load neume glyphs from svg file
             * 2) load MEI file from server
             * 3) load background image and get canvas dimensions from it
             * on success (all done): continue processing
             * on failure, print error message
             */
            $.when(loadGlyphs(rendEng),
                loadPage(),
                handleBackgroundImage()
            ).then(loadSuccess,
                function() {
                    console.log("Failure to load the mei file, glyphs, or background image");
                }
            );
        };

        var loadMeiPage = function(page) {
            // helper function to parse bounding box information
            function parseBoundingBox(zoneFacs) {
                var ulx = parseInt($(zoneFacs).attr("ulx"));
                var uly = parseInt($(zoneFacs).attr("uly"));
                var lrx = parseInt($(zoneFacs).attr("lrx"));
                var lry = parseInt($(zoneFacs).attr("lry"));

                var bb = $.map([ulx, uly, lrx, lry], function(b) {
                    return Math.round(page.scale*b);
                });

                return bb;
            };

            var surface = $(mei).find("surface")[0];
            var clefList = $("clef, sb", mei);
            // calculate sb indices in the clef list
            var clef_sbInd = new Array();
            $(clefList).each(function(cit, cel) {
                if ($(cel).is("sb")) {
                    clef_sbInd.push(cit);
                }
            });

            var neumeList = $("neume, sb", mei);
            // calculate sb indices in the neume list
            // precomputing will render better performance than a filter operation in the loops
            var neume_sbInd = new Array();
            $(neumeList).each(function(nit, nel)  {
                if ($(nel).is("sb")) {
                    neume_sbInd.push(nit);
                }
            });



            var custosList = $("custos, sb", mei);
            // calculate sb indices in the custos list
            var custos_sbInd = new Array();


            // for each system
            $("sb", mei).each(function(sit, sel) {
                if (settings.debug) {
                    console.log("system " + (sit+1));
                }

                // get facs data
                var sbref = $(sel).attr("systemref");
                var sysfacsid = $($(mei).find("system[xml\\:id=" + sbref + "]")[0]).attr("facs");
                var sysFacs = $(surface).find("zone[xml\\:id=" + sysfacsid + "]")[0];

                // create staff
                var s_bb = parseBoundingBox(sysFacs);
                if (settings.debug) {
                    rendEng.outlineBoundingBox(s_bb, {fill: "blue"});
                }

                // get id of parent layer
                var sModel = new Toe.Model.Staff(s_bb);
                sModel.setID($(sel).attr("xml:id"));

                // set global scale using staff from first system
                if (sit == 0) {
                    rendEng.calcScaleFromStaff(sModel, {overwrite: true});
                }

                // instantiate staff view and controller
                var sView = new Toe.View.StaffView(rendEng);
                var sCtrl = new Toe.Ctrl.StaffController(sModel, sView);
                page.addStaff(sModel);

                // load all clefs in the system
                $(clefList).slice(clef_sbInd[sit]+1, clef_sbInd[sit+1]).each(function(cit, cel) {
                    var clefShape = $(cel).attr("shape");
                    var clefStaffLine = parseInt($(cel).attr("line"));

                    // convert mei line attribute to staffPos attribute used in the internal clef Model
                    var staffPos = -(sModel.props.numLines - clefStaffLine) * 2;

                    var clefFacsId = $(cel).attr("facs");
                    var clefFacs = $(surface).find("zone[xml\\:id=" + clefFacsId + "]")[0];
                    var c_bb = parseBoundingBox(clefFacs);
                    if (settings.debug) {
                        rendEng.outlineBoundingBox(c_bb, {fill: "red"});
                    }


                });



                // load all divisions in the system
                $(divList).slice(div_sbInd[sit]+1, div_sbInd[sit+1]).each(function(dit, del) {
                    var divFacs = $(surface).find("zone[xml\\:id=" + $(del).attr("facs") + "]")[0];
                  console.log("division: " + dType);

                });


            });
            rendEng.repaint();
        };



        // asynchronous function
        var handleBackgroundImage = function() {
            console.log("loading background image ...");

        };

        // asynchronous function
        var loadPage = function() {
            var dfd = $.Deferred();

            if (settings.meipath) {
                $.get(settings.meipath, function(data) {
                    console.log("loading MEI file ...");

                    // save mei data
                    mei = data;

                    dfd.resolve();
                });
            }
            else {
                // immediately resolve
                dfd.resolve();
            }

            // return promise
            return dfd.promise();
        };

        // handler for when asynchronous calls have been completed
        var loadSuccess = function() {
            // create page

        };

        // Call the init function when this object is created.
        init();
    };


})(jQuery);