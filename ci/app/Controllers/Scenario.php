<?php 
//Eric Lefebvre L3 IFA 2023/2024
namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Scenario extends BaseController
{
    public function __construct()
    {
        $this->model = model(Db_model::class);
        helper('form');
    }

    public function afficher()
    {
        $data['scenarii'] = $this->model->get_all_scenario();

        return view('templates/haut', $data)
        . view('templates/menu_visiteur')
        . view('affichage_scenarii')
        . view('templates/bas');
    }

    public function afficher_liste()
    {
        $session=session();

        if (!$session->has('user'))
        {
            return redirect()->to('/compte/connecter');
        }

        if ($session->get('role') != 'O') {

            return redirect()->to('/compte/afficher_accueil');
        }

        $data['scenarios'] = $this->model->get_all_scenario_etape($session->get('user'));
        $data['nb_scenario'] = $this->model->get_nb_scenario();

        return view('templates/haut_backend', $data)
        . view('templates/menu_organisateur')
        . view('scenario/scenario_lister')
        . view('templates/bas_backend');
    }

    public function activer($sce_code = null)
    {
        $session=session();

        if (!$session->has('user'))
        {
            return redirect()->to('/compte/connecter');
        }

        if ($session->get('role') != 'O') {

            return redirect()->to('/compte/afficher_accueil');
        }

        if ($sce_code != null && $this->model->activate_scenario($sce_code) == true) {
            $data['activation'] = 'succes';
        } else {
            $data['activation'] = 'failure';
        }

        $data['scenarios'] = $this->model->get_all_scenario_etape($session->get('user'));
        $data['nb_scenario'] = $this->model->get_nb_scenario();

        return view('templates/haut_backend', $data)
        . view('templates/menu_organisateur')
        . view('scenario/scenario_lister')
        . view('templates/bas_backend');
    }

    public function desactiver($sce_code = null)
    {
        $session=session();

        if (!$session->has('user'))
        {
            return redirect()->to('/compte/connecter');
        }

        if ($session->get('role') != 'O') {

            return redirect()->to('/compte/afficher_accueil');
        }

        if ($sce_code != null && $this->model->deactivate_scenario($sce_code) == true) {
            $data['activation'] = 'succes';
        } else {
            $data['activation'] = 'failure';
        }

        $data['scenarios'] = $this->model->get_all_scenario_etape($session->get('user'));
        $data['nb_scenario'] = $this->model->get_nb_scenario();

        return view('templates/haut_backend', $data)
        . view('templates/menu_organisateur')
        . view('scenario/scenario_lister')
        . view('templates/bas_backend');
    }

    public function creer_copie($sce_code = null)
    {
        $session=session();

        if (!$session->has('user'))
        {
            return redirect()->to('/compte/connecter');
        }

        if ($session->get('role') != 'O') {

            return redirect()->to('/compte/afficher_accueil');
        }

        if ($sce_code != null && $this->model->creer_copie_scenario($sce_code, $session->get('id')) == true) {
            $data['creation'] = 'succes';
        } else {
            $data['creation'] = 'failure';
        }

        $data['scenarios'] = $this->model->get_all_scenario_etape($session->get('user'));
        $data['nb_scenario'] = $this->model->get_nb_scenario();

        return view('templates/haut_backend', $data)
        . view('templates/menu_organisateur')
        . view('scenario/scenario_lister')
        . view('templates/bas_backend');
    }

    public function afficher_details($sce_code = null)
    {
        $session=session();

        if (!$session->has('user'))
        {
            return redirect()->to('/compte/connecter');
        }

        if ($session->get('role') != 'O') {

            return redirect()->to('/compte/afficher_accueil');
        }
        
        if ($sce_code == null) {
            return redirect()->to('/scenario/afficher_liste');
        }

        $data['scenario'] = $this->model->get_scenario($sce_code);
        $data['etapes']  = $this->model->get_resume_scenario($sce_code);

        return view('templates/haut_backend', $data)
        . view('templates/menu_organisateur')
        . view('scenario/scenario_details')
        . view('templates/bas_backend');
    }

    public function modifier($sce_code = null)
    {
        $session=session();

        if (!$session->has('user'))
        {
            return redirect()->to('/compte/connecter');
        }

        if ($session->get('role') != 'O') {

            return redirect()->to('/compte/afficher_accueil');
        }
            
        if ($sce_code == null) {

            return redirect()->to('/scenario/scenario_lister');
        }

        // L’utilisateur a validé le formulaire en cliquant sur le bouton
        if ($this->request->getMethod()=="post") {

            if (! $this->validate([
                'intitule' => 'required|max_length[255]',
                'pseudo' => 'required',
                ],
                [ // Configuration des messages d’erreurs
                    'intitule' => [
                        'required' => 'Champ de saisie intitule doit être rempli !',
                    ],
                    'pseudo' => [
                        'required' => 'Champ de saisie pseudo doit être rempli !',
                    ],
                ]))
                {

                    // La validation du formulaire a échoué, retour au formulaire !
                    $data['scenario'] = $this->model->get_scenario($sce_code);
                    $data['etapes']  = $this->model->get_resume_scenario($sce_code);

                    return view('templates/haut_backend', $data)
                    . view('templates/menu_organisateur')
                    . view('scenario/scenario_modifier')
                    . view('templates/bas_backend');
                }

            // TEMPORAIREMENT RELISTER LES SCENARIO
            return redirect()->to('/scenario/afficher_liste');

        }

        // L’utilisateur veut afficher le formulaire pour modifier son scénario
        $data['scenario'] = $this->model->get_scenario($sce_code);
        $data['etapes']  = $this->model->get_resume_scenario($sce_code);

        return view('templates/haut_backend', $data)
        . view('templates/menu_organisateur')
        . view('scenario/scenario_modifier')
        . view('templates/bas_backend');
    }

    public function supprimer($sce_code = null)
    {
        $session=session();

        if (!$session->has('user'))
        {
            return redirect()->to('/compte/connecter');
        }

        if ($session->get('role') != 'O') {

            return redirect()->to('/compte/afficher_accueil');
        }

        if ($sce_code == null) {
            return redirect()->to('/scenario/afficher_liste');
        }

        $etapes = $this->model->get_all_etapes($sce_code);

        if (!empty($etapes)) {

            foreach ($etapes as $etape) {
                $this->model->delete_indice($etape['ETA_id']);
                $this->model->delete_etape($etape['ETA_id']);
                $this->model->delete_ressource($etape['RSC_id']);
            }
        }

        $this->model->delete_participations($sce_code);

        if ($this->model->delete_scenario($sce_code) == true) {

            return redirect()->to('/scenario/afficher_liste');

        }
        
    }

    public function creer()
    {
        $session=session();

        if (!$session->has('user'))
        {
            return redirect()->to('/compte/connecter');
        }

        if ($session->get('role') != 'O') {

            return redirect()->to('/compte/afficher_accueil');
        }

        // L’utilisateur a validé le formulaire en cliquant sur le bouton
        if ($this->request->getMethod()=="post") {

            if (! $this->validate([
                'intitule' => 'required|min_length[2]',
                'etat' => 'required',
                'image' => [
                    'label' => 'Fichier image',
                    'rules' => [
                        'uploaded[image]',
                        'is_image[image]',
                        'mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                        'max_size[image,1000]',]]
                    ], 
                    [ // Configuration des messages d’erreurs
                        'intitule' => [
                            'required' => 'Champ de saisie intitule doit être rempli !',
                        ],
                        'pseudo' => [
                            'min_length' => 'L\'intitulé saisi est trop court !',
                        ],
                        'etat' => [
                            'required' => 'Champ de saisie etat doit être rempli !',
                        ],
                        'image' => [
                            'max_size' => 'La taille de l\'image doit être inférieure à 1Mo !',
                        ],
                        'image' => [
                            'uploaded' => 'Sélectionnez une image valide !',
                        ],
                        'image' => [
                            'is_image' => 'Sélectionnez une image validee !',
                        ],
                        'image' => [
                            'mime_in' => 'L\'extension de l\'image n\'est pas autorisée !',
                        ],
                    ]))
                {
    
                    // La validation du formulaire a échoué, retour au formulaire !
                    return view('templates/haut_backend')
                    . view('templates/menu_organisateur')
                    . view('scenario/scenario_creer')
                    . view('templates/bas_backend');
                }

            // La validation du formulaire a réussi, traitement du formulaire
            $fichier = $this->request->getFile('image');

            if (!empty($fichier)) {

                // Récupération du nom du fichier téléversé
                $nom_fichier = date('Ymd_His') . '_' . $fichier->getName();

                // Dépôt du fichier dans le répertoire ci/public/images
                if($fichier->move("resources/Scenario", $nom_fichier)) {

                    $saisie['intitule'] = addslashes($this->request->getVar('intitule'));
                    $saisie['etat'] = $this->request->getVar('etat');
                    $saisie['image'] = $nom_fichier;
                    $saisie['auteur'] = $session->get('id');

                    if ($this->model->insert_scenario($saisie) == true) { 

                        return redirect()->to('/scenario/afficher_liste');

                    } else {

                        $data['status'] = 'failure';

                        return view('templates/haut_backend', $data)
                        . view('templates/menu_organisateur')
                        . view('scenario/scenario_creer')
                        . view('templates/bas_backend');
                    }

                } else {

                    $data['status'] = 'failure';
    
                    // La validation du formulaire a échoué, retour au formulaire !
                    return view('templates/haut_backend', $data)
                    . view('templates/menu_organisateur')
                    . view('scenario/scenario_creer')
                    . view('templates/bas_backend');
                }

            } else {

                $data['status'] = 'failure';

                // La validation du formulaire a échoué, retour au formulaire !
                return view('templates/haut_backend', $data)
                . view('templates/menu_organisateur')
                . view('scenario/scenario_creer')
                . view('templates/bas_backend');
            }

        }

        // L’utilisateur veut afficher le formulaire pour créer son scénario
        return view('templates/haut_backend')
        . view('templates/menu_organisateur')
        . view('scenario/scenario_creer')
        . view('templates/bas_backend');
    }

    public function afficher_premiere($code_scenario, $difficulte = 0)
    {
        if ($difficulte < 1 || $difficulte > 3)
        {
            return redirect()->to('/');
        }

        // L’utilisateur a validé le formulaire en cliquant sur le bouton
        if ($this->request->getMethod()=="post") {

            if (! $this->validate([
                'reponse' => 'required',
                ], 
                [ // Configuration des messages d’erreurs
                    'reponse' => [
                        'required' => 'Veuillez entrer votre réponse !',
                    ],
                ]))
                {
    
                    // La validation du formulaire a échoué, retour au formulaire !
                    $data['etape'] = $this->model->get_premiere_etape($code_scenario, $difficulte);
                    $data['difficulte'] = $difficulte;
                    $data['code_scenario'] = $code_scenario;

                    return view('templates/haut', $data)
                    . view('templates/menu_visiteur')
                    . view('affichage_premiere_etape')
                    . view('templates/bas');
                }

            // La validation du formulaire a réussi, traitement du formulaire
            $etape = $this->model->get_premiere_etape($code_scenario, $difficulte);
            $reponse_user = $this->request->getVar('reponse');
            $reponse_db = $this->model->get_reponse($etape->ETA_code);
            
            if ($reponse_user == $reponse_db) {

                $code_suivante = $this->model->get_code_suiv($etape->ETA_code);

                return redirect()->to('/scenario/franchir/' .$code_suivante->ETA_code. '/' .$difficulte);
            } else {

                return redirect()->to('/scenario/afficher_premiere/' .$code_scenario. '/' .$difficulte);

            }

        }

        // L’utilisateur veut afficher le formulaire
        $data['etape'] = $this->model->get_premiere_etape($code_scenario, $difficulte);
        $data['difficulte'] = $difficulte;
        $data['code_scenario'] = $code_scenario;

        return view('templates/haut', $data)
        . view('templates/menu_visiteur')
        . view('affichage_premiere_etape')
        . view('templates/bas');
    }

    public function franchir($code_etape, $difficulte = 0)
    {
        if ($difficulte < 1 || $difficulte > 3)
        {
            return redirect()->to('/');
        }

        // L’utilisateur a validé le formulaire en cliquant sur le bouton
        if ($this->request->getMethod()=="post") {

            if (! $this->validate([
                'reponse' => 'required',
                ], 
                [ // Configuration des messages d’erreurs
                    'reponse' => [
                        'required' => 'Veuillez entrer votre réponse !',
                    ],
                ]))
                {
    
                    // La validation du formulaire a échoué, retour au formulaire !
                    $data['etape'] = $this->model->get_etape($code_etape, $difficulte);
                    $data['difficulte'] = $difficulte;

                    return view('templates/haut', $data)
                    . view('templates/menu_visiteur')
                    . view('affichage_etape')
                    . view('templates/bas');
                }

            // La validation du formulaire a réussi, traitement du formulaire
            $etape = $this->model->get_etape($code_etape, $difficulte);
            $reponse_user = $this->request->getVar('reponse');
            $reponse_db = $this->model->get_reponse($code_etape);
            
            if ($reponse_user == $reponse_db) {

                $code_suivante = $this->model->get_code_suiv($etape->ETA_code);

                if (!empty($code_suivante)) {
                    // afficher étape suivante
                    return redirect()->to('/scenario/franchir/' .$code_suivante->ETA_code. '/' .$difficulte);

                } else {
                    // afficher fin scénario
                    return redirect()->to('/scenario/finaliser_scenario/' .$this->model->get_concat_code($code_etape). '/' .$difficulte);
                }

            } else {

                return redirect()->to('/scenario/franchir/' .$code_etape. '/' .$difficulte);
                
            }

        }

        // L’utilisateur veut afficher le formulaire
        $data['etape'] = $this->model->get_etape($code_etape, $difficulte);
        $data['difficulte'] = $difficulte;

        return view('templates/haut', $data)
        . view('templates/menu_visiteur')
        . view('affichage_etape')
        . view('templates/bas');
    }

    public function finaliser_scenario($all_etapes_code, $difficulte = 0)
    {
        if ($difficulte < 1 || $difficulte > 3)
        {
            return redirect()->to('/');
        }

        $splitArray = str_split($all_etapes_code, 8);
        $code_etape1 = $splitArray[0];

        if (strlen($code_etape1) != 8) {
            return redirect()->to('/');
        }

        $nb_etapes = $this->model->get_nb_etapes($code_etape1);

        if ($nb_etapes == 0) {
            return redirect()->to('/');
        }

        // Si chaque code passé en paramètre ne correspond pas a un code d'étape du scénario on redirect
        for ($i = 0; $i < $nb_etapes; $i++) {

            $code_etape_i = $splitArray[$i];

            if (empty($this->model->get_etape_code($code_etape_i))) {
                return redirect()->to('/');
            }
        }

        // L’utilisateur a validé le formulaire en cliquant sur le bouton
        if ($this->request->getMethod()=="post") {

            if (! $this->validate([
                'email' => 'required',
                ], 
                [ // Configuration des messages d’erreurs
                    'email' => [
                        'required' => 'Veuillez entrer votre adresse email pour confirmer votre participation !',
                    ],
                ]))
                {
    
                    // La validation du formulaire a échoué, retour au formulaire !
                    $data['all_codes'] = $all_etapes_code;
                    $data['difficulte'] = $difficulte;

                    return view('templates/haut', $data)
                    . view('templates/menu_visiteur')
                    . view('affichage_fin_scenario')
                    . view('templates/bas');
                }

            // La validation du formulaire a réussi, traitement du formulaire
            $email = $this->request->getVar('email');

            if (empty($this->model->get_participant($email))) {
                $this->model->insert_participant($email);
            }

            // NE FONCTIONNE QUE SI LE PARTICIPANT N'A PAS ENCORE DE REUSSITE AU SCENARIO
            $sce_id = $this->model->get_sce_id($code_etape1);
            $this->model->insert_reussite($email, $sce_id, $difficulte);

            // RETOUR A LA PAGE D'ACCUEIL AVEC MESSAGE DE SUCCES
            $data['cur_page'] = 'accueil';
            $data['actualites'] = $this->model->get_all_actualite();
            $data['scenario_success'] = $this->model->get_sce_intitule($sce_id);
            $data['scenario_success_date'] = $this->model->get_success_date($sce_id, $email);
            $data['scenario_success_diff'] = $difficulte;

            return view('templates/haut', $data)
            . view('templates/menu_visiteur')
            . view('affichage_accueil')
            . view('templates/bas');
        }

        // L’utilisateur veut afficher le formulaire
        $data['all_codes'] = $all_etapes_code;
        $data['difficulte'] = $difficulte;

        return view('templates/haut', $data)
        . view('templates/menu_visiteur')
        . view('affichage_fin_scenario')
        . view('templates/bas');
    }
}

?>