<?php

namespace App\DataTables;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SubscriptionsDataTable extends DataTable
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
            ->addColumn('action', function ($subscription) {
                return '<a type="button" href="'. route('subscription.edit', $subscription->id) .'" class="btn btn-outline-primary btn-sm mr-2">
                            <i class="ft-edit"></i>&nbsp;Edit
                        </a>';
            })
            ->setRowId('id')
            ->addColumn('status', function ($subscription) {
                if ($subscription->status == 1) {
                    return '<span class="badge badge-success">Active</span>';
                } else {
                    return '<span class="badge badge-danger">In-Active</span>';
                }
            })
            ->addColumn('plan_name', function ($subscription) {
                return isset($subscription->plan_name) ? $subscription->plan_name : 'N/A';
            })
            ->rawColumns(['plan_name', 'status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Subscription $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Subscription $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('subscriptions-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')
                    ->title('ID'),
            Column::make('plans')
                    ->title('Subscription Plan'),
            Column::computed('plan_name')
                    ->title('Plan Name')
                    ->addClass('text-center'),
            Column::make('duration'),
            Column::make('price')
                    ->title('Price ($)'),
            Column::computed('status')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60)
                    ->addClass('text-center'),
            Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->minWidth(210)
                    ->addClass('text-center d-flex justify-content-center')
                    ->orderable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Subscriptions_' . date('YmdHis');
    }
}
