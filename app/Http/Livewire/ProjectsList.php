<?php

namespace App\Http\Livewire;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\ProjectExport;
use Illuminate\Support\Carbon;
use App\Models\ProjectCategory;

class ProjectsList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $projectsInPage = [], $allProjects = [];
    public $paginate = 10;
    public $sections = [];
    public $search = '';
    public $sortField = '_pid', $sortDirection = 'desc';
    public $selectedCategory = null, $selectedStatus = null;
    public $selectedDateStart = null, $selectedDateEnd = null;
    public $showAdvancedFilters = false;

    /**
     * We're getting all the projects from the database and storing them in the ``
     * variable. We're also getting all the projects that are currently in the page and storing them
     * in the `` variable
     */
    public function mount()
    {
        $this->allProjects = $this->projectsQuery->pluck('id')->toArray();
        $this->projectsInPage = $this->projects->pluck('id')->toArray();
    }

    /**
     * It returns a view called projects-list.blade.php, and passes it an array of projects, categories,
     * and statuses
     * 
     * @return A view with the projects, categories, and statuses.
     */
    public function render()
    {
        /* return view('livewire.projects-list', [
            'projects' => $this->projects,
            'categories' => ProjectCategory::all(),
            'statuses' => [
                ['id' => Project::PENDING, 'name' => 'pending'],
                ['id' => Project::ACTIVE, 'name' => 'active'],
                ['id' => Project::INACTIVE, 'name' => 'inactive']
            ]
        ]); */
    }

    /* Listening to the events that are emitted from the child components. */
    protected $listeners = [
        'deleteRecord',
        'deleteRecords',
        'exportProjects'
    ];

    /**
     * It toggles the value of the showAdvancedFilters project.
     */
    public function toggleShowAdvancedFilters()
    {
        $this->showAdvancedFilters =! $this->showAdvancedFilters;
    }

    /**
     * Reset the filters
     */
    public function resetFilters() {
        $this->reset('selectedCategory');
        $this->reset('selectedStatus');
        $this->reset('selectedDateStart');
        $this->reset('selectedDateEnd');
    }

    /**
     * > It returns a query builder object that searches for projects, orders them by a field and
     * direction, and filters them by category and status
     * 
     * @return A query builder object.
     */
    public function getProjectsQueryProject()
    {
        return Project::with('categories')
            ->search(trim($this->search))
            ->orderBy($this->sortField, $this->sortDirection)
            ->when($this->selectedCategory, function ($query) {
                return $query->where('category_id', $this->selectedCategory);
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
     * > This function returns a paginated list of projects
     * 
     * @return A paginated collection of projects.
     */
    public function getProjectsProject()
    {
        return $this->projectsQuery->paginate($this->paginate);
    }

    /**
     * It changes the sort field and direction of the projects in the page
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

        $this->projectsInPage = $this->projects->pluck('id')->toArray();
    }

    /**
     * It updates the paginate function.
     */
    public function updatedPaginate()
    {
        $this->projectsInPage = $this->projects->pluck('id')->toArray();
    }

    public function deleteRecord(string $_pid)
    {
        $project = Project::where('id', trim($_pid))->first();

        if ($project->delete()) {
            session()->flash('success', 'Project #' . $project->_pid . ' deleted successfully.');
        } else {
            session()->flash('danger', 'Project #' . $project->_pid . ' not deleted successfully. please try again!');
        }
    }

    /**
     * This PHP function deletes records from a database table based on an array of checked IDs and
     * displays a success message.
     * 
     * @param array checked The parameter `` is an array of IDs of the projects that need to be
     * deleted. The `whereIn` method is used to delete all the projects whose IDs are present in the
     * `` array. The method then displays a success message indicating the number of projects
     * that were deleted. If more
     */
    public function deleteRecords(array $checked)
    {
        Project::whereIn('id', $checked)->delete();

        if (count($checked) > 1) {
            session()->flash('success', number_format(count($checked)) . ' Projects deleted successfully.');
        } else {
            session()->flash('success', number_format(count($checked)) . ' Project deleted successfully.');
        }
    }

    /**
     * > It takes an array of project ids, creates a new instance of the ProjectExport class, and
     * then downloads the file
     * 
     * @param array checked an array of project ids to be exported
     * 
     * @return A download of the file.
     */
    public function exportProjects(array $checked)
    {
        // return (new ProjectExport($checked))->download(now() . ' - projects.xlsx');
    }
}
