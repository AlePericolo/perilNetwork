<?php
/**
* Developed by: Alessandro Pericolo
* Date: 29/11/2018
* Time: 17:02
* Version: 0.1
**/

require_once 'ValutazioneModel.php';

class Valutazione extends ValutazioneModel {

/*CONSTRUCTOR*/
function __construct(PDO $pdo){
	parent::__construct($pdo);
}

    function findValutazioneByIdPostIdUtente($idPost, $idUtente, $typeResult=self::FETCH_OBJ){

        $query = "SELECT *
                    FROM valutazione 
                    WHERE id_post = ? AND id_utente = ?";

        return $this->createResult($query, array($idPost, $idUtente), $typeResult);
    }

    public function getVotoMedio($idPost){
        $query = "SELECT ROUND( AVG(valutazione),1) AS votomedio 
                  FROM valutazione
                  WHERE id_post = ?";
        return $this->createResultValue($query, array($idPost));
    }

    public static function getVotoMedioStatic($pdo, $idPost){
        $app = new self($pdo);
        return $app->getVotoMedio($idPost);
    }

    public function countNumeroVoti($idPost){
        $query = "SELECT COUNT(id) 
                  FROM valutazione
                  WHERE id_post = ?";
        return $this->createResultValue($query, array($idPost));
    }

    public static function countNumeroVotiStatic($pdo, $idPost){
        $app = new self($pdo);
        return $app->countNumeroVoti($idPost);
    }

} //close Class Valutazione