<?php

namespace App\DataTables;

use App\Models\useractivity;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use DB;

class useractivityDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            //->addColumn('action', 'useractivity.action')
            ->addColumn('action', function ($user) {
                return '<a target="__blank" type="button" href="'.url('admin/user/activity/details').'/'.$user->id.'" class="btn btn-outline-primary btn-sm edit-settings">
                    <i class="ft-view"></i>&nbsp;View&nbsp;Details
                </a>';
            })
            ->setRowId('id')
            ->editColumn('logroutes.created_at', function ($contact){
                return date_format($contact->created_at,"Y/m/d H:i:s");
            })            
            ->addIndexColumn('sno');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\useractivity $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(useractivity $model): QueryBuilder
    {
        //return $model->newQuery();
        DB::statement(DB::raw('set @rownum=0'));
        return $model->join('users','users.id','logroutes.user_id')->select(DB::raw('@rownum := @rownum + 1 AS sno'),'users.email','logroutes.created_at','users.id')
        ->groupBy('users.email')->orderBy('logroutes.created_at','desc');
        ;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('useractivity-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        //Button::make('reset'),
                        //Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            //Column::make('sno','sno')->searchable(false),
            Column::computed('action'),
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(60)
            //       ->addClass('text-center'),
            Column::make('id')->hidden(),
            
            Column::make('email','users.email'),
            Column::make('created_at','logroutes.created_at'),
            
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'useractivity_' . date('YmdHis');
    }
}
