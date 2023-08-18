@extends('layouts.default')
@section('title')
    Dashboard
@endsection

@section('body')
<?php //dd($data);?>

<div class="app-content content">
    <div class="content-wrapper">

        <div class="content-body">
              <form action="javascript:;" id="setting" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="">Content type</label>
                   <select name="type" id="type" required class="form-control">
                      <option disabled selected>Select Content type</option>
                      <option value="PP">Privacy Policy</option>
                      <option value="TC">Terms Of Service</option>
                      <option value="CP">Cookie Policy</option>                          
                  </select>
                </div>
                <div class="box mb-3">
                    <textarea name="contenttext" id="editor" class="form-control"></textarea>
                </div>
                <div id="error" class="error"></div>
                <div id="msg"></div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
              <br>
                
        </div>
        </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="{{ asset('backend/curriculum/js/plugins/tinymce/jscripts/tiny_mce/tiny_mce.js') }}"></script>
<script type="text/javascript">

    $(document).ready(function()
    { 
        // tinymce.init({ 
        //     selector:'textarea',
        //     menubar:false,
        //     statusbar: false,
        //     content_style: "#tinymce p{color:#76838f;}"
        // });
        tinymce.init({  
        mode : "specific_textareas",
        selector : "textarea",
        theme : "advanced",
        theme_advanced_buttons1 : "bold,italic,underline",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        width : "100%",
        plugins : "paste",
        paste_text_sticky : true,
        setup : function(ed) {
          ed.onInit.add(function(ed) {
            ed.pasteAsPlainText = true;
          });
        }
      });
    });
</script>
    
<script>
    
    $(document).ready(function(){
        console.log('load content page');
      
      $('form#setting').on('submit', function(event) {
            event.preventDefault();
            var form_check = true;
            var type = $("#type option:selected").val();
            console.log(type);
            var text = tinymce.activeEditor.getContent(); 
           
            var errors = [];
            
            if(text ==''){
                  $("#editor").parent().addClass("has-error");
                  errors.push('Please enter text.');
                  form_check = false;
            }else{
                $("#editor").parent().removeClass("has-error");
            }

            if(type ==''){
                  $("#content_type").parent().addClass("has-error");
                  errors.push('Please select content type');
                  form_check = false;
            }else{
                $("#content_type").parent().removeClass("has-error");
            }
            if(form_check){
                //prj.App.showAlerts("#offer_messages","error","","hide");
                $("div#error").css('display:none');
                formdata = new FormData(this);
                var serviceresponse = prj.content.save(formdata);
            }else{
                $("div#error").css('display:block');
                $("div#error")('<i class="icon-report"></i>'+errors[0]);
            }
        });
      $('form#setting #type').on('change', function(event) {
            
            event.preventDefault();
            var type = $("#type option:selected").val();
            tinymce.activeEditor.setContent('');
            prj.content.list(type);
            
        });
    });


  </script>
  <script type="text/javascript">
    var prj = prj || {};
    prj.content = (function() {
   
    var dataApiUrl = "<?= url('/admin/')?>" ;
    console.log(dataApiUrl);

    var list = function(filter_by_type) {        
        var pageurl = "/getContent";

        var content_type = filter_by_type;       

        var jsonData = {            
            type: filter_by_type,           
            deviceType: 'web'
        }

        var request = $.ajax({
            url: dataApiUrl + pageurl,
            data: jsonData,
            type: 'GET',
            dataType: 'json'
            //,
            // headers: {
            //     "Authorization": "Bearer " + dataTokenGet
            // },
        });


        request.done(function(data) {

            if (data.response.code == 200) { 
                //console.log(data.response); 
                //CKEDITOR.instances.editor.setData('');
                console.log(typeof(data.response.data.contenttext));
                if(typeof(data.response.data.contenttext) != "undefined")
                    tinymce.activeEditor.setContent(data.response.data.contenttext);
                    
                else
                    tinymce.activeEditor.setContent('');

            }
        });

    };
    var save = function(formData) { 
        //alert("aaa");              
        var request = $.ajax({
            url: dataApiUrl + '/content/add',
            data: formData,
            type: 'POST',
            processData: false,
            contentType: false,
            dataType: 'json',
            // headers: {
            //     "Authorization": "Bearer " + dataTokenGet
            // },
        });
        request.done(function(data) {
            if (data.response.code == 200) {                         

                $msgDiv = '<div class="alert alert-success"><strong>Success!</strong>'+data.response.messages[0] +'</div>';
                container = $('div#msg'); 
                container.empty();
                container.append($msgDiv);
                container.show();                
                setTimeout(function(){
                    container.hide();                                      
                    }, 2000);
                
            }
        });

        request.fail(function(jqXHR, textStatus) {
            //alert("failed");
            var jsonResponse = $.parseJSON(jqXHR.responseText);

            var html = '';
            for (var i in jsonResponse.error.messages) {
                html += jsonResponse.error.messages[i];
            }
            $msgDiv = '<div class="alert alert-danger"><i class="icon-report"></i>' + html + '</div>';
            container = $('div#msg');
            container.empty();
            container.append($msgDiv);
            $(container).show();
            setTimeout(function() {
                $(container).hide();
                }, 1000);
                
             });


    };

    return {
        list: list,       
        save: save,       
    };
}());


  </script>
@endsection

