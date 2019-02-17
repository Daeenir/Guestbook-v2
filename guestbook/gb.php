<?php
$link = mysqli_connect("localhost", "eh0008", "H#llgr#n2017", "eh0008");

mysqli_set_charset($link, "utf8");


$message = [];
if (isset($_POST['name'])) {
    $ok = TRUE;
    $name = strip_tags($_POST['name']);
    if (empty($_POST['name'])) {
        $message[] = 'You did not assign a name.';
        $ok = FALSE;
    }
} else {
    $name = '';
}
if (isset($_POST['header'])) {
    $ok = TRUE;
    $header = strip_tags($_POST['header']);
    if (empty($_POST['header'])) {
        $message[] = 'You did not assign a header.';
        $ok = FALSE;
    }
} else {
    $header = '';
}
if (isset($_POST['input'])) {
    $input = strip_tags($_POST['input']);
    if (empty($_POST['input'])) {
        $message[] = 'You have to write something in your post.';
        $ok = FALSE;
    }
} else {
    $input = '';
}
if (isset($_POST['email'])) {
    $email = strip_tags($_POST['email']);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    } else {
        $ok = FALSE;
        $message[] = 'Your email address is not valid.';
    }
} else {
    $email = '';
}
$number = mt_rand(3, 10);

if (isset($_POST['captcha'])) {
    $summa = 5 + $_POST['correct'];
    if ($_POST['captcha'] == $summa) {
    } else {
        $ok = FALSE;
        $message[] = 'You can\'t count.';
    }
}
if (isset($ok)) {
    if ($ok == TRUE) {
        $query = "INSERT INTO `gb_posts` (`PostID`, `Header`, `Email`, `Name`, `Date`, `Post`) VALUES (NULL, '$header', '$email', '$name', NOW(), '$input')";
        mysqli_query($link, $query);
        header('location: gb.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="utf-8"/>
    <title>Posts</title>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
</head>

<body>

<?php
for ($i = 0; $i < count($message); $i++) {
    echo '<div class="error"><h3>' . $message[$i] . '</h3></div>';
}

echo '<fieldset>
<div class="mb-4 card bg-primary">
<h2 class="m-4 text-center">Create your post here!</h2>
</div>
<form method="post">
<div class="container">
	<div class="form-group">
	<label for="header">Header</label>
	<input class="form-control" type="text" placeholder="Choose a header" id="header" name="header" maxlength="20" value="' . $header . '">
    </div>
	<div class="form-group">
	<label for="Namne">Name</label>
	<input class="form-control" type="text" placeholder="Choose a name" id="name" name="name" maxlength="20" value="' . $name . '">
    </div>
<div class="form-group">
<label for="input">What would you like to tell?</label>
<textarea class="form-control" id="input" placeholder="Write something" maxlength="400" name="input">' . $input . '</textarea>
</div>
<div class="form-group">
<label for="captcha">Add 5 and ' . $number . '</label>
<input id="captcha" class="form-control" type="text" placeholder="Show that you can count" name="captcha">
</div>
	<input type="hidden" name="correct" value="' . $number . '">
<div class="form-group">
<input class="btn-primary btn btn-lg" type="Submit" name="Submit" value="Send"></div>
</div>
</form>
</div>
</fieldset>';
$query = "SELECT * FROM `gb_posts` ORDER BY PostID";
$result = mysqli_query($link, $query);
echo mysqli_error($link);
if (mysqli_num_rows($result) == 0) {
  echo '<div class="container"><div class="alert alert-info"><h2 class="">There are currently no posts.</h2></div></div>';
}
else {
  echo '<div class="container"><h3 class="mb-4 mt-4">Previous posts.</h3>';
  while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="card">
            <div class="card-header bg-primary"><h5 class="m-0">' . $row['Header'] . '</h5></div>
            <div class="card-body">Post by: ' . '<b>' . $row['Name'] . '</b>,   ' . $row['Date'] . '<br>
            <p class="m-0 mt-2">' . $row['Post'] . '</p></div>
          </div><br>';
  }
}

?>
</body>
</html>