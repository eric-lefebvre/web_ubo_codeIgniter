<!-- Page Heading -->
<div class="text-center mb-4 mt-4">
    <h1 class="h3 text-gray-800">Modifier mon profil</h1>
    <hr class="w-25 mx-auto mt-3 border-bottom border-primary">
</div>

<div class="container mt-5">
    <div class="card p-4 mx-auto" style="max-width: 400px;">

        <?= session()->getFlashdata('error') ?>

        <?php echo form_open('/compte/modifier_profil'); ?>
            <?= csrf_field() ?>

            <?php 
                if (isset($status))
                    if ($status == "failure") {?>

                    <div class="alert alert-danger" role="alert">
                        Identifiants erronés ou inexistants!
                    </div>

            <?php }?>

            <div class="form-group">
                <label for="old_mdp"><strong>Ancien mot de passe:</strong></label>
                <input type="password" class="form-control" name="old_mdp">
                <?= validation_show_error('old_mdp') ?>
            </div>

            <div class="form-group">
                <label for="new_mdp"><strong>Nouveau mot de passe:</strong></label>
                <input type="password" class="form-control" name="new_mdp">
                <?= validation_show_error('new_mdp') ?>
            </div>

            <div class="form-group">
                <label for="conf_mdp"><strong>Confirmer mot de passe:</strong></label>
                <input type="password" class="form-control" name="conf_mdp">
                <?= validation_show_error('conf_mdp') ?>
            </div>

            <div class="form-group">
                <label for="role"><strong>Role:</strong></label><br>
                <select class="form-select" aria-label="Default select example" for="role" name="role" style="width: max-content;" disabled>
                    <option value = "<?php echo $user->CPT_role;?>" selected><?php echo $user->CPT_role;?></option>
                    <option value="A">Administrateur</option>
                    <option value="O">Organisateur</option>
                </select>

                <input type="hidden" name="role" value="<?php echo $user->CPT_role;?>">

                <?= validation_show_error('role') ?>
            </div>

            <div class="form-group">
                <label for="etat"><strong>Etat:</strong></label><br>
                <select class="form-select" aria-label="Default select example" for="etat" name="etat" style="width: max-content;" disabled>
                    <option value = "<?php echo $user->CPT_etat;?>" selected><?php echo $user->CPT_etat;?></option>
                    <option value="A">Activé</option>
                    <option value="D">Désactivé</option>
                </select>

                <input type="hidden" name="etat" value="<?php echo $user->CPT_etat;?>">

                <?= validation_show_error('etat') ?>
            </div>

            <div class="form-group" style="margin-top: 20px;">
                <div class="d-flex justify-content-between">
                    <a href="<?php echo base_url()?>index.php/compte/afficher_profil" class="btn btn-light btn-outline-primary">Annuler</a>
                    <input type="submit" class="btn btn-light btn-outline-primary" name="valider" value="Valider">
                </div>
            </div>
        </form>

    </div>
</div>