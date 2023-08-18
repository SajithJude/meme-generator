<?php

namespace App\DataTables;

use App\Models\Webinar;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class WebinarsDataTable extends DataTable
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
            ->addColumn('action', function ($webinar) {
                return '<a type="button" href="'. route('webinar.edit', $webinar->id) .'" class="btn btn-outline-primary btn-sm mr-2">
                    <i class="ft-edit"></i>&nbsp;Edit
                </a>
                <a type="button" href="javascript:void(0)" data-table="webinars_table" data-method="get" data-url="'. route('webinar.destroy', $webinar->id) .'" class="btn btn-outline-danger btn-sm delete">
                    <i class="ft-trash"></i>&nbsp;Delete
                </a>';
            })
            ->setRowId('id')
            ->addColumn('image', function ($webinar) {
                return !empty($webinar->image) ? '<img style="max-height: 100px; max-width: 100px;" src="'. asset('assets/img/'.$webinar->image).'">' : 'N/A';
            })
            ->addColumn('video_url', function ($webinar) {
                return strlen($webinar->video_url) > 30 ? substr($webinar->video_url, 0, 30). "..." : $webinar->video_url;
            })
            ->addColumn('accessibility', function ($webinar) {
                return $webinar->accessibility == 1 ? '<span class="badge badge-primary">Paid</span>' : '<span class="badge badge-dark">Free</span>';
            })
            ->rawColumns(['action', 'image', 'video_url', 'accessibility']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Webinar $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Webinar $model): QueryBuilder
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
                    ->setTableId('webinars-table')
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
                    ->title('#'),
            Column::make('video_url')
                    ->title('Webinar URL'),
            Column::make('type'),
            Column::make('date')
                    ->minWidth(210),
            Column::make('instructor')
                    ->title('Instructor Name'),
            Column::computed('accessibility')
                    ->title('User Accessibility')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60)
                    ->addClass('text-center'),
            Column::computed('image')
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
        return 'Webinars_' . date('YmdHis');
    }
}
