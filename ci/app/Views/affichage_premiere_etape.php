<?php if (!empty($etape)) { ?>
<!-- Header-->
<header class="bg-dark py-5 mb-3">
    <div class="container px-4 px-lg-5 my-4">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder mb-4"><?php echo $etape->ETA_intitule; ?></h1>
        </div>
    </div>
</header>

<?php if ($etape->ETA_id != NULL) { ?>

    <div class="container mt-5 text-center">
        <!-- Image -->
        <?php if ($etape->RSC_chemin != NULL && $etape->RSC_chemin != "") { ?>
            <?php
                $imagePath = base_url() . "resources/Etape/" . $etape->RSC_chemin;
                $imageSize = getimagesize($imagePath);
                $maxWidth = 500;
                $displayWidth = min($imageSize[0], $maxWidth);
            ?>
            <img class="mx-auto" style="max-width: <?= $displayWidth ?>px; width: 100%;" src="<?= $imagePath ?>" alt="Image">
        <?php } else { $displayWidth = 500;?>
            <p class="text-muted">Pas d'image</p>
        <?php } ?>

        <!-- Question -->
        <div class="mt-4 mx-auto" style="max-width: <?= $displayWidth ?>px; text-align: left;">
            <h5>Question:</h5>
            <p><?= $etape->ETA_question ?></p>
        </div>

        <!-- AFFICHER L'INDICE -->

        <!-- FORMULAIRE DE REPONSE -->

        <?= session()->getFlashdata('error') ?>

        <?php echo form_open('/scenario/afficher_premiere/' .$code_scenario. '/' .$difficulte); ?>
            <?= csrf_field() ?>

        <!-- Input -->
        <div class="mt-4 mx-auto" style="max-width: <?= $displayWidth ?>px; text-align: left;">
            <label for="reponse" class="form-label"><h5>Votre réponse:</h5></label>
            <input type="text" class="form-control" name="reponse" placeholder="Saisissez votre réponse">
            <?= validation_show_error('reponse') ?>
        </div>

        <div class="mt-4 mx-auto" style="max-width: <?= $displayWidth ?>px; text-align: left;">
            <div class="d-flex justify-content-between">
                <?php if ($etape->IND_lien != NULL) {?>
                    <a target="_blank" href="<?= $etape->IND_lien ?>" class="btn btn-light btn-outline-primary">Besoin d'aide ?</a>
                <?php } else { ?>
                    <p>Aucun indice</p>
                <?php } ?>
                <input type="submit" class="btn btn-light btn-outline-primary" name="valider" value="Valider">
            </div>
        </div>
        
    </div>

<?php } else {
    echo "Aucune étape pour le moment";
} ?>

<?php } else { 
    echo "L'information recherchée n'existe pas";
}?>




    


