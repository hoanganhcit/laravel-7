@extends('layouts.admin')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.testimonials.create') }}">
                Thêm đánh giá
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Danh sách
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Testimonial">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                ID
                            </th>
                            <th>
                                Họ và Tên
                            </th>
                            <th>
                                Hình ảnh
                            </th>
                            <th>
                                Đánh giá
                            </th>
                            <th>
                                Nội Dung
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($testimonials as $key => $testimonial)
                            <tr data-entry-id="{{ $testimonial->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $testimonial->id ?? '' }}
                                </td>
                                <td>
                                    {{ $testimonial->name ?? '' }}
                                </td>
                                <td>
                                    <img src="{{ $testimonial->photo }}" width="100" class="rounded">
                                </td>
                                <td>
                                    <ul class="rating">
                                    @php
                                        $rate = $testimonial->rate;
                                    @endphp
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($rate >= $i)
                                            <li><i class="fas fa-star"></i></li>
                                        @else
                                            <li><i class="fal fa-star"></i></li>
                                        @endif
                                    @endfor
                                    </ul>
                                </td>
                                <td>
                                    {{ Str::limit($testimonial->description, 50, $end = '...') }}
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-info"
                                        href="{{ route('admin.testimonials.edit', $testimonial->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                    <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}"
                                        method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
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
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.testimonials.massDestroy') }}",
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
            let table = $('.datatable-Testimonial:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
