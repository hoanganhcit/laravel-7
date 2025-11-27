@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Thêm Tin Tức
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.press.store') }}" enctype="multipart/form-data" class="row">
                @csrf
                <div class="form-group  col-md-6 col-xs-12">
                    <label for="inputPhoto">Hình Ảnh <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder"
                                class="btn btn-primary text-white">
                                <i class="fal fa-image"></i> Choose
                            </a>
                        </span>
                        <input id="thumbnail" class="form-control" type="text" name="photo"
                            value="{{ old('photo') }}">
                    </div>
                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                    @error('photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class=" col-md-6 col-xs-12">
                    <div class="form-group">
                        <label class="required" for="link">Link Bài Viết</label>
                        <input class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}" type="text"
                            name="link" id="link" value="{{ old('link', '') }}" required>
                        @if ($errors->has('link'))
                            <div class="invalid-feedback">
                                {{ $errors->first('link') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="required" for="title">{{ trans('cruds.post.fields.title') }}</label>
                        <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text"
                            name="title" id="title" value="{{ old('title', '') }}" required>
                        @if ($errors->has('title'))
                            <div class="invalid-feedback">
                                {{ $errors->first('title') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group mt-3">
                        <label for="description">{{ trans('cruds.post.fields.description') }}</label>
                        <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description"
                            id="description">{{ old('description') }}</textarea>
                        @if ($errors->has('description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="photo">Tin tức nổi bật</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_show"
                                value="0" id="is_show">
                            <label class="form-check-label" for="is_show"> Hiển Thị Nổi Bật </label>
                        </div>
                    </div>
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
    <script src="{{ asset('public/admin/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        $('#lfm').filemanager('image');
        
        $("#is_show").change(function() {
            if (this.checked) {
                $(this).attr('value', '1');
            } else {
                $(this).attr('value', '0');
            }
        });

        var editor_config = {
            path_absolute: "/",
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
            file_browser_callback: function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                    'body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document
                    .getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no"
                });
            }
        };

        tinymce.init(editor_config);
    </script>
@endsection
