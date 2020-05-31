
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
    alert(postID);
    let content = document.querySelector(`.text__${postID}`).value;
    if (content !== '') {
        addPost(postID, content);
    }

    let commentsList = document.querySelector(`${postID}__commentsList`);
    let singleComment = document.createElement('div');
    singleComment.classList.add('singleComment');
    singleComment.innerHTML = 'sup, yall';
    body.append(singleComment);

  });
});
