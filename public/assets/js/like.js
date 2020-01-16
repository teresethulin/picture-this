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

likes.forEach(like => {
  like.addEventListener("submit", event => {
    event.preventDefault();

    const heartLiked = `
        <i class="far fa-heart" alt="liked"></i>
      `;
    const heartNotLiked = `
        <i class="fas fa-heart" alt="unliked"></i>
      `;

    let likeButton = like.querySelector(".like-button");
    let numberOfLikes = likeButton.lastElementChild;

    if (likeButton.classList.contains("like")) {
      likeButton.innerHTML = heartNotLiked;
    } else {
      likeButton.innerHTML = heartLiked;
    }
    const likeFormData = new FormData(like);

    fetch("/../app/posts/like.php", {
      method: "POST",
      body: likeFormData
    })
      .then(response => response.json())
      .then(result => (numberOfLikes.textContent = result));
  });
});
