"use strict";

const editProfileButton = document.querySelector(".edit-profile");

const goToEditProfile = () => {
  location.href = "/../app/users/edit_profile.php";
};

editProfileButton.addEventListener("click", goToEditProfile);
