<?php require_once (ROOT.'/views/layouts/header.php'); ?>
<main class="flex align-center">
  <section class="container flex align-center">
    <form name="login" class="login-container full-w flex dir-col valign-center">
      <div class="uvm--input-wrapper">
        <input autocomplete="off" name="login" id="login" maxlength="64" type="text" placeholder="username" class="uvm--input" required>
        <label for="" class="uvm--label">Login</label>
      </div>
      <div class="uvm--input-wrapper">
        <input autocomplete="off" name="password" maxlength="64" type="password" placeholder="username" class="uvm--input" required>
        <label for="" class="uvm--label">Password</label>
      </div>
      <button class="btn login-button" type="button">
        Log in
      </button>
  </form>
  </section>
</main>
<script src="/template/scripts/tools.js"></script>
<script src="/template/scripts/login.js"></script>
<?php require_once (ROOT.'/views/layouts/footer.php'); ?>
