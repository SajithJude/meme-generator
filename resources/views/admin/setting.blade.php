@extends('layouts.default')
@section('title')
    Dashboard
@endsection

@section('body')
<?php ?>

<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-body">
    @if (Session::has('success_message'))
    <div class="alert alert-success alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Well done!</strong>
        {{ Session::get('success_message') }}
    </div>
@endif
@if (Session::has('error_message'))
    <div class="alert alert-danger alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Error!</strong> {{ Session::get('error_message') }}

    </div>
@endif
@if ($errors->any())
    <div class="alert alert-success alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
@endif
     
    <form action="{{url('/admin/setting')}}" id="content_form" method="post" enctype="multipart/form-data">
      @csrf

    <div class="row">
        <div class="form-group col-md-12">            
              <label class="form-control-label">Promo Video <span class="required">*</span></label>
              <input type="text" class="form-control" name="promo_video_link" 
                   value="<?=isset($setting->promo_video_link)?$setting->promo_video_link : ''?>" maxlength="255" required />
            <label class="error" for="promo_video_link"></label>
                  
          
        </div>

    </div>
    <div class="row">
        <div class="form-group col-md-12">            
              <label class="form-control-label">Free Signup Content <span class="required">*</span></label>
              <input type="text" class="form-control" name="free_sign_up" 
                   value="<?=isset($setting->free_sign_up)?$setting->free_sign_up : ''?>" maxlength="255" required />
            <label class="error" for="free_sign_up"></label>
                  
          
        </div>

    </div>
    <div class="row">
        <div class="form-group col-md-12">            
              <label class="form-control-label">Contact Email <span class="required">*</span></label>
              <input type="email" class="form-control" name="contact_email" 
                   value="<?=isset($setting->contact_email)?$setting->contact_email : ''?>" maxlength="255" required/>
            <label class="error" for="contact_email"></label>
                  
          
        </div>

    </div>

    <div class="row">
        <div class="form-group col-md-12">            
              <label class="form-control-label">Instragram <span class="required">*</span></label>
              <input type="text" class="form-control" name="instagram" 
                   value="<?=isset($setting->instagram)?$setting->instagram : ''?>" maxlength="255" required />
            <label class="error" for="instagram"></label>
                  
          
        </div>

    </div>

    <div class="row">
        <div class="form-group col-md-12">            
              <label class="form-control-label">Facebook <span class="required">*</span></label>
              <input type="url" class="form-control" name="facebook" 
                   value="<?=isset($setting->facebook)?$setting->facebook : ''?>" required/>
            <label class="error" for="facebook"></label>
                  
          
        </div>

    </div>

    <div class="row">
        <div class="form-group col-md-12">            
              <label class="form-control-label">Tik Tok <span class="required">*</span></label>
              <input type="url" class="form-control" name="tiktok" 
                   value="<?=isset($setting->tiktok)?$setting->tiktok : ''?>" required/>
            <label class="error" for="tiktok"></label>
                  
          
        </div>

    </div>

    <div class="row">
        <div class="form-group col-md-12">            
              <label class="form-control-label">LinkedIn <span class="required">*</span></label>
              <input type="url" class="form-control" name="linkedin" 
                   value="<?=isset($setting->linkedin)?$setting->linkedin : ''?>" />
            <label class="error" for="linkedin"></label>
                  
          
        </div>

    </div>

    
    <div class="row">
        <div class="form-group col-md-12"> 
            <button type="submit" class="btn btn-primary pull-right">Save</button>
    </div>

    </div>

      </form>
      <br>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script type="text/javascript">
    

    function readFile(input, id) {    
              
      var file_name = input.files[0].name;
      var extension = (input.files[0].name).split('.').pop();
      var allowed_extensions = ["mp4"];
      var fsize = input.files[0].size;
      
      if (input.files && input.files[0]) {
  
          if ($.inArray(extension, allowed_extensions) == -1) {
              toastr.error("Video format mismatch");
              return false;
          } else if(fsize > 1048576*300) {
              toastr.error("Video size exceeds");
              return false;
          } 
          $('.input-group-file input').attr('value', file_name);
          
      }
  }
  $(document).ready(function()
  { 
      $('#course_video').on('change', function () { 
         alert();
          imageId = $(this).data('id'); 
          tempFilename = $(this).val();
          readFile(this, $(this).attr('id')); 
      });
  });
</script>

@endsection

