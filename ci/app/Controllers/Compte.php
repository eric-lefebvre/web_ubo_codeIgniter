<?php 
//Eric Lefebvre L3 IFA 2023/2024
namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Compte extends BaseController
{
    public function __construct()
    {
        $this->model = model(Db_model::class);
        helper('form');
    }

    public function lister()
    {
        $session=session();

        if (!$session->has('id'))
        {
            return redirect()->to('/compte/connecter');
        }
        
        if ($session->get('role') != 'A')
        { 
            return redirect()->to('/compte/afficher_accueil');
        }
        
        $data['nb_comptes'] = $this->model->get_nb_comptes();
        $data['comptes'] = $this->model->get_all_compte();

        return view('templates/haut_backend', $data)
        . view('templates/menu_administrateur')
        . view('compte/compte_lister')
        . view('templates/bas_backend');
    }

    public function afficher_accueil()
    {
        $session=session();

        if (!$session->has('id'))
        {
            return redirect()->to('/compte/connecter');
        }

        $data['user'] = $this->model->get_compte_data_id($session->get('id'));

        if ($session->get('role') == 'A') {
            return view('templates/haut_backend')
            . view('templates/menu_administrateur')
            . view('connexion/compte_accueil', $data)
            . view('templates/bas_backend');
        } else {
            return view('templates/haut_backend')
            . view('templates/menu_organisateur')
            . view('connexion/compte_accueil', $data)
            . view('templates/bas_backend');
        }
    }

    public function connecter()
    {
        // L’utilisateur a validé le formulaire en cliquant sur le bouton
        if ($this->request->getMethod()=="post") {
            if (! $this->validate([
                'pseudo' => 'required|max_length[255]|min_length[2]',
                'mdp' => 'required|max_length[255]|min_length[8]',
                ],
                [ // Configuration des messages d’erreurs
                    'pseudo' => [
                        'min_length' => 'Le pseudo saisi est trop court !',
                    ],
                    'pseudo' => [
                        'required' => 'Veuillez entrer un pseudo pour le compte !',
                    ],
                    'mdp' => [
                        'min_length' => 'Le mot de passe saisi est trop court !',
                    ],
                    'mdp' => [
                        'required' => 'Veuillez entrer un mot de passe !',
                    ],
                ]))
                {
                // La validation du formulaire a échoué, retour au formulaire !
                return view('templates/haut')
                . view('templates/menu_visiteur')
                . view('connexion/compte_connecter')
                . view('templates/bas');
            }
            

            // La validation du formulaire a réussi, traitement du formulaire
            $username=addslashes($this->request->getVar('pseudo'));
            $password=addslashes($this->request->getVar('mdp'));

            if ($this->model->connect_compte($username, $password)==true) {
                $session=session();
                $session->set('user',$username);
                $compte_data = $this->model->get_compte_data_user($username);
                $session->set('id', $compte_data->CPT_id);
                $session->set('role', $compte_data->CPT_role);
                $session->set('etat', $compte_data->CPT_etat);

                $data['user'] = $this->model->get_compte_data_id($session->get('id'));

                if ($session->get('role') == 'A') {
                    return view('templates/haut_backend')
                    . view('templates/menu_administrateur')
                    . view('connexion/compte_accueil', $data)
                    . view('templates/bas_backend');
                } else {
                    return view('templates/haut_backend')
                    . view('templates/menu_organisateur')
                    . view('connexion/compte_accueil', $data)
                    . view('templates/bas_backend');
                }
            } else { 
                $data['status'] = "failure";

                return view('templates/haut')
                . view('templates/menu_visiteur')
                . view('connexion/compte_connecter', $data)
                . view('templates/bas');
            }
        }

        // L’utilisateur veut afficher le formulaire pour se conncecter
        return view('templates/haut')
        . view('templates/menu_visiteur')
        . view('connexion/compte_connecter')
        . view('templates/bas');
    }

    public function afficher_profil()
    {
        $session=session();

        if (!$session->has('id'))
        {
            return redirect()->to('/compte/connecter');
        }

        $data['user'] = $this->model->get_compte_data_id($session->get('id'));

        if ($session->get('role') == 'A') {

            return view('templates/haut_backend')
            . view('templates/menu_administrateur')
            . view('connexion/compte_profil', $data)
            . view('templates/bas_backend');
        } else {
            return view('templates/haut_backend')
            . view('templates/menu_organisateur')
            . view('connexion/compte_profil', $data)
            . view('templates/bas_backend');
        }
    }

    public function modifier_profil()
    {
        $session=session();

        if (!$session->has('id'))
        {
            return redirect()->to('/compte/connecter');
        }

        $data['user'] = $this->model->get_compte_data_id($session->get('id'));

        // L’utilisateur a validé le formulaire en cliquant sur le bouton
        if ($this->request->getMethod()=="post") {

            if (! $this->validate([
                'old_mdp' => 'required|min_length[8]',
                'new_mdp' => 'required|max_length[255]|min_length[8]',
                'conf_mdp' => 'required|matches[new_mdp]',
                'role' => 'required',
                'etat' => 'required'
                ],
                [ // Configuration des messages d’erreurs
                    'old_mdp' => [
                        'min_length' => 'Le mot de passe saisi est trop court !',
                    ],
                    'old_mdp' => [
                        'required' => 'Champ de saisie ancien mot de passe doit être rempli !',
                    ],
                    'new_mdp' => [
                        'min_length' => 'Le nouveau mot de passe saisi est trop court !',
                    ],
                    'new_mdp' => [
                        'required' => 'Champ de saisie nouveau mot de passe doit être rempli !',
                    ],
                    'conf_mdp' => [
                        'matches' => 'Confirmation du mot de passe erronée, veuillez réessayer !',
                    ],
                    'conf_mdp' => [
                        'required' => 'Champ de saisie confirmation du mot de passe doit être rempli !',
                    ],
                    'role' => [
                        'required' => 'Champ de saisie role doit être rempli !',
                    ],
                    'etat' => [
                        'required' => 'Champ de saisie etat doit être rempli !',
                    ],
                ]))
                {
                // La validation du formulaire a échoué, retour au formulaire !
                if ($session->get('role') == 'A') {
                    return view('templates/haut_backend')
                    . view('templates/menu_administrateur')
                    . view('compte/compte_modifier', $data)
                    . view('templates/bas_backend');
                } else {
                    return view('templates/haut_backend')
                    . view('templates/menu_organisateur')
                    . view('compte/compte_modifier', $data)
                    . view('templates/bas_backend');
                }
            }
            

            $recuperation = $this->validator->getValidated();
            $recuperation['old_mdp'] = addslashes($recuperation['old_mdp']);
            $recuperation['new_mdp'] = addslashes($recuperation['new_mdp']);

            if (!empty($this->model->get_compte_data_password($recuperation['old_mdp']))) {

                $this->model->modify_user_password($recuperation, $session->get('user'));

                return redirect()->to('/compte/afficher_profil');

            } else { 
                $data['status'] = "exists";

                if ($session->get('role') == 'A') {
                    return view('templates/haut_backend')
                    . view('templates/menu_administrateur')
                    . view('compte/compte_modifier', $data)
                    . view('templates/bas_backend');
                } else {
                    return view('templates/haut_backend')
                    . view('templates/menu_organisateur')
                    . view('compte/compte_modifier', $data)
                    . view('templates/bas_backend');
                }
            }
        }

        // L’utilisateur veut afficher le formulaire pour modifier son profil
        if ($session->get('role') == 'A') {
            return view('templates/haut_backend')
            . view('templates/menu_administrateur')
            . view('compte/compte_modifier', $data)
            . view('templates/bas_backend');
        } else {
            return view('templates/haut_backend')
            . view('templates/menu_organisateur')
            . view('compte/compte_modifier', $data)
            . view('templates/bas_backend');
        }
    }

    public function deconnecter()
    {
        $session=session();
        $session->destroy();

        return view('templates/haut')
        . view('templates/menu_visiteur')
        . view('connexion/compte_connecter')
        . view('templates/bas');
    }


    public function creer()
    {
        $session=session();

        if (!$session->has('id'))
        {
            return redirect()->to('/compte/connecter');
        }

        if ($session->get('role') != 'A')
        { 
            return redirect()->to('/compte/afficher_accueil');
        }

        // L’utilisateur a validé le formulaire en cliquant sur le bouton
        
        if ($this->request->getMethod()=="post")
        {
            if (! $this->validate([
            'pseudo' => 'required|max_length[255]|min_length[2]',
            'mdp' => 'required|max_length[255]|min_length[8]',
            'conf_mdp' => 'required|matches[mdp]',
            'role' => 'required',
            'etat' => 'required'
            ],
            [ // Configuration des messages d’erreurs
                'pseudo' => [
                    'min_length' => 'Le pseudo saisi est trop court !',
                ],
                'pseudo' => [
                    'required' => 'Veuillez entrer un pseudo pour le compte !',
                ],
                'mdp' => [
                    'min_length' => 'Le mot de passe saisi est trop court !',
                ],
                'mdp' => [
                    'required' => 'Veuillez entrer un mot de passe !',
                ],
                'conf_mdp' => [
                    'matches' => 'Les mots de passe ne correspondent pas !',
                ],
                'conf_mdp' => [
                    'required' => 'Veuillez confirmer votre mot de passe !',
                ],
                'role' => [
                    'required' => 'Champ de saisie role doit être rempli !',
                ],
                'etat' => [
                    'required' => 'Champ de saisie etat doit être rempli !',
                ],
            ]))
            {
                // La validation du formulaire a échoué, retour au formulaire !
                return view('templates/haut_backend')
                . view('templates/menu_administrateur')
                . view('compte/compte_creer')
                . view('templates/bas_backend');
            }

            // La validation du formulaire a réussi, traitement du formulaire
            $recuperation = $this->validator->getValidated();
            $recuperation['pseudo'] = addslashes($recuperation['pseudo']);
            $recuperation['mdp'] = addslashes($recuperation['mdp']);
            
            // L'insertion a fonctionné
            if (empty($this->model->get_compte_data_user($recuperation['pseudo']))) {

                if ($this->model->insert_compte($recuperation) == true) {

                    $data['nb_comptes'] = $this->model->get_nb_comptes();
                    $data['comptes'] = $this->model->get_all_compte();
                    $data['status'] = "compte_ajoute";

                    return view('templates/haut_backend')
                    . view('templates/menu_administrateur')
                    . view('compte/compte_lister', $data)
                    . view('templates/bas_backend');
                } else {

                    $data['status'] = "failure";

                    return view('templates/haut_backend')
                    . view('templates/menu_administrateur')
                    . view('compte/compte_creer', $data)
                    . view('templates/bas_backend');
                }

            } else {

                $data['status'] = "compte_existant";

                return view('templates/haut_backend')
                . view('templates/menu_administrateur')
                . view('compte/compte_creer', $data)
                . view('templates/bas_backend');
            }
            

        }
        
        // L’utilisateur veut afficher le formulaire pour créer un compte
        return view('templates/haut_backend')
        . view('templates/menu_administrateur')
        . view('compte/compte_creer')
        . view('templates/bas_backend');
    }
}

?>