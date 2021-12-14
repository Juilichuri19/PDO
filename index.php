<?php
require_once '_connec.php';
//connect to database
$pdo = new \PDO(DSN, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);

//retrieve records from table 'friend' and display it in the form of list
$query = 'SELECT * FROM friend';
$statement = $pdo->query($query);
$friends = $statement->fetchAll(PDO::FETCH_ASSOC);
echo "<h1>Friends List</h1>";
echo "<ul>";
foreach ($friends as $friend) {
    echo "<li>" . $friend['firstname'] . ' ' . $friend['lastname'] ."</li>" . PHP_EOL;
    echo "<br>";
}
echo "</ul>";

//validation for firstname and lastname
$firsrname = '';
$lastname = '';
$errorMsg = '';

if (isset($_POST['submit'])) {

    if(empty($_POST['firstname']) || empty($_POST['lastname'])) {
        $errorMsg = '<span name="errorMsg" style="color:#ff0000">All fields are required</span><br />';
    } elseif (strlen($_POST['firstname']) > 45 || strlen($_POST['lastname']) > 45) {
        $errorMsg =  '<span name="errorMsg" style="color:#ff0000">Name length should be less than 45 characters</span><br />';

    } else  {
        //if no errors insert the values in table friend
        $firsrname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);

        $query = "INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)";
        $statement = $pdo->prepare($query);

        $statement->bindValue(':firstname', $firsrname, \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);

        $statement->execute();

        header("Location: index.php");

    }
}

//Form to add new friend
?>

<html>
    <head></head>
    <body>
        <h1>Add new Friend</h1>
        <form action="" method="post">
            <div>
                <label for="firstname">Firstname</label> <br>
                <input type="text" id="firstname" name="firstname">

            </div>
            <br>
            <div>
                <label for="lastname">Lastname</label> <br>
                <input type="text" id="lastname" name="lastname">

            </div>
            <?php if(!empty($errorMsg)) {
                echo $errorMsg;
            } ?>
            <br>
            <div class="button">
                <button type="submit" name="submit"> Submit</button>
            </div>
        </form>
    </body>
</html>









