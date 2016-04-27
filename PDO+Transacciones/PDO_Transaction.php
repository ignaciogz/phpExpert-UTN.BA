<?php
/**
  * PDO Transaction Class
  * @author Ignacio Gutierrez
  *
  * @param string $sql_query "Representa el template de la consulta a realizar" 
  * @param string $selectorBindeador "Representa que tipo de query se va a ejecutar"
  * @param array $infoArray "Representa la informacion necesaria para la consulta"
*/

abstract class PDO_Transaction
{
	protected $tipoQuery;
	protected $stmt;

	final public function tQuery($sql_query, $selectorBindeador, $infoArray){
		try {
			//Siguiente query a modo de ejemplo, de lo que entra por parametro:
			
			/*
				$sql_query = "INSERT INTO countries (name, area, population, density)
		                            VALUES (:name, :area, :population, :density)";
			*/
		  	
		  	$this->tipoQuery = $selectorBindeador;
		  	$this->stmt = $dbh->prepare($sql_query);
		  	//Ejecuto Metodo Abstracto 1:
		  		$this->bindeador();

		    $this->dbh->beginTransaction();
		    //Ejecuto Metodo Abstracto 2:
		    	$this->ejecutores($infoArray);
		  
		  $this->dbh->commit();

		} catch (Exception $e) {
		   $this->dbh->rollBack();
		   echo "Failed: " . $e->getMessage();
		}
	}

	abstract protected function bindeador();
	abstract protected function ejecutores($infoArray);
}

// ---------------------------------------------------------------------
//Dentro de la clase: Database extends PDO_Transaction
//Y definir los metodos bindeador y ejecutores, por ejemplo:
	protected function bindeador()
	{
		switch ($this->tipoQuery)
        {
			case "paises":
					$this->stmt->bindParam(':name', $name);
					$this->stmt->bindParam(':area', $area);
					$this->stmt->bindParam(':population', $population);
					$this->stmt->bindParam(':density', $density);
				break;
			case "autos":
					$this->stmt->bindParam(':marca', $marca);
					$this->stmt->bindParam(':modelo', $modelo);
					$this->stmt->bindParam(':precio', $precio);
					$this->stmt->bindParam(':extra', $extra);
				break;
		}
	}

	protected function ejecutores($infoArray)
	{
		//EJEMPLO DE CONTENIDO DE INFO ARRAY, para el case "paises":
		/*
			$infoArray = array(
				array("name" => "Nicaragua", "area" => 129494, "population" => 602800, "density" => 46.55),
				array("name" => "Panama", "area" => 78200, "population" => 3652000, "density" => 46.70)
			);
			
		*/

		switch($this->tipoQuery)
        	{
        	case "paises":
        		foreach ($infoArray as $info)
        			{
					$name = $info["name"]; $area = $info["area"]; $population = $info["polution"]; $density = $info["density"];
					$this->stmt->execute();
				}
        		break;
        	case "autos":
        		foreach ($infoArray as $info)
        			{
					$modelo = $info["modelo"]; $marca = $info["marca"]; $precio = $info["precio"]; $extra = $info["extra"];
					$this->stmt->execute();
				}
        		break;
        	}
	}
