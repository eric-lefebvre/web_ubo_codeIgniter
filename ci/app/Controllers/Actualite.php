<?php 
//Eric Lefebvre L3 IFA 2023/2024
namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Actualite extends BaseController
{
    public function afficher($numero = 0)
    {
        $model = model(Db_model::class);

        if ($numero == 0)
        {
            return redirect()->to('/');
        }
        else
        {
            $data['titre'] = 'Actualité :';
            $data['news'] = $model->get_actualite($numero);
        }

        return view('templates/haut', $data)
        . view('affichage_actualite')
        . view('templates/bas');
    }
}

?>