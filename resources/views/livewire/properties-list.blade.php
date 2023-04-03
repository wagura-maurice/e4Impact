<div x-cloak x-init="$watch('selectPage', value => selectPageUpdated(value))" x-data="{
    propertiesInPage: @entangle('propertiesInPage'),
    allProperties: @entangle('allProperties'),
    selectPage: false,
    selectAll: false,
    selectedType: @entangle('selectedType'),
    sortField: @entangle('sortField'),
    sortDirection: @entangle('sortDirection'),
    checked: [],
    deleteRecord(id) {
        this.checked = this.checked.filter(item => item !== id);
        $wire.emit('deleteRecord', id);
    },
    deleteRecords() {
        $wire.emit('deleteRecords', this.checked);
        this.checked = [];
    },
    selectPageUpdated(value) {
        if (value) {
            this.checked = this.propertiesInPage;
        } else {
            this.selectAll = false;
            this.checked = [];
        }
    },
    selectAllItems() {
        this.selectAll = true;
        this.checked = this.allProperties;
    },
    exportProperties() {
        $wire.emit('exportProperties', this.checked);
    }
}">
    <div class="d-flex justify-content-between align-content-center my-2">
        <div class="d-flex col-md-9">
            <div>
                <div class="d-flex align-items-center ml-4 input-group mb-3">
                    <label class="input-group-text" for="paginate">Per Page</label>
                    <select class="form-select" name="paginate" id="paginate" wire:model="paginate">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
            <div class="dropdown ms-4" x-show="checked.length > 0" x-transition>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    With selected (<span x-text="checked.length"></span>)
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li>
                        <a href="#" class="dropdown-item" type="button"
                            onclick="confirm('Are you sure you want to delete these records?') || event.stopImmediatePropagation()"
                            @click="deleteRecords">
                            <i class="bi bi-trash"></i> <i>Delete</i>
                        </a>
                    </li>
                    <li>
                        <a href="#" @click="exportProperties" class="dropdown-item" type="button">
                            <i class="bi bi-download"></i> <i>Export</i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="d-flex align-items-center ml-4 input-group mb-3">
            <div class="input-group">
                <input wire:model.debounce.500ms="search" type="search" class="form-control"
                    placeholder="Search by _pid, name, address, or type...">
                <span class="btn btn-primary" wire:click="toggleShowAdvancedFilters">
                    <i class="bi bi-chevron-compact-down"></i>
                </span>
            </div>
        </div>
    </div>

    @if ($showAdvancedFilters)
        <div class="col">
            <p class="text-subtitle text-muted">{{ __('Advanced Search Filters') }}</p>
            <div class="row">
                <div class="form-group col-6">
                    <div class="d-flex align-items-center ml-4 input-group mb-3 col">
                        <label class="input-group-text" for="type">By Property Type</label>
                        <select class="form-select" name="type_id" id="type_id" wire:model="selectedType">
                            <option value="">All Type</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ ucwords($type->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-6">
                    <div class="d-flex align-items-center ml-4 input-group mb-3 col">
                        <label class="input-group-text" for="status">By Property Status</label>
                        <select class="form-select" name="_status" id="_status" wire:model="selectedStatus">
                            <option value="">All Status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status['id'] }}">{{ ucwords($status['name']) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-12">
                    <fieldset>
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="date-range">By Creation Date Range</label>
                            </div>
                            <input type="date" name="date-start" id="date-start" class="form-control"
                                placeholder="date start" wire:model="selectedDateStart">
                            <input type="date" name="date-end" id="date-end" class="form-control"
                                placeholder="date end" wire:model="selectedDateEnd">
                        </div>
                    </fieldset>
                </div>
                <div class="col-12 d-flex justify-content-end" data-bs-toggle="tooltip" data-bs-placement="left"
                    title="{{ __('Reset Filters') }}">
                    <div class="buttons">
                        <a href="#" class="btn icon btn-secondary" wire:click="resetFilters">
                            <i class="bi bi-eraser-fill"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="col-md-12 my-3">
        @include('includes.alerts')
    </div>

    <div class="col-md-10 mb-3" x-transition>
        <div x-show="selectAll && selectPage">
            You are currently selecting <strong x-text="checked.length"></strong> items.
        </div>
        <div x-show="selectPage && !selectAll">
            You have selected <strong x-text="checked.length"></strong> items, Do you want to Select All
            <strong x-text="allProperties.length"></strong> items?
            <a href="#" @click="selectAllItems" class="ml-2">Select All</a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-responsive table-hover table-striped">
            <tbody>
                <tr>
                    <th>
                        <div class="form-check">
                            <div class="checkbox">
                                <input type="checkbox" class="form-check-input" x-model="selectPage">
                            </div>
                        </div>
                    </th>
                    <th>
                        <a href="#" wire:click="changeSort('_pid')">
                            #
                            <span x-show="sortDirection == 'desc' && sortField == '_pid'">&uarr;</span>
                            <span x-show="sortDirection == 'asc' && sortField == '_pid'">&darr;</span>
                        </a>
                    </th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Telephone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Units</th>
                    <th>Tenancies</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Status</th>
                    <th>
                        <!-- Action -->
                    </th>
                </tr>
                @forelse($properties as $property)
                    <tr>
                        <td>
                            <div class="form-check">
                                <div class="checkbox">
                                    <input type="checkbox" class="form-check-input" value="{{ $property->_pid }}"
                                        x-model="checked">
                                </div>
                            </div>
                        </td>
                        <td scope="row"><a href="{{ route('property.building.show', $property->_pid) }}">#
                                {{ $property->_pid }}</a></td>
                        <td>{{ ucwords($property->name) }}</td>
                        <td>{{ ucwords($property->type->name) }}</td>
                        <td>
                            <a
                                href="tel:{{ phoneNumberPrefix($property->telephone) }}">{{ phoneNumberPrefix($property->telephone) }}</a>
                        </td>
                        <td>
                            <a href="mailto:{{ $property->email }}">{{ $property->email }}</a>
                        </td>
                        <td>
                            <a href="{{ optional($property)->gps_coordinates ? generateMapLink($property->gps_coordinates, $property->address) : '#' }}"
                                target="_blank">{{ ucwords($property->address) }}</a>
                        </td>
                        <td>{{ number_format($property->units->count()) }}</td>
                        <td>{{ number_format($property->tenancies->count()) }}</td>
                        <td>{{ \Illuminate\Support\Carbon::parse($property->created_at)->diffForHumans() }}</td>
                        <td>{{ \Illuminate\Support\Carbon::parse($property->updated_at)->diffForHumans() }}</td>
                        <td>
                            <a href="#"
                                class="btn icon icon-left btn-sm btn-light-{{ $property->_status == \App\Models\Property::PENDING ? 'info' : ($property->_status == \App\Models\Property::ACTIVE ? 'success' : 'danger') }}"><i
                                    class="{{ $property->_status == \App\Models\Property::PENDING ? 'bi bi-info-circle' : ($property->_status == \App\Models\Property::ACTIVE ? 'bi bi-check2-circle' : 'bi bi-radioactive') }}"
                                    style="font-size: 1.2em; color: #435ebe;"></i>
                                <strong>{{ $property->_status == \App\Models\Property::PENDING ? 'Pending' : ($property->_status == \App\Models\Property::ACTIVE ? 'Active' : 'Inactive') }}</strong></a>
                        </td>
                        <td>
                            <a href="{{ route('property.building.edit', $property->_pid) }}"
                                class="btn icon icon-left btn-sm btn-light-info" title="Edit"
                                style="font-size: 1.2em; color: #56b6f7;"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn icon icon-left btn-sm btn-light-danger"
                                onclick="confirm('Are you sure you want to delete this record?') || event.stopImmediatePropagation()"
                                @click="deleteRecord({{ $property->id }})" title="Trash"
                                style="font-size: 1.2em; color: #f3616d;"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                @empty
                    <div class="col-md-12">
                        <div class="alert alert-light-info color-info">
                            {{ __('No property buildings found. Please try again!') }}
                        </div>
                    </div>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- <div class="row mt-4"> -->
    <!-- <div class="col-sm-6 offset-5"> -->
    {{ $properties->links() }}
    <!-- </div> -->
    <!-- </div> -->
</div>
