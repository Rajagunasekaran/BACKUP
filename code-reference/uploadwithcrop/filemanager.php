<div id="wrap-index">
  <!-- Login header nav !-->
  <?php echo $topHeader;?>
  <div class="container" id="home">
	<div class="row">
		<div>
			<div class="col-xs-3 aligncenter">
				<a href="<?php echo URL::base(TRUE).'dashboard/index'; ?>" title="Back">
					<i class="fa fa-caret-left iconsize"></i>
				</a>
			</div>
			<div class="col-xs-6 aligncenter centerheight">
				<a href="javascript:void(0);" title="Images" data-toggle="modal" data-target="#imgeditormodel" class="img_mgr edit-img cboxElement">File Manager</a>
			</div>
		</div>
	</div>
	<br>
  </div>
  <div id="imgeditormodel" class="modal fade" role="dialog">
	  <div class="modal-dialog modal-lg model-editor">
		<!-- Modal content-->
  		<div class="modal-content aligncenter">
  		  <div class="modal-header" style="border-bottom:0">
  			<button type="button" class="close" onclick="$('#search-workplan').val('')" data-dismiss="modal">&times;</button>
  			<h4 class="modal-title">Image Editor</h4>
  		  </div>
  		  <div class="modal-body">
  			<form action="#" method="post">
  				<div class="aligncenter" style="margin: 0 auto 0 auto">	

            <!-- Content -->
            <div class="image-editor">
              <div class="row">
                <div class="col-md-9">
                  <!-- <h3 class="page-header">Demo:</h3> -->
                  <div class="img-container">
                    <img id="image" src="" alt="Import Picture">
                  </div>
                </div>
                <div class="col-md-3">
                  <!-- <h3 class="page-header">Preview:</h3> -->
                  <div class="docs-preview clearfix">
                    <div class="img-preview preview-lg"></div>
                    <div class="img-preview preview-md"></div>
                    <div class="img-preview preview-sm"></div>
                    <div class="img-preview preview-xs"></div>
                  </div>

                  <!-- <h3 class="page-header">Data:</h3> -->
                  <div class="docs-data">
                    <div class="input-group input-group-sm">
                      <label class="input-group-addon" for="dataX">X</label>
                      <input type="text" class="form-control" id="dataX" placeholder="x">
                      <span class="input-group-addon">px</span>
                    </div>
                    <div class="input-group input-group-sm">
                      <label class="input-group-addon" for="dataY">Y</label>
                      <input type="text" class="form-control" id="dataY" placeholder="y">
                      <span class="input-group-addon">px</span>
                    </div>
                    <div class="input-group input-group-sm">
                      <label class="input-group-addon" for="dataWidth">Width</label>
                      <input type="text" class="form-control" id="dataWidth" placeholder="width">
                      <span class="input-group-addon">px</span>
                    </div>
                    <div class="input-group input-group-sm">
                      <label class="input-group-addon" for="dataHeight">Height</label>
                      <input type="text" class="form-control" id="dataHeight" placeholder="height">
                      <span class="input-group-addon">px</span>
                    </div>
                    <div class="input-group input-group-sm">
                      <label class="input-group-addon" for="dataRotate">Rotate</label>
                      <input type="text" class="form-control" id="dataRotate" placeholder="rotate">
                      <span class="input-group-addon">deg</span>
                    </div>
                    <div class="input-group input-group-sm">
                      <label class="input-group-addon" for="dataScaleX">ScaleX</label>
                      <input type="text" class="form-control" id="dataScaleX" placeholder="scaleX">
                    </div>
                    <div class="input-group input-group-sm">
                      <label class="input-group-addon" for="dataScaleY">ScaleY</label>
                      <input type="text" class="form-control" id="dataScaleY" placeholder="scaleY">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-9 docs-buttons">
                  <!-- <h3 class="page-header">Toolbar:</h3> -->
                  <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
                      <span class="docs-tooltip" data-toggle="tooltip" title="Move Tool">
                        <span class="fa fa-arrows"></span>
                      </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
                      <span class="docs-tooltip" data-toggle="tooltip" title="Crop Tool">
                        <span class="fa fa-crop"></span>
                      </span>
                    </button>
                  </div>

                  <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
                      <span class="docs-tooltip" data-toggle="tooltip" title="Zoom In">
                        <span class="fa fa-search-plus"></span>
                      </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
                      <span class="docs-tooltip" data-toggle="tooltip" title="Zoom Out">
                        <span class="fa fa-search-minus"></span>
                      </span>
                    </button>
                  </div>

                  <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
                      <span class="docs-tooltip" data-toggle="tooltip" title="Move Left">
                        <span class="fa fa-arrow-left"></span>
                      </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
                      <span class="docs-tooltip" data-toggle="tooltip" title="Move Right">
                        <span class="fa fa-arrow-right"></span>
                      </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
                      <span class="docs-tooltip" data-toggle="tooltip" title="Move Up">
                        <span class="fa fa-arrow-up"></span>
                      </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
                      <span class="docs-tooltip" data-toggle="tooltip" title="Move Down">
                        <span class="fa fa-arrow-down"></span>
                      </span>
                    </button>
                  </div>

                  <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
                      <span class="docs-tooltip" data-toggle="tooltip" title="Rotate Left">
                        <span class="fa fa-rotate-left"></span>
                      </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
                      <span class="docs-tooltip" data-toggle="tooltip" title="Rotate Right">
                        <span class="fa fa-rotate-right"></span>
                      </span>
                    </button>
                  </div>

                  <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                      <span class="docs-tooltip" data-toggle="tooltip" title="Flip Horizontal">
                        <span class="fa fa-arrows-h"></span>
                      </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
                      <span class="docs-tooltip" data-toggle="tooltip" title="Flip Vertical">
                        <span class="fa fa-arrows-v"></span>
                      </span>
                    </button>
                  </div>

                  <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="disable" title="Disable">
                      <span class="docs-tooltip" data-toggle="tooltip" title="Disable Tools">
                        <span class="fa fa-lock"></span>
                      </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="enable" title="Enable">
                      <span class="docs-tooltip" data-toggle="tooltip" title="Enable Tools">
                        <span class="fa fa-unlock"></span>
                      </span>
                    </button>
                  </div>
                  
                  <div class="btn-group">
                    <button type="button" class="btn btn-primary crop-btn" data-method="getCroppedCanvas" title="Crop">
                      <span class="docs-tooltip" data-toggle="tooltip" title="Crop">
                        <span class="fa fa-check"></span>
                      </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="clear" title="Clear">
                      <span class="docs-tooltip" data-toggle="tooltip" title="Clear">
                        <span class="fa fa-remove"></span>
                      </span>
                    </button>
                  </div>

                  <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
                      <span class="docs-tooltip" data-toggle="tooltip" title="Reset">
                        <span class="fa fa-refresh"></span>
                      </span>
                    </button>
                  </div>

                  <div class="uploadimage-dragndrop" id="dragndropimage">
                    <div class=""><span class="fa fa-upload fa-3x"></span></div>
                    <div class="uploadimage-text">Drag image here</div>
                  </div>

                  <div class="prefer-text">Or, if you prefer...</div>

                  <div class="btn-group">
                    <label class="btn btn-primary btn-upload" for="inputImage" title="Upload Image File">
                      <input type="file" class="sr-only" id="inputImage" name="file" accept="image/*">
                      <input type="hidden" id="inputImgName" name="inputImgName" value="">
                      <input type="hidden" id="imgid" name="imgid" value="">
                      <input type="hidden" id="hiddenid" name="hiddenid" value="">
                      <span class="docs-tooltip" data-toggle="tooltip" title="Upload Image File">
                        <span class="fa fa-upload"></span>&nbsp;&nbsp;Upload Image
                      </span>
                    </label>
                  </div>

                  <!-- Show the cropped image in modal -->
                  <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="getCroppedCanvasTitle">Cropped Image</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default">Close</button>
                          <a class="btn btn-primary" id="download" href="javascript:void(0);">Save &amp; Upload</a>
                        </div>
                      </div>
                    </div>
                  </div><!-- /.modal -->
                </div><!-- /.docs-buttons -->

                <div class="col-md-3 docs-toggles">
                  <!-- <h3 class="page-header">Toggles:</h3> -->
                  <div class="btn-group btn-group-justified" data-toggle="buttons">
                    <label class="btn btn-primary">
                      <input type="radio" class="sr-only" id="aspectRatio0" name="aspectRatio" value="1.7777777777777777">
                      <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 16 / 9">
                        16:9
                      </span>
                    </label>
                    <label class="btn btn-primary">
                      <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.3333333333333333">
                      <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 4 / 3">
                        4:3
                      </span>
                    </label>
                    <label class="btn btn-primary">
                      <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1">
                      <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 1 / 1">
                        1:1
                      </span>
                    </label>
                    <label class="btn btn-primary">
                      <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="0.6666666666666666">
                      <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 2 / 3">
                        2:3
                      </span>
                    </label>
                    <label class="btn btn-primary active">
                      <input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="NaN">
                      <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: NaN">
                        Free
                      </span>
                    </label>
                  </div>

                  <div class="btn-group btn-group-justified" data-toggle="buttons">          
                    <label class="btn btn-primary active">
                      <input type="radio" class="sr-only" id="viewMode2" name="viewMode" value="2">
                      <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
                        VM1
                      </span>
                    </label>
                    <label class="btn btn-primary">
                      <input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
                      <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 2">
                        VM2
                      </span>
                    </label>
                  </div>

                  <div class="dropdown dropup docs-options">
                    <button type="button" class="btn btn-primary btn-block dropdown-toggle" id="toggleOptions" data-toggle="dropdown" aria-expanded="true">
                      Toggle Options
                      <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="toggleOptions" role="menu">
                      <li role="presentation">
                        <label class="checkbox-inline">
                          <input type="checkbox" name="responsive" checked>
                          responsive
                        </label>
                      </li>
                      <li role="presentation">
                        <label class="checkbox-inline">
                          <input type="checkbox" name="restore" checked>
                          restore
                        </label>
                      </li>
                      <li role="presentation">
                        <label class="checkbox-inline">
                          <input type="checkbox" name="checkCrossOrigin" checked>
                          checkCrossOrigin
                        </label>
                      </li>
                      <li role="presentation">
                        <label class="checkbox-inline">
                          <input type="checkbox" name="checkOrientation" checked>
                          checkOrientation
                        </label>
                      </li>

                      <li role="presentation">
                        <label class="checkbox-inline">
                          <input type="checkbox" name="modal" checked>
                          modal
                        </label>
                      </li>
                      <li role="presentation">
                        <label class="checkbox-inline">
                          <input type="checkbox" name="guides" checked>
                          guides
                        </label>
                      </li>
                      <li role="presentation">
                        <label class="checkbox-inline">
                          <input type="checkbox" name="center" checked>
                          center
                        </label>
                      </li>
                      <li role="presentation">
                        <label class="checkbox-inline">
                          <input type="checkbox" name="highlight" checked>
                          highlight
                        </label>
                      </li>
                      <li role="presentation">
                        <label class="checkbox-inline">
                          <input type="checkbox" name="background" checked>
                          background
                        </label>
                      </li>

                      <li role="presentation">
                        <label class="checkbox-inline">
                          <input type="checkbox" name="autoCrop" checked>
                          autoCrop
                        </label>
                      </li>
                      <li role="presentation">
                        <label class="checkbox-inline">
                          <input type="checkbox" name="movable" checked>
                          movable
                        </label>
                      </li>
                      <li role="presentation">
                        <label class="checkbox-inline">
                          <input type="checkbox" name="rotatable" checked>
                          rotatable
                        </label>
                      </li>
                      <li role="presentation">
                        <label class="checkbox-inline">
                          <input type="checkbox" name="scalable" checked>
                          scalable
                        </label>
                      </li>
                      <li role="presentation">
                        <label class="checkbox-inline">
                          <input type="checkbox" name="zoomable" checked>
                          zoomable
                        </label>
                      </li>
                      <li role="presentation">
                        <label class="checkbox-inline">
                          <input type="checkbox" name="zoomOnTouch" checked>
                          zoomOnTouch
                        </label>
                      </li>
                      <li role="presentation">
                        <label class="checkbox-inline">
                          <input type="checkbox" name="zoomOnWheel" checked>
                          zoomOnWheel
                        </label>
                      </li>
                      <li role="presentation">
                        <label class="checkbox-inline">
                          <input type="checkbox" name="cropBoxMovable" checked>
                          cropBoxMovable
                        </label>
                      </li>
                      <li role="presentation">
                        <label class="checkbox-inline">
                          <input type="checkbox" name="cropBoxResizable" checked>
                          cropBoxResizable
                        </label>
                      </li>
                      <li role="presentation">
                        <label class="checkbox-inline">
                          <input type="checkbox" name="toggleDragModeOnDblclick" checked>
                          toggleDragModeOnDblclick
                        </label>
                      </li>
                    </ul>
                  </div><!-- /.dropdown -->
                </div><!-- /.docs-toggles -->
              </div>
            </div>
  				</div>
  			</form>
  		  </div>
  		  <div class="modal-footer" style="border-top:0">
  			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
  		  </div>
  		</div>
	  </div>
  </div>
  
  <script type="text/javascript">

  $(function () {

    $(document).on('click','#download',function(){
      var imgdata='';
      imgdata = $(this).attr('data-cropped');
      var filename = $('#inputImgName').val();
      var imgname = filename.split('.');
      UploadPic(imgdata,imgname[0]);
    });

    function UploadPic(dataurl,filename) {  
      $.ajax({
        type: 'POST',
        url: "<?php echo URL::site('exercise/upload'); ?>",
        data: {"imgData": dataurl,"imgName":filename},
        success: function (msg) {
          var msgval=JSON.parse(msg);
          if(msgval[0]==1){
            var imgid = $('#imgid').val();
            var hiddenid = $('#hiddenid').val();            
            if( msgval[1] != '' && imgid != '' && hiddenid != '' ){
              $('#'+imgid).attr('src','/assets/uploads/fileupload/'+msgval[1]);
              $('#'+hiddenid).val(msgval[1]);
            }
            $('#getCroppedCanvasModal').modal('hide');
            $('#download').attr('data-cropped','');
            alert('Image saved successfully!');
          }
          else{
            alert('Your upload triggered the error')
          }
        }
      });
    }

    $(document).on('click','#getCroppedCanvasModal button', function() {
      $('#getCroppedCanvasModal').modal('hide');
      $('#download').attr('data-cropped','');
    });
    
    $( document ).ready(function() {
      var imgscr = $('#image').attr('src');
      if(!imgscr){
        $('.crop-btn').prop('disabled', true);
      }
    });
    
  });

</script>