<?php
/**
* Developed by: Alessandro Pericolo
* Date: 29/11/2018
* Time: 17:02
* Version: 0.1
**/

require_once 'UtenteModel.php';

class Utente extends UtenteModel {

/*CONSTRUCTOR*/
function __construct(PDO $pdo){
	parent::__construct($pdo);
}

    function findIdUtenteByIdLogin($idLogin){

        $query = "SELECT id FROM utente WHERE id_login = ?";
        return $this->createResultValue($query, array($idLogin));
    }

    static function findIdUtenteByIdLoginStatic($pdo, $idLogin){

        $app = new self($pdo);
        return $app->findIdUtenteByIdLogin($idLogin);
    }

    function findElencoAmici($idUtente, $typeResult=self::FETCH_OBJ){

        $query = "SELECT id, CONCAT (nome, ' ', cognome) AS nominativo ,foto 
                  FROM utente 
                  WHERE id IN (
                    SELECT id_richiesto 
                    FROM relazione 
                    WHERE id_richiedente = ? AND amicizia = 1
                  );";

        return $this->createResultArray($query, array($idUtente), $typeResult);
    }

    function findRichiesteAmiciziaInAttesa($idUtente, $typeResult=self::FETCH_OBJ){

        $query = "SELECT id, CONCAT (nome, ' ', cognome) AS nominativo ,foto 
                  FROM utente 
                  WHERE id IN (
                        SELECT id_richiedente 
                        FROM relazione 
                        WHERE id_richiesto = ? AND amicizia = 0
                  );";

        return $this->createResultArray($query, array($idUtente), $typeResult);
    }

    function cercaNuoviAmici($idLogin, $idUtente, $typeResult=self::FETCH_OBJ){

        $query = "SELECT id, CONCAT (nome, ' ', cognome) AS nominativo ,foto 
                  FROM utente 
                  WHERE id_login != ? 
                  AND id NOT IN (
	                SELECT id_richiesto 
	                FROM relazione 
	                WHERE id_richiedente = ? 
	                GROUP BY id_richiesto
                  )
                  AND id NOT IN (
                    SELECT id_richiedente
                    FROM relazione
                    WHERE id_richiesto = ? AND amicizia = 0
                    GROUP BY id_richiedente
                  )";

        return $this->createResultArray($query, array($idLogin, $idUtente, $idUtente), $typeResult);
    }

    function cercaNuoviAmiciFiltro($idLogin, $idUtente, $nome, $cognome, $etaDa, $etaA, $typeResult=self::FETCH_OBJ){

        $query = "SELECT id, CONCAT (nome, ' ', cognome) AS nominativo ,foto, TIMESTAMPDIFF(YEAR, data_nascita, CURDATE()) AS eta 
                  FROM utente 
                  WHERE id_login != ? 
                  AND id NOT IN (
	                SELECT id_richiesto 
	                FROM relazione 
	                WHERE id_richiedente = ? 
	                GROUP BY id_richiesto
                  )
                  AND id NOT IN (
                    SELECT id_richiedente
                    FROM relazione
                    WHERE id_richiesto = ? AND amicizia = 0
                    GROUP BY id_richiedente
                  )
                  AND nome LIKE ?
                  AND cognome LIKE ?
                  HAVING eta BETWEEN ? AND ?
                  ";

        return $this->createResultArray($query, array($idLogin, $idUtente, $idUtente, '%'.$nome.'%', '%'.$cognome.'%', $etaDa, $etaA), $typeResult);
    }

    function findRichiesteInAttesaByIdRichiedente($idRichiedente, $typeResult=self::FETCH_OBJ){

        $query = "SELECT  id, CONCAT (nome, ' ', cognome) AS nominativo ,foto 
                  FROM utente 
                  WHERE id IN (
                        SELECT id_richiesto 
                        FROM relazione 
                        WHERE id_richiedente = ? AND amicizia = 0
                  );";

        return $this->createResultArray($query, array($idRichiedente), $typeResult);
    }

} //close Class Utente