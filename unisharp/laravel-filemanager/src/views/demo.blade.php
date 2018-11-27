<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Laravel Filemanager</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<style>
.overlay{
  width: 100%;
    height: 100%;
    background: #b19c9cfc;
    opacity: 0.5;

}
</style>
<body id="elbody">
  <div class="container">
    <h1 class="page-header">Database Restore</h1>
    <a href="{{ url('/logout') }}">Login</a>
    <div class="row">
    <div class="alert alert-success" id="success-alert" hidden>
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Success! </strong>
        Database is restored successfully.
    </div>
      <div class="col-md-6 col-md-offset-3">
                  <form id="restoreform">
                  <input type='hidden' name='_token' value='{{csrf_token()}}'>
              <div class="form-group">
                <label for="exampleFormControlSelect1">File</label>
                <select class="form-control" id="filename" name="filename">
                  @foreach($items as $items)
                  <option value="{{$items}}">{{$items}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="exampleFormControlSelect1">Database</label>
                <select class="form-control" id="dbname" name="dbname">
                  @foreach($dbases as $db)
                  <option value="{{$db->datname}}">{{$db->datname}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="exampleFormControlSelect1">Role</label>
                <select class="form-control" id="role" name="role">
                  @foreach($roles as $roles)
                  <option value="{{$roles->rolname}}">{{$roles->rolname}}</option>
                  @endforeach
                </select>
              </div>
              <button type="button" class="btn btn-primary" id="restore">Restore</button>
            </form>
       </div>        
    </div>
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <h2>File Manger Launcher</h2>
        <div class="input-group">
          <span class="input-group-btn">
            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
              <i class="fa fa-picture-o"></i> Open
            </a>
          </span>
        </div>
        <img id="holder" style="margin-top:15px;max-height:100px;">
      </div>
    </div>
  </div>

  <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="messageModalLabel">Response</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
          <textarea id="bashoutput" rows="15" cols="66">
          </textarea>
          </div>
          <div class="modal-footer">
            
          </div>
        </div>
      </div>
    </div>

  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script>
   var route_prefix = "{{ url(config('lfm.prefix')) }}";
  </script>

  <script src="http://malsup.github.com/jquery.form.js"></script> 


<script src="{{ asset('/vendor/unisharp/laravel-filemanager/js/lfm.js') }}"></script>
  
  <script>
    $('#lfm').filemanager('files', {prefix: route_prefix});
  </script>
  <script>
    $(function(){
      $('#restore').on('click',function(){
        $('#lfm').attr('disabled',true);
        $('#restore').attr('disabled',true);
        $('#elbody').addClass('overlay');
        $('#loading-image').show();
        $("#restoreform").ajaxSubmit({
            url: '/laravel-filemanager/restoredb', 
            type: 'post',
            // success:function(data){
            //   debugger;
            //   $('#loading-image').hide();
            //   $('#elbody').removeClass('overlay');
            //   $('.modal-backdrop').remove();
            //   $('#messageModal').modal('show');
            //   $("#bashoutput").val(data.data);
            //   $('#lfm').attr('disabled',false);
            //   $('#restore').attr('disabled',false);
            // },
            complete:function(data){
              $('#lfm').attr('disabled',false);
              $('#restore').attr('disabled',false);
              $('#loading-image').hide();
              $('#elbody').removeClass('overlay');
              $('.modal-backdrop').remove();
              if(data.responseJSON.data==""){
                $("#success-alert").show();
              }
              else{
                $("#success-alert").hide();
                $('#messageModal').modal('show');
                $("#bashoutput").val(data.responseJSON.data);
              }
            }
            })
      });
     
    });
  </script>
<img src="/img/loading.gif" id="loading-image" alt="Smiley face" height="100" width="100" style="margin-left: 603px;margin-top: -271px;z-index: 0;position: absolute;" hidden>

</body>
</html>
