<?php
//Eric Lefebvre L3 IFA 2023/2024
namespace App\Models;
use CodeIgniter\Model;

use CodeIgniter\Database\ConnectionInterface;

class Db_model extends Model {
    protected $db;

    // Constructeur qui crée la connexion à la BDD
    public function __construct()
    {
        $this->db = db_connect();
    }

    // Renvoie le nombre de comptes (nb) en une seule ligne
    public function get_nb_comptes()
    {
        $resultat = $this->db->query("SELECT COUNT(*) as nb FROM T_COMPTE_CPT;");

        return $resultat->getRow();
    }

    // Renvoie la liste de tous les logins
    public function get_all_compte()
    {
        $resultat = $this->db->query("SELECT CPT_login, CPT_role, CPT_etat FROM T_COMPTE_CPT ORDER BY CPT_etat ASC;");

        return $resultat->getResultArray();
    }

    // Insère dans la BD le login et le mot de passe dans saisie
    public function insert_compte($saisie)
    {
        //Récuparation (+ traitement si nécessaire) des données du formulaire
        $login = $saisie['pseudo'];
        $mdp = $saisie['mdp'];
        $role = $saisie['role'];
        $etat = $saisie['etat'];
        $sql="INSERT INTO T_COMPTE_CPT VALUES(NULL, '".$login."','".$mdp."','".$role."','".$etat."');";
        return $this->db->query($sql);
    }

    public function connect_compte($u,$p)
    {
        $sql="SELECT CPT_login,CPT_mdp
        FROM T_COMPTE_CPT
        WHERE CPT_login='".$u."'
        AND CPT_mdp= SHA2('".$p."_SEL0945%ab5Ht6k9:/01kM', 256)
        AND CPT_etat = 'A'";

        $resultat=$this->db->query($sql);

        if($resultat->getNumRows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function modify_user_password($saisie, $login)
    {
        $old_mdp=$saisie['old_mdp'];
        $new_mdp=$saisie['new_mdp'];

        $sql="UPDATE T_COMPTE_CPT 
        SET CPT_mdp = SHA2('" .$new_mdp. "_SEL0945%ab5Ht6k9:/01kM', 256)
        WHERE CPT_login='" .$login. "'
        AND CPT_mdp= SHA2('" .$old_mdp. "_SEL0945%ab5Ht6k9:/01kM', 256);";
        
        return $this->db->query($sql);
    }

    public function get_compte_data_password($mdp)
    {
        $sql="SELECT * FROM T_COMPTE_CPT WHERE CPT_mdp= SHA2('" .$mdp. "_SEL0945%ab5Ht6k9:/01kM', 256);";

        $resultat=$this->db->query($sql);

        return $resultat->getRow();
    }

    public function get_compte_data_user($u)
    {
        $sql="SELECT CPT_id, CPT_login, CPT_role, CPT_etat FROM T_COMPTE_CPT WHERE CPT_login = '" .$u. "';";

        $resultat=$this->db->query($sql);

        return $resultat->getRow();
    }

    public function get_compte_data_id($identifiant)
    {
        $sql="SELECT CPT_id, CPT_login, CPT_role, CPT_etat FROM T_COMPTE_CPT WHERE CPT_id = '" .$identifiant. "';";

        $resultat=$this->db->query($sql);

        return $resultat->getRow();
    }

    // Renvoie l'actualité correspondant au numero passé en paramètre
    public function get_actualite($numero)
    {
        $requete = "SELECT * FROM T_ACTUALITE_ACT WHERE ACT_id =" .$numero. ";";
        $resultat = $this->db->query($requete);
        return $resultat->getRow();
    }

    // Renvoie la liste des actualités
    public function get_all_actualite()
    {
        $requete = "SELECT T_ACTUALITE_ACT.ACT_intitule, T_ACTUALITE_ACT.ACT_description, T_ACTUALITE_ACT.ACT_etat, CAST(ACT_date AS DATE) AS ACT_date, T_COMPTE_CPT.CPT_login
        FROM T_ACTUALITE_ACT
        JOIN T_COMPTE_CPT USING(CPT_id)
        WHERE ACT_etat = 'A'
        ORDER BY ACT_date DESC
        LIMIT 5;";
        $resultat = $this->db->query($requete);
        return $resultat->getResultArray();
    }

    // Active un scénario dont le code est passé en paramètre
    public function activate_scenario($sce_code)
    {
        $sql = "UPDATE T_SCENARIO_SCE SET SCE_etat = 'A' WHERE SCE_code = '" .$sce_code. "';";

        return $this->db->query($sql);
    }

    // Desactive un scénario dont le code est passé en paramètre
    public function deactivate_scenario($sce_code)
    {
        $sql = "UPDATE T_SCENARIO_SCE SET SCE_etat = 'D' WHERE SCE_code = '" .$sce_code. "';";

        return $this->db->query($sql);
    }
    
    // Copie le scénario passé en paramètre et l'insère dans la BD
    public function creer_copie_scenario($sce_code, $cpt_id)
    {
        $sql = "INSERT INTO T_SCENARIO_SCE (
            CPT_id,
            SCE_code,
            SCE_intitule,
            SCE_etat,
            SCE_cheminImage
        )
        SELECT
            " .$cpt_id. ",
            SUBSTRING(MD5(RAND()), 1, 5),
            SCE_intitule,
            SCE_etat,
            SCE_cheminImage
        FROM
            T_SCENARIO_SCE
        WHERE
            SCE_code = '" .$sce_code. "';";

        return $this->db->query($sql);
    }

    // Insère dans la BD le scénario dans le champ saisie
    public function insert_scenario($saisie)
    {
        //Récuparation (+ traitement si nécessaire) des données du formulaire
        $intitule = $saisie['intitule'];
        $etat = $saisie['etat'];
        $image = $saisie['image'];
        $auteur = $saisie['auteur'];

        $sql="INSERT INTO T_SCENARIO_SCE VALUES (NULL, '" .$auteur. "', SUBSTRING(MD5(RAND()), 1, 5), '" .$intitule. "', '" .$etat. "', '" .$image. "');";

        return $this->db->query($sql);
    }

    // Renvoie la liste des scénarios activés
    public function get_all_scenario()
    {
        $resultat = $this->db->query("SELECT T_SCENARIO_SCE.*, T_COMPTE_CPT.CPT_login
        FROM T_SCENARIO_SCE
        JOIN T_COMPTE_CPT USING(CPT_id)
        WHERE SCE_etat = 'A';");
        

        return $resultat->getResultArray();
    }

    public function get_scenario($sce_code)
    {
        $resultat = $this->db->query("SELECT *
        FROM T_SCENARIO_SCE
        WHERE SCE_code = '" .$sce_code. "';");
        

        return $resultat->getRow();
    }

    // Renvoie les informations essentielles de toutes les etapes 
    // d'un scénario et ses indices sous formes de chaînes concaténées
    public function get_resume_scenario($sce_code)
    {
        $resultat = $this->db->query("SELECT
        T_ETAPE_ETA.ETA_intitule,
        T_ETAPE_ETA.ETA_question,
        T_ETAPE_ETA.ETA_reponse,
        T_RESSOURCE_RSC.RSC_chemin,
        GROUP_CONCAT(T_INDICE_IND.IND_description) AS indices_description,
        GROUP_CONCAT(T_INDICE_IND.IND_lien) AS indices_lien
        FROM T_SCENARIO_SCE
        LEFT JOIN T_ETAPE_ETA USING(SCE_id)
        LEFT JOIN T_RESSOURCE_RSC USING(RSC_id)
        LEFT JOIN T_INDICE_IND ON T_ETAPE_ETA.ETA_id = T_INDICE_IND.ETA_id
        WHERE SCE_code = '" .$sce_code."'
        GROUP BY T_ETAPE_ETA.ETA_id;");

        return $resultat->getResultArray();
    }

    // Renvoie la liste des scénarios et le nombre d'etape de chaque scénario
    public function get_all_scenario_etape($cpt_login)
    {
        $resultat = $this->db->query("SELECT *
        FROM (
            SELECT T_SCENARIO_SCE.*, T_COMPTE_CPT.CPT_login, COUNT(ETA_id) as nb_etapes
            FROM T_SCENARIO_SCE
            JOIN T_COMPTE_CPT USING(CPT_id)
            LEFT JOIN T_ETAPE_ETA ON T_SCENARIO_SCE.SCE_id = T_ETAPE_ETA.SCE_id
            WHERE T_COMPTE_CPT.CPT_login = '" .$cpt_login. "'
            GROUP BY SCE_id
        
            UNION
        
            SELECT T_SCENARIO_SCE.*, T_COMPTE_CPT.CPT_login, COUNT(ETA_id) as nb_etapes
            FROM T_SCENARIO_SCE
            JOIN T_COMPTE_CPT USING(CPT_id)
            LEFT JOIN T_ETAPE_ETA ON T_SCENARIO_SCE.SCE_id = T_ETAPE_ETA.SCE_id
            WHERE T_COMPTE_CPT.CPT_login <> '" .$cpt_login. "' OR T_COMPTE_CPT.CPT_login IS NULL
            GROUP BY SCE_id
        ) AS combined_result
        ORDER BY 
            CASE WHEN combined_result.CPT_login = '" .$cpt_login. "' THEN 1 ELSE 2 END, combined_result.SCE_id;
        ");
        

        return $resultat->getResultArray();
    }

    // Renvoie le nombre d'étapes du scénario dont la prémière étape est passée en paramètre
    public function get_nb_etapes($code_etape)
    {
        $resultat = $this->db->query("SELECT COUNT(*) as nb 
        FROM T_ETAPE_ETA 
        WHERE SCE_id = (SELECT SCE_id FROM T_ETAPE_ETA WHERE ETA_code = '" .$code_etape. "');");
    
        return $resultat->getRow()->nb;
    }

    // Renvoie le nombre de scénarios de la BD
    public function get_nb_scenario()
    {
        $resultat = $this->db->query("SELECT COUNT(*) as nb FROM T_SCENARIO_SCE");
    
        return $resultat->getRow();
    }

    // Renvoie la liste des scénarios activés
    public function get_all_etapes($sce_code)
    {
        $resultat = $this->db->query("SELECT *
        FROM T_ETAPE_ETA
        WHERE SCE_id = (SELECT SCE_id FROM T_SCENARIO_SCE WHERE SCE_code = '" .$sce_code. "');");

        return $resultat->getResultArray();
    }

    // Supprime les participations au scnéario dont le code est passé en paramètre
    public function delete_participations($sce_code)
    {
        $sql="DELETE FROM T_REUSSITE_RST WHERE SCE_id = (SELECT SCE_id FROM T_SCENARIO_SCE WHERE SCE_code = '" .$sce_code. "');";

        return $this->db->query($sql);
    }

    // Supprime le scénario dont le code est passé en paramètre
    public function delete_scenario($sce_code)
    {
        $sql="DELETE FROM T_SCENARIO_SCE WHERE SCE_code ='" .$sce_code. "';";

        return $this->db->query($sql);
    }

    // Supprime tous les indices dont l'id étape est égal à celui passé en paramètre
    public function delete_indice($eta_id)
    {
        $sql="DELETE FROM T_INDICE_IND WHERE ETA_id = " .$eta_id. ";";

        return $this->db->query($sql);
    }

    // Supprime la ressource dont l'id est passé en paramètre
    public function delete_ressource($rsc_id)
    {
        $sql="DELETE FROM T_RESSOURCE_RSC WHERE RSC_id = " .$rsc_id. ";";

        return $this->db->query($sql);
    }

    // Supprime l'etape dont l'id est passé en paramètre
    public function delete_etape($eta_id)
    {
        $sql="DELETE FROM T_ETAPE_ETA WHERE ETA_id = " .$eta_id. ";";

        return $this->db->query($sql);
    }

    // Renvoie l'etape dont le code du scénario est passé en paramètre
    public function get_premiere_etape($code_scenario, $difficulte)
    {
        $resultat = $this->db->query("SELECT T_ETAPE_ETA.*, T_INDICE_IND.IND_difficulte, T_INDICE_IND.IND_description, T_INDICE_IND.IND_lien, T_RESSOURCE_RSC.RSC_chemin, T_RESSOURCE_RSC.RSC_type
        FROM T_SCENARIO_SCE
        LEFT JOIN T_ETAPE_ETA ON T_SCENARIO_SCE.SCE_id = T_ETAPE_ETA.SCE_id
        AND ETA_ordre = 1
        LEFT JOIN T_INDICE_IND ON T_ETAPE_ETA.ETA_id = T_INDICE_IND.ETA_id 
        AND IND_difficulte = " .$difficulte. "
        LEFT JOIN T_RESSOURCE_RSC USING(RSC_id)
        WHERE SCE_code = '" .$code_scenario. "';");

        return $resultat->getRow();
    }

    // Renvoie la réponse à la question de l'étape
    public function get_reponse($code_etape)
    {
        $resultat = $this->db->query("SELECT ETA_reponse FROM T_ETAPE_ETA WHERE ETA_code = '" .$code_etape. "';");

        return $resultat->getRow()->ETA_reponse;
    }

    // Renvoie la liste des codes de toutes les étapes du scénario concaténés
    public function get_concat_code($code_etape)
    {
        $resultat = $this->db->query("SELECT GROUP_CONCAT(ETA_code SEPARATOR '') as chaine
        FROM T_ETAPE_ETA
        WHERE SCE_id = (SELECT SCE_id FROM T_ETAPE_ETA WHERE ETA_code = '6uu5qX6j');");

        return $resultat->getRow()->chaine;
    }

    // Renvoie l'etape dont le code et la difficulté sont passés en paramètres
    public function get_etape($code_etape, $difficulte)
    {
        $resultat = $this->db->query("SELECT T_ETAPE_ETA.*, T_INDICE_IND.IND_difficulte, T_INDICE_IND.IND_description, T_INDICE_IND.IND_lien, T_RESSOURCE_RSC.RSC_chemin, T_RESSOURCE_RSC.RSC_type
        FROM T_ETAPE_ETA
        LEFT JOIN T_INDICE_IND ON T_ETAPE_ETA.ETA_id = T_INDICE_IND.ETA_id
        AND IND_difficulte = " .$difficulte. "
        LEFT JOIN T_RESSOURCE_RSC USING(RSC_id)
        WHERE ETA_code = '" .$code_etape. "';");

        return $resultat->getRow();
    }

    // Renvoie l'etape dont le code est passé en paramètre
    public function get_etape_code($code_etape)
    {
        $resultat = $this->db->query("SELECT T_ETAPE_ETA.ETA_code
        FROM T_ETAPE_ETA
        WHERE ETA_code = '" .$code_etape. "';");

        return $resultat->getRow();
    }

    // Renvoie le code de l'étape suivant celle dont le code est passé en paramètre
    public function get_code_suiv($code_etape)
    {
        $resultat = $this->db->query("SELECT ETA_code 
        FROM T_ETAPE_ETA 
        WHERE ETA_ordre = (SELECT ETA_ordre FROM T_ETAPE_ETA WHERE ETA_code = '" .$code_etape. "') + 1 
        AND SCE_id = (SELECT SCE_id FROM T_ETAPE_ETA WHERE ETA_code = '" .$code_etape. "');");

        return $resultat->getRow();
    }

    // Renvoie le participant
    public function get_participant($email)
    {
        $resultat = $this->db->query("SELECT PAR_adresse 
        FROM T_PARTICIPANT_PAR 
        WHERE PAR_adresse = '" .$email. "';");

        return $resultat->getRow();
    }

    // Ajoute un participant dans la BD
    public function insert_participant($email)
    {
        $sql="INSERT INTO T_PARTICIPANT_PAR VALUES (NULL, '" .$email. "');";

        return $this->db->query($sql);
    }

    // Renvoie l'id du scénario dont le code étape est passée en paramètre
    public function get_sce_id($code_etape)
    {
        $resultat = $this->db->query("SELECT SCE_id FROM T_ETAPE_ETA WHERE ETA_code = '" .$code_etape. "';");

        return $resultat->getRow()->SCE_id;
    }

    // Renvoie l'intitulé du scénario dont l'id est passé en paramètre
    public function get_sce_intitule($sce_id)
    {
        $resultat = $this->db->query("SELECT SCE_intitule FROM T_SCENARIO_SCE WHERE SCE_id = " .$sce_id. ";");

        return $resultat->getRow()->SCE_intitule;
    }

    // Renvoie la date de dernière réussite du participant au scénario
    public function get_success_date($sce_id, $email)
    {
        $resultat = $this->db->query("SELECT CAST(RST_dateDerniere AS DATE) AS RST_dateDerniere
        FROM T_REUSSITE_RST 
        WHERE SCE_id = " .$sce_id. " 
        AND PAR_id = (SELECT PAR_id FROM T_PARTICIPANT_PAR WHERE PAR_adresse = '" .$email. "');");

        return $resultat->getRow()->RST_dateDerniere;
    }

    // Ajoute une reussite dans la BD
    public function insert_reussite($email, $sce_id, $difficulte)
    {
        $sql="INSERT INTO T_REUSSITE_RST VALUES ($sce_id, (SELECT PAR_id FROM T_PARTICIPANT_PAR WHERE PAR_adresse = '" .$email. "'), NOW(), NOW(), $difficulte);";

        return $this->db->query($sql);
    }
}

?>