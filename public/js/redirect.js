function redirect() {
  const hash = window.location.hash;
  console.log(hash);
  if (hash !== null) {
    switch (hash) {
      case "#menu":
        viewMenu();
        break;
      case "#about":
        viewAbout();
        break;
      case "#contact":
        viewContacts();
        break;
      default:
        viewHome();
        break;
    }
  }

  Array.from(document.getElementsByClassName("a-tag")).forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      const href = e.target.getAttribute("href");
      location.hash = href;
      location.reload();
    });
  });
}

document.addEventListener("DOMContentLoaded", redirect);
