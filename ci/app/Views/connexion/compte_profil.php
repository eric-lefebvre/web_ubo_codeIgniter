<?php
    $session=session();
?>

<!-- Page Heading -->
<div class="text-center mb-4 mt-4">
    <h1 class="h3 text-gray-800">Mon profil</h1>
    <hr class="w-25 mx-auto mt-3 border-bottom border-primary">
</div>

<div class="container mt-5">
    <div class="card p-4 mx-auto" style="max-width: 400px;">

        <div class="mb-3">
            <strong>Login:</strong> <?php echo stripslashes($session->get('user'));?>
        </div>

        <div class="mb-3">
            <strong>Mot de passe:</strong> <?php echo str_repeat('&#8226;', 8);?>
        </div>

        <div class="mb-3">
            <strong>Role:</strong>
            <?php echo ($session->get('role') == 'A') ? 'Administrateur' : 'Organisateur'; ?>
        </div>

        <div class="mb-3">
            <strong>Etat:</strong>
            <?php echo ($session->get('etat') == 'A') ? 'Activé' : 'Désactivé'; ?>
        </div>

        <a href="<?php echo base_url();?>index.php/compte/modifier_profil" class="btn btn-primary">Modifier</a>

    </div>
</div>
