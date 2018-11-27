<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=EDGE" />
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- Chrome, Firefox OS and Opera -->
  <meta name="theme-color" content="#75C7C3">
  <!-- Windows Phone -->
  <meta name="msapplication-navbutton-color" content="#75C7C3">
  <!-- iOS Safari -->
  <meta name="apple-mobile-web-app-status-bar-style" content="#75C7C3">

  <title>{{ trans('laravel-filemanager::lfm.title-page') }}</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/unisharp/laravel-filemanager/img/folder.png') }}">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('vendor/unisharp/laravel-filemanager/css/cropper.min.css') }}">
 
<link rel="stylesheet" href="{{ asset('/vendor/unisharp/laravel-filemanager/css/lfm.css') }}"> 
  <link rel="stylesheet" href="{{ asset('vendor/unisharp/laravel-filemanager/css/mfb.css') }}">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.css">
</head>
<style>
.overlay{
  width: 100%;
    height: 100%;
    background: #a4b2bb;
    opacity: 0.5;
}
</style>
<body id="elbody">
  <div class="container-fluid" id="wrapper">
    <div class="panel panel-primary hidden-xs">
      <div class="panel-heading">
        <h1 class="panel-title">{{ trans('laravel-filemanager::lfm.title-panel') }}</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-2 hidden-xs">
        <div id="tree"></div>
      </div>

      <div class="col-sm-10 col-xs-12" id="main">
        <nav class="navbar navbar-default" id="nav">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-buttons">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand clickable hide" id="to-previous">
              <i class="fa fa-arrow-left"></i>
              <span class="hidden-xs">{{ trans('laravel-filemanager::lfm.nav-back') }}</span>
            </a>
            <a class="navbar-brand visible-xs" href="#">{{ trans('laravel-filemanager::lfm.title-panel') }}</a>
          </div>
          <div class="collapse navbar-collapse" id="nav-buttons">
            <ul class="nav navbar-nav navbar-right">
              <li>
                <a class="clickable" id="thumbnail-display">
                  <i class="fa fa-th-large"></i>
                  <span>{{ trans('laravel-filemanager::lfm.nav-thumbnails') }}</span>
                </a>
              </li>
              <li>
                <a class="clickable" id="list-display">
                  <i class="fa fa-list"></i>
                  <span>{{ trans('laravel-filemanager::lfm.nav-list') }}</span>
                </a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  {{ trans('laravel-filemanager::lfm.nav-sort') }} <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="#" id="list-sort-alphabetic">
                      <i class="fa fa-sort-alpha-asc"></i> {{ trans('laravel-filemanager::lfm.nav-sort-alphabetic') }}
                    </a>
                  </li>
                  <li>
                    <a href="#" id="list-sort-time">
                      <i class="fa fa-sort-amount-asc"></i> {{ trans('laravel-filemanager::lfm.nav-sort-time') }}
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
        <div class="visible-xs" id="current_dir" style="padding: 5px 15px;background-color: #f8f8f8;color: #5e5e5e;"></div>

        <div id="alerts"></div>

        <div id="content"></div>
      </div>

      <ul id="fab">
        <li>
          <a href="#"></a>
          <ul class="hide">
            <li>
              <a href="#" id="add-folder" data-mfb-label="{{ trans('laravel-filemanager::lfm.nav-new') }}">
                <i class="fa fa-folder"></i>
              </a>
            </li>
            <li>
              <a href="#" id="upload" data-mfb-label="{{ trans('laravel-filemanager::lfm.nav-upload') }}">
                <i class="fa fa-upload"></i>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>

  <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aia-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">{{ trans('laravel-filemanager::lfm.title-upload') }}</h4>
        </div>
        <div class="modal-body">
          <form action="{{ route('unisharp.lfm.upload') }}" role='form' id='uploadForm' name='uploadForm' method='post' enctype='multipart/form-data'>
            <div class="form-group" id="attachment">
              <label for='upload' class='control-label'>{{ trans('laravel-filemanager::lfm.message-choose') }}</label>
              <div class="controls">
                <div class="input-group" style="width: 100%">
                  <input type="file" id="upload" name="upload[]" multiple="multiple">
                </div>
              </div>
            </div>
            <input type='hidden' name='working_dir' id='working_dir'>
            <input type='hidden' name='type' id='type' value='{{ request("type") }}'>
            <input type='hidden' name='_token' value='{{csrf_token()}}'>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('laravel-filemanager::lfm.btn-close') }}</button>
          <button type="button" class="btn btn-primary" id="upload-btn">{{ trans('laravel-filemanager::lfm.btn-upload') }}</button>
        </div>
      </div>
    </div>
  </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Restore to Database</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="restoreform">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
              <div class="form-group">
                <label for="recipient-name" class="form-control-label">file:</label>
                <input type="text" class="form-control" id="filename" name="filename" readonly>
              </div>
              <div class="form-group">
                <label for="recipient-name" class="form-control-label">Database:</label>
                <input type="text" class="form-control" id="dbname" name="dbname" required>
              </div>
              <div class="form-group">
                <label for="message-text" class="form-control-label">Role</label>
                <input type="text" class="form-control" id="role" name="role" required>
              </div>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="restore">Restore</button>
            </form>
          </div>
          <div class="modal-footer">
            
          </div>
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
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
  <script src="{{ asset('vendor/unisharp/laravel-filemanager/js/cropper.min.js') }}"></script>
  <script src="{{ asset('vendor/unisharp/laravel-filemanager/js/jquery.form.min.js') }}"></script>
  <script>
    var route_prefix = "{{ url('/') }}";
    var lfm_route = "{{ url(config('lfm.prefix')) }}";
    var lang = {!! json_encode(trans('laravel-filemanager::lfm')) !!};
  </script>
  
  <script src="{{ asset('vendor/unisharp/laravel-filemanager/js/script.js') }}"></script>
  <script>
    $.fn.fab = function () {
      var menu = this;
      menu.addClass('mfb-component--br mfb-zoomin').attr('data-mfb-toggle', 'hover');
      var wrapper = menu.children('li');
      wrapper.addClass('mfb-component__wrap');
      var parent_button = wrapper.children('a');
      parent_button.addClass('mfb-component__button--main')
        .append($('<i>').addClass('mfb-component__main-icon--resting fa fa-plus'))
        .append($('<i>').addClass('mfb-component__main-icon--active fa fa-times'));
      var children_list = wrapper.children('ul');
      children_list.find('a').addClass('mfb-component__button--child');
      children_list.find('i').addClass('mfb-component__child-icon');
      children_list.addClass('mfb-component__list').removeClass('hide');
    };
    $('#fab').fab({
      buttons: [
        {
          icon: 'fa fa-folder',
          label: "{{ trans('laravel-filemanager::lfm.nav-new') }}",
          attrs: {id: 'add-folder'}
        },
        {
          icon: 'fa fa-upload',
          label: "{{ trans('laravel-filemanager::lfm.nav-upload') }}",
          attrs: {id: 'upload'}
        }
      ]
    });
  </script>

  <script>
  $(document).ready(function() {
      $('#exampleModal').on('show.bs.modal', function(e) {
        //get data-id attribute of the clicked element
        var filename = $(e.relatedTarget).data('id');

        //populate the textbox
        $(e.currentTarget).find('input[name="filename"]').val(filename);
      });

      $('#restore').on('click',function(){
        $('#elbody').addClass('overlay');
        $('#exampleModal').hide();
        $('#loading-image').show();
        $("#restoreform").ajaxSubmit({
            url: '/laravel-filemanager/restoredb', 
            type: 'post',
            success:function(data){
              $('#loading-image').hide();
              $('#elbody').removeClass('overlay');
              $('.modal-backdrop').remove();
              $('#messageModal').modal('show');
              $("#bashoutput").val(data.data);
            },
            complete:function(){
              $('#loading-image').hide();
              $('#elbody').removeClass('overlay');
              $('.modal-backdrop').remove();
            }
            })
      });
    });
  </script>
<img src="/img/loading.gif" id="loading-image" alt="Smiley face" height="100" width="100" style="margin-left:  700px;z-index:-1;position:relative" hidden>

</body>

</html>