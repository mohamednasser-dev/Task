<?php

namespace App\DataTables;

use App\Models\Supervisor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTablesEditor;

class SupervisorDataTableEditor extends DataTablesEditor
{
    protected $model = Supervisor::class;

    /**
     * Get create action validation rules.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'email' => 'required|email|unique:' . $this->resolveModel()->getTable(),
            'name'  => 'required',
        ];
    }

    /**
     * Get edit action validation rules.
     *
     * @param Model $model
     * @return array
     */
    public function editRules(Model $model)
    {
        return [
            'email' => 'sometimes|required|email|' . Rule::unique($model->getTable())->ignore($model->getKey()),
            'name'  => 'sometimes|required',
        ];
    }

    /**
     * Get remove action validation rules.
     *
     * @param Model $model
     * @return array
     */
    public function removeRules(Model $model)
    {
        return [];
    }
    public function creating(Model $model, array $data)
    {
        $data['password'] = bcrypt($data['password']);
    }

    /**
     * Pre-update action event hook.
     *
     * @param Model $model
     * @return array
     */
    public function updating(Model $model, array $data)
    {
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }
        return $data;
    }
}
