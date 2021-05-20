<?php
/**
 * Gestion suivi du paiement des frais
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

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$lesFichesDeFraisASuivre = $pdo->getLesIdFraisValides();

if (sizeof($lesFichesDeFraisASuivre)== 0) {
            ajouterErreur('Pas de fiches de frais validee a mettre en paiement');
            include 'vues/v_erreurs.php';
                }
else {
    
    switch ($action) {
    case 'selectionnerFiche':
        $indexAselectionner = array_key_last($lesFichesDeFraisASuivre);
        //$indexAselectionner = 0;
        $ficheASelectionnerId = $lesFichesDeFraisASuivre[ $indexAselectionner]['idvisiteur'];
        $ficheASelectionnerMois = $lesFichesDeFraisASuivre[$indexAselectionner]['mois'];

        include 'vues/v_selectionnerFicheSuivi.php';
        break;
    default:
        switch ($action) {
            case 'afficherSuiviFiche':
                $ficheSelectionnee = filter_input(INPUT_POST, 'lstFiche', FILTER_SANITIZE_STRING);
                $ficheSelectionneeArray = explode(",", $ficheSelectionnee);
                $ficheSelectionneeId = $ficheSelectionneeArray[0];
                $ficheSelectionneeMois = $ficheSelectionneeArray[1];
            break;   
            default:
                $ficheSelectionneeId = filter_input(INPUT_GET, 'visiteur', FILTER_SANITIZE_STRING);
                $ficheSelectionneeMois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
            break;   
        }
        $ficheASelectionnerId = $ficheSelectionneeId;
        $ficheASelectionnerMois = $ficheSelectionneeMois;
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($ficheSelectionneeId, $ficheSelectionneeMois);
        $lesFraisForfait = $pdo->getLesFraisForfait($ficheSelectionneeId, $ficheSelectionneeMois);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($ficheSelectionneeId, $ficheSelectionneeMois);
        $libEtat = $lesInfosFicheFrais['libEtat'];
        $montantValide = $lesInfosFicheFrais['montantValide'];
        $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
        $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);

        switch ($action) {
            case 'afficherSuiviFiche':
            break;   
            case 'mettreEnPaiement':
                $pdo->majEtatFicheFrais($ficheSelectionneeId, $ficheSelectionneeMois, "MP");   
                $pdo->majDateModifFicheFrais($ficheSelectionneeId, $ficheSelectionneeMois);

                break;   
        }

        include 'vues/v_selectionnerFicheSuivi.php';
        include 'vues/v_suiviFiche.php';

        break;   



    }
}