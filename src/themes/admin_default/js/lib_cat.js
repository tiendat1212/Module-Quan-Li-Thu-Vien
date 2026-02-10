/**
 * File: themes/admin_default/js/library_cat.js
 */

// Hàm mở cửa sổ Thêm
function nv_add_cat() {
    $('#id').val(0);
    $('#title').val('');
    $('#description').val('');
    $('#modalTitle').text('Thêm thể loại mới');
    $('#catModal').modal('show');
}

// Hàm mở cửa sổ Sửa
function nv_edit_cat(id) {
    $.get(
        cat_action_url + '&get=1&id=' + id,
        function (res) {
            $('#id').val(res.id);
            $('#title').val(res.title);
            $('#description').val(res.description);
            $('#modalTitle').text('Sửa thông tin thể loại');
            $('#catModal').modal('show');
        },
        'json'
    ).fail(function () {
        alert('Không lấy được dữ liệu thể loại');
    });
}


// Hàm Xóa
// Lưu ý: Biến cat_action_url sẽ được định nghĩa ở file TPL
function nv_del_cat(id) {
    if (confirm('Bạn có muốn xóa thể loại này không?')) {
        $.post(cat_action_url, 'delete_id=' + id, function(res) {
           var response = res.trim();
            
            if (response == 'OK') {
                window.location.reload();
            } else if (response.includes('ERROR')) {
                alert(response.replace('ERROR:', '').trim());
            } else {
                alert('Lỗi không xác định: ' + response);
            }
        }).fail(function() {
             alert("Lỗi kết nối hoặc lỗi server (500/Decoding Failed)");
        });
    }
}