<html>
<head>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<form id="submit_form" action="user_handler.php" method="post">
    <div class="col-sm-4">
        <div class="form-group">
            <label>Имя</label>
            <input type="text" class="form-control" name="user_name" id="name" placeholder="Имя" required>
        </div>
        <div class="form-group">
            <label>Пароль</label>
            <input type="password" class="form-control" name="pass" placeholder="Пароль" required>
        </div>
        <input type="submit" class="btn btn-success" name="add" value="Войти"><br><br><br>
    </div>
</form>

</body>
</html>


<?php
if (isset($_GET["msg"]) && $_GET["msg"] == 'failed') {
	echo "Неверные Логин / Пароль!";
}
?>