@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Các bình luận
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Brand">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                Họ và tên
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Bình luận
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
                                Bài viết
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $key => $comment)
                            <tr data-entry-id="{{ $comment->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $comment->name ?? '' }}
                                </td>
                                <td>
                                    {{ $comment->email ?? '' }}
                                </td>
                                <td>
                                    {{ $comment->message ?? '' }}
                                </td>
                                <td>
                                    <div class="checkbox-btn checkbox-btn--rounded">
                                        <input type="checkbox" class="switch-checkbox"
                                            {{ $comment->status == 1 ? 'checked' : '' }} data-id="{{ $comment->id }}" />
                                        <div class="toggler" data-label-checked="Hiện" data-label-unchecked="Ẩn"></div>
                                    </div>
                                    <input type="hidden" name="status" value="{{ $comment->status }}">
                                </td>
                                <td>
                                    @php
                                        $post = App\Models\Post::where('id', $comment->post_id)->first();
                                    @endphp
                                    <a href="{{ route('site.blogs.show', [$post->slug]) }}"
                                        target="_blank">{{ $post->title ?? '' }}</a>
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.brands.edit', $comment->id) }}">
                                        Sửa
                                    </a>
                                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST"
                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                        style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Xóa">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.comments.massDestroy') }}",
                className: 'btn-danger',
                action: function(e, dt, node, config) {
                    var ids = $.map(dt.rows({
                        selected: true
                    }).nodes(), function(entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                                headers: {
                                    'x-csrf-token': _token
                                },
                                method: 'POST',
                                url: config.url,
                                data: {
                                    ids: ids,
                                    _method: 'DELETE'
                                }
                            })
                            .done(function() {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)
            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 25,
            });
            let table = $('.datatable-Brand:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });


            $('.switch-checkbox').change(function() {
                var comment_id = $(this).data('id');
                if ($(this).is(":checked")) {
                    $(this).parent().next().attr('value', '1');
                    var status = $(this).parent().next().val();

                    
                } else {
                    $(this).parent().next().attr('value', '0');
                    var status = $(this).parent().next().val();
                    
                }
                // alert(comment_id); 
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('admin.comments.active') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        comment_id: comment_id,
                        status: status
                    },
                    success: function(data) {
                        location.reload();
                    }
                });
            });
        })
    </script>
@endsection
