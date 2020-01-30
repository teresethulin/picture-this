"use strict";

// This section of code runs when the search input is used.
const search = document.querySelector('.search-input');
if(search!=null) {
  search.addEventListener('input', event => {
    event.preventDefault();
    const list = document.querySelector('.search-list');
    const formData = new FormData(search);

    fetch('/app/users/search.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(users => {
      if(event.target.value.length <=0) {
        list.innerHTML = "";
      } else {
        list.innerHTML = "";
        if(users.length==0) {
          const noResults = document.createElement('li');
          noResults.innerHTML = `<h3>No username found</h3>`;
          list.appendChild(noResults);
        } else {
          users.forEach(user => {
            const item = document.createElement('li');
            item.innerHTML = `<form id="${user['id']}" action="profile.php" method="post">
            <input type="hidden" name="profileID" value="${user['id']}">
            <div onclick="document.getElementById('${user['id']}').submit();" class="post-user-container">
            <img class="post-avatar" src="/uploads/avatar/${user['avatar']}">
            <h3>${user['username']}</h3></div></form>`;
            list.appendChild(item);
          });
        };
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


