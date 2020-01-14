"use strict";

const likes = document.querySelectorAll(".form-like");
const icons = document.querySelectorAll(".fa-heart");

// Toggle heart icon
function toggleIcons() {
  if (this.classList.contains("far")) {
    this.classList.remove("far");
    this.classList.add("fas");
  } else {
    this.classList.remove("fas");
    this.classList.add("far");
  }
}

icons.forEach(icon => {
  icon.addEventListener("click", toggleIcons);
});

// Number of likes request
likes.forEach(like => {
  like.addEventListener("submit", event => {
    event.preventDefault();

    const formData = new FormData(like);

    fetch(`http://localhost:8000/app/posts/like.php`, {
      method: "POST",
      body: formData
    })
      .then(response => {
        return response.json();
      })
      .then(json => {
        const numberOfLikes = event.target.querySelector(".likes");

        if (json === "0") {
          numberOfLikes.textContent = " ";
        } else {
          numberOfLikes.textContent = json;
        }
      });
  });
});
