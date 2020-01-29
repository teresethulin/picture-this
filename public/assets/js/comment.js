"use strict";

// This section of code is used for when a comment is entered on a post
const commentBTNs = document.querySelectorAll(".comment-button");
commentBTNs.forEach(commentBTN => {
    commentBTN.addEventListener('click', event => {
        const ID = commentBTN.id;
        const commentsDiv = document.querySelector(`.comments-container-${ID}`);
        const usernameElement = document.querySelector('.dummy-user-div');
        const postOwner = document.querySelector('.dummy-post-div');
        const username = usernameElement.innerHTML;
        const owner = postOwner.id;
        event.preventDefault();
        const div = document.createElement('div');
        div.classList.add("comment-box");
        const h5User = document.createElement('h5');
        h5User.classList.add("comment-user");
        h5User.innerHTML = username;
        div.appendChild(h5User);
        const editForm = document.createElement('form');
        editForm.classList.add("edit-post-form");
        editForm.method = "post";
        editForm.innerHTML = `<input type="hidden" name="post-id" value="${ID}">
        <input id="updateField" type="text" name="comment-text">
        <button class="edit-comment-button" type="submit">Post</button>`;
        div.appendChild(editForm);
        commentsDiv.appendChild(div);
        updateField.focus();

        editForm.addEventListener('submit', event => {
            event.preventDefault();
            const formData = new FormData(editForm);
            fetch('/app/posts/insert-comment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(comment => {
                div.innerHTML = "";
                if(comment.commentText!=="") {
                    const container = document.createElement('div');
                    container.classList.add(`comment-container`, `comment-container-${comment.commentID}`);
                    const h5User = document.createElement('h5');
                    h5User.classList.add("comment-user");
                    h5User.innerHTML = username;
                    div.appendChild(h5User);
                    const h5Text = document.createElement('h5');
                    h5Text.classList.add(`comment-text-${comment.commentID}`);
                    div.id = `${comment.commentID}`;
                    div.classList.add(`comment-writer-${comment.userID}`, `comment-owner-${owner}`);
                    h5Text.innerHTML = comment.commentText;
                    div.appendChild(h5Text);
                    container.appendChild(div);
                    commentsDiv.appendChild(container);
                    editComment();
                };
            });
        });
    });
});

// This section of code is used for when a comment is clicked so that it can be edited or deleted.
function editComment() {
    if(document.querySelector(`.dummy-user-div`)) {
        const usernameElement = document.querySelector('.dummy-user-div');
        const ID = usernameElement.id;
        const comments = document.querySelectorAll(`.comment-writer-${ID}, .comment-owner-${ID}`);
        comments.forEach(comment => {
            comment.addEventListener('click', event => {
                event.preventDefault();
                const commentID = comment.id;
                const container = document.querySelector(`.comment-container-${commentID}`);
                const h5 = document.querySelector(`.comment-text-${commentID}`);
                // If the comment has already been clicked, return.
                if (h5==null) {
                    return;
                }
                const existingCommentText = h5.innerHTML;
                comment.removeChild(h5);
                const btnDiv = document.createElement('div');
                btnDiv.classList.add("comment-edit-delete-div");

                // This form is used to edit post.
                const editCommentForm = document.createElement('form');
                editCommentForm.classList.add("edit-comment-form");
                editCommentForm.method = "post";
                editCommentForm.innerHTML = `<input type="hidden" name="comment-id" value="${commentID}">
                <input id="updateField" type="text" name="comment-text" value="${existingCommentText}">
                <button class="edit-comment-button" type="submit">Update</button>`;
                // Only allow access to the edit form if the user is the comment writer (not the post owner).
                if(comment.classList.contains(`comment-writer-${ID}`)) {
                    btnDiv.appendChild(editCommentForm);
                }
                const deleteTag = document.createElement('div');
                deleteTag.classList.add("edit-delete-btn");
                deleteTag.innerHTML = `<i class="far fa-trash-alt"></i>`;
                btnDiv.appendChild(deleteTag);
                container.appendChild(btnDiv);

                // If comment is edited.
                editCommentForm.addEventListener('submit', event => {
                    event.preventDefault();
                    const editCommentFormData = new FormData(editCommentForm);
                    fetch("/app/posts/edit-comment.php", {
                        method: 'post',
                        body: editCommentFormData
                    })
                    .then(response => response.json())
                    .then(newComment => {
                        if(newComment.commentText != "") {
                            const h5New = document.createElement('h5');
                            h5New.classList.add(`comment-text-${commentID}`);
                            h5New.innerText = newComment.commentText;
                            comment.appendChild(h5New);
                            btnDiv.innerHTML = "";
                        };
                    });
                });

                // If comment is deleted. The same "editCommentForm" form is used here as well.
                deleteTag.addEventListener('click', event => {
                    event.preventDefault();
                    const editCommentFormData = new FormData(editCommentForm);
                    fetch("/app/posts/delete-comment.php", {
                        method: 'post',
                        body: editCommentFormData
                    });
                    comment.innerHTML = "";
                    btnDiv.innerHTML = "";
                });
            });
        });
    };
};

editComment();

