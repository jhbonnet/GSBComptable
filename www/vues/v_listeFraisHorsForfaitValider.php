<?php
/**
 * Vue Liste des frais hors forfait
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
?>
<hr>
<div class="row">
    <div class="panel panel-info">
        <div class="panel-heading"> Descriptif des éléments hors forfait </div>
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th class="date">Date</th>
                    <th class="libelle">Libellé</th>  
                    <th class="montant">Montant</th>  
                    <th class="action">&nbsp;</th> 
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
                <form action="index.php?uc=validerFrais&action=validerCreationFrais&visiteur=<?php echo $leVisiteur ?>&mois=<?php echo $leMois ?>&idFrais=<?php echo $id ?>" 
                        method="post" >
                    <td> 
                        <div class="form-group">
                            <input type="text" id="txtLibelleHF1" name="dateHF" 
                                class="form-control" id="text1" value="<?php echo $date ?>">
                        </div>
                    </td>
                    <td> 
                        <div class="form-group">
                            <input type="text" id="txtLibelleHF2" name="libelleHF" 
                                class="form-control" id="text2" value="<?php echo $libelle ?>">
                        </div>
                    </td>
                    <td> 
                        <div class="form-group">
                            <input type="text" id="txtLibelleHF3" name="montantHF" 
                                class="form-control" id="text3" value="<?php echo $montant ?>">
                        </div>
                    </td>
                    <td>
                        <button class="btn btn-success" type="submit">Corriger</button>
                        <button class="btn btn-danger" type="reset">Reinitialiser</button>
                    </td>
                </form>
                    <td>
                        <form action="index.php?uc=validerFrais&action=supprimerFraisHorsForfait&visiteur=<?php echo $leVisiteur ?>&mois=<?php echo $leMois ?>&idFrais=<?php echo $id ?>" 
                        method="post" >
                        
                        <button class="btn btn-dark" type="submit">Supprimer</button>
                        </form>
                    </td>

                </tr>
                <?php
            }
            ?>
            </tbody>  
        </table>
    </div>
</div>

    
<form method="post" action="index.php?uc=validerFrais&action=validerNombresJustificatifs&visiteur=<?php echo $leVisiteur ?>&mois=<?php echo $leMois ?>" >
    <fieldset>       
        <div class="row">
            <div class="col-md-2">
                <h6>Nombre de justificatifs : </h6>
            </div>
            <div class="col-md-1">
                <input type="text" id="nbJustificatifs" 
                       name="nbJustificatifs"
                       size="1" maxlength="3" 
                       value="<?php echo $nbJustificatifs ?>" 
                       class="form-control"> <br>
            </div>
        </div>
        <button class="btn btn-success" type="submit">Valider</button>
        <button class="btn btn-danger" type="reset">Reinitialiser</button>
    </fieldset>
</form>

