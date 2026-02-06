<!-- BEGIN: main -->
<div class="librarymgt">
    <h1 class="page-header">{PAGE_TITLE}</h1>

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

    <!-- BEGIN: empty -->
    <div class="alert alert-info">Chưa có sách.</div>
    <!-- END: empty -->

    <!-- BEGIN: has_books -->
    <div class="row librarymgt-grid">
        <!-- BEGIN: loop -->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="panel panel-default book-card">
                <div class="book-cover">
                    <!-- BEGIN: has_image -->
                    <img src="{ROW.image}" alt="{ROW.title}">
                    <!-- END: has_image -->

                    <!-- BEGIN: no_image -->
                    <div class="no-cover"><span>No Cover</span></div>
                    <!-- END: no_image -->
                </div>

                <div class="book-info">
                    <h4 class="book-title" title="{ROW.title}">{ROW.title}</h4>

                    <div class="book-meta">
                        <div><span class="book-label">Tác giả:</span> {ROW.author}</div>
                        <div><span class="book-label">Thể loại:</span> {ROW.name}</div>
                    </div>
                </div>

                <div class="book-footer">
                    <span class="label label-info">SL: {ROW.quantity}</span>
                    <small class="text-muted">{ROW.add_time}</small>
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
