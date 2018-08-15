<?php
  require_once 'views/header.php';
  require_once 'views/toolbar.php';
?>
  <main class="main-wrapper">
    <section class="section-wrapper">
      <h1>Add a post</h1>
      <div class="form-group">
        <div class="mdc-text-field mdc-text-field--fullwidth">
          <input type="text" id="title" class="mdc-text-field__input" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="article" placeholder="Entry title">
        </div>
        <div class="mdc-text-field mdc-text-field--textarea" style="margin-top: 25px;">
          <textarea class="mdc-text-field__input" name="post" id="comment" rows="8" cols="120" placeholder="Your post should not be more tha 10000 characters! Remember!"></textarea>
        </div>
        <button onclick="addEntry()" class="btn btn-primary" value="Post">Post </button>
      </div>
    </section>
  </main>
</body>
<footer class="footer-wrapper"></footer>
</html>
