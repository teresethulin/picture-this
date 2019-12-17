"use strict";

const editProfileButton = document.querySelector(".edit-profile");

const goToEditProfile = () => {
  location.href = "/edit-profile.php";
};

editProfileButton.addEventListener("click", goToEditProfile);
