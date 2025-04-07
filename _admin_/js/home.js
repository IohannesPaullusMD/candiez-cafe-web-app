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

  getHomeDetails(); // Fetch and render home details
}

function getHomeDetails() {
  $.ajax({
    url: "../backend/site-details?page=home",
    type: "GET",
    dataType: "json",
    success: renderHomeDetails,
    error: function (error) {
      console.error("Error fetching home details:", error);
    },
  });
}

function renderHomeDetails(details) {
  console.log("Home details:", details);
}
