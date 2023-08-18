<div class="modal fade" id="subscriptionOrderModal" tabindex="-1" role="dialog" aria-labelledby="subscriptionOrderModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Edit Subscription Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="subscriptionOrderModalForm" class="update-subscription-order-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input name="start_date" id="start_date" type="date" class="form-control" required onchange="console.log($(this).val())">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input name="end_date" id="end_date" type="date" class="form-control" required onchange="console.log($(this).val())">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>