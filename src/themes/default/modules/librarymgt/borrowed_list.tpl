<!-- BEGIN: main -->
<div class="librarymgt borrowed-list">
    <div class="page-header">
        <h1>{PAGE_TITLE}</h1>
        <a href="{BACK_URL}" class="btn btn-default">
            <i class="fa fa-arrow-left"></i> Quay lại danh sách sách
        </a>
    </div>

    <!-- BEGIN: empty -->
    <div class="alert alert-info">
        <i class="fa fa-info-circle"></i> Bạn chưa có yêu cầu mượn sách nào.
    </div>
    <!-- END: empty -->

    <!-- BEGIN: has_data -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th width="5%">STT</th>
                    <th width="10%">Ảnh</th>
                    <th width="25%">Tên sách</th>
                    <th width="15%">Tác giả</th>
                    <th width="12%">Ngày yêu cầu</th>
                    <th width="10%">Ngày mượn</th>
                    <th width="10%">Hạn trả</th>
                    <th width="8%">Trạng thái</th>
                    <th width="5%">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <!-- BEGIN: loop -->
                <tr>
                    <td class="text-center">{ROW.stt}</td>
                    <td>
                        <!-- BEGIN: has_image -->
                        <img src="{ROW.image}" alt="{ROW.book_title}" class="img-thumbnail" style="max-width: 60px;">
                        <!-- END: has_image -->
                        
                        <!-- BEGIN: no_image -->
                        <div class="no-cover-small">No Cover</div>
                        <!-- END: no_image -->
                    </td>
                    <td>
                        <strong>{ROW.book_title}</strong>
                    </td>
                    <td>{ROW.author}</td>
                    <td>{ROW.request_time_formatted}</td>
                    <td>{ROW.borrow_date_formatted}</td>
                    <td>{ROW.due_date_formatted}</td>
                    <td>
                        <span class="label label-{ROW.status_class}">
                            {ROW.status_text}
                        </span>
                    </td>
                    <td class="text-center">
                        <!-- BEGIN: can_cancel -->
                        <button type="button" class="btn btn-danger btn-sm btn-cancel" data-borrow-id="{ROW.id}" title="Hủy yêu cầu">
                            <i class="fa fa-times"></i>
                        </button>
                        <!-- END: can_cancel -->

                        <!-- BEGIN: cannot_cancel -->
                        <button type="button" class="btn btn-default btn-sm" disabled>
                            <i class="fa fa-minus"></i>
                        </button>
                        <!-- END: cannot_cancel -->
                    </td>
                </tr>
                <!-- END: loop -->
            </tbody>
        </table>
    </div>

    <!-- BEGIN: gp -->
    <div class="text-center">{GENERATE_PAGE}</div>
    <!-- END: gp -->
    <!-- END: has_data -->
</div>

<script type="text/javascript">
$(document).ready(function() {
    // Xử lý nút hủy yêu cầu
    $('.btn-cancel').click(function() {
        var borrowId = $(this).data('borrow-id');
        var btn = $(this);
        
        if (confirm('Bạn có chắc chắn muốn hủy yêu cầu mượn sách này?')) {
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            
            $.ajax({
                type: 'POST',
                url: '{CANCEL_URL}',
                data: {
                    cancel: 1,
                    borrow_id: borrowId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert(response.message);
                        btn.prop('disabled', false).html('<i class="fa fa-times"></i>');
                    }
                },
                error: function() {
                    alert('Có lỗi xảy ra. Vui lòng thử lại!');
                    btn.prop('disabled', false).html('<i class="fa fa-times"></i>');
                }
            });
        }
    });
});
</script>

<style>
.borrowed-list {
    padding: 20px 0;
}
.no-cover-small {
    background: #f5f5f5;
    border: 1px dashed #ddd;
    padding: 10px 5px;
    text-align: center;
    color: #999;
    font-size: 11px;
    border-radius: 3px;
    max-width: 60px;
}
.table > tbody > tr > td {
    vertical-align: middle;
}
</style>
<!-- END: main -->
