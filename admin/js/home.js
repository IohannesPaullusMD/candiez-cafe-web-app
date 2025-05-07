function viewHome() {
  console.log("Home view activated");
  const root = document.getElementById("root");
  const pageNavBar = createPageNavBar();
  document.getElementsByTagName("body")[0].insertBefore(pageNavBar, root);
}
