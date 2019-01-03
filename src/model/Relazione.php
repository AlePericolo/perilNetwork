<?php
/**
* Developed by: Alessandro Pericolo
* Date: 29/11/2018
* Time: 17:02
* Version: 0.1
**/

require_once 'RelazioneModel.php';

class Relazione extends RelazioneModel {

/*CONSTRUCTOR*/
function __construct(PDO $pdo){
	parent::__construct($pdo);
}

    function findIdRichiestiFromIdRichiedente($idRichiedente, $typeResult=self::FETCH_OBJ){

        $query = "SELECT id_richiesto FROM relazione WHERE id_richiedente = ?";
        return $this->createResultArray($query, array($idRichiedente), $typeResult);
    }

    function findRelazioneByIdRichiedenteAndRichiesto($idRichiedente, $idRichiesto, $typeResult=self::FETCH_OBJ){

        $query = "SELECT * FROM relazione WHERE id_richiedente = ? AND id_richiesto = ?";
        return $this->createResult($query, array($idRichiedente, $idRichiesto), $typeResult);
    }

    function deleteRelazioneByIdRichiedenteAndRichiesto($idRichiedente, $idRichiesto, $typeResult=self::FETCH_OBJ){

        $query = "DELETE FROM relazione WHERE id_richiedente = ? AND id_richiesto = ?";
        return $this->createResult($query, array($idRichiedente, $idRichiesto), $typeResult);
    }


} //close Class Relazione