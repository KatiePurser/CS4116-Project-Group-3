<div class="modal fade" id="reviewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">Leave A Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="post" action="review.php">
                <div class="modal-body">
                    <!-- Hidden field to store service ID -->
                    <input type="hidden" name="service_id" id="service-id">
                    <input type="hidden" name="request_id" id="request-id">

                    <!-- Rating -->
                    <div class="mb-3">
                        <label class="form-label d-block">Your Rating</label>
                        <div class="rating-radio">

                            <input type="radio" id="rating1" name="rating" value="1" />
                            <label for="rating1">1</label>

                            <input type="radio" id="rating2" name="rating" value="2" />
                            <label for="rating2">2</label>

                            <input type="radio" id="rating3" name="rating" value="3" />
                            <label for="rating3">3</label>

                            <input type="radio" id="rating4" name="rating" value="4" />
                            <label for="rating4">4</label>

                            <input type="radio" id="rating5" name="rating" value="5" required />
                            <label for="rating5">5</label>
                        </div>
                    </div>

                    <!-- Review Text -->
                    <div class="mb-3">
                        <label for="review-text" class="form-label">Your Review</label>
                        <textarea class="form-control" id="review-text" name="review" rows="4" required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>