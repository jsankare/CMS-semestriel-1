<?php

namespace App\Core;

use PDO;

class SQL
{
    protected PDO $pdo;
    protected string $table;

    public function __construct()
    {
        try{
            $this->pdo = new PDO("pgsql:host=".$_ENV['DB_HOST'].";dbname=".$_ENV['DB_NAME'].";port=".$_ENV['DB_PORT'],$_ENV['DB_USER'],$_ENV['DB_PASSWORD']);
        }catch (\Exception $e){
            die("Erreur SQL : ".$e->getMessage());
        }

        $classChild = get_called_class();

        $this->table = $_ENV['DB_PREFIX'].strtolower(str_replace("App\\Models\\","",$classChild));
    }

    public function save()
    {
        
        //Ne pas ecrire en dur le nom de la table ou des colonnes à inserer en bdd
        $columnsAll = get_object_vars($this);
        $columnsToDelete = get_class_vars(get_class());
        $columns = array_diff_key($columnsAll, $columnsToDelete);

        //C'est pour convertir les booléen
        foreach ($columns as $key => $value) {
            if (is_bool($value)) {
                $columns[$key] = $value ? 'true' : 'false';
            }
        }

        if( empty($this->getId()) ) {
            $sql = "INSERT INTO ".$this->table. " (". implode(', ', array_keys($columns) ) .")  
        VALUES (:". implode(',:', array_keys($columns) ) .")";
        }else{

            // UPDATE esgi_user SET firstname=:firstname, lastname=:lastname WHERE id=1
            foreach ( $columns as $column=>$value){
                $sqlUpdate[] = $column."=:".$column;
            }

            $sql = "UPDATE ".$this->table. " SET ".implode(',', $sqlUpdate). " WHERE id=".$this->getId();
        }
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute($columns);

    }

}
