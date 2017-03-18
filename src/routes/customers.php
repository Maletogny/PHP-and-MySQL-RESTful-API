<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Get all customers

$app->get('/api/customers', function(Request $request, Response $response){
  $sql = "SELECT * FROM customers";

  try {
    //get database object
    $db = new db();
    //connect
    $db = $db->connect();

    $stmt = $db->query($sql);

    $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;

    echo json_encode($customers);



  } catch(PDOException $e) {
    echo '{"error": {"text": '. $e->getMessage(). '}}';
  }

});


//Get a single customer

$app->get('/api/customer/{id}', function(Request $request, Response $response){
  $id = $request->getAttribute('id');

  $sql = "SELECT * FROM customers WHERE id = $id";

  try {
    //get database object
    $db = new db();
    //connect
    $db = $db->connect();

    $stmt = $db->query($sql);

    $customer = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;

    echo json_encode($customer);



  } catch(PDOException $e) {
    echo '{"error": {"text": '. $e->getMessage(). '}}';
  }

});


//Add customers

$app->post('/api/customer/add', function(Request $request, Response $response){
  $firstName = $request->getParam('firstName');
  $lastName = $request->getParam('lastName');
  $phone = $request->getParam('phone');
  $email = $request->getParam('email');
  $address = $request->getParam('address');
  $city = $request->getParam('city');
  $country = $request->getParam('country');

  $sql = "INSERT INTO customers (firstName,lastName,phone,email,address,city,country) VALUES(:firstName,:lastName,:phone,:email,:address,:city,:country)";

  try {
    //get database object
    $db = new db();
    //connect
    $db = $db->connect();

    // $stmt = $db->query($sql);

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':country', $country);

    $stmt->execute();

    echo '{"notice": {"text": "Customer Added"}}';

  } catch(PDOException $e) {
    echo '{"error": {"text": '. $e->getMessage(). '}}';
  }

});


//Update customers

$app->put('/api/customer/update/{id}', function(Request $request, Response $response){
  $id = $request->getAttribute('id');
  $firstName = $request->getParam('firstName');
  $lastName = $request->getParam('lastName');
  $phone = $request->getParam('phone');
  $email = $request->getParam('email');
  $address = $request->getParam('address');
  $city = $request->getParam('city');
  $country = $request->getParam('country');

  $sql = "UPDATE customers SET
                firstName = :firstName,
                lastName = :lastName,
                phone = :phone,
                email = :email,
                address = :address,
                city = :city,
                country = :country

  WHERE id = $id";

  try {
    //get database object
    $db = new db();
    //connect
    $db = $db->connect();

    // $stmt = $db->query($sql);

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':country', $country);

    $stmt->execute();

    echo '{"notice": {"text": "Customer Updated"}}';

  } catch(PDOException $e) {
    echo '{"error": {"text": '. $e->getMessage(). '}}';
  }

});


//Delete customer

$app->delete('/api/customer/delete/{id}', function(Request $request, Response $response){
  $id = $request->getAttribute('id');

  $sql = "DELETE FROM customers WHERE id = $id";

  try {
    //get database object
    $db = new db();
    //connectDelete
    $db = $db->connect();

    $stmt = $db->prepare($sql);

    $stmt->execute();
    // $db = null;

    echo '{"notice": {"text": "Customer deleted"}}';

  } catch(PDOException $e) {
    echo '{"error": {"text": '. $e->getMessage(). '}}';
  }

});
