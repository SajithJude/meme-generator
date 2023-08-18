<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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
            ->addColumn('action', function ($user) {
                return '<a type="button" href="'. route('students.edit', $user->id) .'" class="btn btn-outline-primary btn-sm mr-2">
                            <i class="ft-edit"></i>&nbsp;Edit
                        </a>
                        <a type="button" href="javascript:" class="btn btn-outline-warning btn-sm mr-2 open-student-courses-modal" data-url="'. route('get.student.courses', $user->id) .'" data-user-id="'. $user->id .'" style="color: black;">
                            <i class="ft-video"></i>&nbsp;Courses
                        </a>';
            })
            ->setRowId('id')
            ->addColumn('status', function ($user) {
                if ($user->status == 1) {
                    return '<span class="badge badge-success">Active</span>';
                } else {
                    return '<span class="badge badge-danger">In-Active</span>';
                }
            })
            ->addColumn('available_booking_counts', function ($user) {
                $count = $user->availableBookingCounts ? $user->availableBookingCounts->booking_count : 0;
                $class = $user->availableBookingCounts ? 'primary' : 'danger';
                return '<span class="badge badge-'.$class.' px-2">'. $count .'</span>';
            })
            ->addColumn('plan', function ($user) {
                return $user->userSubscribedPlans ? ucwords($user->userSubscribedPlans->subscription->plan_name) : 'Free';
            })
            ->addColumn('phone_number', function ($user) {
                return strlen($user->phone_number) > 12 ? substr($user->phone_number, 0, 12) ."..." : $user->phone_number;
            })
            ->rawColumns(['status', 'action', 'plan', 'phone_number', 'available_booking_counts']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->with('availableBookingCounts');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('users_table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0)
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
            Column::make('id'),
            Column::make('first_name'),
            Column::make('email'),
            Column::make('phone_number'),
            Column::computed('plan')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60)
                    ->addClass('text-center'),
            Column::computed('status')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60)
                    ->addClass('text-center'),
            Column::computed('available_booking_counts')
                    ->exportable(false)
                    ->printable(false)
                    ->width(40)
                    ->addClass('text-center')
                    ->title('Booking Credits')
                    ->orderable(false),
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
        return 'Users_' . date('YmdHis');
    }
}
