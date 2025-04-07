function viewAbout() {
  const root = $("#root");
  const div1 = $("<div>", {
    class: "container",
  });

  getAboutDetails();
}

function getAboutDetails() {
  $.ajax({
    url: `../backend/site-details?page=about`,
    type: "GET",
    dataType: "json",
    success: renderAboutDetails,
    error: function (error) {
      console.error("Error fetching products details:", error);
    },
  });
}

function renderAboutDetails(about) {
  console.log("About details:", about);
}
