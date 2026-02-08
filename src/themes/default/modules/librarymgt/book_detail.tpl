<!-- BEGIN: main -->
<div class="librarymgt book-detail">
    <div class="page-header">
        <h1>{BOOK.title}</h1>
        <div class="header-control-buttons">
            <a href="{BACK_URL}" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Quay lại
            </a>

            <div class="book-actions">
                <!-- BEGIN: can_borrow -->
                <button type="button" class="btn btn-primary btn-lg btn-borrow" data-book-id="{BOOK.id}">
                    <i class="fa fa-book"></i> Mượn sách
                </button>
                <!-- END: can_borrow -->

                <!-- BEGIN: cannot_borrow -->
                <button type="button" class="btn btn-default btn-lg" disabled data-toggle="tooltip" title="{DISABLED_REASON}">
                    <i class="fa fa-lock"></i> Không thể mượn
                </button>
                <!-- END: cannot_borrow -->
            </div>
        </div>
        
    </div>

    <div class="row">
        <div class="col-md-10 col-sm-10">
            <div class="book-detail-cover">
                <!-- BEGIN: has_image -->
                <img src="{BOOK.image}" alt="{BOOK.title}" class="img-responsive img-thumbnail">
                <!-- END: has_image -->
                
                <!-- BEGIN: no_image -->
                <div class="no-cover-large">
                    <span>No Cover Available</span>
                </div>
                <!-- END: no_image -->
            </div>
        </div>

        <div class="col-md-12 col-sm-12">
            <div class="book-detail-info">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th width="30%">Tác giả:</th>
                            <td>{BOOK.author}</td>
                        </tr>
                        <tr>
                            <th>Thể loại:</th>
                            <td>{BOOK.cat_title}</td>
                        </tr>
                        <tr>
                            <th>ISBN:</th>
                            <td>{BOOK.isbn}</td>
                        </tr>
                        <tr>
                            <th>Nhà xuất bản:</th>
                            <td>{BOOK.publisher}</td>
                        </tr>
                        <tr>
                            <th>Năm xuất bản:</th>
                            <td>{BOOK.publish_year}</td>
                        </tr>
                        <tr>
                            <th>Số lượng còn lại:</th>
                            <td>
                                <span class="label label-{BOOK.quantity > 0 ? 'success' : 'danger'}">
                                    {BOOK.quantity} cuốn
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Ngày thêm:</th>
                            <td>{BOOK.add_time_formatted}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="book-description">
                    <h3>Mô tả:</h3>
                    <p>{BOOK.description}</p>
                </div>

                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    // Kích hoạt tooltip
    $('[data-toggle="tooltip"]').tooltip();
    
    // Xử lý nút mượn sách
    $('.btn-borrow').click(function() {
        var bookId = $(this).data('book-id');
        var btn = $(this);
        
        if (confirm('Bạn có chắc chắn muốn mượn sách này?')) {
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...');
            
            $.ajax({
                type: 'POST',
                url: '{BORROW_URL}',
                data: {
                    save: 1,
                    book_id: bookId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        window.location.href = '{BACK_URL}&{NV_OP_VARIABLE}=borrowed';
                    } else {
                        alert(response.message);
                        btn.prop('disabled', false).html('<i class="fa fa-book"></i> Mượn sách');
                    }
                },
                error: function() {
                    alert('Có lỗi xảy ra. Vui lòng thử lại!');
                    btn.prop('disabled', false).html('<i class="fa fa-book"></i> Mượn sách');
                }
            });
        }
    });
});
</script>


<!-- END: main -->
