@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.post.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.posts.store") }}" enctype="multipart/form-data" class="row">
            @csrf
            <div class="form-group  col-md-6 col-xs-12">
                <label for="inputPhoto">Hình Ảnh <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-btn">
                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                            <i class="fal fa-image"></i> Choose
                        </a>
                    </span>
                  <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}">
                </div>
                <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                  @error('photo')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
            </div>
            <div class="form-group  col-md-6 col-xs-12">
                <label class="required" for="title">{{ trans('cruds.post.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.title_helper') }}</span>
                <div class="form-group mt-3">
                    <label for="description">{{ trans('cruds.post.fields.description') }}</label>
                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description') }}</textarea>
                    @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.post.fields.description_helper') }}</span>
                </div>
                
                <div class="form-group ">
                    <div class="d-flex justify-between"> 
                        <label for="categories">{{ trans('cruds.post.fields.category') }}</label>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                        </div>
                    </div>
                    <select class="form-control select2 {{ $errors->has('categories') ? 'is-invalid' : '' }}" name="categories[]" id="categories" multiple>
                        @foreach($categories as $id => $category)
                        <option value="{{ $id }}" {{ in_array($id, old('categories', [])) ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('categories'))
                    <div class="invalid-feedback">
                        {{ $errors->first('categories') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.post.fields.category_helper') }}</span>
                </div>
                <div class="form-group">
                    <div class="d-flex justify-between"> 
                        <label for="tags">{{ trans('cruds.post.fields.tags') }}</label>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                        </div>
                    </div>
                    <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" name="tags[]" id="tags" multiple>
                        @foreach($tags as $id => $tag)
                        <option value="{{ $id }}" {{ in_array($id, old('tags', [])) ? 'selected' : '' }}>{{ $tag }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('tags'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tags') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.post.fields.tags_helper') }}</span>
                </div>
                
                <div class="form-group mt-4">
                    <div class="form-check ">
                        <input class="form-check-input" type="checkbox" id="is_feature" onclick="isFeature()" >
                        <label class="form-check-label" for="is_feature">
                            Bài viết nổi bật
                        </label>
                        <input type="hidden" name="is_feature" value="0" id="val_isfeature">
                    </div>
                </div>
            </div>

            <div class="form-group col-md-12">
                <label for="content">{{ trans('cruds.post.fields.content') }}</label>
                <textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content" id="content" style="min-height: 600px">{{ old('content') }}</textarea>
                @if($errors->has('content'))
                    <div class="invalid-feedback">
                        {{ $errors->first('content') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.content_helper') }}</span>
            </div>
            <div class="form-group col-md-12">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script src="{{asset('public/admin/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('public/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<script>
    function isFeature () {
        var checkBox = document.getElementById("is_feature");
        if (checkBox.checked == true){
            $('#val_isfeature').val('1') ;
        } else {
            $('#val_isfeature').val('0') ;
        }
    }
    $('#lfm').filemanager('image', {prefix: '{{url("/laravel-filemanager")}}'});

    var editor_config = {
        path_absolute : "/",
        selector: "#content",
        plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
        ],
        menubar: false,
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        relative_urls: false,
        file_browser_callback : function(field_name, url, type, win) {
          var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
          var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

          var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
          if (type == 'image') {
            cmsURL = cmsURL + "&type=Images";
        } else {
            cmsURL = cmsURL + "&type=Files";
        }

        tinyMCE.activeEditor.windowManager.open({
            file : cmsURL,
            title : 'Filemanager',
            width : x * 0.8,
            height : y * 0.8,
            resizable : "yes",
            close_previous : "no"
        });
    }
};

tinymce.init(editor_config);
</script>
@endsection