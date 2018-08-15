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
            <div class="col-2-2">
              <label for="name">User name*</label><br>
              <label for="number">Password*</label><br>
            </div>
            <div class="col-1-2">
              <input class="user-input" type="text" name="name" id="username" ><br>
              <input class="user-input" type="password" name="number" id="password" ><br>
              <input type="submit" class="submit" onclick="addUser()"  value="Add user">


                <form class="contact-form" method="GET">
                </form>
            </div>
        </div>
    </section>
  </main>
</body>


<footer class="footer-wrapper">
</footer>

</html>
