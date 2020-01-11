"use strict";

const editProfileButton = document.querySelector(".edit-profile-button");

const goToEditProfile = () => {
  location.href = "/edit-profile.php";
};

editProfileButton.addEventListener("click", goToEditProfile);
