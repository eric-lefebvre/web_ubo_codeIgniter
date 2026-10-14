<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Gestion des scénarios</h1>
        <h2 class="h5 mb-0 text-gray-800">Nombre de scénarios: <?php echo $nb_scenario->nb; ?></h2>
    </div>
</div>

<?php if (!empty($scenarios)) { ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped overflow-auto">
            <thead class="table-secondary">
                <tr>
                    <th> Intitulé </th>
                    <th> Image </th>
                    <th> Nombre d'étapes </th>
                    <th> Auteur </th>
                    <th> Détails </th>
                    <th> Modifier </th>
                    <th> Activer/désactiver </th>
                    <th> Remettre à zéro </th>
                    <th> Supprimer </th>
                </tr>
            </thead>
        <?php foreach($scenarios as $scenario) { ?>

            <tr>
                <td> <?php echo $scenario['SCE_intitule']?> </td>
                <td> <?php echo "<img style='width: 100px; height: auto;' src='" .base_url(). "resources/Scenario/" .$scenario['SCE_cheminImage']. "'";?> </td>
                <td> <?php echo $scenario['nb_etapes'];?> </td>
                <td> <?php echo $scenario['CPT_login'];?> </td>



                <!-- METTRE DES ICONES PAS DES BOUTONS AVEC DU TEXTE -->


                
                <td> <?php echo "Details"?> </td>
                <td> <?php echo "Modifier"?> </td>
                <td> <?php echo "Activer/désactiver"?> </td>
                <td> <?php echo "Remettre à zéro"?> </td>
                <td> <?php echo "Supprimer"?> </td>
            </tr>

        <?php } ?>

        </table>

    </div>


<?php 
} else {
    echo "Aucun scénario pour l'instant !";
}
?>