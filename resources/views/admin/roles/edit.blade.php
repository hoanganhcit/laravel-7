@extends('layouts.admin')
@section('content')
@section('styles')
<style>
    .roles-lists .px-6 {
        padding-left: calc(1.25rem + 15px) !important;
        padding-right: calc(1.25rem + 15px) !important;
    }
</style>
@endsection
<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.role.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.roles.update", [$role->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.role.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $role->title) }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.role.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required mb-4" for="permissions">{{ trans('cruds.role.fields.permissions') }}</label>
                <div class="roles-lists row">
                    <div class="form-check col-md-12 col-xs-12 mb-4 px-6">
                        <input class="form-check-input" type="checkbox" name="all" id="select-all">
                        <label class="form-check-label">Chọn tất cả</label>
                    </div>
                    @foreach($permissions as $id => $permission)
                    <div class="form-check col-md-3 col-xs-12 mb-4 px-6">
                        <input class="form-check-input" type="checkbox" name="permissions[]"
                            value="{{ $id }}" {{ (in_array($id, old('permissions', [])) || $role->permissions->contains($id)) ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $permission }}</label>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>


@section('scripts')
    <script>
        $(document).ready(function() {
            $('#select-all').click(function(event) {   
                if(this.checked) {
                    $(':checkbox').each(function() {
                        this.checked = true;                        
                    });
                } else {
                    $(':checkbox').each(function() {
                        this.checked = false;                       
                    });
                }
            }); 
        });
    </script>
@endsection
@endsection 