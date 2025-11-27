@extends('layouts.admin')
@section('content') 
<div class="card">
    <div class="card-header">
        Đánh giá
    </div> 
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Product">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            Sản Phẩm
                        </th>
                        <th>
                            Người dùng
                        </th>
                        <th>
                            Mức độ
                        </th>
                        <th>
                            Nội dung
                        </th>
                        <th>
                            Ngày đăng
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $key => $review)
                        <tr data-entry-id="{{ $review->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $review->product->name ?? '' }}
                            </td>
                            <td>
                                {{ $review->name ?? '' }}
                            </td>
                            <td>
                                <ul class="list-inline d-flex rating-result mb-0 fs-13">
                                    @php
                                        $rate = $review->rate;
                                    @endphp
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($rate >= $i)
                                            <li class="list-inline-item mr-1 lh-1">
                                                <span class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                </span>
                                            </li>
                                        @else
                                            <li class="list-inline-item mr-1 lh-1">
                                                <span class="text-warning">
                                                    <i class="fal fa-star"></i>
                                                </span>
                                            </li>
                                        @endif
                                    @endfor
                                </ul>
                            </td>
                            <td> 
                                {{ $review->message ?? '' }}
                            </td> 
                            <td>
                                {{$review->created_at->format("d/m/Y")}}
                            </td> 
                            <td> 
                                <form action="{{ route('admin.products.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    @method('DELETE')
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
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
    $(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons) 
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
    let deleteButton = {
        text: deleteButtonTrans,
        url: "{{ route('admin.products.reviews.massDestroy') }}",
        className: 'btn-danger',
        action: function (e, dt, node, config) {
        var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
            return $(entry).data('entry-id')
        });

        if (ids.length === 0) {
            alert('{{ trans('global.datatables.zero_selected') }}')

            return
        }

        if (confirm('{{ trans('global.areYouSure') }}')) {
            $.ajax({
            headers: {'x-csrf-token': _token},
            method: 'POST',
            url: config.url,
            data: { ids: ids, _method: 'DELETE' }})
            .done(function () { location.reload() })
        }
        }
    }
    dtButtons.push(deleteButton) 

    $.extend(true, $.fn.dataTable.defaults, {
        orderCellsTop: true,
        order: [[ 1, 'desc' ]],
        pageLength: 25,
    });
    let table = $('.datatable-Product:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
    
    })

</script>
@endsection