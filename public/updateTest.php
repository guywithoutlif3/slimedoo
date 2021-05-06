<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="">
</head>

<body>
    <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <form action="/messages/update/22" method="POST">
        <label for="message">message:</label><br>
        <input type="text" id="message" name="message" value="old value"><br>
        <input type="submit" value="Submit">
    </form>


    <form action="/users/update/username" method="POST">
        <label for="username">username:</label><br>
        <input type="text" id="username" name="username" value="old name"><br>
        <input type="submit" value="Submit">
    </form>

    <form action="/users/update/password" method="POST">
        <label for="password">password:</label><br>
        <input type="text" id="password" name="password" value="old name"><br>
        <input type="submit" value="Submit">
    </form>
</body>

</html>