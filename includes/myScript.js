

var locationSelect = document.getElementById("editLocation");

console.log("test"); 
// Fetch countries from the REST Countries API
fetch("https://restcountries.com/v3.1/all")
  .then((response) => response.json())
  .then((data) => {
    // Iterate through the list of countries and create an option for each one
    data.sort((a, b) => a.name.common.localeCompare(b.name.common));

    // Iterate through the sorted list and create an option for each country
    data.forEach((country) => {
      var option = document.createElement("option");
      option.value = country.name.common;
      option.textContent = country.name.common;
      locationSelect.appendChild(option);
    });
  })
  .catch((error) => {
    console.error("Error fetching countries:", error);
  });







  $(document).ready(function () {
    // Handle the Save Changes button click
    $("#saveChangesBtn").click(function () {
      // Get form data
      var formData = {
        first_name: $("#editFirstName").val(),
        last_name: $("#editLastName").val(),
        location: $("#editLocation").val(),
        job: $("#editTitle").val(),
        gender: $("#editGender").val(),
        bio: $("#editBio").val(),
        hourly_pay: $("#editHourlyPay").val(),

        id: $("#idUser").val(),
      };

        console.log(formData); 
      // Send the AJAX POST request to update the profile
      $.ajax({
        type: "POST",
        url: "includes/update_profile.php", // Specify the PHP file to handle the update
        data: formData,
        success: function (response) {
          // Handle the response from the server (e.g., display a success message)
          if (response === "success") {
            // Update the user's information on the page without refreshing
            $("#editProfileModal").modal("hide");
            location.reload();
            
          } else {
            alert("Profile update failed. Please try again.");
          }
        },
        error: function () {
          alert("An error occurred while updating the profile.");
        },
      });
    });
  });
