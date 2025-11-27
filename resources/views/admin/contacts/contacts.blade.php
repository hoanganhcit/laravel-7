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
                                Họ và Tên
                            </th>
                            <th>
                                Số Điện Thoại
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Lời Nhắn
                            </th>
                            <th>
                                Hành động
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $key => $contact)
                            <tr data-entry-id="{{ $contact->id }}">
                                <td>
                                    {{ $contact->name ?? '' }}
                                </td>
                                <td>
                                    {{ $contact->phone ?? '' }}
                                </td>
                                <td>
                                    {{ $contact->email ?? '' }}
                                </td>
                                <td>
                                    {{ Str::limit($contact->message, '50') }}
                                </td>
                                <td>
                                    <a href="javascript:void(0)" class="btn-action btn btn-xs text-white btn-warning reply_contact"
                                        data-id="{{ $contact->id }}" data-target="#reply_contact" data-toggle="modal">
                                        Phản Hồi
                                    </a>
                                    <a href="javascript:void(0)" class="btn-action btn btn-xs btn-info view-contact"
                                        data-id="{{ $contact->id }}" data-target="#view_contact" data-toggle="modal">
                                        Xem
                                    </a>
                                    <form action="{{ route('admin.subscribers.del_contact', $contact->id) }}" method="POST"
                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                        style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger"
                                            value="{{ trans('global.delete') }}">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reply_contact" role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 1024px" role="document">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title" id="viewModalLongTitle">Phản hồi khách hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form enctype="multipart/form-data" method="POST" action="{{route('admin.contacts.sendEmail')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-25" id="email_data"></div>
                        <div class="form-group mb-25" id="message_data">
                            <label>Nội Dung</label>
                            <textarea class="form-control" id="message" name="message"></textarea>
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
    <div class="modal fade" id="view_contact" role="dialog">
        <div class="modal-dialog modal-dialog-md" role="document">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title" id="viewModalLongTitle">Lời nhắn</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form enctype="multipart/form-data" method="POST" action="">
                    @csrf
                    <div class="modal-body px-4 py-4">
                        <div id="view_name"></div>
                        <div id="view_phone"></div>
                        <div id="view_email"></div>
                        <div id="view_message"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger me-2" data-dismiss="modal">Đóng</button>
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
            $('.reply_contact').on('click', reply_contact);
            $('.view-contact').on('click', view_contact);
        });
        //  reply contact
        function reply_contact(id) {
            var id = $(this).data('id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('admin.subscribers.reply_contact') }}",
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

        //  view contact
        function view_contact(id) {
            var id = $(this).data('id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('admin.subscribers.view_contact') }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#view_name').html(data.view_name);
                    $('#view_phone').html(data.view_phone);
                    $('#view_email').html(data.view_email);
                    $('#view_message').html(data.view_message);
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
    @parent
@endsection
