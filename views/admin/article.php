<?php 

$html = "";

foreach ($param['notes'] as $note) {
  $html = $html . "<form name='article' class='note'>
  <input hidden name='id' value='".$note['id']."'>
  <div class='note-container flex'>
  <div class='description-area full-w flex'>
  <textarea required name='description' required maxlength='4000'>"
    .  htmlspecialchars($note['description']) .
  "</textarea></div>
  <div class='note-data flex dir-col valign-start'>
    <div class='username'>@"
    . htmlspecialchars($note['username']) .
    "</div>
    <div class='email'>"
    . htmlspecialchars($note['email']) .
    "</div>
    <div class='flex dir-col'>";
      foreach ($param['statuses'] as $status) {
        $html = $html . "<label>
        <input type='radio' name='status' value='" . $status['id'] . $res = $status['id'] == $note['status_id'] ? " ' checked>": "'>";
        $html = $html . $status['status'] . "</label>";
      }
    $html = $html ."</div>
    </div>
   </div>
   <div class='nav-container full-w flex align-end'>
      <button class='btn'>
        SAVE
      </button>
   </div> 
  </form>";
}

return $html;
