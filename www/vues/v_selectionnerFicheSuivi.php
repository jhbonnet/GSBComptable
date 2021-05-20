<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * ATTENTION: en fait veut on vraiment montrer le detail des frais forfaitisés car une fiche validee est un total (cf base de donnee: on ne voit pas le detail) : donc simplement mettre une boite avec le total ?
 */
?>
<div class="row">
    <div class="col-md-4">
        <h3>Sélectionner une fiche : </h3>
    </div>
    <div class="col-md-4">
        <form action="index.php?uc=suivreFrais&action=afficherSuiviFiche" 
              method="post" role="form">
            <div class="form-group">
                <label for="lstFiche" accesskey="n"> Choisir la fiche de frais : </label>
                <select id="lstFiche" name="lstFiche" class="form-control">
                    <?php
                    foreach ($lesFichesDeFraisASuivre as $uneFiche) {
                        $id = $uneFiche['idvisiteur'];
                        $nom = $uneFiche['nom'];
                        $prenom = $uneFiche['prenom'];
                        $mois = $uneFiche['mois'];
                        if ($id == $ficheASelectionnerId AND $mois == $ficheASelectionnerMois) {
                            ?>
                            <option selected value="<?php echo $id . "," . $mois ?>">
                                <?php echo $nom . ' ' . $prenom . ' : ' . $mois?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $id . "," . $mois ?>">
                                <?php echo $nom . ' ' . $prenom . ' : ' . $mois?> </option>
                            <?php
                        }
                    }
                    ?>    

                </select>
            </div>
            <input id="ok" type="submit" value="Valider" class="btn btn-success" 
                   role="button">
            
        </form>
    </div>
</div>
