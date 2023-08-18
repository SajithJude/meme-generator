<?php

namespace App\DataTables;

use App\Models\UserLoginLog;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use DB;

class UserslogsDataTable extends DataTable
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
            
            ->editColumn('created_at', function ($contact){
                return date('d/m/y H:i', strtotime($contact->created_at) );
            })
            
            ->editColumn('updated_at', function ($contact){
                return date('d/m/y H:i', strtotime($contact->updated_at) );
            })
            
            ->setRowId('id')
            ->addIndexColumn('sno')
            
            // ->make(true);
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Userslog $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(UserLoginLog $model): QueryBuilder
    {
        DB::statement(DB::raw('set @rownum=0'));
        return $model->join('users','users.id','user_login_logs.user_id')->select(DB::raw('@rownum := @rownum + 1 AS sno'),'users.email as email','user_login_logs.*');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {


        return $this->builder()
                    ->setTableId('userlogs-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print')
                        //,
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
            Column::make('email','users.email'),
            Column::make('login_at'),
            Column::make('logout_at'),
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
        return 'Userslogs_' . date('YmdHis');
    }
}
