<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="row">    
    <h2>Suivi de fiches de frais validées pour la mise en paiement </h2>
    <h3>Eléments forfaitisés</h3>
    <div class="col-md-4">

        
             
                 
                <?php
                foreach ($lesFraisForfait as $unFrais) {
                    $idFrais = $unFrais['idfrais'];
                    $libelle = htmlspecialchars($unFrais['libelle']);
                    $quantite = $unFrais['quantite']; ?>
                    <div class="row">
                        <div class="col-sm-9"><h3><?php echo $libelle ?></h3></div>
                        <div class="col-sm-3"><h3><?php echo $quantite ?></h3></div>
                    </div> 
        
                    <?php
                }
                ?>
                
            
    </div>
</div>
<div class="row">
    <div class="panel panel-info">
        <div class="panel-heading"> Descriptif des éléments hors forfait </div>
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th class="date">Date</th>
                    <th class="libelle">Libellé</th>  
                    <th class="montant">Montant</th>  
                </tr>
            </thead>  
            <tbody>
            <?php
            foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                $date = $unFraisHorsForfait['date'];
                $montant = $unFraisHorsForfait['montant'];
                $id = $unFraisHorsForfait['id']; ?>           
                <tr>
                    <td> 
                            <?php echo $date ?>
                    </td>
                    <td> 
                            <?php echo $libelle ?>
                    </td>
                    <td> 
                            <?php echo $montant ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>  
        </table>
    </div>
</div>

    
         
        <div class="row">
            <div class="col-md-4">
                <h3>Nombre de justificatifs : </h3>
            </div>
            <div class="col-md-1">
                <h3><?php echo $nbJustificatifs ?></h3>
            </div>
        </div>
<form action="index.php?uc=suivreFrais&action=mettreEnPaiement&visiteur=<?php echo $ficheSelectionneeId ?>&mois=<?php echo $ficheSelectionneeMois ?>" 
              method="post" role="form">
        <input id="ok" type="submit" value="Mettre en paiement" class="btn btn-success" 
                   role="button">
        </form>



    