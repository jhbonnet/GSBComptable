<?php
/**
 * Gestion de l'affichage des frais
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

switch ($action) {
case 'selectionnerVisiteur':
    $lesVisiteurs = $pdo->getLesVisiteurs();
    $visiteurASelectionner = $lesVisiteurs[array_key_last($lesVisiteurs) ]['idvisiteur'];
    //$visiteurASelectionner = $lesVisiteurs[0]['idvisiteur'];

    include 'vues/v_listeVisiteursMois.php';
    break;
case 'selectionnerMois':
    $leVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
    $lesVisiteurs = $pdo->getLesVisiteurs();
    $visiteurASelectionner = $leVisiteur;
    include 'vues/v_listeVisiteursMois.php';


    $lesMois = $pdo->getLesMoisDisponibles($leVisiteur);
    // Afin de sélectionner par défaut le dernier mois dans la zone de liste
    // on demande toutes les clés, et on prend la première,
    // les mois étant triés décroissants
    
    $moisASelectionner = $lesMois[0]['mois'];
    include 'vues/v_listeMoisValider.php';
    break;

default:
    $leVisiteur = filter_input(INPUT_GET, 'visiteur', FILTER_SANITIZE_STRING);
    switch ($action) {
        case 'voirEtatFrais':
            $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
            break;
    default:
        $leMois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
        break;
    }
    
    // dans le bloc qui suit on s'occupe de toutes les modifications de bases de donnees pour chacune des actions
    switch ($action) {
        case 'validerMajFraisForfait': 
            $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
            if (lesQteFraisValides($lesFrais)) {
                $pdo->majFraisForfait($leVisiteur, $leMois, $lesFrais);
            } else {
                ajouterErreur('Les valeurs des frais doivent être numériques');
                include 'vues/v_erreurs.php';
            }
        break;
        case 'validerCreationFrais':
            $dateFrais = filter_input(INPUT_POST, 'dateHF', FILTER_SANITIZE_STRING);
            $libelle = filter_input(INPUT_POST, 'libelleHF', FILTER_SANITIZE_STRING);
            $montant = filter_input(INPUT_POST, 'montantHF', FILTER_VALIDATE_FLOAT);
            $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_STRING);

            
            valideInfosFrais($dateFrais, $libelle, $montant);
            if (nbErreurs() != 0) {
                include 'vues/v_erreurs.php';
            } else {
                $pdo->majFraisHorsForfait(
                    $idFrais,                    
                    $libelle,
                    $dateFrais,
                    $montant
                );
            }
            break;
        case 'validerNombresJustificatifs':
            $nbJustificatifs = filter_input(INPUT_POST, 'nbJustificatifs', FILTER_VALIDATE_INT);
            $pdo->majNbJustificatifs($leVisiteur, $leMois, $nbJustificatifs);
            $pdo->majDateModifFicheFrais($leVisiteur, $leMois);
            $pdo->majMontantValideFicheFrais($leVisiteur, $leMois);
            break;            
        case 'supprimerFraisHorsForfait':
            $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_STRING);
            $leMoisSuivant = getLeMoisSuivant($leMois);
            
            if ($pdo->estPremierFraisMois($leVisiteur, $leMoisSuivant)) 
            {
            
            $pdo->creeNouvellesLignesFrais($leVisiteur, $leMoisSuivant);
            
            }
            $pdo->refuserFraisHorsForfait($idFrais, $leMoisSuivant);
                    
            
            break;
    }
    
    
    
    $lesVisiteurs = $pdo->getLesVisiteurs();
    $visiteurASelectionner = $leVisiteur;
    
    $lesMois = $pdo->getLesMoisDisponibles($leVisiteur);
    $moisASelectionner = $leMois;
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($leVisiteur, $leMois);
    $lesFraisForfait = $pdo->getLesFraisForfait($leVisiteur, $leMois);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leVisiteur, $leMois);
    $numAnnee = substr($leMois, 0, 4);
    $numMois = substr($leMois, 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/v_listeVisiteursMois.php';
    include 'vues/v_listeMoisValider.php';    
    include 'vues/v_etatFraisValider.php';
    include 'vues/v_listeFraisHorsForfaitValider.php';
}
