document.getElementById("review-response").addEventListener("click", function () {
    var reviewId = this.getAttribute("data-review-id");
    document.getElementById("reviewId").value = reviewId;
  
    var responseModal = new bootstrap.Modal(document.getElementById("reviewResponseModal"));
    responseModal.show();
  });
  