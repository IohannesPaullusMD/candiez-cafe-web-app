function createProductModal(categories) {
  const modal = document.createElement("div");
  const modalDialog = document.createElement("div");
  const modalContent = document.createElement("div");
  const modalHeader = document.createElement("div");
  const modalBody = document.createElement("div");
  const modalFooter = document.createElement("div");

  modal.className = "modal fade";
  modal.id = "product-modal";
  modal.setAttribute("data-bs-backdrop", "static");
  modal.setAttribute("data-bs-keyboard", "false");
  modal.setAttribute("tabindex", "-1");
  modal.setAttribute("aria-labelledby", "product-modal-label");
  modal.setAttribute("aria-hidden", "true");

  modalDialog.className = "modal-dialog modal-dialog-centered";
  modal.appendChild(modalDialog);

  modalContent.className = "modal-content";
  modalDialog.appendChild(modalContent);

  modalHeader.className = "modal-header";
  modalHeader.innerHTML =
    '<h1 class="modal-title fs-5" id="product-modal-label">Add Product</h1>';
  modalContent.appendChild(modalHeader);

  modalBody.className = "modal-body";
  modalBody.innerHTML = "hello, world";
  modalContent.appendChild(modalBody);

  modalFooter.className = "modal-footer";
  modalFooter.innerHTML =
    '<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>';
  modalContent.appendChild(modalFooter);
  return modal;
}
