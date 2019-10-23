<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="register.php" method="post">

    <table border=0>
        <tr>
            <td>Ф.И.О.</td>
            <td><input type="text" name="fio" size=20/></td>
        </tr>
        <tr>
            <td>E-mail</td>
            <td><input type="text" name="email"/></td>
        </tr>
        <tr>
            <td>Пароль</td>
            <td><input type="password" name="password"/></td>
        </tr>
        <tr>
            <td>Повтор пароля</td>
            <td><input type="password" name="confirm"/></td>
        </tr>
    </table>

    <p><input type="checkbox" name="agree">Я принимаю пользовательское соглашение
    <p><input type="submit" value="Зарегистрироваться"/>

</form>
</body>
</html>