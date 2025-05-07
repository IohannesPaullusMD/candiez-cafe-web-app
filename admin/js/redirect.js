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
      case "#contacts":
        viewContacts();
        return;
      default:
        break;
    }
  }
  viewHome();
};

document.addEventListener("DOMContentLoaded", redirect);
