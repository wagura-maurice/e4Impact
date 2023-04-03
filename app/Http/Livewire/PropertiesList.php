<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Property;
use App\Models\PropertyType;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;
use App\Exports\PropertyExport;

class PropertiesList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $propertiesInPage = [], $allProperties = [];
    public $paginate = 10;
    public $sections = [];
    public $search = '';
    public $sortField = '_pid', $sortDirection = 'desc';
    public $selectedType = null, $selectedStatus = null;
    public $selectedDateStart = null, $selectedDateEnd = null;
    public $showAdvancedFilters = false;

    /**
     * We're getting all the properties from the database and storing them in the ``
     * variable. We're also getting all the properties that are currently in the page and storing them
     * in the `` variable
     */
    public function mount()
    {
        $this->allProperties = $this->propertiesQuery->pluck('id')->toArray();
        $this->propertiesInPage = $this->properties->pluck('id')->toArray();
    }

    /**
     * It returns a view called properties-list.blade.php, and passes it an array of properties, types,
     * and statuses
     * 
     * @return A view with the properties, types, and statuses.
     */
    public function render()
    {
        return view('livewire.properties-list', [
            'properties' => $this->properties,
            'types' => PropertyType::all(),
            'statuses' => [
                ['id' => Property::PENDING, 'name' => 'pending'],
                ['id' => Property::ACTIVE, 'name' => 'active'],
                ['id' => Property::INACTIVE, 'name' => 'inactive']
            ]
        ]);
    }

    /* Listening to the events that are emitted from the child components. */
    protected $listeners = [
        'deleteRecord',
        'deleteRecords',
        'exportProperties'
    ];

    /**
     * It toggles the value of the showAdvancedFilters property.
     */
    public function toggleShowAdvancedFilters()
    {
        $this->showAdvancedFilters =! $this->showAdvancedFilters;
    }

    /**
     * Reset the filters
     */
    public function resetFilters() {
        $this->reset('selectedType');
        $this->reset('selectedStatus');
        $this->reset('selectedDateStart');
        $this->reset('selectedDateEnd');
    }

    /**
     * > It returns a query builder object that searches for properties, orders them by a field and
     * direction, and filters them by type and status
     * 
     * @return A query builder object.
     */
    public function getPropertiesQueryProperty()
    {
        return Property::with([
            'type',
            'units',
            'tenancies'
        ])
            ->search(trim($this->search))
            ->orderBy($this->sortField, $this->sortDirection)
            ->when($this->selectedType, function ($query) {
                return $query->where('type_id', $this->selectedType);
            })
            ->when($this->selectedStatus, function ($query) {
                return $query->where('_status', $this->selectedStatus);
            })
            ->when($this->selectedDateStart, function($query) {
                return $query->where('created_at', '>=', Carbon::parse($this->selectedDateStart));
            })
            ->when($this->selectedDateEnd, function($query) {
                return $query->where('created_at', '<=', Carbon::parse($this->selectedDateEnd));
            });
    }

    /**
     * > This function returns a paginated list of properties
     * 
     * @return A paginated collection of properties.
     */
    public function getPropertiesProperty()
    {
        return $this->propertiesQuery->paginate($this->paginate);
    }

    /**
     * It changes the sort field and direction of the properties in the page
     * 
     * @param sortField The field to sort by.
     */
    public function changeSort($sortField)
    {
        if ($this->sortField == $sortField) {
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $sortField;
        }

        $this->propertiesInPage = $this->properties->pluck('id')->toArray();
    }

    /**
     * It updates the paginate function.
     */
    public function updatedPaginate()
    {
        $this->propertiesInPage = $this->properties->pluck('id')->toArray();
    }

    public function deleteRecord(string $_pid)
    {
        $property = Property::where('id', trim($_pid))->first();

        if ($property->delete()) {
            session()->flash('success', 'Property #' . $property->_pid . ' deleted successfully.');
        } else {
            session()->flash('danger', 'Property #' . $property->_pid . ' not deleted successfully. please try again!');
        }
    }

    public function deleteRecords(array $checked)
    {
        Property::whereIn('id', $checked)->delete();

        if (count($checked) > 1) {
            session()->flash('success', number_format(count($checked)) . ' Properties deleted successfully.');
        } else {
            session()->flash('success', number_format(count($checked)) . ' Property deleted successfully.');
        }
    }

    /**
     * > It takes an array of property ids, creates a new instance of the PropertyExport class, and
     * then downloads the file
     * 
     * @param array checked an array of property ids to be exported
     * 
     * @return A download of the file.
     */
    public function exportProperties(array $checked)
    {
        return (new PropertyExport($checked))->download(now() . ' - properties.xlsx');
    }
}
