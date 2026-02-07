{PHP}
{LANG.books_manager}
{/PHP}

<!-- BEGIN: main -->
<div class="container-xl">
    <div class="page-wrapper">
        <!-- Page body -->
        <div class="page-body">
            <div class="row row-deck row-cards">
                <div class="col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{LANG.books_manager}</h3>
                            <div class="card-actions">
                                <a href="{ADD_BOOK_URL}" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                    {LANG.add_new}
                                </a>
                            </div>
                        </div>
                        
                        <!-- Filter Form -->
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex">
                                <div class="text-muted">
                                    <form method="GET" class="d-flex gap-2">
                                        <input type="hidden" name="{NAME_VARIABLE}" value="{MODULE_NAME}">
                                        <input type="hidden" name="{OP_VARIABLE}" value="main">
                                        
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                            </span>
                                            <input type="text" name="search" class="form-control" placeholder="{LANG.search_books}" value="{SEARCH}">
                                        </div>
                                        
                                        <select name="cat_id" class="form-select" style="width: auto;">
                                            <option value="0">{LANG.all_categories}</option>
                                            <!-- BEGIN: category_option -->
                                            <option value="{CATEGORY.id}" {CATEGORY.selected}>{CATEGORY.name}</option>
                                            <!-- END: category_option -->
                                        </select>
                                        
                                        <button type="submit" class="btn btn-outline-secondary">
                                            {LANG.search}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Books Table -->
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>{LANG.title}</th>
                                        <th>{LANG.author}</th>
                                        <th>{LANG.category}</th>
                                        <th>{LANG.quantity}</th>
                                        <th>{LANG.status}</th>
                                        <th>{LANG.date}</th>
                                        <th>{LANG.actions}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- BEGIN: book_loop -->
                                    <tr>
                                        <td>
                                            <span class="text-muted">{BOOK.id}</span>
                                        </td>
                                        <td>
                                            <div class="text-truncate">
                                                <a href="#" class="text-reset text-decoration-none">{BOOK.title}</a>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-blue text-white">{BOOK.author}</span>
                                        </td>
                                        <td>
                                            <span>{BOOK.cat_title}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                <!-- BEGIN: quantity_warning -->
                                                <span class="badge badge-sm bg-warning">
                                                <!-- END: quantity_warning -->
                                                {BOOK.quantity}
                                                <!-- BEGIN: quantity_warning -->
                                                </span>
                                                <!-- END: quantity_warning -->
                                            </span>
                                        </td>
                                        <td>
                                            <!-- BEGIN: status_active -->
                                            <span class="badge bg-success">{BOOK.status_text}</span>
                                            <!-- END: status_active -->
                                            <!-- BEGIN: status_inactive -->
                                            <span class="badge bg-danger">{BOOK.status_text}</span>
                                            <!-- END: status_inactive -->
                                        </td>
                                        <td>
                                            <span class="text-muted">{BOOK.add_date}</span>
                                        </td>
                                        <td>
                                            <div class="btn-list flex-nowrap">
                                                <a href="{BOOK.edit_url}" class="btn btn-icon btn-ghost-primary" title="{LANG.edit}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                                </a>
                                                <a href="#" onclick="confirmDelete({BOOK.id}, '{BOOK.title|escape}'); return false;" class="btn btn-icon btn-ghost-danger" title="{LANG.delete}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- END: book_loop -->
                                    
                                    <!-- BEGIN: no_books -->
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-6">
                                            <p>{LANG.no_books}</p>
                                        </td>
                                    </tr>
                                    <!-- END: no_books -->
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <!-- BEGIN: pagination -->
                        <div class="card-footer d-flex align-items-center">
                            <p class="text-muted m-0 flex-fill">
                                {TOTAL_BOOKS} {LANG.books}
                            </p>
                            <ul class="pagination m-0 ms-auto">
                                {PAGINATION}
                            </ul>
                        </div>
                        <!-- END: pagination -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Delete Modal -->
<div class="modal modal-blur fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9l.463 -11.038c.164 -.957 .888 -1.738 1.845 -1.962m0 0a2.009 2.009 0 0 1 1.974 .224m-4.282 1.738a2 2 0 0 0 -1.974 .224c.957 .224 1.681 1.005 1.845 1.962" /><path d="M16.757 3h2.fed a1 1 0 0 1 .996 1.09l-.41 5.173a2 2 0 0 1 -1.991 1.737h-.802a2 2 0 0 1 -1.99 -1.737l-.41 -5.173a1 1 0 0 1 .996 -1.09z" /><path d="M9 6h6" /><path d="M6 9a1 1 0 0 0 -1 1v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-12a1 1 0 0 0 -1 -1" /><path d="M9 12v6" /><path d="M12 12v6" /><path d="M15 12v6" /></svg>
                <h3>{LANG.confirm_delete}</h3>
                <p class="text-muted">Sách: <strong id="deleteBookTitle"></strong></p>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col"><a href="#" class="btn btn-white w-100" data-bs-dismiss="modal">
                                {LANG.back}
                            </a></div>
                        <div class="col"><a href="#" class="btn btn-danger w-100" id="confirmDeleteBtn">
                                {LANG.delete}
                            </a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(bookId, bookTitle) {
        document.getElementById('deleteBookTitle').textContent = bookTitle;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
        
        document.getElementById('confirmDeleteBtn').onclick = function(e) {
            e.preventDefault();
            // Gửi request xóa sách
            const url = window.location.href.split('?')[0] + '?' + 
                'mod=librarymgt&op=main&op_delete=delete&book_id=' + bookId;
            window.location.href = url;
        };
    }
</script>

<!-- END: main -->
