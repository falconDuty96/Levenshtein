<?php
	$time_start = microtime(true);

	// Database connection
	try {
		$conn = new PDO("mysql:host=localhost;dbname=igoguide","root","") ;
	}
	catch(PDOException $e) {
		echo $e ;
		die() ;
	}

	
	$req = "SELECT * FROM etablissements INNER JOIN users ON users.users_id=etablissements.users_id INNER JOIN categories ON categories.categories_id=etablissements.categories_id INNER JOIN sous_categories ON sous_categories.sous_categories_id=etablissements.sous_categories_id" ;

	$stmt = $conn->query($req) ;
	$res = $stmt->fetchAll(PDO::FETCH_OBJ) ;


	// Levenshtein distance
	$txt = "Quai de la Noé" ;

	// Adding rank
	for($i = 0; $i < count($res); $i++) {
		$res[$i]->rank = levenshtein($res[$i]->etablissements_adresse, $txt) ;
	}

	// Sort ranking:
	for($j = 0; $j < count($res); $j++) {
		for($k = $j; $k < count($res); $k++) {
			if($res[$j]->rank > $res[$k]->rank) {
				$tmp = $res[$j] ;
				$res[$j] = $res[$k] ;
				$res[$k] = $tmp ;
			}
		}
	}


	var_dump($res) ;


	







	// Time ending
	$time_end = microtime(true);
	$time = $time_end - $time_start ;
	echo "Results in: $time seconds\n";

?>