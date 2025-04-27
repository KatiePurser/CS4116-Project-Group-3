<!-- Modal for submitting a service review -->
<div class="modal fade" id="reviewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg rounded-4">

            <div class="modal-header text-white rounded-top-4">
                <h5 class="modal-title fw-bold" id="reviewModalLabel">Leave a Review</h5>
                <button type="button" class="btn-close me-2" data-bs-dismiss="modal"></button>
            </div>

            <form method="post" action="review.php">
                <div class="modal-body px-5 py-4">

                    <!-- Hidden inputs to pass service and request IDs -->
                    <input type="hidden" name="service_id" id="service-id">
                    <input type="hidden" name="request_id" id="request-id">

                    <!-- Star Rating Section -->
                    <div class="mb-3">
                        <label class="form-label d-block fw-semibold">Your Rating</label>
                        <div class="star-rating d-flex flex-row-reverse justify-content-center gap-1">

                            <input type="radio" id="star5" name="rating" value="5" required />
                            <label for="star5" title="5 stars">★</label>

                            <input type="radio" id="star4" name="rating" value="4" />
                            <label for="star4" title="4 stars">★</label>

                            <input type="radio" id="star3" name="rating" value="3" />
                            <label for="star3" title="3 stars">★</label>

                            <input type="radio" id="star2" name="rating" value="2" />
                            <label for="star2" title="2 stars">★</label>

                            <input type="radio" id="star1" name="rating" value="1" />
                            <label for="star1" title="1 star">★</label>

                        </div>
                    </div>

                    <!-- Textarea for the review -->
                    <div class="mb-4">
                        <label for="review-text" class="form-label fw-semibold">Your Review</label>
                        <textarea class="form-control rounded-3 border" id="review-text" name="review" rows="4"
                            placeholder="Share your thoughts..." required></textarea>
                    </div>
                </div>

                <div class="modal-footer border-0 px-5 pb-4">
                    <button type="submit" class="submit-btn btn px-4 text-white">Submit</button>
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>

<style>
    .modal-header,
    .submit-btn {
        background-color: #82689A;
    }

    .submit-btn:hover {
        background-color: #5b496d;
    }

    .modal-title {
        padding: 10px;
    }

    .star-rating {
        direction: ltr;
        font-size: 2rem;
    }

    .star-rating input[type="radio"] {
        display: none;
    }

    .star-rating label {
        cursor: pointer;
        color: #ccc;
        transition: color 0.2s;
    }

    .star-rating input[type="radio"]:checked~label {
        color: #ffc107;
    }

    .star-rating label:hover,
    .star-rating label:hover~label {
        color: #ffda6a;
    }
</style>