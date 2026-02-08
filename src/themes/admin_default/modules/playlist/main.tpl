<!-- BEGIN: main -->
<div class="page">
    <!-- BEGIN: loop -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <img src="{LOOP.thumbnail}" alt="{LOOP.title}" class="img-fluid" style="max-height: 100px;">
                </div>
                <div class="col-md-6">
                    <h5>{LOOP.title}</h5>
                    <p class="text-muted">{LOOP.description}</p>
                </div>
                <div class="col-md-3 text-end">
                    <span class="badge bg-info">{LOOP.duration}</span>
                    <!-- BEGIN: status_active -->
                    <span class="badge bg-success">{LANG.active}</span>
                    <!-- END: status_active -->
                    <!-- BEGIN: status_inactive -->
                    <span class="badge bg-danger">{LANG.inactive}</span>
                    <!-- END: status_inactive -->
                </div>
            </div>
        </div>
    </div>
    <!-- END: loop -->
    <div class="text-center mt-4">{GENERATE_PAGE}</div>
</div>
<!-- END: main -->
