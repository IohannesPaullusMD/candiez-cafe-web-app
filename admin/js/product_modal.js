function changeImagePreview() {
  const imageUpload = document.getElementById("imageUpload");
  const imagePreview = document.getElementById("imagePreview");
  const imgContainer = document.getElementById("img-img-container");
  const file = imageUpload.files[0];
  if (file) {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function () {
      imagePreview.src = reader.result;
      imgContainer.style.display = "flex"; // Show the image container
    };
  } else {
    imagePreview.src = "../docs/img-placeholder.jpg"; // Reset the image preview
    imgContainer.style.display = "none"; // Hide the image container
  }
}

function saveProduct() {
  const imageStr = document.getElementById("imagePreview").src;
  const name = document.getElementById("name").value;
  const description = document.getElementById("description").value;
  const category = document.getElementById("category").value;
  const availability = document.getElementById("availability").checked;

  if (imageStr === "../docs/img-placeholder.jpg") {
    alert("Please upload an image.");
    return;
  }

  if (!name || !description || category === "-1") {
    alert("Please fill in all fields.");
    return;
  }

  if (document.getElementById("prod-id").innerHTML === "-1") {
    addProduct(
      category,
      name,
      description,
      imageStr,
      availability,
      (response) => {
        if (response.status === 201) {
          alert("Product added successfully.");
          location.reload();
        } else {
          alert("Error adding product.");
        }
      }
    );
  }
}

function createModalBody(categories) {
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
      class="form-control mb-3"
      placeholder="Enter Description"
    ></textarea>

    <!-- Category -->
    <select id="category" class="form-select mb-3">
      <option value="-1" disabled selected>Select Category</option>
      ${categories
        .map(
          (category) =>
            `<option value="${category["id"]}">${category["name"]}</option>`
        )
        .join("")}
    </select>

    <!-- Availability -->
    <div class="form-check mb-3">
      <input
        type="checkbox"
        class="form-check-input"
        id="availability"
        checked
      />
      <label class="form-check-label" for="availability">
      <strong>Available</strong>
      </label>
    </div>
    

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
  modalBody
    .querySelector("#imageUpload")
    .addEventListener("change", changeImagePreview);
  return modalBody;
}

function createnewProdModalFooter() {
  const modalFooter = document.createElement("div");
  modalFooter.className = "modal-footer";
  modalFooter.innerHTML = `
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
    <button type="button" class="btn btn-primary" id="save-product">Save</button>
  `;
  return modalFooter;
}

function createProductModal(categories, product = null) {
  const modal = document.createElement("div");
  const modalDialog = document.createElement("div");
  const modalContent = document.createElement("div");
  const modalHeader = document.createElement("div");
  const modalBody = createModalBody(categories);
  const modalFooter = document.createElement("div");
  const prodId = document.createElement("p");

  prodId.id = "prod-id";
  prodId.style.display = "none"; // Hide the product ID field
  prodId.innerHTML = product ? product["id"] : "-1";
  modalBody.appendChild(prodId);

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
  modalHeader.innerHTML = `<h1 class="modal-title fs-5" id="product-modal-label">${
    product ? "Edit" : "Add"
  } Product</h1>`;
  modalContent.appendChild(modalHeader);

  modalContent.appendChild(modalBody);

  modalFooter.className = "modal-footer";
  modalFooter.innerHTML = `
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
    <button type="button" class="btn btn-primary" id="save-product">Save</button>
  `;
  modalFooter
    .querySelector("#save-product")
    .addEventListener("click", () => saveProduct());
  modalContent.appendChild(modalFooter);
  return modal;
}

function clearModal() {}
