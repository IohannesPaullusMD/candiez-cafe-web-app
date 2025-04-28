function redirect() {
  const hash = window.location.hash;

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

document.addEventListener("DOMContentLoaded", redirect);
