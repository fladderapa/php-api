
<?php
  require_once 'views/header.php';
  require_once 'views/toolbar.php';
?>

  <main class="main-wrapper">
    <section class="section-wrapper">
      <div id="myContainer" class="container">
      </div>
    </section>
    <section>
    <div id="material-table"></div>
    </section>
    <!-- <section class="section-wrapper">
      <h1>Add a user</h1>
        <div class="section-row">
            <div class="col-1-2">
              <label for="name">User name*</label><br>
              <label for="number">Password*</label><br>
            </div>
            <div class="col-1-2">
              <input type="text" name="name" id="username" ><br>
              <input type="password" name="number" id="password" ><br>
              <input type="submit" class="submit" onclick="addUser()"  value="Add user">
                <form class="contact-form" method="GET">
                </form>
            </div>
        </div>
    </section> -->
    <!-- <section class="section-wrapper">
      <h1>Add a post</h1>
      <div class="form-group">
        <input type="text" id="title" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="article" placeholder="Article name">
        <textarea name="post" id="comment" rows="8" cols="120" placeholder="Your post should not be more tha 10000 characters! Remember!"></textarea>
        <br/>
        <button onclick="addEntry()" class="btn btn-primary" value="Post">Post </button>


      </div>
    </section> -->

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
