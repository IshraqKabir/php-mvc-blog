
const addPost = (post_id, content) => {
  const comment = {
      'post_id': post_id,
      'content': content
  };
  fetch('http://localhost/comments/addComment', {
    method: 'POST',
    body: JSON.stringify(comment),
    headers: {
      'Content-type': 'application/json; charset=UTF-8'
    }
  })
  .then(res => {
    // will remove the text from comment input field
    let content = document.querySelector(`.text__${postID}`);
    content.value = '';
  })
  .catch(err => console.log(err));
}



// adding query selectors to all the comment input Icons
document.querySelectorAll('.addCommentIcon').forEach(icon => {
  icon.addEventListener('click', event => {
    let addCommentIcon = event.target;
    let classList = addCommentIcon.classList;
    classList = Array.prototype.slice.call(classList);
    postIDString = classList[0];
    postID = postIDString.replace("button__", "");
    // alert(postID);
    let commentContent = document.querySelector(`.text__${postID}`).value;
    if  (commentContent !== '') {
        addPost(postID, commentContent);
    }

    let commentsList = document.querySelector(`.commentsList__${postID}`);
    console.log(commentsList);
    let singleComment = document.createElement('div');
    singleComment.classList.add('singleComment');
      let imgDiv = document.createElement('div');
      imgDiv.classList.add('img');
        let img = document.createElement('img');
        img.src= "https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSpYHz0hbmkgfvd6XKbIUJlpMS5hNSCp5avLRAEa8cNAyBpJ0_V&usqp=CAU";
        img.alt = "default_profile_pic";
        img.classList.add('responsive-img');
        img.classList.add('circle');
        img.classList.add('profile-pic');
        imgDiv.append(img);
      let content = document.createElement('div');
      content.classList.add('content');
        let username = document.createElement('div');
        username.classList.add("username");
          let anchor = document.createElement('a');
          anchor.setAttribute('href', 'http://localhost/profiles/userProfile/{{comment.user_id}}');
          let session_username = document.querySelector('.session_username').textContent;
          anchor.innerHTML = session_username;
          username.append(anchor);
          content.append(username);
          let commentText = document.createElement('div');
          commentText.classList.add('commentText');
          commentText.innerHTML = commentContent;
          content.append(commentText);

      // adding all the elements to form singleComment div
      singleComment.append(imgDiv);
      singleComment.append(content);


      // will add single comment to the commment list
      commentsList.prepend(singleComment);

      singleComment.classList.add('light-blue');

      setTimeout(() => {
        singleComment.classList.remove('light-blue');
      }, 1000);

  });
});

// adding event listener to the comment button to show/hide comment section
document.querySelectorAll('.commentButton').forEach(button => {
  button.addEventListener('click', event => {
    let commentButton = event.target;
    let classList = commentButton.classList;
    classList = Array.prototype.slice.call(classList);
    postID = classList[0];
    let commentSectionWrapper = document.querySelector(`.commentSectionWrapper__${postID}`);
    commentSectionWrapper.classList.toggle('__show');
  })
});
