<?php

class Note
{

  const REGEXP = [
    'username' => '/^[A-Za-z0-9]{4,64}$/',
    'email' => '/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/',
    'description' => '/[\s\S]{1,4096}/',
    'id' => '/^([0-9]{0,})$/',
    'status' => '/^([0-9]{0,})$/'
  ];

  const SORTS = [
    'email' => 'email',
    'username' => 'username',
    'status' => 'status_id'
  ];

  public static function newNote($username, $email, $description)
  {
    $db = Database::getConnection();

    $stmt = $db->prepare("INSERT INTO notes(username, email, description)
      VALUES(?, ?, ?)")->execute([$username, $email, $description]);

    if ($stmt)
    {
      return $db->lastInsertId();
    }

    return false;
  }

  public static function updateNote($id, $description, $status_id)
  {
    $edited = 0;
    $db = Database::getConnection();
    $stmt = $db->prepare("SELECT
                              description
                          FROM
                              notes
                          WHERE
                              id = ?");
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($description !== $result['description']) {
      $edited = 1;
    }

$stmt = $db->prepare("UPDATE
                notes
              SET
                description = ?,
                status_id = ?,
                edited = ?
              WHERE
                id = ?");

    $stmt->execute([$description, $status_id, $edited, $id]);

    return $stmt;
  }

  public static function getCount()
  {
    $db = Database::getConnection();
    
    $stmt = $db->query("SELECT COUNT(id) as count FROM notes");
    
    $stmt = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt)
    {
      return $stmt['count'];
    }

    return false;
  }

  public static function getNotes($offset = 0, $orderBy = 'id', $orderOn = 'DESC', $limit = 3)
  {
    $db = Database::getConnection();
    $orderBy = 'n.' . $orderBy;
    $stmt = $db->prepare("SELECT
                          n.id,
                          n.username,
                          n.email,
                          n.description,
                          n.edited,
                          n.status_id,
                          s.status,
                          s.class_name
                      FROM
                          notes AS n
                      INNER JOIN statuses AS s
                      ON
                          n.status_id = s.id
                      ORDER BY $orderBy $orderOn 
                      LIMIT ? OFFSET ?");

    $stmt->execute([$limit, $offset]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result)
    {
      return $result;
    }

    return false;
  }
  
  public static function getStatuses()
  {
    $db = Database::getConnection();
    $stmt = $db->query("SELECT
                          *
                          FROM
                          statuses");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result)
    {
      return $result;
    }

    return false;
  }

  public static function validate($array, $rules)
  {
    $errors = [];

    foreach ($rules as $key => $rule) {
      if (key_exists($key, $array)) 
      {
        if (!preg_match($rule, trim($array[$key]))) 
        {
          array_push($errors, $key);
        }
      }
    }

    if (!$errors)
    {
      return true;
    }

    return $errors;
  }
}
