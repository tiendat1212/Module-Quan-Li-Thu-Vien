<!-- BEGIN: main -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">{LANG.book_list}</h1>
    </div>

    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width: 60px">#</th>
                        <th>{LANG.book_title}</th>
                        <th style="width: 200px">{LANG.book_author}</th>
                        <th style="width: 180px">{LANG.book_category}</th>
                        <th style="width: 120px" class="text-center">{LANG.book_quantity}</th>
                        <th style="width: 140px">{LANG.book_created_at}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- BEGIN: loop -->
                    <tr>
                        <td class="text-center">{LOOP.id}</td>
                        <td>{LOOP.title}</td>
                        <td>{LOOP.author}</td>
                        <td>{LOOP.category_name}</td>
                        <td class="text-center">{LOOP.quantity}</td>
                        <td>{LOOP.created_at}</td>
                    </tr>
                    <!-- END: loop -->
                </tbody>
            </table>
        </div>

        <!-- BEGIN: gp -->
        <div class="text-center">{GENERATE_PAGE}</div>
        <!-- END: gp -->
    </div>
</div>
<!-- END: main -->