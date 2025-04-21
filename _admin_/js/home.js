function viewHome() {
  const root = $("#root");
  const div1 = $("<div>", {
    class: "container",
  });
  const div2 = $("<div>", {
    class: "container",
  });

  root.empty();
  root.append(div1);
  root.append(div2);
}
