<div>
    <section class="section">
        <div class="row">
            <div class="col-lg-3">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Formatter</h5>

                        <!-- General Form Elements -->
                        <form>
                            <div class="input-group mb-3">
                                <label for="basic-url" class="form-label">Title</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Enter title" aria-label="Enter title" aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2">
                                        <input type="color" class="form-control form-control-color" id="exampleColorInput" value="#4154f1" title="Choose your color">
                                    </span>
                                </div>
                            </div>

                            <div class="text-center pt-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>

                        </form><!-- End General Form Elements -->

                    </div>
                </div>

            </div>

            <div class="col-lg-9">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Report Content</h5>

                        <form id="reportForm">
                            <!-- Single Participant Section -->
                            <div class="mb-4">
                                <h6 class="card-subtitle mb-3">Individual Participant</h6>
                                <!-- Initial participant row -->
                                <div class="row mb-3 participant-row g-2">
                                    <label class="col-sm-2 col-form-label">Participant 1</label>
                                    <div class="col-sm-8 row g-2">
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="participants[0][name]" placeholder="Name" required>
                                        </div>
                                        <div class="col-sm-3">
                                            <select class="form-select" name="participants[0][category]" required>
                                                <option value="">Select category</option>
                                                <option value="Champion">Champion</option>
                                                <option value="1st Runner Up">1st Runner Up</option>
                                                <option value="2nd Runner Up">2nd Runner Up</option>
                                                <option value="Finalist">Finalist</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <select class="form-select" name="participants[0][title]" required>
                                                <option value="">Select title</option>
                                                <option value="Champion">Champion</option>
                                                <option value="1st Runner Up">1st Runner Up</option>
                                                <option value="2nd Runner Up">2nd Runner Up</option>
                                                <option value="Finalist">Finalist</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" class="btn btn-danger btn-remove" disabled>
                                            <i class="bi bi-dash-circle"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-10 offset-sm-2">
                                        <button type="button" id="addParticipant" class="btn btn-info">
                                            <i class="bi bi-plus-circle"></i> Add Another Participant
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Top Participants List Section -->
                            <div class="mb-4">
                                <h6 class="card-subtitle mb-3">Top Participants List</h6>
                                <div id="participantsContainer">
                                    <!-- Initial participant row -->
                                    <div class="row mb-3 participant-row g-2">
                                        <label class="col-sm-2 col-form-label">Participant 1</label>
                                        <div class="col-sm-8 row g-2">
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="participants[0][name]" placeholder="Name" required>
                                            </div>
                                            <div class="col-sm-3">
                                                <select class="form-select" name="participants[0][category]" required>
                                                    <option value="">Select category</option>
                                                    <option value="Champion">Champion</option>
                                                    <option value="1st Runner Up">1st Runner Up</option>
                                                    <option value="2nd Runner Up">2nd Runner Up</option>
                                                    <option value="Finalist">Finalist</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <select class="form-select" name="participants[0][title]" required>
                                                    <option value="">Select title</option>
                                                    <option value="Champion">Champion</option>
                                                    <option value="1st Runner Up">1st Runner Up</option>
                                                    <option value="2nd Runner Up">2nd Runner Up</option>
                                                    <option value="Finalist">Finalist</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-danger btn-remove" disabled>
                                                <i class="bi bi-dash-circle"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-10 offset-sm-2">
                                        <button type="button" id="addParticipant" class="btn btn-info">
                                            <i class="bi bi-plus-circle"></i> Add Another Participant
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center pt-3">
                                <button type="submit" class="btn btn-primary">Generate Report</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>
</div>