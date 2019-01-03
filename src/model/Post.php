<?php
/**
* Developed by: Alessandro Pericolo
* Date: 29/11/2018
* Time: 17:02
* Version: 0.1
**/

require_once 'PostModel.php';

class Post extends PostModel {

/*CONSTRUCTOR*/
function __construct(PDO $pdo){
	parent::__construct($pdo);
}

    function findPostUtenteByIdUtente($idUtente, $typeResult=self::FETCH_OBJ){

        $query = "SELECT 
                        post.*,
                        CONCAT (utente.nome, ' ', utente.cognome) AS nominativo,
                        utente.foto
                    FROM post 
                    INNER JOIN utente ON post.id_utente = utente.id
                    WHERE id_utente = ?
                    ORDER BY data_pubblicazione DESC";

        return $this->createResultArray($query, array($idUtente), $typeResult);
    }

    function findPostUtenteAmiciByIdUtente($idUtente, $typeResult=self::FETCH_OBJ){

        $query = "SELECT 
                        post.*,
                        CONCAT (utente.nome, ' ', utente.cognome) AS nominativo,
                        utente.foto
                    FROM post 
                    INNER JOIN utente ON post.id_utente = utente.id
                    WHERE id_utente = ? OR id_utente IN (
                        SELECT id_richiesto 
                        FROM relazione 
                        WHERE id_richiedente = ? AND amicizia = 1
                      ) 
                    ORDER BY data_pubblicazione DESC";


        return $this->createResultArray($query, array($idUtente, $idUtente), $typeResult);
    }

} //close Class Post