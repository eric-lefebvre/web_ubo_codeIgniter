<!-- Page Heading -->
<div class="text-center mb-4 mt-4">
    <h1 class="h3 text-gray-800">Modifier scénario</h1>
    <h2 class="h5 mb-0 text-gray-800"><?php echo $scenario->SCE_intitule; ?></h2>
    <hr class="w-25 mx-auto mt-3 border-bottom border-primary">
</div>

<div class="container mt-5">
    <div class="card p-4 mx-auto" style="max-width: 400px;">

        <?= session()->getFlashdata('error') ?>

        <?php echo form_open('/scenario/modifier'); ?>
            <?= csrf_field() ?>

            <?php 
                if (isset($status))
                    if ($status == "failure") {?>

                    <div class="alert alert-danger" role="alert">
                        <!-- a modifier --> alerte
                    </div>

            <?php }?>
                
            <div class="form-group">
                <label for="intitule">Intitule:</label>
                <input type="input" class="form-control" name="intitule" value="<?= set_value('intitule', $scenario->SCE_intitule) ?>">
                <?= validation_show_error('intitule') ?>
            </div>

            <div class="form-group">
                <label for="image">Image: </label>
                <input type="file" name="image" value="<?= set_value('image', $scenario->SCE_cheminImage) ?>">
                <?= validation_show_error('pseudo') ?>
            </div>

            <div class="form-group" style="margin-top: 20px;">
                <div class="d-flex justify-content-between">
                    <a href="<?php echo base_url()?>index.php/scenario/afficher_liste" class="btn btn-light btn-outline-primary">Annuler</a>
                    <input type="submit" class="btn btn-light btn-outline-primary" name="valider" value="Valider">
                </div>
            </div>
        </form>

    </div>
</div>