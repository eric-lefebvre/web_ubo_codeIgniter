<?php if (!empty($scenario)) {?>
<!-- Page Heading -->
<div class="text-center mb-4 mt-4">
    <h2 class="h5 mb-0 text-gray-800">Détails du scénario: </h2>
    <h2 class="h5 mb-0 text-gray-800"><?php echo $scenario->SCE_intitule; ?></h2>
    <hr class="w-25 mx-auto mt-3 border-bottom border-primary">
</div>

<a class="nav-link" href="<?php echo base_url();?>index.php/scenario/afficher_liste" style="font-size: 1.4rem;">
    <i class="fas fa-fw fa-arrow-left"></i>
    <span>Retour</span>
</a>

<?php if ($etapes[0]['ETA_intitule'] != null) { ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped overflow-scroll">
            <thead class="table-secondary">
                <tr>
                    <th> Image </th>
                    <th> Intitulé étape </th>
                    <th> Question </th>
                    <th> Réponse </th>
                    <th> Indices </th>
                    <!-- <th> Liens </th> -->
                </tr>
            </thead>
        <?php foreach($etapes as $etape) { ?>

            <tr>
                <td> 
                    <?php 
                        if ($etape['RSC_chemin'] == NULL || $etape['RSC_chemin'] == "")
                            echo "Pas d'image";
                        else 
                            echo "<img style='width: 100px; height: auto;' src='" .base_url(). "resources/Etape/" .$etape['RSC_chemin']. "'";?> 
                </td>
                <td> <?php echo $etape['ETA_intitule']?> </td>
                <td> <?php echo $etape['ETA_question'];?> </td>
                <td> <?php echo $etape['ETA_reponse'];?> </td>
                <td> 
                    <ul>
                        <?php
                            $indicesDescription = explode(",", $etape['indices_description']);
                            foreach ($indicesDescription as $description) {
                                echo "<li>" .$description. "</li>";
                            }
                        ?> 
                    </ul>
                </td>
                <!-- LIENS
                <td> 
                    <ul>
                        <?php /*
                            $indicesLiens = explode(",", $etape['indices_lien']);
                            foreach ($indicesLiens as $lien) {
                                echo "<li>" .$lien. "</li>";
                            } */
                        ?> 
                    </ul>
                </td>
                -->
            </tr>

        <?php } ?>

        </table>
    </div>

<?php 
    } else {
        echo "Aucune étape pour l'instant";
    }
?>
<?php } else {
    echo "Ce scénario n'existe pas";
}?>