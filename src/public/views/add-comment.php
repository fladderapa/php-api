<?php
  require_once 'views/header.php';
  require_once 'views/toolbar.php';
?>
  <main class="main-wrapper">
    <section class="section-wrapper">
    </section>
    <section class="section-wrapper">
      <h1>Add a Comment</h1>
      <div class="form-group">
      <div class="mdc-text-field mdc-text-field--textarea" style="margin-top: 25px;">
        <textarea class="mdc-text-field__input" name="post" id="contentComment" rows="8" cols="120" placeholder="Your post should not be more tha 10000 characters! Remember!"></textarea>
        </div>
        <button onclick="addComment()" class="btn btn-primary" value="Post">Post </button>
      </div>
    </section>
  </main>
  <script>
    var addComment = function(){
    var url = window.location.pathname;
    var id = url.substring(url.lastIndexOf('/') + 1);
    var content = document.getElementById("contentComment").value;

    var time = new Date();

    const formData = new FormData();
    formData.append('entryID', id);
    formData.append('content', content);

    const postOptions = {
      method: 'POST',
      body: formData,
      // MUCH IMPORTANCE!
      credentials: 'include'
    }
    //debugger;
    fetch('/api/addComment', postOptions)
      .then(res => res.json())
      .then(window.location = "/");
      
    }
  </script>
</body>
<footer class="footer-wrapper">
</footer>


</html>
