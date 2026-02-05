<!-- BEGIN: main -->
<div class="page panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="{CONTENT.image}" alt="{CONTENT.title}" class="img-thumbnail" style="max-width: 100%" />
            </div>
            <div class="col-md-8">
                <h1 class="title margin-bottom-lg">{CONTENT.title}</h1>
                <p><strong>{LANG.author}:</strong> {CONTENT.author}</p>
                <p><strong>{LANG.quantity_available}:</strong> <span class="badge">{CONTENT.quantity}</span></p>
                <div class="margin-bottom-lg">{CONTENT.description}</div>
                <hr />
                <div class="borrow-action">
                    <!-- BEGIN: allow_borrow -->
                    <button class="btn btn-primary btn-lg" onclick="nv_borrow_book({CONTENT.id});">
                        <i class="fa fa-book"></i> {LANG.borrow_book}
                    </button>
                    <!-- END: allow_borrow -->

                    <!-- BEGIN: error_borrow -->
                    <span class="d-inline-block" data-toggle="tooltip" title="{ERROR_MESSAGE}">
                        <button class="btn btn-primary btn-lg disabled" style="pointer-events: none;" type="button" disabled>
                            <i class="fa fa-book"></i> {LANG.borrow_book}
                        </button>
                    </span>
                    <!-- END: error_borrow -->
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function () { $('[data-toggle="tooltip"]').tooltip(); });
function nv_borrow_book(id) {
    if (confirm('{LANG.confirm_borrow}')) {
        $.ajax({
            url: nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=borrow&nocache=' + new Date().getTime(),
            method: 'POST',
            data: { book_id: id },
            dataType: 'json',
            success: function(data) {
                if (data && data.status === 'ok') {
                    alert(data.message || '{LANG.borrow_success}');
                    window.location.href = nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=history';
                } else if (data && data.status === 'need_login') {
                    alert(data.message || 'Please login');
                    window.location.href = nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=users&' + nv_fc_variable + '=login&nv_redirect=' + encodeURIComponent(window.location.href);
                } else if (data && data.status === 'error') {
                    alert(data.message || 'Error');
                } else {
                    console.log('Borrow success unknown response:', data);
                    alert('{LANG.borrow_error_generic}' || 'An unexpected error occurred. Check console.');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Borrow request failed', textStatus, errorThrown, jqXHR.responseText);
                // show short message but keep full HTML response in console for debugging
                alert('{LANG.borrow_error_generic}' || 'An unexpected error occurred. Check console.');
            }
        });
    }
}
</script>
<!-- END: main -->