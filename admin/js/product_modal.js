function createModalBody() {
  const modalBody = document.createElement("div");
  modalBody.className = "modal-body";

  modalBody.innerHTML = `
    <!-- Image Preview (Starts with Placeholder) -->
    <div id="img-img-container">
    <div class="image-container">
      <img
        id="imagePreview"
        src="../docs/img-placeholder.jpg"
        alt="Image Preview"
      />
    </div>
    </div>

    <!-- Upload Input -->
    <input
      type="file"
      id="imageUpload"
      class="form-control mb-3"
      accept="image/*"
    />

    <!-- Name -->
    <input
      type="text"
      id="name"
      class="form-control mb-3"
      placeholder="Enter Name"
    />

    <!-- Description -->
    <textarea
      id="description"
      class="form-control"
      placeholder="Enter Description"
    ></textarea>

    <style>
      #img-img-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 1rem; /* Space between image and input */
      }
      /* Style for the image preview to maintain 1:1 aspect ratio */
      .image-container {
        width: 150px; /* Fixed width */
        height: 150px; /* Fixed height */
        overflow: hidden; /* Ensures cropping */
        display: flex;
        justify-content: center;
        align-items: center;
        border: 2px solid #ccc;
        border-radius: 10px; /* Optional rounded corners */
      }

      .image-container img {
        width: 100%; /* Ensures full coverage */
        height: 100%; /* Ensures full coverage */
        object-fit: cover; /* Crops to the center */
      }
    </style>
  `;

  return modalBody;
}

function createProductModal(categories) {
  const modal = document.createElement("div");
  const modalDialog = document.createElement("div");
  const modalContent = document.createElement("div");
  const modalHeader = document.createElement("div");
  const modalBody = createModalBody();
  const modalFooter = document.createElement("div");

  modal.className = "modal fade";
  modal.id = "product-modal";
  modal.setAttribute("data-bs-backdrop", "static");
  modal.setAttribute("data-bs-keyboard", "false");
  modal.setAttribute("tabindex", "-1");
  modal.setAttribute("aria-labelledby", "product-modal-label");

  modalDialog.className = "modal-dialog modal-dialog-centered";
  modal.appendChild(modalDialog);

  modalContent.className = "modal-content";
  modalDialog.appendChild(modalContent);

  modalHeader.className = "modal-header";
  modalHeader.innerHTML =
    '<h1 class="modal-title fs-5" id="product-modal-label">Add Product</h1>';
  modalContent.appendChild(modalHeader);

  modalContent.appendChild(modalBody);

  modalFooter.className = "modal-footer";
  modalFooter.innerHTML =
    '<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>';
  modalContent.appendChild(modalFooter);
  return modal;
}

function clearModal() {}
