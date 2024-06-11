<?php

namespace App\Modules\Auth\Livewire;

use App\Modules\Auth\Models\CompanyRoles;
use App\Modules\Auth\Traits\Authorize;
use Zofe\Rapyd\Traits\WithDataTable;
use Livewire\Component;

class CompaniesRolesTable extends Component
{
    use Authorize;
    use WithDataTable;
    public $search;


    public function mount()
    {
        $this->sortField = 'name';
        $this->sortAsc = true;
    }
    public function booted()
    {
        $this->authorize('admin');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function getDataSet()
    {
        $search = $this->search;
        $items = CompanyRoles::ssearch($search)->with(['company','users'])
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return $items;
    }

    public function render()
    {
        $items = $this->getDataSet();

        return view('auth::company_roles_table', compact('items'))
            ->layout('auth::admin');
    }
}
