<aside>
    <div class="title justify-content-center">
        <h3>Топ читаемых</h3>
    </div><br>
    <div class="top-views">
        <?php
            $articles = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `views` DESC LIMIT 6");
        ?>

        <?php
            while ($art = mysqli_fetch_assoc($articles)) {
                ?>
                <section class="col  mb-4">
                    <div class="card border-secondary">
                        <img src="img/<?php echo $art['img'] ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h6 class="card-title"><?php echo $art['title'] ?></h6>
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
                            </div>
                            <a href="../article.php?id=<?php echo $art['id']; ?>" class="btn btn-outline-dark">Читать</a><br>
                            <span class="views"><?php echo 'Просмотров: '. $art['views']; ?></span>
                        </div>
                    </div>
                </section>
                <?php
            }
        ?>
    </div>
</aside>