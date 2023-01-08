<!DOCTYPE html>
<html lang="en">

<head>

    <style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body {
        width: 100%;
        height: 100vh;
        display: grid;
        place-items: center;
        background: #f5f5f5;
    }

    .card-wrap {
        width: 40%;
        height: auto;
        background: #fff;
        padding: 20px;
        box-shadow: 0px 0px 10px 1px #ddd;

    }

    .card-wrap h1 {
        font-size: 28px;
        color: #000;
        font-weight: 900;
        text-align: center;
        margin-bottom: 20px;
    }

    .card-wrap p {
        font-size: 13px;
        color: #000;
        line-height: 28px;
        text-align: justify;
        text-align-last: center;
        letter-spacing: 1px;
    }

    .card-box {
        position: relative;
        font-weight: 900;
        font-size: 14px;
        cursor: pointer;
        text-decoration: underline;
    }

    .card-popup {
        box-sizing: border-box;
        position: absolute;
        top: 30px;
        left: -85px;
        z-index: 9;
        background: purple;
        color: #fff;
        font-weight: normal;
        width: 250px;
        height: auto;
        padding: 10px;
        font-size: 12px;
        line-height: 22px;
        letter-spacing: normal;
        cursor: text;
        visibility: hidden;
        opacity: 0;
        transform: translate3d(0, 20, 0);
        z-index: 1;
        transition: .5s;

    }

    .card-popup:before {
        position: absolute;
        content: '';
        width: 25px;
        height: 25px;
        background: purple;
        top: -50px;
        left: 0;
        right: 0;
        margin: auto;
        transform: rotate(45deg);
        z-index: -1;

    }

    ..card-box:hover . .card-popup {
        visibility: visible;
        z-index: 1;
        transform: translate3d(0, 20px, 0);
        transition: .5s;
    }
    </style>

</head>

<?php include('header.php') ?>
<?php include('db_connect.php');
?>
<title>ANATOMY OF THE HEART</title>
<link rel="stylesheet" href="styles/style.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>

    <!--	<?php include('nav_bar.php') ?>-->

    <br>
    <br>

    <div class="card-wrap">
        <h1>Example</h1>
        <p> this is example only <span class="card-box">Example <span class="card-popup"> <img src="img/4 cham.jpg"
                        alt="">This is example</span></span> this is an example only</p>
    </div>

</body>

</html>