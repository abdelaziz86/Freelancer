

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