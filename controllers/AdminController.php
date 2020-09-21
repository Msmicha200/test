<?php 

class AdminController
{
    public function actionAdmin()
    {
        if (isset($_SESSION['admin']))
        {

          if (!isset($_GET['page']))
          {
            header("Location: /admin?page=1");
          }

          $currentPage = $_GET['page'];
          $limit = 3;
          $offset = ($currentPage - 1) * $limit;
          $notes = Note::getNotes($offset);

          $statuses = Note::getStatuses();
          $notes = Note::getNotes(0);
          $totalNotes = Note::getCount();
          $totalPages = ceil($totalNotes / $limit);

          require_once ROOT."/views/admin/index.php";
        } else {
            header("Location: /login");
        }
    }

    public function actionUpdateNote()
    {
      if (isset($_SESSION['admin']))
      {
        $validator = Note::validate($_POST, Note::REGEXP);
  
        if ($validator !== true)
        {
          echo json_encode([
            'status' => 'bad',
            'errors' => $validator
          ]);
          die();
        }
    
        $result = Note::updateNote($_POST['id'], $_POST['description'], $_POST['status']);
    
        if ($result)
        {
          echo json_encode([
            'status' => 'ok'
          ]);
        }
    
        return false;
      } else {
        echo json_encode([
          'status' => 'auth'
        ]);
        return false;
      }
    }
    public function actionNotesPage() 
    {
      $statuses = Note::getStatuses();
      $page = $_GET['page'];
      $limit = 3;
      $offset = ($page - 1) * $limit;
      $notes = Note::getNotes($offset);
      
      echo Tools::render("/admin/article", [
        'notes' => $notes,
        'statuses' => $statuses]);
  
      return true;
    }

    public function actionLogout()
    {
      unset($_SESSION['admin']);
      session_destroy();
      header("Location: /main");
    }
}
