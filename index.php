<?php
    require "includes/config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- <link rel="shortcut icon" href="/images/www.jpg" type="image/jpg"> -->
    <title><?php echo $config['title']; ?></title>
</head>
<body>
    <?php include "includes/header.php" ?>
    <main>
        <div class="container-lg">
            <div class="row">
                <article class="news col-9">
                    <div class="row justify-content-between">
                        <div class="title">
                            <h2>Новости</h2>
                        </div>
                        <div class="more">
                            <a href="/articles.php?categorie=0" class="btn btn-outline-info">Все статьи</a>
                        </div>
                    </div><br>
                    
                    <div class="row row-cols-1 row-cols-md-2">
                        <?php
                            $articles = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `id` DESC LIMIT 5");
                        ?>

                        <?php
                            while ($art = mysqli_fetch_assoc($articles)) {
                                ?>
                                <section class="col  mb-5">
                                    <div class="card border-secondary">
                                        <img src="img/<?php echo $art['img'] ?>" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $art['title'] ?></h5>
                                            <div class="card-cat-meta">
                                                <?php 
                                                    $art_cat = false;
                                                    foreach($categories as $cat){
                                                        if($cat['id'] == $art['categorie_id']){
                                                            $art_cat = $cat;
                                                            break;
                                                        }
                                                        
                                                    }
                                                ?>
                                                <h6>Категория: <a href="/articles.php?categorie=<?php echo $art_cat['id']; ?>"><?php echo $art_cat['title']; ?></a></h6>
                                            </div>
                                            
                                            <p class="card-text"><?php echo mb_substr($art['text'],0,150, 'utf-8') . ' ...' ?></p>
                                            <a href="article.php?id=<?php echo $art['id']; ?>" class="btn btn-outline-dark">Читать дальше</a>
                                        </div>
                                    </div>
                                </section>
                                <?php
                            }
                        ?>
                        
                    </div>
                </article>
                <article class="col-3 sidebar">
                    <br><br><br>
                    <?php include "includes/sidebar.php" ?>
                </article>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>