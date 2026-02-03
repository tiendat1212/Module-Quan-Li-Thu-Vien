<!-- BEGIN: main -->
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr class="text-center">
                <th width="50">{LANG.stt}</th>
                <th>{LANG.book_name}</th>
                <th width="150">{LANG.borrow_date}</th>
                <th width="150">{LANG.return_date}</th>
                <th width="120">{LANG.status}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">{ROW.stt}</td>
                <td><strong>{ROW.book_name}</strong></td>
                <td class="text-center">{ROW.date}</td>
                <td class="text-center">
                    <span class="{ROW.class_due}">{ROW.due_date_text}</span>
                </td>
                <td class="text-center">
                    <span class="label label-{ROW.status_class}">{ROW.status_text}</span>
                </td>
            </tr>
            </tbody>
    </table>
</div>

<div class="text-center">
    {GENERATE_PAGE}
</div>
<!-- END: main -->