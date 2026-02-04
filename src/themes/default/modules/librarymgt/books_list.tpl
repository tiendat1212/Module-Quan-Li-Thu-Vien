<!-- BEGIN: main -->
<div class="librarymgt">
    <h1>{PAGE_TITLE}</h1>

    <div class="librarymgt-cats">
        <a href="{URL_ALL}" class="btn btn-default">Tất cả</a>

        <!-- BEGIN: cat_loop -->
        <a href="{CAT.link}" class="btn btn-default<!-- BEGIN: active --> active<!-- END: active -->">
            {CAT.name}
        </a>
        <!-- END: cat_loop -->

        <!-- BEGIN: borrowed_link -->
        <a href="{URL_BORROWED}" class="btn btn-primary pull-right">Sách đã mượn</a>
        <!-- END: borrowed_link -->
        <div class="clearfix"></div>
    </div>

    <hr />

    <!-- BEGIN: empty -->
    <div class="alert alert-info">Chưa có sách.</div>
    <!-- END: empty -->

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th style="width:60px">ID</th>
                <th>Tên sách</th>
                <th style="width:220px">Tác giả</th>
                <th style="width:220px">Thể loại</th>
                <th style="width:120px">Số lượng</th>
                <th style="width:140px">Ngày thêm</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td>{ROW.id}</td>
                <td>{ROW.title}</td>
                <td>{ROW.author}</td>
                <td>{ROW.name}</td>
                <td>{ROW.quantity}</td>
                <td>{ROW.add_time}</td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>

    <!-- BEGIN: gp -->
    <div class="text-center">{GENERATE_PAGE}</div>
    <!-- END: gp -->
</div>
<!-- END: main -->
