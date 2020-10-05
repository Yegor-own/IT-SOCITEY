<?php
    require "includes/config.php";
    $article = mysqli_query($connection, "SELECT * FROM `articles` WHERE `id` = " . (int) $_GET['id']);
    $articl = mysqli_fetch_assoc($article);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title><?php echo $articl['title'] ?></title>
</head>
<body>
    <?php 
        include "includes/header.php";
        if (mysqli_num_rows($article) <= 0){
            ?>
            ARTICLE NOT FOUND 404
            <?php
        } else  {
            mysqli_query($connection, "UPDATE `articles` SET `views` = `views` + 1 WHERE `id` = " . (int) $articl['id']);
            ?>
            <main>
                <div class="container-lg">
                    <div class="row">
                        <article class="article col-12 rounded border border-dark">
                            <br>
                            <div class="row justify-content-around align-items-center">
                                <div class="title">
                                    <h2 class="title"><?php echo $articl['title'] ?></h2>
                                </div>
                                <div class="views">
                                    <span class="views"><?php echo 'Просмотров: '. $articl['views']; ?></span>
                                </div>
                            </div>
                            <br>
                            <img class="rounded border border-dark" src="../img/<?php echo $articl['img'] ?>" class="card-img-top" alt="..." style="width: 100%;">
                            <br><br>
                            <section class="text">
                                <?php
                                    echo $articl['text'];
                                ?>
                            </section>
                            <br>
                            <section class="comments justify-content-center">
                                <div class="comments-title">
                                    <h3 class="title">Коментарии</h3><br>
                                </div>
                                <?php 
                                    if (isset($_POST['do_post'])){
                                        $errors = array();
                                        if ($_POST['Login'] == ''){
                                            $errors[] = 'Введите логин';
                                        }
                                        if ($_POST['Email'] == ''){
                                            $errors[] = 'Введите Email';
                                        }
                                        if ($_POST['text'] == ''){
                                            $errors[] = 'Напишите коментарий';
                                        }
                                    }
                                ?>
                                <?php 
                                    if ($_POST['do_post']){
                                        if (empty($errors)){
                                            mysqli_query($connection, "INSERT INTO `comments` (`author`, `email`, `text`, `articles_id`) VALUES ('".$_POST['Login']."', '".$_POST['Email']."', '".$_POST['text']."', '".$articl['id']."' )");
                                            echo '<div class="alert alert-success" role="alert">Коментарий успешно добавлен!!!</div>';
                                        }
                                        else{
                                            echo '<div class="alert alert-danger" role="alert">' . $errors['0'] . '</div>';
                                        }
                                    }
                                ?>
                                <?php
                                    $comments = mysqli_query($connection, "SELECT * FROM `comments` WHERE `articles_id` = " . (int) $articl['id'] . " ORDER BY `id` DESC");
                                ?>
                                <?php
                                    if (mysqli_num_rows($comments) <= 0){
                                        ?>
                                        Нет коментариев!!
                                        <?php
                                    }
                                    while ($com = mysqli_fetch_assoc($comments)) {
                                        ?>
                                        <div class="row col-12">
                                            <div class="comment-img col-2">
                                                <img class="rounded-circle" src="https://www.gravatar.com/avatar/<?php echo md5($com['email']); ?>?s=100" alt="">
                                            </div>
                                            <div class="comment-content">
                                                <div class="comment-author">
                                                    <h4><a href="/articles.php?id=<?php echo $com['articles_id']; ?>" ><?php echo $com['author']; ?></a></h4>
                                                </div>
                                                <div class="comment-text">
                                                    <p><?php echo $com['text'] ?></p>
                                                </div>
                                            </div>
                                        </div><hr><br>
                                        <?php
                                    }
                                ?>
                            </section><br>
                            <section class="leave-comment">
                                <div class="title">
                                    <h3>Оставить комениарий</h3>
                                </div><br>
                                
                                <form action="/article.php?id=<?php echo $articl['id'] ?>" method="POST" class="leavecomment">
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" name="Login" class="form-control" placeholder="Логин">
                                        </div>
                                        <div class="col">
                                            <input type="text" name="Email" class="form-control" placeholder="Email почта">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col">
                                            <textarea name="text" placeholder="Комениарий" class="form-control"></textarea>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col">
                                            <input type="submit" name="do_post" class="btn btn-outline-success" value="Оставить">
                                        </div>
                                    </div>
                                </form>
                            </section><br>
                        </article>
                    </div><br><br>
                </div>
            </main>
            <?php
        }
    ?>
    

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>  
</body>
</html>