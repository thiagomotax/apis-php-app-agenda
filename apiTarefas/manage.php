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
         $descricao      = filter_var($_REQUEST['descricao'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $id =  $_REQUEST['id'];

         // Attempt to run PDO prepared statement
         try {
          $sql  = "INSERT INTO tarefas(descricaoTarefa, idUsuario) VALUES (:descricao, :id)";
          $stmt 	= $pdo->prepare($sql);
            $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
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
         $descricao      = filter_var($_REQUEST['descricao'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $recordID   =  filter_var($_REQUEST['recordID'], FILTER_SANITIZE_NUMBER_INT);

         // Attempt to run PDO prepared statement
         try {
            $sql 	= "UPDATE tarefas SET descricaoTarefa = :descricao WHERE idTarefa = :recordID";
            $stmt 	=	$pdo->prepare($sql);
            $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
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
            $sql  = "DELETE FROM tarefas WHERE idTarefa = :recordID";
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