"use strict";

// This section of code runs when a post is liked or unliked.
let likeBTNs = document.querySelectorAll(".like-button");
likeBTNs.forEach(likeBTN => {
    const ID = likeBTN.id;
    likeBTN.addEventListener('click', event => {
        const span = document.querySelector(`.span-${ID}`);
        let numLikes = parseInt(span.innerHTML);
        const path = `img-${ID}`;
        const imgSRC = document.getElementById(path).src;
        if(imgSRC.includes("inactive")) {
          numLikes = numLikes + 1;
          likeBTN.innerHTML = `<img class="like-img" id="img-${ID}" src="/uploads/icons/heart-active.svg">
          <span class="span-${ID}">${numLikes}</span>`;
        } else {
          numLikes = numLikes - 1;
          likeBTN.innerHTML = `<img class="like-img" id="img-${ID}" src="/uploads/icons/heart-inactive.svg">
          <span class="span-${ID}">${numLikes}</span>`;
        }
        event.preventDefault();
        const likeForm = document.createElement('form');
        likeForm.method = "post";
        likeForm.innerHTML = `<input type="hidden" name="post-id" value="${ID}">`;
        const likeFormData = new FormData(likeForm);
        fetch("app/posts/like.php", {
        method: 'POST',
        body: likeFormData
        });
    });
});
