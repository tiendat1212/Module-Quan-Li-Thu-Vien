<!-- BEGIN: main -->
<div class="page">
    <div class="card">
        <div class="card-body">
            <h4>{CONTENT.title}</h4>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <img src="{CONTENT.thumbnail}" alt="{CONTENT.title}" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <p><strong>{LANG.description}:</strong></p>
                    <p>{CONTENT.description}</p>
                    
                    <p><strong>{LANG.duration}:</strong> {CONTENT.duration}</p>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="javascript:history.back();" class="btn btn-secondary">
                    {GLANG.back}
                </a>
            </div>
        </div>
    </div>
</div>
<!-- END: main -->
