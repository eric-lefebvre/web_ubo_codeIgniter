<?php if (isset($scenario_success)) { ?>
    <script>
        alert("Votre réussite du <?= $scenario_success_date ?> au scénario: '<?= $scenario_success ?>' en difficulté <?= $scenario_success_diff ?> bien été enregistrée");
    </script>
<?php } ?>

<!-- Header-->
<header class="bg-dark py-4 mb-5">
    <div class="container px-4 px-lg-5 my-4">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder mb-4">Découvrez nos expositions éphémères</h1>
            <p class="lead fw-normal text-white-50 mb-0">Cliquez sur jouer pour choisir une exposition</p>
        </div>
    </div>
</header>

<!-- Affichage Actualites-->

<?php if (!empty($actualites)) { ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped overflow-auto">
            <thead class="table-secondary">
                <tr>
                    <th> Intitule </th>
                    <th> Description </th>
                    <th> Auteur </th>
                    <th> Date de publication </th>
                </tr>
            </thead>
        <?php foreach($actualites as $act) { ?>

            <tr>
                <td> <?php echo $act['ACT_intitule']?> </td>
                <td> <?php echo $act['ACT_description']?> </td>
                <td> <?php echo $act['CPT_login']?> </td>
                <td> <?php echo $act['ACT_date']?> </td>
            </tr>

        <?php } ?>

        </table>
    </div>
    
<?php } else {
    echo "Aucune actualité pour l'instant !";
}?>