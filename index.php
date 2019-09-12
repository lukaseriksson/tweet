<?php
include 'include/dbinfo.php';
try {
    $dbh = new PDO(
        'mysql:host=localhost;dbname=' . $database . '',
         $user,
          $password
    );
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
$sth = $dbh->prepare('SELECT * FROM tweet
            JOIN users
            ON tweet.user_id = users.id');
$sth->execute();
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
include 'views/index_layout.php';
?>