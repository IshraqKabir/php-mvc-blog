const like = (postID) => {
  // console.log(postID);
  fetch(`http://localhost/posts/likePost/${postID}`, {
    method: "post",
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    }
  })
    .then(() => {

    });
}

document.querySelectorAll('.likeIcon').forEach(button => {
  button.addEventListener('click', event => {
    let likeButton = event.target;
    let classList = likeButton.classList;
    classList = Array.prototype.slice.call(classList);
    postID = classList[0];
    like(postID);

    let likeCount = document.querySelector(`.likeCount__${postID}`).textContent;
    let likesString = likeCount.slice(7,-1);
    let likes = Number(likesString, 10);
    // console.log(likesString);

    if(likeButton.classList.contains('active')) {
      likes--;

      event.target.classList.remove('active');
    }
    else {
      likes++;
      event.target.classList.add('active');
    }

    document.querySelector(`.likeCount__${postID}`).textContent = 'Likes (' + likes + ')';



  });
});
