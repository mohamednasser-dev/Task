<?php

namespace App\DataTables;

use App\Models\Supervisor;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SupervisorDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)->setRowId('id')->addColumn('password', '');
//        return datatables()
//            ->eloquent($query)
//            ->addColumn('action', 'supervisor.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Supervisor $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Supervisor $model)
    {
//        return $model->newQuery();
        return $model->newQuery()->select('id', 'name', 'email');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('supervisor-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()

                ->parameters([
                    'dom' => 'Bfrtip',
                    'order' => [1, 'asc'],
                    'select' => [
                        'style' => 'os',
                        'selector' => 'td:first-child',
                    ],
                    'buttons' => [
                        ['extend' => 'create', 'editor' => 'editor'],
                        ['extend' => 'edit', 'editor' => 'editor'],
                        ['extend' => 'remove', 'editor' => 'editor'],
                    ]
                ]);
//        ->orderBy(1)
//                    ->buttons(
//                        Button::make('create'),
//                        Button::make('export'),
//                        Button::make('print'),
//                        Button::make('reset'),
//                        Button::make('reload')
//                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            [
                'data' => null,
                'defaultContent' => '',
                'className' => 'select-checkbox',
                'title' => '',
                'orderable' => false,
                'searchable' => false
            ],
            'id',
            'name',
            'email',
        ];

//        return [
//            'id',
//            'name',
//            'phone',
//            'email'
//        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Supervisor_' . date('YmdHis');
    }
}
