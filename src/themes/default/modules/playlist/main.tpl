<!-- BEGIN: main -->
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">{LANG.playlist_manager}</h2>
            
            <!-- BEGIN: empty -->
            <div class="alert alert-info" role="alert">
                {LANG.no_data}
            </div>
            <!-- END: empty -->
            
            <!-- BEGIN: loop -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <img src="{LOOP.thumbnail}" class="card-img-top" alt="{LOOP.title}" style="height: 180px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{LOOP.title}</h5>
                        <p class="card-text text-muted">{LOOP.description}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary">{LOOP.duration}</span>
                            <a href="{SITE_HREF}?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}=detail&amp;id={LOOP.id}" class="btn btn-sm btn-primary">
                                {GLANG.view_more}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: loop -->
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12 text-center">
            {GENERATE_PAGE}
        </div>
    </div>
</div>
<!-- END: main -->
