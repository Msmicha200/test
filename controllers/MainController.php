<?php

class MainController 
{

  public function __construct()
  {

  }

  public function getSortParams ()
  {
    $sortDirection = "DESC";
    $sortOn = "id";

    if (isset($_GET['sortOn']) && isset($_GET['sortDirection'])) 
    {
      if ($_GET['sortDirection'] == "desc" && array_key_exists($_GET['sortOn'], Note::SORTS)) 
      {
        $sortDirection = "DESC";
        $sortOn = Note::SORTS[$_GET['sortOn']];
      }
      else if ($_GET['sortDirection'] == "asc" && array_key_exists($_GET['sortOn'], Note::SORTS))
      {
        $sortDirection = "ASC";
        $sortOn = Note::SORTS[$_GET['sortOn']];
      }
    }
    
    return [$sortDirection, $sortOn];
  }

  public function actionIndex() 
  {
    if (!isset($_GET['page']))
    {
      header("Location: /main?page=1");
    }

    [ $sortDirection, $sortOn] = $this->getSortParams();
    $currentPage = $_GET['page'];
    $limit = 3;
    $offset = ($currentPage - 1) * $limit;
    $notes = Note::getNotes($offset, $sortOn, $sortDirection);

    $totalNotes = Note::getCount();
    $totalPages = ceil($totalNotes / $limit);
    
    require_once(ROOT."/views/main/index.php");

    return true;
  }

  public function actionNotesPage() 
  {
    [ $sortDirection, $sortOn] = $this->getSortParams();
    $page = $_GET['page'];
    $limit = 3;
    $offset = ($page - 1) * $limit;
    $notes = Note::getNotes($offset, $sortOn, $sortDirection);

    echo Tools::render("/main/article", [
      'notes' => $notes
    ]);

    return true;
  }

  public function actionAddNote()
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


    $result = Note::newNote($_POST['username'], $_POST['email'], $_POST['description']);
    $count = Note::getCount();
    $count = ceil($count / 3);
    
    if ($result)
    {
      echo json_encode([
        'status' => 'ok',
        'html' => Tools::render("/main/article", [
          'notes' => [
            [
              'username' => $_POST['username'],
              'email' => $_POST['email'],
              'description' => $_POST['description'],
              'status' => 'Rejected',
              'class_name' => 'rejected',
              'edited' => 0
            ]
          ]
        ]),
        'pagesCount' => $count
      ]);
    }

    return true;
  }
  
  public function actionLogin()
  {
    if (isset($_SESSION['admin']))
    {
      header("Location: /admin");
    }

    require_once ROOT."/views/login/index.php";
  }

  public function actionCheck()
  {
    if ($_POST['login'] == 'admin' && $_POST['password'] == '123') 
    {
      $_SESSION['admin'] = 1;
      echo json_encode([
        'result' => 'ok'
      ]);
      die();
    } else {
      echo json_encode([
        'result' => 'error'
      ]);
      die();
    }
  }

}
