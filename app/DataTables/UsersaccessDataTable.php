<?php

namespace App\DataTables;

use App\Models\Usersaccess;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use DB;

class UsersaccessDataTable extends DataTable
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
            //->addColumn('action', 'usersaccess.action')
            ->setRowId('id')
            ->editColumn('created_at', function ($contact){
                return date('d/m/y H:i', strtotime($contact->created_at) );
            })
            
            ->editColumn('updated_at', function ($contact){
                return date('d/m/y H:i', strtotime($contact->updated_at) );
            })
            
            ->addIndexColumn('sno');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Usersaccess $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Usersaccess $model): QueryBuilder
    {
        //return $model->newQuery();
        DB::statement(DB::raw('set @rownum=0'));
        return $model->join('users','free_user_course_access.user_id','users.id')
                ->join('courses','courses.id','free_user_course_access.course_id')->select(DB::raw('@rownum := @rownum + 1 AS sno'),'courses.course_title', 'users.first_name', 'users.last_name','users.email','free_user_course_access.*');


    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('usersaccess-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
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
            // Column::computed('action')
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(60)
            //       ->addClass('text-center'),
            Column::make('sno','sno')->searchable(false),
            Column::make('id')->hidden(),
            Column::make('first_name','users.first_name'),
            Column::make('last_name','users.last_name'),
            Column::make('email','users.email'),
            Column::make('course_title','courses.course_title'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Usersaccess_' . date('YmdHis');
    }
}
