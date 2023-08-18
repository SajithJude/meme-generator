{{--    START: Model --}}
<div class="modal fade text-left" id="common_modal" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="basicModalLabel1">Delete Boat Type</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p> {{ $message }}? !</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="{{$action_id}}">  {{ $action_btn }}</button>
            </div>
        </div>
    </div>
</div>

{{--    END: Model --}}
