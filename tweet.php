<?php
// tweet.php?id=3
// tweet.php?id=<script>alert("xss")</script>
//$tweetId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$tweetId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
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
$sth = $dbh->prepare('SELECT tweet.*, users.name FROM tweet
            JOIN users
            ON tweet.user_id = users.id
            WHERE tweet.id =' . $tweetId);
$sth->execute();
$result = $sth->fetch(PDO::FETCH_ASSOC);
print_r($result);
?>

<body>
    <div class="container px-5">
    <?php foreach ($result as $row): ?>
        <section class="card mt-2">
            <header class="card-header d-flex align-items-center">
                <h5 class="card-title pl-4 mb-0">
                    <?= $row['name'] ?>
                    <small class="pl-4">
                        <?= $row['created_at'] ?>
                    </small>
                </h5>
            </header>
            <a href="tweet.php?id=<?= $row['id'] ?>">
                <div class="card-body">
                    <p class="card-text">
                        <?= $row['body'] ?>
                    </p>
                </div>
            </a>
            <footer class="card-footer d-flex justify-content-end">
            </footer>
        </section>
    <?php endforeach ?>
    </div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>