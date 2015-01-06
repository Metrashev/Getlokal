<script type="text/javascript">
            var _error_message = "<?php print __("Please enter content in the field.",null, 'company');?>";

            var _default_caption_content = "<?php print __("Video Title",null, 'company');?>";
            var _default_description_content = "<?php print __("Video Description",null, 'company');?>";

            var _default_filename_content= "";
            var _please_wait_message = "<?php print __("Your video is being uploaded. Please do not close this page and wait until the process of uploading has completed and you have seen a confirmation message. If you close the page the process will be interrupted and your video will not be successfully uploaded!",null, 'company');?>";
            var _video_caption_length_error = "<?php print __("The title of the video must contain between 8 and 99 characters",null, 'company');?>";
            var _video_description_length_error = "<?php print __("The description of the video must contain between 20 and 240 characters",null, 'company');?>";
            var _video_filename_error = "<?php print __("Please select a video for uploading!",null, 'company');?>";
            var _video_file_format_error = "<?php print __("You tried to upload a file that is not in the allowed format for video files. Please upload a video file.",null, 'company');?>";
        var _submit_without_file_error = "<?php print __("Choose a video file from your computer and enter information in the mandatory fields below.",null, 'company');?>";
        var _submit_with_file_error = "<?php print __("Please enter information in the mandatory fields below.",null, 'company');?>";
        var _slug="<?php echo $company->getSlug();?>";
         var _form  = null;
            var formValidateObj = null;
        function _setFileError(error_content,removeError)
        {
            removeError = typeof(removeError) != 'undefined' ? removeError : false;
        if(removeError && $(".reg_msg_fail").length > 0)
        {
            $(".reg_msg_fail").remove();
            return;
        }
        else if(removeError)
        {
            return;
        }
        if($(".reg_msg_fail").length > 0)
        {
            $(".reg_msg_fail").html(error_content);
            return; 
        }
        var _form  = $("#videouploader_toked_id").attr("form");
        $(_form).prepend("<div class='reg_msg_fail'>"+error_content+"</div>");  
        }
        /************************************************************
             * Here we will render clips image, title and description
             * @author Georgi Naumov
             * gonaumov@gmail.com for contacs and sugestions
             ************************************************************/
        function __changeYoutobeVideo(video_id)
            {
                var youtobe_player_video_holder = document.getElementById("youtobe_player_video_holder");
                youtobe_player_video_holder.loadVideoById(video_id);
            }
            function handleSetFirstCompleted(response)
            {
                if(typeof response.responseText != 'undefined' && /:"([0-9]+)"/.test(response.responseText))
                {
                    var _updatedId = "mdef"+RegExp.$1;
                    $('[id^="mdef"]').not('#'+_updatedId).show("slow");
                    $('#'+_updatedId).hide("slow");
                }
            }
            function initGetlokalVideohandlers(){
                $("#video_caption,#video_description,#video_filename").bind('click keydown blur change focus',function(){
                _setFileError('',true);
                    if($.inArray($(this).attr("value"),[_default_caption_content,
                                  _default_description_content],
                                  _default_filename_content) != -1)
                    {
                        $(this).attr("value","");
                    }
                    $(this).css("color","black");
                    $(this).css("font-size","12px");
                    $(this).css("font-style","normal");
                });
                window.videoFormHasError = false;
                $("#video_caption").val(_default_caption_content);
                $("#video_description").val(_default_description_content);
                $("#video_filename").val(_default_filename_content);
                /********************************************************
                 * Check if there is successfull uploaded video
                 * and show success
                 ********************************************************/

                var _cookieValue = parseInt($.cookie("videouploadprocessset"));
                if(_cookieValue == 1)
                {
                    var _successMessage = "<?php print __("The video was successfully uploaded.");?>";
                    $("#success_message_holder").show();
                    $("#success_message_holder").html('<p>'+_successMessage+'</p><br/>');
                    var expires = "";
                    var _days = -1;
                    document.cookie = "videouploadprocessset="+_days+expires+"; path=/";    
                }
                else
                {
                    $("#success_message_holder").hide();
                };
                /******************************************
                 * Check title .. I hope don't rewrite
                 * again .. 
                 ******************************************/
                 $("#video_caption").bind('blur',function(){
                    if($(this).val() == "" || $(this).val() == _default_caption_content)
                    {
                    	$(this).parent().addClass('error');
                        $("#video_caption_error").html(_error_message);
                        window.videoFormHasError = true;
                    }
                    else if($(this).val().length < 8 || $(this).val().length > 99)
                    {
                    	$(this).parent().addClass('error');
                        $("#video_caption_error").html(_video_caption_length_error);
                        window.videoFormHasError = true;
                    }
                    else
                    {
                    	$(this).parent().removeClass('error');
                        $("#video_caption_error").html("");    
                    }  
                });
                 $("#video_description").bind('blur',function(){
                     if($(this).val() == "" || $(this).val() == _default_description_content)
                     {
                         $(this).parent().addClass('error');
                         $("#video_description_error").html(_error_message);
                         window.videoFormHasError = true;
                     }
                     else if($(this).val().length < 20 || $(this).val().length > 244)
                     {
                    	 $(this).parent().addClass('error');
                         $("#video_description_error").html(_video_description_length_error);
                         window.videoFormHasError = true;
                     }
                     else
                     {
                    	 $(this).parent().removeClass('error');
                         $("#video_description_error").html("");    
                     }  
                 });
                $("#video_filename").bind('blur change',function(){
                 _setFileError('',true);
                    if($(this).val() == "")
                    {
                    	$(this).parent().addClass('error');
                        $("#file_error_message").html(_video_filename_error);
                         window.videoFormHasError = true;
                    }
                    else if(/(?:\.webm|\.mpeg4|\.mpg|\.3gpp|\.mov|\.avi|\.mpegps|\.wmv|\.flv|\.mp4)$/i.test($(this).val()) == false)
                    {
                    	$(this).parent().addClass('error');
                        $("#file_error_message").html(_video_file_format_error);
                        window.videoFormHasError = true;
                    }
                    else
                    {
                    	$(this).parent().removeClass('error');
                        $("#file_error_message").html("");
                    }
                });
                _form = $(document.getElementsByTagName("FORM").item(0));
                var _url = window.location.href;
                var _video_caption = $("#video_caption").attr("value");
                var _video_description = $("#video_description").attr("value");
                $("#video_caption").attr("maxlength",99);
                $("#video_description").attr("maxlength",240);
               $("#formsubmit").click(function(event){
            	  
            	   var validationResult =  handleSumbitProcess(event);
               if (validationResult)
               {
            	   $("#loading-image").show();
               }
              
                  if(validationResult == false)
                  {
                      
                        event.preventDefault();
                        return false;
                  }
                 try {
                 
                   if($("#videouploader_toked_id").val() == "")
                   {
                        var _url = /(http:\/\/[^\/]+\/)/i.test(window.location.href) ? RegExp.$1 : '';
                      
                        generateYoutobeToken();
                       
                   }
           var formObj = _form.get(0);
                   formObj.submit();
                   return true;
                 }
                 catch(ex)
                 {}
               });
            }

            
            function handleSumbitProcess(event)
            {
            	//return true;
                window.videoFormHasError = false;
              

                if($("#video_filename").val() == _default_filename_content )
                {
                $("#video_filename").css("border","2px solid red");   
                    $("#file_error_message").html(_video_filename_error);
                    window.videoFormHasError = true;
                   _setFileError(_submit_without_file_error); 
                }
                else if(/(?:\.webm|\.mpeg4|\.mpg|\.3gpp|\.mov|\.avi|\.mpegps|\.wmv|\.flv|\.mp4)$/i.test($("#video_filename").val()) == false)
                {
                $("#video_filename").css("border","2px solid red"); 
                    $("#file_error_message").html(_video_file_format_error);
                    window.videoFormHasError = true;
                    _setFileError(_submit_without_file_error);
                }
                else
                {
                   $("#video_filename").css("border","1px solid #CCCCCC"); 
                    $("#file_error_message").html("");
                }                

                if($("#video_caption").val() == "" || $("#video_caption").val() == _default_caption_content)
                {
            $("#video_caption").css("border","2px solid red");
                    $("#video_caption_error").html(_error_message);
                    window.videoFormHasError = true;
                }
                else if($("#video_caption").val().length < 8 || $("#video_caption").val().length > 99)
                {
                 $("#video_caption").css("border","2px solid red");
                     $("#video_caption_error").html(_video_caption_length_error);
                     window.videoFormHasError = true;
                }
                else
                {
                $("#video_caption").css("border","1px solid #CCCCCC");    
                    $("#video_caption_error").html("");    
                } 
               
                if($("#video_description").val() == "" || $("#video_description").val() == _default_description_content)
                {
                $("#video_description").css("border","2px solid red");  
                    $("#video_description_error").html(_error_message);
                     window.videoFormHasError = true;
                }
                else if($("#video_description").val().length < 20)
                {
                 $("#video_caption").css("border","2px solid red");
                     $("#video_description_error").html(_video_description_length_error);
                     window.videoFormHasError = true;
                }else if($("#video_description").val().length > 240)
                {
                    $("#video_caption").css("border","2px solid red");
                        $("#video_description_error").html(_video_description_length_error);
                        window.videoFormHasError = true;
                }
                else
                {
                $("#video_description").css("border","1px solid #CCCCCC"); 
                    $("#video_description_error").html("");    
                }
                
                if(window.videoFormHasError == true)
                {
                 if($("#file_error_message").html() == "")
                 {
                   _setFileError(_submit_with_file_error);
                 }
                    return false;
                }
            
                $.cookie("videouploadprocessset",1,{path: '/'});
              
                return true;
            }
            function generateYoutobeToken()
            { 
                 var _video_caption_content = $("#video_caption").attr("value");
                 var _video_description_content = $("#video_description").val();
                 var _url = window.location.href;
                 
                 _url = _url.replace(/(?:#|\?videoid=[0-9]+)$/,"");
                 _url = _url + "?generate_youtube_token=1&videotitle="+_video_caption_content+"&videodescription="+_video_description_content+"&slug="+_slug;
                 $.ajax({
                    type: "GET",
                    url: _url,
                    async: false,
                    success: function(data) {
                    /****************************************
                     * Find the form wrap video title
                     * input
                     ****************************************/
                    document.getElementById("videouploader_toked_id").value = data.token;
                    var _form = document.getElementById("videouploader_toked_id").parentNode;
                    _url = _url.replace("generate_youtube_token=1&","");
                    _url = _url + "&slug="+_slug;
                    var _urlAction = data.url+"?nexturl="+window.location.href.replace(/\?.+$/,"");
                    _form.method = "post";
                    _form.action = _urlAction;                  
                    }
                  });
                
            }
           $(document).ready(function() {
        	  
                initGetlokalVideohandlers();
            });
           $(window).load(function() {
        	   jQuery('#loading-image').hide();
        	 });
</script>