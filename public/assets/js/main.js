
// This section of code runs when the search input is used.
const search = document.querySelector('.search-input');
if(search!=null) {
  search.addEventListener('input', event => {
    event.preventDefault();
    const list = document.querySelector('.search-list');
    const formData = new FormData(search);

    fetch('/app/posts/search.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(users => {
      if(event.target.value.length <=1) {
        list.innerHTML = "";
      } else {
        list.innerHTML = "";
        const item = document.createElement('li');
        if(users.length==0) {
          item.innerHTML = `<h3>No username found</h3>`;
        } else {
        users.forEach(user => {
          item.innerHTML = `<form id="${user['id']}" action="profile.php" method="post">
          <input type="hidden" name="profileID" value="${user['id']}">
          <div onclick="document.getElementById('${user['id']}').submit();" class="post-user-container">
          <img class="post-avatar" src="/uploads/avatar/${user['avatar']}">
          <h3>${user['username']}</h3></div></form>`
          });
        };
        list.appendChild(item);
      };
    });
  });
};

// This function is called when a user is followed.
const followUser = () => {
  const followDiv = document.querySelector(".follow-div");
  const followers = document.querySelector(".numFollowers");
  const numFollowers = parseInt(followers.innerHTML);
  followers.innerHTML = numFollowers+1;

  const elementWithID = document.querySelector(".profile-username");
  const followedUserID = elementWithID.id;
  followDiv.innerHTML = `<h6 class="following">Following</h6>
  <button class="follow-buttons unfollow-button" onclick="unfollowUser()">Unfollow</button>`;

  const followForm = document.createElement('form');
  followForm.method = "post";
  followForm.innerHTML = `<input type="hidden" name="followed-user-id" value="${followedUserID}">`;
  const followFormData = new FormData(followForm);
  fetch("app/users/follow.php", {
  method: 'POST',
  body: followFormData
  });
}

// This function is called when a user is unfollowed.
const unfollowUser = () => {
  const followDiv = document.querySelector(".follow-div");
  const followers = document.querySelector(".numFollowers");
  const numFollowers = parseInt(followers.innerHTML);
  followers.innerHTML = numFollowers-1;

  const elementWithID = document.querySelector(".profile-username");
  const unfollowedUserID = elementWithID.id;
  followDiv.innerHTML = `<button class="follow-buttons" onclick="followUser()">Follow</button>`;

  const unfollowForm = document.createElement('form');
  unfollowForm.method = "post";
  unfollowForm.innerHTML = `<input type="hidden" name="unfollowed-user-id" value="${unfollowedUserID}">`;
  const unfollowFormData = new FormData(unfollowForm);
  fetch("app/users/unfollow.php", {
  method: 'POST',
  body: unfollowFormData
  });
};

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
