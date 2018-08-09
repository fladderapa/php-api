<?php
  require_once 'views/header.php';
  require_once 'views/toolbar.php';
?>
  <main class="main-wrapper">
    <section class="section-wrapper">
    </section>
    <section class="section-wrapper">
      <h1>Add a post</h1>
      <div class="form-group">
        <input type="text" id="title" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="article" placeholder="Article name">
        <textarea name="post" id="comment" rows="8" cols="120" placeholder="Your post should not be more tha 10000 characters! Remember!"></textarea>
        <br/>
        <button onclick="addEntry()" class="btn btn-primary" value="Post">Post </button>


      </div>
    </section>
  </main>
</body>
<script src="scripts/jquery-latest.js"></script>
<script src="scripts/jquery.tablesorter.js"></script>
<script src="scripts/jquery.tablesorter.pager.js"></script>
<script src="scripts/main.js"></script>
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js" defer></script>

<footer class="footer-wrapper">
</footer>

</html>
