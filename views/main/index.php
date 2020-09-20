<?php require_once (ROOT.'/views/layouts/header.php'); ?>
<main class="flex valign-center dir-col ">
  <section class="container flex align-end">
    <a class="login" href="/login">LOGIN</a>
  </section>
  <section class="container">
      <nav class="menu flex align-center">
        <ul class="flex full-w align-around sorts-container">
          <li>
            <button data-sortOn="email" data-sortDir="desc" class="btn">
              Email
              <span><img src="/template/images/arr.svg" alt=""></span>
            </button>
          </li>
          <li>
            <button data-sortOn="username" data-sortDir="desc" class="btn">
              Username
              <span><img src="/template/images/arr.svg" alt=""></span>
            </button>
          </li>
          <li>
            <button data-sortOn="status" data-sortDir="desc" class="btn">
              Status
              <span><img src="/template/images/arr.svg" alt=""></span>
            </button>
          </li>
        </ul>
      </nav>
    </section>
    <section class="container flex">
      <form action="" name="newNote" class="full-w flex align-end new-note-form">
        <div class="description-area full-w">
          <textarea name="description" maxlength="4000" placeholder="Note description" required id="description" cols="30" rows="10"></textarea>
        </div>
        <div class="user-data-container flex dir-col align-between  ">
          <div class="uvm--input-wrapper">
            <input autocomplete="off" name="username" maxlength="64" type="text" id="username" placeholder="username" class="uvm--input" required>
            <label for="username" class="uvm--label">Username</label>
          </div>
          <div class="uvm--input-wrapper">
            <input autocomplete="off" name="email" maxlength="64" type="text" id="email" placeholder="username" class="uvm--input" required>
            <label for="email" class="uvm--label">E-mail</label>
          </div>
          <button class="btn full-w accept-btn" type="button" id="accept-note">
            Accept
          </button>
        </div>
      </form>
    </section>
    <section class="container notes-container">
      <?php if ($notes): ?>
        <?php foreach ($notes as $note): ?>
          <article class="note flex">
            <aside class="description">
              <?=htmlspecialchars($note['description'])?>
            </aside>
            <div class="note-data flex dir-col valign-start">
              <div class="username">
                @<?=htmlspecialchars($note['username'])?>
              </div>
              <div class="email">
                <?=htmlspecialchars($note['email'])?>
              </div>
              <div class="status <?=$note['class_name']?>">
                <?=$note['status']?>
              </div>
            </div>
            <div class="edited">
              <?php 
                if ($note['edited'] == 1)
                  echo 'Edited';
              ?>
            </div>
          </article>
        <?php endforeach ?>
      <?php endif ?>
    </section>
    <section class="container flex align-center">
      <div class="pagination-buttons flex flex-wrap align-center">
        <?php for ($i=0; $i < $totalPages; $i++): ?>
              <button data-id="<?=$i+1?>" class="btn pagination-btn
              <?php echo $i+1 == $_GET['page'] ? 'selected-page' : ''; ?>" data-page="<?=$i+1?>">
                <?=$i+1?>
              </button>
        <?php endfor ?>
      </div>
    </section>
</main>
<script src="/template/scripts/tools.js"></script>
<script src="/template/scripts/pagination.js"></script>
<script src="/template/scripts/main.js"></script>
<?php require_once (ROOT.'/views/layouts/footer.php'); ?>
