<!-- BEGIN: main -->

<!-- BEGIN: error -->
<div class="alert alert-danger">
    {ERROR}
</div>

<script>
    $(document).ready(function () {
        $('#catModal').modal('show');
    });
</script>
<!-- END: error -->

<div class="text-right" style="margin-bottom: 10px;">
    <button class="btn btn-primary" onclick="nv_add_cat();">
        <i class="fa fa-plus"></i> Thêm thể loại
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="text-center" width="50">STT</th>
                <th>Tên thể loại</th>
                <th>Mô tả</th>
                <th>Ngày tạo</th>
                <th class="text-center" width="150">Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <!-- BEGIN: row -->
            <tr>
                <td class="text-center">{ROW.stt}</td>
                <td><strong>{ROW.title}</strong></td>
                <td>{ROW.description}</td>
                <td>{ROW.add_time_str}</td>
                <td class="text-center">
                    <button class="btn btn-xs btn-default" onclick="nv_edit_cat({ROW.id});">
                        <i class="fa fa-edit"></i> Sửa
                    </button>

                    <button class="btn btn-xs btn-danger" onclick="nv_del_cat({ROW.id});">
                        <i class="fa fa-trash"></i> Xóa
                    </button>
                </td>
            </tr>
        <!-- END: row -->
        </tbody>
    </table>
</div>

<div class="modal fade" id="catModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h4 class="modal-title" id="modalTitle">Thêm thể loại</h4>
            </div>

            <form action="{ACTION_URL}" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="{ROW_EDIT.id}">
                    <input type="hidden" name="save" value="1">

                    <div class="form-group">
                        <label>
                            Tên thể loại <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               id="title"
                               class="form-control"
                               required
                               value="{ROW_EDIT.title}"
                               placeholder="Nhập tên thể loại...">
                    </div>

                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea name="description"
                                  id="description"
                                  class="form-control"
                                  rows="3">{ROW_EDIT.description}</textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var cat_action_url = '{ACTION_URL}';
</script>
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/admin_default/js/lib_cat.js"></script>

<!-- END: main -->
