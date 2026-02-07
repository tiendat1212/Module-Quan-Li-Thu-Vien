/**
 * Quản lý mượn / trả sách - Admin
 */

function borrowAction(id, action) {
    if (!id || !action) return;

    let msg = '';

    switch (action) {
        case 'approve':
            msg = 'Bạn có chắc muốn DUYỆT yêu cầu mượn này?';
            break;
        case 'cancel':
            msg = 'Bạn có chắc muốn HUỶ yêu cầu mượn này?';
            break;
        case 'return':
            msg = 'Xác nhận sách đã được TRẢ?';
            break;
    }

    if (!confirm(msg)) {
        return;
    }

    $.ajax({
        type: 'POST',
        url: window.location.href,
        data: {
            action: action,
            id: id
        },
        success: function (res) {
            if (res === 'OK') {
                window.location.reload();
            } else {
                alert(res);
            }
        },
        error: function () {
            alert('Lỗi hệ thống hoặc mất kết nối!');
        }
    });
}
