@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Danh sách người đăng ký nhận thông báo
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Brand">
                    <thead>
                        <tr>
                            <th>
                                Email
                            </th>
                            <th>
                                Số điện thoại
                            </th>
                            <th>
                                Hành động
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($newsletters as $key => $newsletter)
                            <tr data-entry-id="{{ $newsletter->id }}">
                                <td>
                                    {{ $newsletter->email ?? '' }}
                                </td>
                                <td>
                                    {{ $newsletter->phone_number ?? '' }}
                                </td>
                                <td>
                                    <a href="javascript:void(0)" class="btn-action btn-sm quick-modal"
                                        data-id="{{ $newsletter->id }}" data-target="#modal_promotion" data-toggle="modal">
                                        <i class="fab fa-telegram-plane text-info fs-18" style="font-size: 18px"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_promotion" role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 1024px" role="document">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title" id="viewModalLongTitle">Gửi Khuyễn Mãi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form enctype="multipart/form-data" method="POST" action="{{route('admin.contacts.sendEmail')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-25" id="email_data"></div>
                        <div class="form-group mb-25">
                            <label for="exampleInputEmail1">Nội Dung</label>
                            <textarea name="message" id="message" class="form-control" placeholder="Message"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger me-2" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Gửi Email</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('public/admin/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('public/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
    <script>
        $(function() {
            $('.quick-modal').on('click', modal_promotion);
        });
        //  send mail 
        function modal_promotion(id) {
            var id = $(this).data('id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('admin.subscribers.quick_promotion') }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#email_data').html(data.email_data);
                }
            });
        }
        $('#lfm').filemanager('image', {prefix: '{{url("/laravel-filemanager")}}'});

        var editor_config = {
            path_absolute : "/",
            selector: "#message",
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
