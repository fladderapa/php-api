<?php
  require_once 'views/header.php';
  require_once 'views/toolbar.php';
?>
  <main class="main-wrapper">
    <section class="section-wrapper">
    </section>

    <section class="section-wrapper">
      <h1>Update post</h1>
      <div class="form-group">
        <div class="mdc-text-field mdc-text-field--fullwidth">
          <input type="text" id="title" class="mdc-text-field__input" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="article" placeholder="Entry title">
        </div>
        <div class="mdc-text-field mdc-text-field--textarea" style="margin-top: 25px;">
          <textarea class="mdc-text-field__input" name="post" id="content" rows="8" cols="120" placeholder="Your post should not be more tha 10000 characters! Remember!"></textarea>
        </div>
        <button onclick="updateEntry()" class="btn btn-primary" value="Post">Update </button>
      </div>
    </section>

  </main>
  <script>
    var updateEntry = function(){
    var url = window.location.pathname;
    var id = url.substring(url.lastIndexOf('/') + 1);
    var title = document.getElementById("title").value;
    var content = document.getElementById("content").value;

    var time = new Date();

    const formData = new FormData();
    formData.append('entryID', id);
    formData.append('title', title);
    formData.append('content', content);
      
    const string = 'title='+ title + '&content='+ content + '&entryID='+ id;

    const postOptions = {
      method: 'PATCH',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: string,
      // MUCH IMPORTANCE!
      credentials: 'include'
    }
    //debugger;
    fetch('/api/entries', postOptions)
      .then(res => res.json())
      .then(window.location = "/");
      
    }
  </script>
</body>
<footer class="footer-wrapper">
</footer>


</html>
