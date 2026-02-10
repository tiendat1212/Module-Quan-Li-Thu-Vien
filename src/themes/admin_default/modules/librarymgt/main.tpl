<!-- BEGIN: main -->
<div class="well">
    <form action="{NV_BASE_ADMINURL}index.php" method="get" class="form-inline">
        <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
        <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />

        <div class="form-group">
            <div class="input-group">
                <input class="form-control" id="books-search" type="text" name="search" value="{SEARCH}" placeholder="{LANG.search_books}" />
                <span class="input-group-btn">
                    <button type="button" class="btn btn-default" aria-label="Clear" onclick="document.getElementById('books-search').value='';document.getElementById('books-search').focus();">
                        <i class="fa fa-times"></i>
                    </button>
                </span>
            </div>
        </div>

        <div class="form-group">
            <select class="form-control" name="cat_id">
                <option value="0">{LANG.all_categories}</option>
                <!-- BEGIN: category_option -->
                <option value="{CATEGORY_OPTION.id}" {CATEGORY_OPTION.selected}>{CATEGORY_OPTION.name}</option>
                <!-- END: category_option -->
            </select>
        </div>

        <div class="form-group">
            <select class="form-control" name="status">
                <!-- BEGIN: status_option -->
                <option value="{STATUS_OPTION.value}" {STATUS_OPTION.selected}>{STATUS_OPTION.label}</option>
                <!-- END: status_option -->
            </select>
        </div>

        <div class="form-group">
            <select class="form-control" name="sort">
                <option value="ASC" {SORT_ASC_SELECTED}>ID Tăng (ASC)</option>
                <option value="DESC" {SORT_DESC_SELECTED}>ID Giảm (DESC)</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">{LANG.search}</button>
        <a href="{RESET_URL}" class="btn btn-default btn-sm">{LANG.reset_filters}</a>

        <a href="{ADD_BOOK_URL}" class="btn btn-success pull-right">
            <i class="fa fa-plus"></i> {LANG.add_new}
        </a>
        <div class="clearfix"></div>
    </form>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th style="width:60px" class="text-center">ID</th>
                <th>{LANG.title}</th>
                <th style="width:200px">{LANG.author}</th>
                <th style="width:200px">{LANG.category}</th>
                <th style="width:100px" class="text-center">{LANG.quantity}</th>
                <th style="width:120px" class="text-center">{LANG.status}</th>
                <th style="width:140px" class="text-center">{LANG.date}</th>
                <th style="width:140px" class="text-center">{LANG.actions}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td class="text-center">{ROW.id}</td>
                <td>
                    <a href="{ROW.detail_url}" target="_blank" rel="noopener">
                        {ROW.title}
                    </a>
                </td>
                <td>{ROW.author}</td>
                <td>{ROW.cat_title}</td>
                <td class="text-center">
                    <form action="{CURRENT_URL}" method="post" class="form-inline">
                        <input type="hidden" name="quantity_update" value="1" />
                        <input type="hidden" name="book_id" value="{ROW.id}" />
                        <input type="hidden" name="checkss" value="{ROW.checkss}" />
                        <div class="input-group input-group-sm">
                            <input type="number" name="quantity" class="form-control input-sm" value="{ROW.quantity}" min="0" style="width:80px" />
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default btn-sm" title="{LANG.save}">
                                    <i class="fa fa-save"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </td>
                <td class="text-center">
                    <form action="{CURRENT_URL}" method="post" class="form-inline">
                        <input type="hidden" name="status_update" value="1" />
                        <input type="hidden" name="book_id" value="{ROW.id}" />
                        <input type="hidden" name="checkss" value="{ROW.checkss}" />
                        <input type="hidden" name="new_status" value="{ROW.toggle_status}" />
                        <button type="submit" class="btn btn-{ROW.status_class} btn-xs" title="{LANG.status}">
                            {ROW.status_text}
                        </button>
                    </form>
                </td>
                <td class="text-center">{ROW.add_date}</td>
                <td class="text-center text-nowrap">
                    <a href="{ROW.edit_url}" class="btn btn-default btn-xs">
                        <i class="fa fa-fw fa-edit"></i> {GLANG.edit}
                    </a>
                    <a href="{ROW.delete_url}" class="btn btn-danger btn-xs" onclick="return confirm('{LANG.confirm_delete}');">
                        <i class="fa fa-fw fa-trash"></i> {GLANG.delete}
                    </a>
                </td>
            </tr>
            <!-- END: loop -->

            <!-- BEGIN: no_books -->
            <tr>
                <td colspan="8" class="text-center text-muted">{LANG.no_books}</td>
            </tr>
            <!-- END: no_books -->
        </tbody>
    </table>
</div>

<!-- BEGIN: gp -->
<div class="text-center">{GENERATE_PAGE}</div>
<!-- END: gp -->
<!-- END: main -->
