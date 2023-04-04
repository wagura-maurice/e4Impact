<div x-cloak x-init="$watch('selectPage', value => selectPageUpdated(value))" x-data="{
    projectsInPage: @entangle('projectsInPage'),
    allProjects: @entangle('allProjects'),
    selectPage: false,
    selectAll: false,
    selectedCategory: @entangle('selectedCategory'),
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
            this.checked = this.projectsInPage;
        } else {
            this.selectAll = false;
            this.checked = [];
        }
    },
    selectAllItems() {
        this.selectAll = true;
        this.checked = this.allProjects;
    },
    exportProjects() {
        $wire.emit('exportProjects', this.checked);
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
                <button class="btn btn-secondary dropdown-toggle" category="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    With selected (<span x-text="checked.length"></span>)
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li>
                        <a href="#" class="dropdown-item" category="button"
                            onclick="confirm('Are you sure you want to delete these records?') || event.stopImmediatePropagation()"
                            @click="deleteRecords">
                            <i class="bi bi-trash"></i> <i>Delete</i>
                        </a>
                    </li>
                    <li>
                        <a href="#" @click="exportProjects" class="dropdown-item" category="button">
                            <i class="bi bi-download"></i> <i>Export</i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="d-flex align-items-center ml-4 input-group mb-3">
            <div class="input-group">
                <input wire:model.debounce.500ms="search" category="search" class="form-control"
                    placeholder="Search by _pid, name, address, or category...">
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
                        <label class="input-group-text" for="category">By Project Category</label>
                        <select class="form-select" name="category_id" id="category_id" wire:model="selectedCategory">
                            <option value="">All Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ ucwords($category->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-6">
                    <div class="d-flex align-items-center ml-4 input-group mb-3 col">
                        <label class="input-group-text" for="status">By Project Status</label>
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
                            <input category="date" name="date-start" id="date-start" class="form-control"
                                placeholder="date start" wire:model="selectedDateStart">
                            <input category="date" name="date-end" id="date-end" class="form-control"
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
            <strong x-text="allProjects.length"></strong> items?
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
                                <input category="checkbox" class="form-check-input" x-model="selectPage">
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
                    <th>Category</th>
                    <th>Description</th>
                    <th>Telephone</th>
                    <th>Email</th>
                    <th>Logo</th>
                    <th>Website</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Status</th>
                    <th>
                        <!-- Action -->
                    </th>
                </tr>
                @forelse($projects as $project)
                    <tr>
                        <td>
                            <div class="form-check">
                                <div class="checkbox">
                                    <input category="checkbox" class="form-check-input" value="{{ $project->_pid }}"
                                        x-model="checked">
                                </div>
                            </div>
                        </td>
                        <td scope="row"><a href="{{ route('project.catalog.show', $project->_pid) }}"># {{ $project->_pid }}</a></td>
                        <td>{{ ucwords($project->name) }}</td>
                        <td>{{ ucwords($project->category->name) }}</td>
                        <td>{{ ucwords($project->description) }}</td>
                        <td>
                            <a
                                href="tel:{{ phoneNumberPrefix($project->telephone) }}">{{ phoneNumberPrefix($project->telephone) }}</a>
                        </td>
                        <td>
                            <a href="mailto:{{ $project->email }}">{{ $project->email }}</a>
                        </td>
                        <td class="avatar avatar-lg me-3">
                            <img src="{{ $project->logo ?? '#' }}" alt="{{ $project->name }}" srcset="{{ $project->logo ?? '#' }}">
                        </td>
                        <td>
                            <a href="{{ $project->website ?? '#' }}" target="_blank">{{ $project->website ?? '#' }}</a>
                        </td>
                        <td>{{ \Illuminate\Support\Carbon::parse($project->created_at)->diffForHumans() }}</td>
                        <td>{{ \Illuminate\Support\Carbon::parse($project->updated_at)->diffForHumans() }}</td>
                        <td>
                            <a href="#"
                                class="btn icon icon-left btn-sm btn-light-{{ $project->_status == \App\Models\Project::PENDING ? 'info' : ($project->_status == \App\Models\Project::ACTIVE ? 'success' : 'danger') }}"><i
                                    class="{{ $project->_status == \App\Models\Project::PENDING ? 'bi bi-info-circle' : ($project->_status == \App\Models\Project::ACTIVE ? 'bi bi-check2-circle' : 'bi bi-radioactive') }}"
                                    style="font-size: 1.2em; color: #435ebe;"></i>
                                <strong>{{ $project->_status == \App\Models\Project::PENDING ? 'Pending' : ($project->_status == \App\Models\Project::ACTIVE ? 'Active' : 'Inactive') }}</strong></a>
                        </td>
                        <td>
                            <a href="{{ route('project.catalog.edit', $project->_pid) }}"
                                class="btn icon icon-left btn-sm btn-light-info" title="Edit"
                                style="font-size: 1.2em; color: #56b6f7;"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn icon icon-left btn-sm btn-light-danger"
                                onclick="confirm('Are you sure you want to delete this record?') || event.stopImmediatePropagation()"
                                @click="deleteRecord({{ $project->id }})" title="Trash"
                                style="font-size: 1.2em; color: #f3616d;"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                @empty
                    <div class="col-md-12">
                        <div class="alert alert-light-info color-info">
                            {{ __('No project found. Please try again!') }}
                        </div>
                    </div>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- <div class="row mt-4"> -->
    <!-- <div class="col-sm-6 offset-5"> -->
    {{ $projects->links() }}
    <!-- </div> -->
    <!-- </div> -->
</div>
