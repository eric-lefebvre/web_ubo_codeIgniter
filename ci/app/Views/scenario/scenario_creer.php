<!-- Page Heading -->
<div class="text-center mb-4 mt-4">
    <h1 class="h3 text-gray-800">Créer scénario</h1>
    <hr class="w-25 mx-auto mt-3 border-bottom border-primary">
</div>

<div class="container mt-5">
    <div class="card p-4 mx-auto" style="max-width: 400px;">

        <?= session()->getFlashdata('error') ?>

        <?php echo form_open_multipart('/scenario/creer'); ?>
            <?= csrf_field() ?>

            <?php 
                if (isset($status))
                    if ($status == "failure") {?>

                    <div class="alert alert-danger" role="alert">
                        Le scénario n'a pas pu être créé, essayez avec une autre image
                    </div>

            <?php }?>
                
            <div class="form-group">
                <label for="intitule"><strong>Intitule:</strong></label>
                <input type="input" class="form-control" name="intitule">
                <?= validation_show_error('intitule') ?>
            </div>

            <div class="form-group">
                <label for="image"><strong>Image: </strong></label><br>
                <input type="file" name="image">
                <?= validation_show_error('image') ?>
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
                    <a href="<?php echo base_url()?>index.php/scenario/afficher_liste" class="btn btn-light btn-outline-primary">Annuler</a>
                    <input type="submit" class="btn btn-light btn-outline-primary" name="valider" value="Valider">
                </div>
            </div>
        </form>

    </div>
</div>