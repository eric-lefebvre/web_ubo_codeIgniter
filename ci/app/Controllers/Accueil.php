<?php 
//Eric Lefebvre L3 IFA 2023/2024
namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Accueil extends BaseController
{
    public function afficher()
    {
        $model = model(Db_model::class);

        $data['cur_page'] = 'accueil';
        $data['actualites'] = $model->get_all_actualite();

        return view('templates/haut', $data)
        . view('templates/menu_visiteur')
        . view('affichage_accueil')
        . view('templates/bas');
    }
}

?>