"use strict";

const editProfileButton = document.querySelector(".edit-profile-button");

const goToEditProfile = () => {
  location.href = "/edit-profile.php";
};
if(editProfileButton!=null) {
  editProfileButton.addEventListener("click", goToEditProfile);
};
