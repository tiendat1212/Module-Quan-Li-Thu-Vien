<!-- BEGIN: main -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">{LANG.book_add}</h3>
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
                    <input type="file" name="image_file" class="form-control" accept=".jpg,.jpeg,.png,.gif,.webp" />
                    <p class="help-block">{LANG.placeholder_image}</p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{LANG.description}</label>
                <div class="col-sm-9">
                    <textarea name="description" class="form-control" rows="4" placeholder="{LANG.placeholder_description}">{DATA.description}</textarea>
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
                <div class="col-sm-9 col-sm-offset-3">
                    <button type="submit" class="btn btn-primary">{LANG.book_add}</button>
                    <a class="btn btn-default" href="{BACK_URL}">{LANG.back}</a>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- END: main -->
