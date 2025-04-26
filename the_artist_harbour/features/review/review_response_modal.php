<form id="responseForm" method="POST" action="scripts/submit_review_response.php">
    <input type="hidden" name="review_id" id="reviewId">

    <div class="mb-4">
        <label for="reviewResponseText" class="form-label fw-semibold">Your Response</label>
        <textarea class="form-control rounded-3 border" id="reviewResponseText" name="review_response_text" rows="4"
            placeholder="Type your response here..." required></textarea>
    </div>

    <div class="modal-footer d-flex justify-content-between border-0 px-0">
        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="submit-btn btn text-white px-4">Submit Response</button>
    </div>
</form>


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
</style>