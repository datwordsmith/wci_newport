    <!-- Add Testimony Modal -->
    <div class="modal fade" id="addTestimonyModal" tabindex="-1" aria-labelledby="addTestimonyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title serif-font" id="addTestimonyModalLabel">Share Your Testimony</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="testimonyForm">
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <label for="testimonyTitle" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="testimonyTitle" name="title" required placeholder="Enter testimony title">
                            </div>
                            <div class="col-md-6">
                                <label for="testimonyAuthor" class="form-label fw-semibold">Your Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="testimonyAuthor" name="author" required placeholder="Enter your name">
                            </div>

                            <!-- Contact Information -->
                            <div class="col-md-6">
                                <label for="testimonyEmail" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="testimonyEmail" name="email" required placeholder="Enter your email">
                            </div>
                            <div class="col-md-6">
                                <label for="testimonyPhone" class="form-label fw-semibold">Phone Number</label>
                                <input type="tel" class="form-control" id="testimonyPhone" name="phone" placeholder="Enter your phone number">
                            </div>

                            <!-- Result Category -->
                            <div class="col-md-6">
                                <label for="testimonyResult" class="form-label fw-semibold">Result Category <span class="text-danger">*</span></label>
                                <select class="form-select" id="testimonyResult" name="result" required>
                                    <option value="">Select a result category</option>
                                    <option value="Healing">Healing</option>
                                    <option value="Breakthrough">Breakthrough</option>
                                    <option value="Restoration">Restoration</option>
                                    <option value="Provision">Provision</option>
                                    <option value="Protection">Protection</option>
                                    <option value="Favour">Favour</option>
                                    <option value="Deliverance">Deliverance</option>
                                    <option value="Success">Success</option>
                                    <option value="Family">Family</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <!-- Date -->
                            <div class="col-md-6">
                                <label for="testimonyDate" class="form-label fw-semibold">Date of Testimony</label>
                                <input type="date" class="form-control" id="testimonyDate" name="date" max="2025-08-25">
                            </div>

                            <!-- Engagements -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Engagements (Select all that apply)</label>
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Prayer" id="engagement1" name="engagements">
                                            <label class="form-check-label" for="engagement1">Prayer</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Anointing" id="engagement2" name="engagements">
                                            <label class="form-check-label" for="engagement2">Anointing</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Communion" id="engagement3" name="engagements">
                                            <label class="form-check-label" for="engagement3">Communion</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Kingdom Service" id="engagement4" name="engagements">
                                            <label class="form-check-label" for="engagement4">Kingdom Service</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Sowing of Seed" id="engagement5" name="engagements">
                                            <label class="form-check-label" for="engagement5">Sowing of Seed</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Fasting" id="engagement6" name="engagements">
                                            <label class="form-check-label" for="engagement6">Fasting</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Mantle" id="engagement7" name="engagements">
                                            <label class="form-check-label" for="engagement7">Mantle</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Evangelism" id="engagement8" name="engagements">
                                            <label class="form-check-label" for="engagement8">Evangelism</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Testimony Content -->
                            <div class="col-12">
                                <label for="testimonyContent" class="form-label fw-semibold">Your Testimony <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="testimonyContent" name="content" rows="6" required placeholder="Share your testimony in detail..."></textarea>
                                <div class="form-text">Please share your testimony in detail, including what happened and how God moved in your situation.</div>
                            </div>

                            <!-- Permission -->
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="yes" id="publishPermission" name="publishPermission" required>
                                    <label class="form-check-label" for="publishPermission">
                                        <strong>I give permission for this testimony to be published on the church website and used for ministry purposes.</strong> <span class="text-danger">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="reset" class="btn btn-outline-secondary">Reset Form</button>
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="fas fa-paper-plane me-2"></i>Submit Testimony
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
