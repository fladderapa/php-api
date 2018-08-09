<?php

namespace App\Controllers;

class TodoController
{
    private $db;

    /**
     * Dependeny Injection (DI): http://www.phptherightway.com/#dependency_injection
     * If this class relies on a database-connection via PDO we inject that connection
     * into the class at start. If we do this TodoController will be able to easily
     * reference the PDO with '$this->db' in ALL functions INSIDE the class
     * This class is later being injected into our container inside of 'App/container.php'
     * This results in we being able to call '$this->get('Todos')' to call this class
     * inside of our routes.
     */
    public function __construct(\PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function getAllEntries()
    {
        $getAll = $this->db->prepare('SELECT entries.entryID, entries.title, entries.content, users.username, entries.createdAt FROM entries INNER JOIN users ON entries.createdBy = users.userID');
        $getAll->execute();
        return $getAll->fetchAll();
    }

    public function getAllComments()
    {
        $getAll = $this->db->prepare('SELECT comments.commentID, comments.content, comments.createdAt, comments.createdBy FROM comments');
        $getAll->execute();
        return $getAll->fetchAll();
    }

    public function getLast20Entries()
    {
        $getAll = $this->db->prepare('SELECT * FROM (SELECT entries.entryID, entries.title, entries.content, users.username, entries.createdAt FROM entries INNER JOIN users ON entries.createdBy = users.userID ORDER BY entryID DESC LIMIT 20) as r ORDER BY entryID');
        $getAll->execute();
        return $getAll->fetchAll();
    }

    public function getAllUsers()
    {
        $getAll = $this->db->prepare('SELECT `userID`,`username`,`createdAt` FROM `users`');
        $getAll->execute();
        return $getAll->fetchAll();
    }

    public function getOne($table,$id)
    {
      $tableID = "";
      if ($table == 'entries') {
        $tableID = "entryID";
      }
      elseif ($table == 'users') {
        $tableID = 'userID';
      }
        $getOne = $this->db->prepare("SELECT * FROM $table WHERE $tableID = :id");
        $getOne->execute([
          ':id' => $id
        ]);
        return $getOne->fetch();
    }


    /****************************************/
    /* Post */
    /****************************************/

    // Add a user
    public function addUser($todo)
    {
        $addOne = $this->db->prepare(
            'INSERT INTO users (username, password) VALUES (:username, :password)'
        );

        $hashed = password_hash($todo['password'], PASSWORD_DEFAULT);
        $addOne->execute([
          ':username'  => $todo['username'],
          'password' => $hashed
        ]);
        return [
          'id'          => (int)$this->db->lastInsertId(),
          'username'     => $todo['username']
        ];
    }

    // Add an entry
    public function addEntry($todo)
    {
        $addOne = $this->db->prepare(
            'INSERT INTO entries (`title`, `content`, `createdBy`, `createdAt`) VALUES (:title, :content, :createdBy, :createdAt)'
        );

        $date = date("Y-m-d H:i:s");
        $addOne->execute([
          ':title'  => $todo['title'],
          ':content'  => $todo['content'],
          ':createdBy'  => 1,
          ':createdAt'  => $date
        ]);
        return [
          'entryID'      => (int)$this->db->lastInsertId(),
          'title'     => $todo['title'],
          'content'     => $todo['content'],
          'createdAt'     => $date,
        ];
    }

}
