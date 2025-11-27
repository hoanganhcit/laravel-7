@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <iframe src="{{url("/filemanager?type=image")}}" style="width: 100%; height: calc(100vh - 100px); overflow: hidden; border: none;"></iframe>
    </div>
@endsection