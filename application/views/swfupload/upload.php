<!DOCTYPE html>
<html>
<head>
<title>上传</title>
<link href="/resource/swfupload/css/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/resource/swfupload/swf/swfupload.js"></script>
<script type="text/javascript" src="/resource/swfupload/swf/swfupload.queue.js"></script>
<script type="text/javascript" src="/resource/swfupload/js/fileprogress.js"></script>
<script type="text/javascript" src="/resource/swfupload/js/handlers.js"></script>
<script type="text/javascript">
		var swfu;

		window.onload = function() {
			var settings = {
				flash_url : "/resource/swfupload/swf/swfupload.swf",
				flash9_url : "/resource/swfupload/swf/swfupload_fp9.swf",
				upload_url: "/swfupload/uploadfileform",
				post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},
				file_size_limit : "1024 MB",
				file_types : "*.rar;*.flv;*.swf;*.gif;*.wmv;*.7z;*.zip;*.rar;*.jpg;*.png;*.xls;*.xlsx;*.doc;*.docx;*.pdf;*.ppt;*.pptx;*.mp3;*.mp4;*.avi;*.rm;*.rmvb;*.mov;*.m4a;*.3gp;*.wma",
				file_types_description : "All Files",
				file_upload_limit : 1,
				file_queue_limit : 0,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				debug: false,

				// Button settings
				button_image_url: "/resource/swfupload/images/TestImageNoText_65x29.png",
				button_width: "65",
				button_height: "29",
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text: '<span class="theFont">上传</span>',
				button_text_style: ".theFont { font-size: 16; }",
				button_text_left_padding: 12,
				button_text_top_padding: 3,

				// The event handler functions are defined in handlers.js
				swfupload_preload_handler : preLoad,
				swfupload_load_failed_handler : loadFailed,
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	// Queue plugin event
			};

			swfu = new SWFUpload(settings);
	     };

        function uploadSuccess(file, serverData) {
          try {
            var progress = new FileProgress(file, this.customSettings.progressTarget);
            var zfc=serverData.indexOf("&");
            window.parent.document.getElementById("<?=$fileid?>").value=serverData.substring(9,zfc);
            window.parent.document.getElementById("<?=$fileinfo?>").value=serverData.substring(zfc+1);
            progress.setComplete();
            progress.setStatus("上传完成.");
            progress.toggleCancel(false);

          } catch (ex) {
            this.debug(ex);
          }
        }
	</script>
</head>
<body>


<div id="content">

	<form id="form1" action="index.php" method="post" enctype="multipart/form-data">
		
			<div class="fieldset flash" id="fsUploadProgress">
			<span class="legend">源文件</span>
			</div>
			<div>
				<span id="spanButtonPlaceHolder"></span>
				<input id="btnCancel" type="button" value="取消" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
			</div>

	</form>
</div>
</body>
</html>

