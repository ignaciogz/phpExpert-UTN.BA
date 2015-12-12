<?php
/**
 * Lacuna PDO Data Class
 * @autor Miguel Barocchi
 * @param bool $auto_connect can be ommited: default value = true
 *
 *
 * Usage:
 * $db = new Database();
 * $db->call('sp_test_update',array((string)'6'));
 * $db->query('insert into table(a,b) values(8,9)');
 * $res = $db->query('select * from kek');
 * $res = $db->call('sp_test_get',array((string)'6'));
 **/

class Database {

    private $dbh;
    public $lastID;
	/*
	 * Si se instancia un nuevo objeto de clase, $auto_connect = true
	 * Si no está definido un valor para el nombre de la base de datos, 
	 * se solicitan los datos que se encuentran en connection.php
	 * Luego, se llama a la función connect() la cual instancia la conexión
	 * y mediante la estructura "try catch" atrapa y muestra posibles errores  */
    public function __construct($auto_connect = true){
        if(!defined('DB_DBNAME')){
            require_once(PATH_CFG.'connection.php');
        }
        if($auto_connect){$this->connect();}
    }

/**
 * Connect to the database
 *
 * @return void
 */
 /*En este caso se conecta a la base de datos y de presentarse algún inconveniente 
  * atrapa y retorna el error mediante la estructura "try catch"*/
    public function connect(){
        try {
            $dsn = 'mysql:dbname=' . DB_DBNAME . ';host=' . DB_HOST;
            $this->dbh = new PDO($dsn, DB_USER, DB_PASS);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo  $e->getMessage();
        }
    }

/**
 * Query database and return fetched query result
 *
 * @return Array
 * @param string $sql_query SQL query
 */    
    public function query($sql_query){
        try{
            $smh = $this->dbh->query($sql_query);
            return $smh->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            /*if error code = HY000 means that fetchall() returned no result*/
            if($e->getCode()!='HY000'){
                echo $e->getMessage();
            }
        }
    }
}