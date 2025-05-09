function loadAuthenticatedPage() {
  const body = document.getElementsByTagName("body")[0];
  const root = document.getElementById("root");
  const pageNavBar = createPageNavBar();
  const footer = document.createElement("footer");

  document.head.innerHTML += `
    <style>
      .a-tag:hover {
        text-decoration: underline;
      }
    </style>
  `;

  body.insertBefore(pageNavBar, root);
  body.appendChild(footer);
  root.className = "container mt-5 flex-grow-1";
  footer.className = "bg-dark text-center text-white py-3 mt-auto";
  footer.innerHTML = "<p>© 2025 Candiez Café. All rights reserved.</p>";
  redirect();
}

document.addEventListener("DOMContentLoaded", loadAuthenticatedPage);
