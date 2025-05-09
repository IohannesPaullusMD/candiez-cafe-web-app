function createCategoryButton(category, container) {
  const button = document.createElement("div");
  const input = document.createElement("input");
  const label = document.createElement("label");

  input.type = "radio";
  input.className = "btn-check";
  input.name = "btnradio";
  input.id = `btnradio${category["id"]}`;
  input.autocomplete = "off";
  input.setAttribute("onclick", `loadProducts(${category["id"]})`);

  if (category["id"] === 1) {
    input.setAttribute("checked", "");
  }

  label.className = "btn btn-outline-dark";
  label.setAttribute("for", `btnradio${category["id"]}`);
  label.innerText = category["name"];

  container.appendChild(input);
  container.appendChild(label);

  return input;
}

/*
<input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked="" wfd-id="id3">
<label class="btn btn-outline-primary" for="btnradio1">Radio 1</label>
*/

function createCategoryNavBar(categories) {
  const categoryNavBar = document.createElement("div");
  categoryNavBar.className = "btn-group";
  // categoryNavBar.setAttribute("data-toggle", "buttons");
  categoryNavBar.setAttribute("role", "group");
  categoryNavBar.setAttribute("aria-label", "Basic radio toggle button group");
  categoryNavBar.style.width = "100%";
  categoryNavBar.style.marginBottom = "1rem";
  categories.forEach((category) => {
    createCategoryButton(category, categoryNavBar);
  });

  return categoryNavBar;
}
