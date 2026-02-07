<!-- BEGIN: main -->

<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Quản lý mượn / trả sách</strong>
    </div>

    <div class="panel-body">

        <!-- SEARCH + FILTER -->
        <form method="get" class="row" style="margin-bottom: 15px;">
            <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}">
            <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}">
            <input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}">

            <!-- Search -->
            <div class="col-sm-6">
                <input type="text"
                       name="q"
                       value="{Q}"
                       class="form-control"
                       placeholder="Tìm theo tên sách hoặc người mượn">
            </div>

            <!-- Filter status -->
            <div class="col-sm-4">
                <select name="status" class="form-control">
                    <option value="-1">-- Tất cả trạng thái --</option>
                    <!-- BEGIN: status -->
                    <option value="{STATUS.key}" {STATUS.selected}>
                        {STATUS.text}
                    </option>
                    <!-- END: status -->
                </select>
            </div>

            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary btn-block">
                    Lọc
                </button>
            </div>
        </form>

        <!-- TABLE -->
        <table class="table table-bordered table-hover">
            <thead>
            <tr class="info">
                <th width="50">ID</th>
                <th>Tên sách</th>
                <th>Người mượn</th>
                <th>Ngày mượn</th>
                <th>Hạn trả</th>
                <th width="120">Trạng thái</th>
                <th width="180">Hành động</th>
            </tr>
            </thead>

            <tbody>
            <!-- BEGIN: row -->
            <tr>
                <td>{ROW.id}</td>
                <td>{ROW.book_title}</td>
                <td>{ROW.username}</td>
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

    </div>
</div>

<script>
    var cat_action_url = '{ACTION_URL}';
</script>
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/admin_default/js/lib_borrows.js"></script>

<!-- END: main -->
