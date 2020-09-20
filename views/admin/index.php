<?php require_once (ROOT.'/views/layouts/header.php'); ?>
<main class="flex valign-center dir-col ">
  <section class="container flex align-end">
    <a class="login" href="/logout">LOGOUT</a>
  </section>
  <section class="container notes-container">
    <?php if ($notes): ?>
      <?php foreach ($notes as $note): ?>
        <form name="article" class="note">
          <input type="text" name="id" hidden value="<?=$note['id']?>">
          <div class="note-container flex">
            <div class="description-area full-w flex">
              <textarea name="description" required maxlength="4000"><?=htmlspecialchars($note['description'])?></textarea>
            </div>
            <div class="note-data flex dir-col valign-start">
              <div class="username">
                @<?=htmlspecialchars($note['username'])?>
              </div>
              <div class="email">
                <?=htmlspecialchars($note['email'])?>
              </div>
              <div class="flex dir-col">
                <?php foreach ($statuses as $status): ?>
                  <label>
                    <input type="radio" name='status' 
                    <?=$note['status_id'] == $status['id'] ? 'checked' : '' ?> value="<?=$status['id']?>">
                    <?=$status['status']?>
                  </label>  
                <?php endforeach ?>
              </div>
            </div>
          </div>
          <div class="nav-container full-w flex align-end">
            <button class="btn">SAVE</button>
          </div>
        </form>
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
<script src="/template/scripts/admin.js"></script>
<script src="/template/scripts/select.js"></script>
<?php require_once (ROOT.'/views/layouts/footer.php'); ?>
