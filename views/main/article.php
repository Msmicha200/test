<?php 
$html = "";

foreach ($param['notes'] as $note) {
  $html = $html . "<article class='note flex'>
  <aside class='description'>"
    .  htmlspecialchars($note['description']) .
  "</aside>
  <div class='note-data flex dir-col valign-start'>
    <div class='username'>@"
    . htmlspecialchars($note['username']) .
    "</div>
    <div class='email'>"
    . htmlspecialchars($note['email']) .
    "</div>
    <div class='status " .$note['class_name'] . "'>"
    . $note['status'] .
    "</div>
  </div>
  <div class='edited'>";
  $html = $html . $edited = $note['edited'] == 1 ? 'Edited' : '';
  $html = $html . 
  "</div>
  </article>";
}

return $html;
