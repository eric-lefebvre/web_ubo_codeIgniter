<h1><?php echo $titre;?></h1><br />
<?php
    if (isset($news))
    {
        echo $news->ACT_id;
        echo(" -- ");
        echo $news->ACT_intitule;
    }
    else 
    {
        echo ("Pas d'actualité !");
    }
?>
