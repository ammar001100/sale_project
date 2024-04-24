<div class="modal fade" id="modal-danger">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h4 class="modal-title">تحذير</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>هل انت متاكد من عملية الحذف ؟</p>
            </div>
            <div class="modal-footer justify-content-between">
                <a href="{{ route('admin.treasuries.delete_treasuries_delivery', $info->id) }}" type="button"
                    class="btn btn-outline-light">متابعة</a>
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">الغاء</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
