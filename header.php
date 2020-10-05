<?php
    $categories_q = mysqli_query($connection, "SELECT * FROM `articles_categories`");
    $categories = array();
    while($cat = mysqli_fetch_assoc($categories_q)){
        $categories[] = $cat;
    }
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark col-12">
    <a class="navbar-brand" href="/"><?php echo $config['title']; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?php
                foreach($categories as $cat){
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/articles.php?categorie=<?php echo $cat['id']; ?>"><?php echo $cat['title']; ?></a>
                    </li>
                    <?php
                }
            ?>
            <li class="nav-item">
                <a class="nav-link" href="../pages/made.php">Написать свою статью</a>
            </li>
        </ul>
    </div>
    <form class="form-inline" method="GET" action="../article.php">
        <input class="form-control mr-sm-2" type="search" placeholder="Поиск" aria-label="Search">
        <button class="btn btn-outline-warning my-2 my-sm-0" type="submit">Поиск</button>
    </form>
</nav><br>