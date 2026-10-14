<?php $session = session(); ?>
<!-- Page Heading -->
<div class="text-center mb-4 mt-4">
    <h1 class="h3 mb-0 text-gray-800">Gestion des scénarios</h1>
    <h2 class="h5 mb-0 text-gray-800">Nombre de scénarios: <?php echo $nb_scenario->nb; ?></h2>
    <hr class="w-25 mx-auto mt-3 border-bottom border-primary">
</div>

<a class="nav-link" href="<?php echo base_url();?>index.php/scenario/creer" style="font-size: 1.4rem;">
    <i class="fas fa-fw fa-plus"></i>
    <span>Creer</span>
</a>

<?php if (!empty($scenarios)) { ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped overflow-scroll">
            <thead class="table-secondary">
                <tr>
                    <th> Intitulé </th>
                    <th> Image </th>
                    <th> Nombre d'étapes </th>
                    <th> Auteur </th>
                    <th> Etat </th>
                    <th>  </th>
                    <th>  </th>
                    <th>  </th>
                    <th>  </th>
                    <th>  </th>
                    <th>  </th>
                </tr>
            </thead>
        <?php foreach($scenarios as $scenario) { ?>

            <tr>
                <td class="text-break" style="max-width: 300px;"> <?php echo $scenario['SCE_intitule']?> </td>
                <td style="max-width: 300px;"> 
                    <?php 
                        if ($scenario['SCE_cheminImage'] == NULL || $scenario['SCE_cheminImage'] == "")
                            echo "Pas d'image";
                        else 
                            echo "<img style='width: 120px; height: auto;' src='" .base_url(). "resources/Scenario/" .$scenario['SCE_cheminImage']. "'";?> 
                </td>
                <td  class="text-break" style="max-width: 150px;"> 
                    <?php 
                        if ($scenario['nb_etapes'] > 0)
                            echo $scenario['nb_etapes'];
                        else
                            echo "Aucune étape pour ce scénario";
                    ?> 
                </td>
                <td class="text-break" style="max-width: 150px;"> <?php echo $scenario['CPT_login'];?> </td>
                <td> <?php echo ($scenario['SCE_etat'] == 'A') ? 'Activé' : 'Désactivé'; ?> </td>

                <!-- DETAILS -->
                <td> 
                    <a class="nav-link" href="<?php echo base_url(). "index.php/scenario/afficher_details/" .$scenario['SCE_code']?>">
                        <i class="fas fa-fw fa-eye"></i>
                    </a> 
                </td>

                <?php 
                    if ($session->get('id') != $scenario['CPT_id']) {
                ?>
                <!-- COPIER -->
                <td> 
                    <a class="nav-link" href="<?php echo base_url()?>index.php/scenario/afficher_liste"
                    onclick="return confirm('Créer une copie de \'<?= $scenario['SCE_intitule']?>\' dont vous serez l\'auteur ?');">
                        <i class="fas fa-fw fa-copy"></i>
                    </a> 
                </td>

                <?php 
                    } else {
                        echo "<td>  </td>";
                    }
                ?>
                
                <?php 
                    if ($session->get('id') == $scenario['CPT_id']) {
                ?>
                <!-- MODIFIER -->
                <td> 
                    <a class="nav-link" href="<?php echo base_url()?>index.php/scenario/afficher_liste">
                        <i class="fas fa-fw fa-pen"></i>
                    </a> 
                </td>
                <!-- DESACTIVER/ACTIVER -->
                <td> 
                    <?php 
                        if ($scenario['SCE_etat'] == 'D') {?>
                            <a class="nav-link" href="<?php echo base_url();?>index.php/scenario/activer/<?php echo $scenario['SCE_code'];?>">
                            <i class="fas fa-fw fa-toggle-off"></i>
                    <?php } else { ?>
                            <a class="nav-link" href="<?php echo base_url();?>index.php/scenario/desactiver/<?php echo $scenario['SCE_code'];?>">
                            <i class="fas fa-fw fa-toggle-on"></i>
                    <?php } ?>
                    </a> 
                </td>
                <!-- REMETTRE A 0 -->
                <td> 
                    <a class="nav-link" href="<?php echo base_url();?>index.php/scenario/afficher_liste"
                    onclick="return confirm('Effacer toutes les données de ce scénario ?');">
                        <i class="fas fa-fw fa-eraser"></i>
                    </a> 
                </td>
                <!-- SUPPRIMER -->
                <td> 
                    <a class="nav-link" href="<?php echo base_url();?>index.php/scenario/supprimer/<?php echo $scenario['SCE_code'];?>"
                    onclick="return confirm('Supprimer ce scénario ?');">
                        <i class="fas fa-fw fa-trash"></i>
                    </a> 
                </td>
                <?php 
                    } else {
                        echo "<td>  </td>";
                        echo "<td>  </td>";
                        echo "<td>  </td>";
                        echo "<td>  </td>";
                    }
                ?>
            </tr>

        <?php } ?>

        </table>
    </div>

<?php 
    } else {
        echo "Aucun scénario pour l'instant !";
    }
?>