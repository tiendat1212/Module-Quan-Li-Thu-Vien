<!-- BEGIN: main -->
<!-- BEGIN: select_book -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">{LANG.select_book}</h3>
    </div>
    <div class="panel-body">
        <form action="{NV_BASE_ADMINURL}index.php" method="get" class="form-horizontal">
            <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
            <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />

            <div class="form-group">
                <label class="col-sm-3 control-label">{LANG.select_book_prompt}</label>
                <div class="col-sm-9">
                    <select name="book_id" class="form-control">
                        <!-- BEGIN: book_option -->
                        <option value="{BOOK.id}">#{BOOK.id} - {BOOK.title} ({BOOK.author})</option>
                        <!-- END: book_option -->
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="col-sm-9">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-edit"></i> {LANG.edit}
                    </button>
                    <a href="{BACK_URL}" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> {LANG.back}
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- END: select_book -->

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">{LANG.book_edit}</h3>
    </div>
    <div class="panel-body">
        <!-- BEGIN: error -->
        <div class="alert alert-danger">
            <ul class="list-unstyled">
                <!-- BEGIN: error_item -->
                <li>{ERROR.message}</li>
                <!-- END: error_item -->
            </ul>
        </div>
        <!-- END: error -->

        <form action="{NV_BASE_ADMINURL}index.php" method="post" class="form-horizontal" enctype="multipart/form-data">
            <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
            <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
            <input type="hidden" name="book_id" value="{BOOK_ID}" />
            <input type="hidden" name="submit" value="1" />

            <div class="form-group">
                <label class="col-sm-3 control-label">{LANG.title}</label>
                <div class="col-sm-9">
                    <input type="text" name="title" class="form-control" value="{DATA.title}" placeholder="{LANG.placeholder_title}" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{LANG.author}</label>
                <div class="col-sm-9">
                    <input type="text" name="author" class="form-control" value="{DATA.author}" placeholder="{LANG.placeholder_author}" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{LANG.category}</label>
                <div class="col-sm-9">
                    <select name="cat_id" class="form-control">
                        <option value="0">{LANG.placeholder_category}</option>
                        <!-- BEGIN: category_option -->
                        <option value="{CATEGORY.id}" {CATEGORY.selected}>{CATEGORY.name}</option>
                        <!-- END: category_option -->
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{LANG.publisher}</label>
                <div class="col-sm-9">
                    <input type="text" name="publisher" class="form-control" value="{DATA.publisher}" placeholder="{LANG.placeholder_publisher}" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{LANG.publish_year}</label>
                <div class="col-sm-9">
                    <input type="number" name="publish_year" class="form-control" value="{DATA.publish_year}" placeholder="{LANG.placeholder_publish_year}" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{LANG.isbn_label}</label>
                <div class="col-sm-9">
                    <input type="text" name="isbn" class="form-control" value="{DATA.isbn}" placeholder="{LANG.placeholder_isbn}" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{LANG.quantity}</label>
                <div class="col-sm-9">
                    <input type="number" name="quantity" class="form-control" value="{DATA.quantity}" placeholder="{LANG.placeholder_quantity}" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{LANG.image}</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input class="form-control" type="text" name="image" id="id_image" value="{DATA.image}" />
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-info" data-toggle="selectfile" data-target="id_image" data-path="{UPLOADS_DIR_USER}" data-type="image">
                                <em class="fa fa-folder-open-o"></em> {GLANG.browse_image}
                            </button>
                        </span>
                    </div>
        
                    <div style="margin-top: 10px;">
                        <p><strong>{LANG.current_image}:</strong></p>
                        <img src="{NV_BASE_SITEURL}{NV_UPLOADS_DIR}/{MODULE_UPLOAD}/{CURRENT_IMAGE}" alt="Book cover" class="img-thumbnail" style="max-width: 200px;" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{LANG.description}</label>
                <div class="col-sm-9">
                    <textarea name="description" class="form-control" rows="5" placeholder="{LANG.placeholder_description}">{DATA.description}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{LANG.status}</label>
                <div class="col-sm-9">
                    <select name="status" class="form-control">
                        <!-- BEGIN: status_option -->
                        <option value="{STATUS.value}" {STATUS.selected}>{STATUS.label}</option>
                        <!-- END: status_option -->
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="col-sm-9">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> {LANG.save}
                    </button>
                    <a href="{BACK_URL}" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> {LANG.back}
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- END: main -->
