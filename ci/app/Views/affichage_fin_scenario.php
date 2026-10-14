<!-- Header-->
<header class="bg-dark py-5 mb-3">
    <div class="container px-4 px-lg-5 my-4">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder mb-4">Valider ma participation</h1>
        </div>
    </div>
</header>

<div class="container mt-5">
    <div class="card p-4 mx-auto" style="max-width: 400px;">

        <?= session()->getFlashdata('error') ?>

        <?php echo form_open('/scenario/finaliser_scenario/' .$all_codes. '/' .$difficulte); ?>
            <?= csrf_field() ?>
                
            <div class="form-group">
                <label for="email"><strong>Adresse email:</strong></label>
                <input type="input" class="form-control" name="email">
                <?= validation_show_error('email') ?>
            </div>

            <div class="form-group" style="margin-top: 20px;">
                <div class="d-flex justify-content-between">
                    <a href="<?php echo base_url()?>" class="btn btn-light btn-outline-primary">Je ne m'enregistre pas</a>
                    <input type="submit" class="btn btn-light btn-outline-primary" name="valider" value="Valider">
                </div>
            </div>
        </form>

    </div>
</div>