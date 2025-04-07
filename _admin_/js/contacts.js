function viewContacts() {
  const root = $("root");
  const div1 = $("<div>", {
    class: "container",
  });

  getContacts();
}

function getContacts() {
  $.ajax({
    url: `../backend/site-details?page=contacts`,
    type: "GET",
    dataType: "json",
    success: renderContacts,
    error: function (error) {
      console.error("Error fetching products details:", error);
    },
  });
}

function renderContacts(contacts) {
  console.log("Contacts:", contacts);
}
