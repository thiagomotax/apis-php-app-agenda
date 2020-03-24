<?php
   header('Access-Control-Allow-Origin: *');

   // Define database connection parameters
   $hn      = 'mysql995.umbler.com';
   $un      = 'luiza';
   $pwd     = 'ourtime123';
   $db      = 'ourtime';
   $cs      = 'utf8';

   $dsn  = "mysql:host=" . $hn . ";port=3306;dbname=" . $db . ";charset=" . $cs;
   $opt  = array(
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                       );
   // Create a PDO instance (connect to the database)
   $pdo  = new PDO($dsn, $un, $pwd, $opt);

   // Retrieve the posted data
   $key  = strip_tags($_REQUEST['key']);
   $data = array();

 switch($key)
   {

      // Add a new record to the technologies table
      case "create":

         // Sanitise URL supplied values
         $titulo      = filter_var($_REQUEST['titulo'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $sigla      = filter_var($_REQUEST['sigla'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $horai      = filter_var($_REQUEST['horai'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $horaf      = filter_var($_REQUEST['horaf'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $dias      = $_REQUEST['dias'];
         $diatodo      = $_REQUEST['diatodo'];
         $repete      = $_REQUEST['repete'];
         $meses      = $_REQUEST['meses'];
         $datap =  date('m-d-Y');
         $id =  $_REQUEST['id'];





         // Attempt to run PDO prepared statement
         try {
          $sql  = "INSERT INTO horarios(tituloHorario, siglaHorario, horaInicialHorario, horaFinalHorario, diasHorario, diaTodoHorario, repeteHorario, mesesHorario, dataHorario, idUsuario) VALUES (:titulo, :sigla, :horai, :horaf, :dias, :diatodo, :repete, :meses, :datap, :id)";
          $stmt 	= $pdo->prepare($sql);
            $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
            $stmt->bindParam(':sigla', $sigla, PDO::PARAM_STR);
            $stmt->bindParam(':horai', $horai, PDO::PARAM_STR);
            $stmt->bindParam(':horaf', $horaf, PDO::PARAM_STR);
            $stmt->bindParam(':dias', $dias, PDO::PARAM_INT);
            $stmt->bindParam(':diatodo', $diatodo, PDO::PARAM_BOOL);
            $stmt->bindParam(':repete', $repete, PDO::PARAM_BOOL);
            $stmt->bindParam(':meses', $meses, PDO::PARAM_INT);
            $stmt->bindParam(':datap', $datap, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();
            //echo json_encode(array('message' => 'Congratulations the record ' . $descricao . ' was added to the database'));
         }
         // Catch any errors in running the prepared statement
         catch(PDOException $e)
         {
            echo $e->getMessage();
         }

      break;




      // Update an existing record in the technologies table
      case "update":

         // Sanitise URL supplied values
         $titulo      = filter_var($_REQUEST['titulo'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $horai      = filter_var($_REQUEST['horai'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $horaf      = filter_var($_REQUEST['horaf'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $datai      = filter_var($_REQUEST['datai'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $dataf      = filter_var($_REQUEST['dataf'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $diatodo      = filter_var($_REQUEST['diatodo'], FILTER_SANITIZE_NUMBER_INT);
         $recordID   =  filter_var($_REQUEST['recordID'], FILTER_SANITIZE_NUMBER_INT);

         // Attempt to run PDO prepared statement
         try {
            $sql 	= "UPDATE horarios SET tituloHorario = :titulo, horaInicialHorario = :horai, horaFinalHorario = :horaf, dataInicialHorario = :datai, dataFinalHorario = :dataf, diaTodoHorario = :diatodo WHERE idHorario = :recordID";
            $stmt 	=	$pdo->prepare($sql);
            $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
            $stmt->bindParam(':horai', $horai, PDO::PARAM_STR);
            $stmt->bindParam(':horaf', $horaf, PDO::PARAM_STR);
            $stmt->bindParam(':datai', $datai, PDO::PARAM_STR);
            $stmt->bindParam(':dataf', $dataf, PDO::PARAM_STR);
            $stmt->bindParam(':diatodo', $diatodo, PDO::PARAM_INT);
            $stmt->bindParam(':recordID', $recordID, PDO::PARAM_INT);
            $stmt->execute();

            //echo json_encode('Congratulations the record ' . $descricao . ' was updated');
         }
         // Catch any errors in running the prepared statement
         catch(PDOException $e)
         {
            echo $e->getMessage();
         }

      break;



      // Remove an existing record in the technologies table
      case "delete":

         // Sanitise supplied record ID for matching to table record
         $recordID   =  filter_var($_REQUEST['recordID'], FILTER_SANITIZE_NUMBER_INT);
         
         // Attempt to run PDO prepared statement
         try {
            $pdo  = new PDO($dsn, $un, $pwd);
            $sql  = "DELETE FROM horarios WHERE idHorario = :recordID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':recordID', $recordID, PDO::PARAM_INT);
            $stmt->execute();

            //echo json_encode('Congratulations the record ' . $namaDepan . ' was removed');
         }
         // Catch any errors in running the prepared statement
         catch(PDOException $e)
         {
            echo $e->getMessage();
         }

      break;
   }

?>