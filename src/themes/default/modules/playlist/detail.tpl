<!-- BEGIN: main -->
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">{CONTENT.title}</h1>
            
            <div class="card mb-4">
                <div class="ratio ratio-16x9">
                    <iframe src="{CONTENT.media_url}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{LANG.description}</h5>
                    <p class="card-text">{CONTENT.description}</p>
                    
                    <div class="mt-3">
                        <span class="badge bg-primary text-lg">{CONTENT.duration}</span>
                    </div>
                    
                    <div class="mt-4">
                        <a href="javascript:history.back();" class="btn btn-secondary">
                            {GLANG.back}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: main -->
