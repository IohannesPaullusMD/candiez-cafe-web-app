const redirect = (e) => {
  const hash = window.location.hash;

  if (e) {
    e.preventDefault();
  }

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
        break;
    }
  }
  getHomeDetails();
};

document.addEventListener("DOMContentLoaded", redirect);
