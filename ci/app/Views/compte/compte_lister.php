<!-- Page Heading -->
<div class="text-center mb-4 mt-4">
    <h1 class="h3 text-gray-800">Gestion des comptes</h1>
    <h2 class="h5 mb-0 text-gray-800">Nombre de comptes: <?php echo $nb_comptes->nb; ?></h2>
    <hr class="w-25 mx-auto mt-3 border-bottom border-primary">
</div>

<a class="nav-link" href="<?php echo base_url();?>index.php/compte/creer" style="font-size: 1.4rem;">
    <i class="fas fa-fw fa-plus"></i>
    <span>Ajouter</span>
</a>

<?php 
    if (isset($status)) {
        if ($status == "compte_ajoute") {?>

        <div class="alert alert-succes" role="alert">
            Compte ajouté avec succès
        </div>
<?php } } ?>

<?php if (!empty($comptes) && $nb_comptes->nb > 1) { ?>

    <table class="table table-bordered table-striped overflow-auto">
        <thead class="table-secondary">
            <tr>
                <th> Login </th>
                <th> Role </th>
                <th> Etat </th>
            </tr>
        </thead>
    <?php foreach($comptes as $compte) { ?>

        <tr>
            <td> <?php echo $compte['CPT_login'];?> </td>
            <td> <?php echo ($compte['CPT_role'] == 'A') ? 'Administrateur' : 'Organisateur'; ?> </td>
            <td> <?php echo ($compte['CPT_etat'] == 'A') ? 'Activé' : 'Désactivé'; ?> </td>
        </tr>

    <?php } ?>

    </table>

<?php 
    } else {
        echo "Aucun compte pour le moment";
    }
?>