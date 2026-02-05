<!-- BEGIN: main -->
<table class="table table-bordered table-hover">
<thead>
<tr>
    <th>STT</th>
    <th>Người mượn</th>
    <th>Sách</th>
    <th>Ngày mượn</th>
    <th>Hạn trả</th>
    <th>Trạng thái</th>
    <th>Thao tác</th>
</tr>
</thead>

<tbody>
<!-- BEGIN: row -->
<tr>
    <td>{ROW.stt}</td>
    <td>{ROW.username}</td>
    <td>{ROW.book_title}</td>
    <td>{ROW.borrow_date}</td>
    <td>{ROW.due_date}</td>
    <td>
        <span class="label label-{ROW.status_class}">
            {ROW.status_text}
        </span>
    </td>
    <td>

        <!-- BEGIN: approve -->
        <button class="btn btn-xs btn-success"
                onclick="borrowAction({ROW.id}, 'approve')">
            Duyệt
        </button>
        <!-- END: approve -->

        <!-- BEGIN: cancel -->
        <button class="btn btn-xs btn-danger"
                onclick="borrowAction({ROW.id}, 'cancel')">
            Huỷ
        </button>
        <!-- END: cancel -->

        <!-- BEGIN: return -->
        <button class="btn btn-xs btn-primary"
                onclick="borrowAction({ROW.id}, 'return')">
            Xác nhận trả
        </button>
        <!-- END: return -->

    </td>
</tr>
<!-- END: row -->
</tbody>
</table>



<!-- END: main -->