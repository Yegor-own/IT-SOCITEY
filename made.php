<?php
    require "../includes/config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Made</title>
</head>
<body>
    <?php 
        include "../includes/header.php";
    ?>
            <main>
                <div class="container-lg">
                    <div class="row">
                        <article class="article col-12 rounded border border-secondary">
                            <br>
                            <?php 
                                if (isset($_POST['do_post'])){
                                    $errors = array();
                                    if ($_POST['Title'] == ''){
                                        $errors[] = 'Введите название';
                                    }
                                    if ($_POST['Login'] == ''){
                                        $errors[] = 'Введите логин';
                                    }
                                    if ($_POST['Email'] == ''){
                                        $errors[] = 'Введите Email';
                                    }
                                    if ($_POST['Img'] == ''){
                                        $errors[] = 'Выберите картинку';
                                    }
                                    if ($_POST['text'] == ''){
                                        $errors[] = 'Напишите что нибудь';
                                    }
                                }
                                if ($_POST['do_post']){
                                    if (empty($errors)){
                                        mysqli_query($connection, "INSERT INTO `articles` (`title`, `author`, `email`, `text`) VALUES ('".$_POST['Title']."', '".$_POST['Login']."', '".$_POST['Email']."', '".$_POST['text']."')");
                                        echo '<div class="alert alert-success" role="alert">Статья добавлена!!!</div>';
                                    }
                                    else{
                                        echo '<div class="alert alert-danger" role="alert">' . $errors['0'] . '</div>';
                                    }
                                }
                                
                            ?>
                            <form action="../pages/made.php" method="POST" class="leavearticle">
                                <div class="row">
                                    <div class="col">
                                        <input type="text" name="Title" class="form-control" placeholder="Название">
                                    </div>
                                    <div class="col">
                                        <input type="text" name="Login" class="form-control" placeholder="Логин">
                                    </div>
                                    <div class="col">
                                        <input type="text" name="Email" class="form-control" placeholder="Email почта">
                                    </div>
                                </div><br>
                                <div class="input-group">
                                    <div class="col-5 custom-file">
                                        
                                        <input type="file" name="Img" id="img" class="custom-file-input" id="Img" aria-describedby="inputGroupFileAddon01" accept="image/*">
                                        <label class="custom-file-label" for="Img" id="chose_img">Выберите картинку</label>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col">
                                        <textarea name="text" placeholder="Текст" class="form-control"></textarea>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col">
                                        <input type="submit" name="do_post" class="btn btn-outline-success" value="Опубликовать">
                                    </div>
                                </div>
                            </form>
                            <br>
                        </article>
                    </div><br><br>
                </div>
            </main>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function(){
            $('input[type="file"]').change(function(e){
                var fileName = e.target.files[0].name;
                $("#chose_img").text(fileName);
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>  
</body>
</html>