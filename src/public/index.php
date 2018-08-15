<?php
if (session_status() == PHP_SESSION_NONE) {
    session_set_cookie_params(3600);
    session_start();
}

/**
 * Require the autoload script, this will automatically load our classes
 * so we don't have to require a class everytime we use a class. Evertime
 * you create a new class, remember to runt 'composer update' in the terminal
 * otherwise your classes may not be recognized.
 */
require_once '../../vendor/autoload.php';

/**
 * Here we are creating the app that will handle all the routes. We are storing
 * our database config inside of 'settings'. This config is later used inside of
 * the container inside 'App/container.php'
 */

$container = require '../App/container.php';
$app = new \Slim\App($container);
$auth = require '../App/auth.php';
require '../App/cors.php';


/********************************
 *          ROUTES              *
 ********************************/


$app->get('/', function ($request, $response, $args) {
    /**
     * This fetches the 'index.php'-file inside the 'views'-folder
     */
    return $this->view->render($response, 'index.php');
});

$app->get('/add-user', function ($request, $response, $args) {
    /**
     * This fetches the 'index.php'-file inside the 'views'-folder
     */
    return $this->view->render($response, 'add-user.php');
});

$app->get('/add-entry', function ($request, $response, $args) {
    /**
     * This fetches the 'index.php'-file inside the 'views'-folder
     */
    return $this->view->render($response, 'add-entry.php');
});

$app->get('/add-comment/{id}', function ($request, $response, $args) {
    /**
     * This fetches the 'index.php'-file inside the 'views'-folder
     */
    return $this->view->render($response, 'add-comment.php');
});

$app->get('/update-entry/{id}', function ($request, $response, $args) {
    /**
     * This fetches the 'index.php'-file inside the 'views'-folder
     */
    return $this->view->render($response, 'update-entry.php');
});

/**
 * I added basic inline login functionality. This could be extracted to a
 * separate class. If the session is set is checked in 'auth.php'
 */
$app->post('/login', function ($request, $response, $args) {
    /**
     * Everything sent in 'body' when doing a POST-request can be
     * extracted with 'getParsedBody()' from the request-object
     * https://www.slimframework.com/docs/v3/objects/request.html#the-request-body
     */
    $body = $request->getParsedBody();
    $fetchUserStatement = $this->db->prepare('SELECT * FROM users WHERE username = :username');
    $fetchUserStatement->execute([
        ':username' => $body['username']
    ]);
    $user = $fetchUserStatement->fetch();
    if (password_verify($body['password'], $user['password'])) {
        $_SESSION['loggedIn'] = true;
        $_SESSION['userID'] = $user['id'];
        return $response->withJson(['data' => [ $user['id'], $user['username'] ]]);
    }
    return $response->withJson(['error' => 'wrong password']);
});

/**
 * Basic implementation, implement a better response
 */
$app->get('/logout', function ($request, $response, $args) {
    session_destroy();
    return $response->withJson('Success');
});


/**
 * The group is used to group everything connected to the API under '/api'
 * This was done so that we can check if the user is authed when calling '/api'
 * but we don't have to check for auth when calling '/signin'
 */
$app->group('/api', function () use ($app) {

  // GET http://localhost:XXXX/api/entries
  //List all entries
  $app->get('/entries', function ($request, $response, $args) {
    //   url: api/entries?amount=X
    if (isset($_GET['amount'])) {
        $amount = ($_GET['amount']);
        $amountTodos = $this->todos->getAmountEntries($amount);
        return $response->withJson(['data' => $amountTodos]);
    }
    else{
        $allTodos = $this->todos->getAllEntries();
        return $response->withJson(['data' => $allTodos]);
    }

  });

  // GET http://localhost:XXXX/api/todos
  // List the last 20 entries
  $app->get('/getLast20Entries', function ($request, $response, $args) {
      $allTodos = $this->todos->getLast20Entries();
      return $response->withJson(['data' => $allTodos]);
  });

  // GET http://localhost:XXXX/api/users
  // List all users
  $app->get('/users', function ($request, $response, $args) {
    if (isset($_GET['amount'])) {
        $amount = ($_GET['amount']);
        $amountUsers = $this->todos->getAmountUsers($amount);
        return $response->withJson(['data' => $amountUsers]);
    }
    else{
        $allTodos = $this->todos->getAllUsers();
        return $response->withJson(['data' => $allTodos]);
    }
  });


  $app->get('/comments', function ($request, $response, $args) {
    // GET http://localhost:XXXX/api/comments?amount=X
    // List amount of comments
    if (isset($_GET['amount'])) {
        $amount = ($_GET['amount']);
        $amountComments = $this->todos->getAmountComments($amount);
        return $response->withJson(['data' => $amountComments]);
    }
     // List all comments
     // GET http://localhost:XXXX/api/comments
    else{
        $allTodos = $this->todos->getAllComments();
        return $response->withJson(['data' => $allTodos]);       
    }
  });

  // GET http://localhost:XXXX/api/comments/id
  //Get one comment with id
    $app->get('/comments/{id}', function ($request, $response, $args) {
        $id = $args['id'];
        $singleComment = $this->todos->getOneComment($id);
        return $response->withJson(['data' => $singleComment]);
    });



  // GET http://localhost:XXXX/api/[table]/id
  $app->get('/{table}/{id}', function ($request, $response, $args) {
      $id = $args['id'];
      $table = $args['table'];
      $singleTodo = $this->todos->getOne($table,$id);
      return $response->withJson(['data' => $singleTodo]);
  });


  /****************************************/
  /* Post */
  /****************************************/

  // POST a user to /api/addUser
  $app->post('/addUser', function ($request, $response, $args) {
      $body = $request->getParsedBody();
      $newTodo = $this->todos->addUser($body);
      return $response->withJson(['data' => $newTodo]);
  });

  // POST a entry to /api/entries
  $app->post('/addEntry', function ($request, $response, $args) {
      $body = $request->getParsedBody();
      $newTodo = $this->todos->addEntry($body);
      return $response->withJson(['data' => $newTodo]);
  });

  // POST a comment to /api/addComment
  $app->post('/addComment', function ($request, $response, $args) {
    $body = $request->getParsedBody();
    $newTodo = $this->todos->addComment($body);
    return $response->withJson(['data' => $newTodo]);
});

//UPDATE entry to /api/entries
$app->patch('/entries', function ($request, $response, $args){
    $body = $request->getParsedBody();
    $entryUpdate = $this->todos->updateEntry($body);
    return $response->withJson(['data' => $entryUpdate]);
});

//DELETE entry to /api/entries/id
$app->delete('/entries/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $singleEntry = $this->todos->deleteOneEntry($id);
    return $response->withJson(['data' => $singleEntry]);
});

//DELETE comments to /api/comments/id
$app->delete('/comments/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $singleComment = $this->todos->deleteOneComment($id);
    return $response->withJson(['data' => $singleComment]);
});

//GET entries by user  /api/user/entries/id
$app->get('/user/entries/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $allEntriesByUser = $this->todos->getAllEntriesByUser($id);
   return $response->withJson(['data' => $allEntriesByUser]);
});

//GET comment by entry  /api/entry/comments/id
$app->get('/entry/comments/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $allCommentsByEntry = $this->todos->getAllCommentsByEntry($id);
   return $response->withJson(['data' => $allCommentsByEntry]);
});

});

$app->run();
