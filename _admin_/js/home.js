function getHomeDetails() {
  output = null; // Initialize data variable
  $.ajax({
    url: "../backend/site-details?page=home",
    type: "GET",
    dataType: "json",
    success: function (data) {
      output = data; // Assign the response data to the variable
      viewHome(output); // Call viewHome with the data
      console.log("Home details fetched successfully:", data);
    },
    error: function (error) {
      console.error("Error fetching home details:", error);
    },
  });

  return output; // Return the data variable
}

function viewHome(data = null) {
  if (!data) {
    return;
  }

  const root = $("#root");
  root.empty(); // Clear the root element
  root.append(
    `<div class="home-container">
        <p>${data["text"]}</p>
      </div>`
  );
}
