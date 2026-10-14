<!-- Header-->
<header class="bg-dark py-4 mb-4">
    <div class="container px-4 px-lg-5 my-4">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder mb-4">Découvrez nos expositions éphémères</h1>
            <p class="lead fw-normal text-white-50 mb-0">Sélectionnez une exposition pour commencer</p>
        </div>
    </div>
</header>

<!-- Affichage Scenarii-->
<section class="py-5">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            
        <?php 
            if (!empty($scenarii)) {
                foreach($scenarii as $scenario) { ?>

            <div class="col mb-5 mt-5">
                <div class="card h-100">
                    <!-- Image -->
                    <?php 
                        if ($scenario['SCE_cheminImage'] == NULL || $scenario['SCE_cheminImage'] == "") {
                            echo "Pas d'image";
                        } else {?>
                            <img class="card-img-top" src="<?php echo base_url() . "resources/Scenario/" .$scenario['SCE_cheminImage']?>" alt="..." >
                        <?php } ?>
                    
                    <!-- Details-->
                    <div class="card-body mt-2 mb-0">
                        <div class="text-center">
                            <!-- Intitule -->
                            <h4 class="fw-bolder"><?php echo $scenario['SCE_intitule']?></h4>
                            <!-- Intitule -->
                            <h5 class="fw-bolder"><?php echo "Par: " .$scenario['CPT_login']?></h5>
                        </div>
                    </div>
                    <!-- Actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="dropdown text-center">
                            <a class="dropdown-toggle btn btn-outline-dark mt-auto" role="button" data-bs-toggle="dropdown" aria-expanded="false">Difficulté</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo "/~e22107159/index.php/scenario/afficher_premiere/" . $scenario['SCE_code'] . "/1"?>">Facile</a></li>
                                <li><a class="dropdown-item" href="<?php echo "/~e22107159/index.php/scenario/afficher_premiere/" . $scenario['SCE_code'] . "/2"?>">Moyen</a></li>
                                <li><a class="dropdown-item" href="<?php echo "/~e22107159/index.php/scenario/afficher_premiere/" . $scenario['SCE_code'] . "/3"?>">Difficile</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <?php 
                } 
            } else {
                echo "Aucun scénario pour l'instant !";
            }
        ?>

        </div>
    </div>
</section>
