<!-- Page Heading -->
<div class="text-center mb-4 mt-4">
    <h1 class="h3 text-gray-800">Créer un compte</h1>
    <hr class="w-25 mx-auto mt-3 border-bottom border-primary">
</div>

<div class="container mt-5">
    <div class="card p-4 mx-auto" style="max-width: 400px;">

        <?= session()->getFlashdata('error') ?>

        <?php echo form_open('/compte/creer'); ?>
            <?= csrf_field() ?>

            <?php 
                $session=session();

                if (isset($status)) {
                    if ($status == "compte_existant") {?>

                    <div class="alert alert-danger" role="alert">
                        Le compte n'a pas pu être créé car il existe déjà
                    </div>
                    <?php }
                    if ($status == "failure") {?>

                    <div class="alert alert-danger" role="alert">
                        Le compte n'a pas pu être créé, veuillez réessayer
                    </div>
                    <?php } ?>

            <?php }?>
                
            <div class="form-group">
                <label for="pseudo"><strong>Pseudo:</strong></label>
                <input type="input" class="form-control" name="pseudo" value="<?= set_value('pseudo') ?>">
                <?= validation_show_error('pseudo') ?>
            </div>

            <div class="form-group">
                <label for="mdp"><strong>Mot de passe:</strong></label>
                <input type="password" class="form-control" name="mdp">
                <?= validation_show_error('mdp') ?>
            </div>

            <div class="form-group">
                <label for="conf_mdp"><strong>Confirmer mot de passe:</strong></label>
                <input type="password" class="form-control" name="conf_mdp">
                <?= validation_show_error('conf_mdp') ?>
            </div>

            <div class="form-group">
                <label for="role"><strong>Role:</strong></label><br>
                <select class="form-select" aria-label="Default select example" for="role" name="role" style="width: max-content;">
                    <option value="O" selected>Organisateur</option>
                    <option value="A">Administrateur</option>
                </select>
                <?= validation_show_error('role') ?>
            </div>

            <div class="form-group">
                <label for="etat"><strong>Etat:</strong></label><br>
                <select class="form-select" aria-label="Default select example" for="etat" name="etat" style="width: max-content;">
                    <option value="A" selected>Activé</option>
                    <option value="D">Désactivé</option>
                </select>
                <?= validation_show_error('etat') ?>
            </div>

            <div class="form-group" style="margin-top: 20px;">
                <div class="d-flex justify-content-between">
                    <a href="<?php echo base_url()?>index.php/compte/afficher_liste" class="btn btn-light btn-outline-primary">Annuler</a>
                    <input type="submit" class="btn btn-light btn-outline-primary" name="valider" value="Valider">
                </div>
            </div>
        </form>

    </div>
</div>