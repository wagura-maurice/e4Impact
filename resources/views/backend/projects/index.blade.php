@extends('layouts.app')

@push('stylesheets')
@endpush

@section('breadcrumb')
    @include('layouts.partials.breadcrumb', ['breadcrumb' => optional($data)->breadcrumb])
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <livewire:projects-list />
        </div>
    </div>
@endsection

@push('scripts')
@endpush
