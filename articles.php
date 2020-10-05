<?php
    require "includes/config.php";
    $cat_num = $_GET['categorie'];
    if ($cat_num != 0){
        $categorie = mysqli_query($connection, "SELECT * FROM `articles_categories` WHERE `id` = " . (int) $cat_num);
        $categ = mysqli_fetch_assoc($categorie);
    }else{
        $categ = ['title' => 'Все'];
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>$categ['title'];</title>
</head>
<body>
    <?php include "includes/header.php" ?>
    <main>
        <div class="container-lg">
            <div class="row">
                <article class="news col-9">
                    <h2 class="display-4"><?php if ($cat_num != 0){echo $categ['title'] . ' (все)';}else{echo $categ['title'];} ?></h2>
                    <div class="row row-cols-1 row-cols-md-2">
                        <?php
                            $per_page = 4;
                            $page = 1;

                            if (isset($_GET['page'])){
                                $page = (int) $_GET['page'];
                            }

                            $total_count_q = mysqli_query($connection, "SELECT COUNT(`id`) AS `total_count` FROM `articles`");
                            $total_count = mysqli_fetch_assoc($total_count_q);
                            $total_count = $total_count['total_count'];

                            $total_pages = ceil($total_count / $per_page);
                            if ($page < 0 || $page > $total_pages){
                                $page = 1;
                            }
                            $offset = ($per_page * $page) - $per_page;
                            if ($page != 0){
                                $offset = $per_page * $page;
                            }
                            if ($cat_num != 0){
                                $articles = mysqli_query($connection, "SELECT * FROM `articles` WHERE `categorie_id` = $cat_num ORDER BY `id` DESC");
                            } else{
                                $articles = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `id` DESC LIMIT $offset,$per_page");
                            }
                            if (mysqli_num_rows($articles) <= 0){
                                echo 'Нет статей!';
                            }
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
                            if ($cat_num == 0){
                                if (mysqli_num_rows($articles) > 0){
                                    echo '<nav class="paginator justify-content-center">';
                                        echo '<ul class="pagination justify-content-center">';
                                            echo '<li class="page-item">';
                                            if ($page > 1){
                                                echo '<a class="page-link" href="/articles.php?page='. ($page - 1) . '" tabindex="-1" aria-disabled="true">&laquo; Previous</a>';
                                            }
                                            echo '</li>';
                                            echo '<li class="page-item">';
                                            if ($page < $total_pages){
                                                echo '<a class="page-link"href="/articles.php?page='. ($page + 1) . '">Next &raquo;</a>';
                                            }
                                            echo '</li>';
                                        echo '</ul>';
                                    echo '</nav>';
                                }
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