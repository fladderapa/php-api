<?php
  require_once 'views/header.php';
  require_once 'views/toolbar.php';
?>
  <main class="main-wrapper">
    <section class="section-wrapper">
    </section>
    <section class="section-wrapper">
      <h1>Add a user</h1>
        <div class="section-row">
            <div class="col-1-2">
              <label for="name">User name*</label><br>
              <label for="number">Password*</label><br>
            </div>
            <div class="col-1-2">
              <input class="user-input" type="text" name="name" id="username" ><br>
              <input class="user-input" type="password" name="number" id="password" ><br>
              <input type="submit" class="submit" onclick="addUser()"  value="Add user">
              <div class="mdc-text-field">
  <input type="text" id="my-text-field" class="mdc-text-field__input">
  <label class="mdc-floating-label" for="my-text-field">Hint text</label>
  <div class="mdc-line-ripple"></div>
</div>

                <form class="contact-form" method="GET">
                </form>
            </div>
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
