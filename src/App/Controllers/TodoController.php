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
        $getAll = $this->db->prepare('SELECT entries.entryID, entries.title, entries.content, users.username, entries.createdAt FROM entries INNER JOIN users ON entries.createdBy = users.userID LIMIT 20');
        $getAll->execute();
        return $getAll->fetchAll();
    }

    public function getAmountEntries($amount)
    {
        $getAmount = $this->db->prepare("SELECT * FROM (SELECT entries.entryID, entries.title, entries.content, users.username, entries.createdAt FROM entries INNER JOIN users ON entries.createdBy = users.userID ORDER BY entryID DESC LIMIT $amount) as r ORDER BY entryID");
        $getAmount->execute();
        return $getAmount->fetchAll();
    }

    public function getAllComments()
    {
        $getAll = $this->db->prepare('SELECT * FROM comments LIMIT 20');
        $getAll->execute();
        return $getAll->fetchAll();
    }

    public function getAmountComments($amount)
    {
        $getAmount = $this->db->prepare("SELECT * FROM comments LIMIT $amount");
        $getAmount->execute();
        return $getAmount->fetchAll();
    }

    public function getAllEntriesByUser( $id)
    {   
        $getUserPosts = $this->db->prepare('SELECT * FROM entries WHERE createdBy=:id');
        $getUserPosts->execute([':id' => $id]);
        $userPosts = $getUserPosts->fetchAll();
        return $userPosts;
    }

    public function getAllCommentsByEntry( $id)
    {   
        $getCommentsByEntry = $this->db->prepare('SELECT * FROM comments WHERE entryID=:id');
        $getCommentsByEntry->execute([':id' => $id]);
        $CommentsByEntry= $getCommentsByEntry->fetchAll();
        return $CommentsByEntry;
    }

    public function getOneComment($id)
    {
        $getOneComment = $this->db->prepare('SELECT * FROM comments WHERE commentID = :id');
        $getOneComment->execute([':id' => $id]);
        return $getOneComment->fetch();
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

    public function getAmountUsers($amount)
    {
        $getAmount = $this->db->prepare("SELECT `userID`,`username`,`createdAt` FROM `users` LIMIT $amount");
        $getAmount->execute();
        return $getAmount->fetchAll();
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
            'INSERT INTO users (username, password, createdAt) VALUES (:username, :password, :createdAt)'
        );

        $date = date("Y-m-d H:i:s");
        $hashed = password_hash($todo['password'], PASSWORD_DEFAULT);
        $addOne->execute([
          ':username'  => $todo['username'],
          'password' => $hashed,
          ':createdAt'  => $date
        ]);
        return [
          'id'          => (int)$this->db->lastInsertId(),
          'username'     => $todo['username'],
          'createdAt'     => $date,
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

    public function addComment($comments)
    {    // fetches current datetime into Swedish datetime.

         $newDate= date("Y-m-d H:i:s", strtotime('+2 hours')); 

         $addOne = $this->db->prepare(
          'INSERT INTO comments (entryID, content, createdBy, createdAt) VALUES (:entryID, :content, :createdBy, :createdAt)'
        );

         $addOne->execute([
            ':entryID' => $comments['entryID'], 
           ':content'   => $comments['content'],
           ':createdBy' => 1,
           ':createdAt' => $newDate
          ]);

         return [
           ':content'   => $entry['content'],
           ':createdBy' => $comments['createdBy'], 
           ':createdAt' => $newDate
        ];
    }

    public function deleteOneEntry($id)
    {
        $deleteOne = $this->db->prepare('DELETE FROM entries WHERE entryID = :id');
        $deleteOne->execute([':id' => $id]);
    }

    public function deleteOneComment($id)
    {
        $deleteOneComment = $this->db->prepare('DELETE FROM comments WHERE commentID = :id');
        $deleteOneComment->execute([':id' => $id]);
    }

    public function updateEntry($entry)
    {
        // UPDATE `entries` SET `title` = 'Uppdaterad', `content` = 'Via webbläsaren' WHERE `entries`.`entryID` = 16;
      $updateOne = $this->db->prepare('UPDATE entries SET title = :title, content = :content WHERE entryID = :entryID');
      $updateOne->execute([
        ':title' => $entry['title'], 
        ':content'   => $entry['content'],
        ':entryID' => $entry['entryID']
      ]);
    //   $updateOne->execute([ ':title' => $body['title'], ':content' => $body['content'], ':entryID' => $id]);
    }

}
