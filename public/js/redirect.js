function redirect() {
  // e.preventDefault();
  const hash = window.location.hash;
  console.log(hash);
  if (hash !== null) {
    switch (hash) {
      case "#menu":
        viewMenu();
        return;
      case "#about":
        viewAbout();
        return;
      case "#contact":
        viewContacts();
        return;
      default:
        viewHome();
        break;
    }
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
document.addEventListener("DOMContentLoaded", redirect);
