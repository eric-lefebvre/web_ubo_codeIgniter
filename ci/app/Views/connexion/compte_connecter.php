<div class="container mt-5">
    <div class="card p-4 mx-auto" style="max-width: 400px;">

        <h2>Se connecter</h2>

        <?= session()->getFlashdata('error') ?>

        <?php echo form_open('/compte/connecter'); ?>
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="pseudo">Pseudo:</label>
                <input type="input" class="form-control" name="pseudo" value="<?= set_value('pseudo') ?>">
                <?= validation_show_error('pseudo') ?>
            </div>

            <div class="form-group">
                <label for="mdp">Mot de passe:</label>
                <input type="password" class="form-control" name="mdp" style="margin-bottom: 10px;">
                <?= validation_show_error('mdp') ?>
            </div>

            <?php if (isset($status))
                if ($status == "failure") {?>
            <div class="alert alert-danger" role="alert">
                Echec d’authentification, veuillez réessayez
                </div>
            <?php }?>

            <div class="form-group" style="text-align: right;">
                <input type="submit" class="btn btn-light btn-outline-primary" name="submit" value="Se connecter">
            </div>
        </form>

    </div>
</div>