<!doctype html>
<html>

<head>
    <style>
        .links a {
            padding-left: 10px;
            margin-left: 10px;
            border-left: 1px solid #000;
            text-decoration: none;
            color: #999;
        }
        .links a:first-child {
            padding-left: 0;
            margin-left: 0;
            border-left: none;
        }
        .links a:hover {text-decoration: underline;}
        .column-left {
            display: inline;
            float: left;
        }
        .column-right {
            display: inline;
            float: right;
        }
    </style>
    <!-- In production, only one script (pdf.js) is necessary -->
    <!-- In production, change the content of PDFJS.workerSrc below -->
    <script src="pdf.js-master/src/shared/util.js"></script>
    <script src="pdf.js-master/src/display/api.js"></script>
    <script src="pdf.js-master/src/display/metadata.js"></script>
    <script src="pdf.js-master/src/display/canvas.js"></script>
    <script src="pdf.js-master/src/display/webgl.js"></script>
    <script src="pdf.js-master/src/display/pattern_helper.js"></script>
    <script src="pdf.js-master/src/display/font_loader.js"></script>
    <script src="pdf.js-master/src/display/annotation_helper.js"></script>

    <script src="http://parall.ax/parallax/js/jspdf.js"></script>
    <script src="http://code.jquery.com/jquery-1.5.2.min.js" type="text/javascript" ></script>
    <script src="jqScribble/jquery.jqscribble.js" type="text/javascript"></script>
    <script src="jqScribble/jqscribble.extrabrushes.js" type="text/javascript"></script>
    <script>
        // Specify the main script used to create a new PDF.JS web worker.
        // In production, leave this undefined or change it to point to the
        // combined `pdf.worker.js` file.
        PDFJS.workerSrc = 'pdf.js-master/src/worker_loader.js';
    </script>
    <script>
        'use strict';
        PDFJS.disableWorker = true;
        PDFJS.getDocument('generated_pdf/image_name4.pdf').then(function(pdf) {
            // Using promise to fetch the page

            pdf.getPage(1).then(function(page) {
                var scale = 1.1;
                var viewport = page.getViewport(scale);
                //
                // Prepare canvas using PDF page dimensions
                //
                var canvas = document.getElementById('test');
                var context = canvas.getContext('2d');
                var img=context.getImageData(0, 0, canvas.width, canvas.height);
                context.putImageData(img,canvas.width,canvas.height);
                canvas.width = canvas.width;
                canvas.height = canvas.height;
                //
                // Render PDF page into canvas context
                //
                var renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                page.render(renderContext);
            });
        });

    </script>
</head>

<body>
<script>
    function save()
    {
        $("#test").data("jqScribble").save(function(imageData)
        {
            if(confirm("This will write a file using the example image_save.php. Is that cool with you?"))
            {
                $.post('image_save.php', {imagedata: imageData}, function(response)
                {
                    $('body').append(response);
                });
            }
        });
    }
    function addImage()
    {
        var img = prompt("Enter the URL of the image.");
        if(img !== '')$("#test").data("jqScribble").update({backgroundImage: img});
    }

    function savepdf()
    {
        var canvas = document.getElementById('test');
        var imgData = canvas.toDataURL("image/png", 1.0);
        var pdf = new jsPDF();
        pdf.addImage(imgData, 'JPEG', 0, 0);
        pdf.save('file.pdf');
    }
    $(document).ready(function()
    {
        $("#test").jqScribble();
    });
</script>
<table  style="height: 200px" width="700" id="ARE_tbl_paintbox">
    <tr>
        <td width="153"><label id="ARE_lbl_paint">PAINT</label></td>
        <td>
            <div style="overflow: hidden; margin-bottom: 5px;">
                <div class="column-left links">
                    <strong>BRUSHES:</strong>
                    <a href="#" onclick='$("#test").data("jqScribble").update({brush: BasicBrush});'>Basic</a>
                    <a href="#" onclick='$("#test").data("jqScribble").update({brush: DotBrush});'>Dot</a>
                </div>
                <div class="column-right links">
                    <strong>COLORS:</strong>
                    <a href="#" onclick='$("#test").data("jqScribble").update({brushColor: "rgb(0,0,0)"});'>Black</a>
                    <a href="#" onclick='$("#test").data("jqScribble").update({brushColor: "rgb(255,0,0)"});'>Red</a>
                    <a href="#" onclick='$("#test").data("jqScribble").update({brushColor: "rgb(0,255,0)"});'>Green</a>
                    <a href="#" onclick='$("#test").data("jqScribble").update({brushColor: "rgb(0,0,255)"});'>Blue</a>
                </div>
            </div>
            <canvas id="test" style="border: 1px solid gray;" width="500" height="200"></canvas>
<!--            <canvas id="test" width=500 height=200 style='width:500px;height:200px;border: 1px solid gray;'></canvas>-->
<!--            <div id="test" style="border: 1px solid gray;position:relative; width:500px; height:200px; background-color:#7a7a7a; "><canvas style="border: 1px solid gray;" width="500" height="200"></canvas></div>-->
            <div class="links" style="margin-top: 5px;">
                <strong>OPTIONS:</strong>
                <a href="#" onclick='$("#test").data("jqScribble").clear();'>Clear</a>
                <a href="#" onclick='$("#test").data("jqScribble").save();'>Save</a>
                <a href="#" onclick='savepdf();'>Save PDF</a>
            </div>
        </td>
    </tr>
</table>
</body>

</html>