<!-- BEGIN: main -->
<div class="librarymgt">
    <h1 class="page-header">{PAGE_TITLE}</h1>

    <div class="librarymgt-cats" style="margin-bottom: 15px;">
        <a href="{URL_ALL}" class="btn btn-default">Tất cả</a>

        <!-- BEGIN: cat_loop -->
        <a href="{CAT.link}" class="btn btn-default<!-- BEGIN: active --> active<!-- END: active -->" style="margin-left: 6px;">
            {CAT.name}
        </a>
        <!-- END: cat_loop -->

        <!-- BEGIN: borrowed_link -->
        <a href="{URL_BORROWED}" class="btn btn-primary pull-right">Sách đã mượn</a>
        <!-- END: borrowed_link -->
        <div class="clearfix"></div>
    </div>

    <!-- BEGIN: empty -->
    <div class="alert alert-info">Chưa có sách.</div>
    <!-- END: empty -->

    <!-- BEGIN: has_books -->
    <div class="row">
        <!-- BEGIN: loop -->
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3" style="margin-bottom: 18px;">
            <div class="panel panel-default" style="height: 100%;">
                <div class="panel-body" style="padding: 10px;">
                    <div style="width: 100%; aspect-ratio: 3/4; background: #f5f5f5; border: 1px solid #eee; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                        <!-- Nếu có ảnh bìa thì hiển thị -->
                        <!-- BEGIN: has_image -->
                        <img src="{ROW.image}" alt="{ROW.title}" style="width:100%; height:100%; object-fit:cover;">
                        <!-- END: has_image -->

                        <!-- Nếu không có ảnh -->
                        <!-- BEGIN: no_image -->
                        <div style="padding: 10px; text-align:center; color:#999;">
                            No Cover
                        </div>
                        <!-- END: no_image -->
                    </div>

                    <h4 style="margin: 10px 0 6px; font-size: 16px; font-weight: 600; line-height: 1.2; height: 38px; overflow: hidden;">
                        {ROW.title}
                    </h4>

                    <div style="color:#555; margin-bottom: 6px;">
                        <strong>Tác giả:</strong> {ROW.author}
                    </div>
                    <div style="color:#555; margin-bottom: 6px;">
                        <strong>Thể loại:</strong> {ROW.name}
                    </div>

                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top: 8px;">
                        <span class="label label-info">SL: {ROW.quantity}</span>
                        <small style="color:#888;">{ROW.add_time}</small>
                    </div>
                </div>

                <div class="panel-footer" style="display:flex; gap:8px; justify-content:space-between; align-items:center;">
                    <!-- (Tuỳ chọn) Nút chi tiết nếu bạn có trang detail -->
                    <!-- <a class="btn btn-default btn-xs" href="{ROW.link}">Chi tiết</a> -->

                    <!-- (Tuỳ chọn) Nút mượn: bạn làm sau -->
                    <!-- <a class="btn btn-success btn-xs" href="{ROW.borrow_link}">Mượn</a> -->

                    <span></span>
                </div>
            </div>
        </div>
        <!-- END: loop -->
    </div>

    <!-- BEGIN: gp -->
    <div class="text-center">{GENERATE_PAGE}</div>
    <!-- END: gp -->
    <!-- END: has_books -->
</div>
<!-- END: main -->
