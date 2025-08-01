<div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <!-- Card -->
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-primary text-white text-center rounded-top-4">
                        <h4 class="mb-0">Database Import & Export</h4>
                    </div>
                    <div class="card-body p-4">

                        <!-- Export Section -->
                        <div class="mb-4 text-center">
                            <h6>Export Database</h6>
                            <button class="btn btn-success px-4" type="button">
                                <i class="bi bi-download me-1"></i> Export Now
                            </button>
                        </div>
                        <hr>
                        <!-- Import Section -->
                        <div class="text-center">
                            <h6>Import Database</h6>
                            <form method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <input type="file" class="form-control" name="database_file" accept=".sql">
                                </div>
                                <button class="btn btn-primary px-4" type="submit">
                                    <i class="bi bi-upload me-1"></i> Import
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>