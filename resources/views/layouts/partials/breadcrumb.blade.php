<div class="row align-content-center align-items-center">
    <div class="col-12 col-md-6">
        <h3>{{ optional($breadcrumb)->title ? ucwords($breadcrumb->title) : null }}</h3>
        <p class="text-subtitle text-muted">
            {{ optional($breadcrumb)->description ? ucwords($breadcrumb->description) : null }}</p>
    </div>
    <div class="col-12 col-md-6">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ optional($breadcrumb)->route ? ucwords($breadcrumb->route) : null }}</li>
            </ol>
            @if (optional($breadcrumb)->new)
                <a href="{{ $breadcrumb->new['route'] }}" class="btn icon icon-left btn-sm btn-light-info float-end"
                    style="font-size: 1em; color: #435ebe;">
                    <i class="bi bi-plus-circle-fill"></i>
                    <strong>{{ ucwords($breadcrumb->new['title']) }}</strong>
                </a>
            @endif
        </nav>
    </div>
</div>
