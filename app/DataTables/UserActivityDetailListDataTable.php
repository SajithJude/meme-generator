<?php

namespace App\DataTables;

use App\Models\UserActivityDetailList;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;
use DB;

class UserActivityDetailListDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $query->orderBy('dated', 'desc'); // Sort by the 'dated' column in descending order
        return (new EloquentDataTable($query))
            ->addColumn('action', 'useractivitydetaillist.action')
            ->editColumn('dated', function ($rec){
                return date('d/M/Y h:i A', strtotime($rec->dated) );
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\UserActivityDetailList $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(UserActivityDetailList $model): QueryBuilder
    {
        //return $model->newQuery();
        //dd($this->draw);
        DB::statement(DB::raw('set @rownum=0'));
        return $model->join('users','users.id','logroutes.user_id')->where('user_id',$this->id)->select(DB::raw('@rownum := @rownum + 1 AS sno'),'users.email','logroutes.page','logroutes.objecttype as item', 'logroutes.objectname as itemname','logroutes.created_at as dated','logroutes.id');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('useractivitydetaillist-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print')
                       
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
            // Column::computed('action')
            //        ->exportable(false)
            //       ->printable(false)
            //       ->width(60)
            //       ->addClass('text-center'),
            Column::make('id')->hidden(),            
            Column::make('email','users.email'),
            Column::make('page','page'),
            Column::make('item','logroutes.itemname'),
            Column::make('itemname','itemname'),
            Column::make('dated','logroutes.dated'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'UserActivityDetailList_' . date('YmdHis');
    }
}
