function logoutUser() {
  console.log("logging out");
  setAdminUserStatus(
    false,
    "",
    "",
    (data) => console.log(data),
    location.reload()
  );
}

function redirect() {
  const hash = window.location.hash;
  console.log(hash);
  if (hash !== null) {
    switch (hash) {
      case "#archive":
        viewArchive();
        break;
      case "#logout":
        logoutUser();
        break;
      default:
        viewProducts();
        break;
    }
  }

  Array.from(document.getElementsByClassName("a-tag")).forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      location.reload();
    });
  });
}
