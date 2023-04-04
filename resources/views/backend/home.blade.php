@extends('layouts.app')

@push('stylesheets')
@endpush

@section('breadcrumb')
    @include('layouts.partials.breadcrumb', ['breadcrumb' => optional($data)->breadcrumb])
@endsection

@section('content')
@endsection

@push('scripts')
@endpush
