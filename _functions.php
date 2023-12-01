<?php

function toLanding($loc=["index.php","."],$msg=NULL) {
    if ($msg != NULL && !empty($msg)) {
        header("Location:" . $loc[0] . "?ret-msg=$msg");
    } else {
        header("Location:" . $loc[1]);
    }
    exit();
}

function addOrder(array $sqlargs, array $retargs, int $tableNr, string $fullName, string $telephone, string $email, string $time, string $details) {
    // Basic validation of inputted values
    if (empty($tableNr) || empty($fullName) || empty($telephone) || empty($email) || empty($time)) {
        //return array(False,"Order placement failed! (Empty form input)",array());
        toLanding($retargs,"Order placement failed! (Empty form input)");
    }

    // Extracting values from the arg array
    list($sql_host, $sql_uname, $sql_password, $sql_database, $sql_table) = $sqlargs;

    // Connect to SQL server UTF8
    $mysqli = new mysqli($sql_host, $sql_uname, $sql_password, $sql_database);
    $mysqli->set_charset("utf8");

    // Verify connection to database
    if ($mysqli->connect_error) {
        return array(False,"Failed to connect to SQL databse (" . $mysqli->connect_error . ")",array());
    }

    // Here we now use ? as a placeholder for our later values
    $sqlcmd = "INSERT INTO " . $sql_table . " (TableNr, FullName, Telephone, Email, Time, Details) VALUES (?, ?, ?, ?, ?, ?)";

    // We also create a stmt (statement) and use the mysqli.prepare method on it to load it as a prepared-statement
    $prepped_statement = $mysqli->prepare($sqlcmd);

    // We use bind_param to bind our placeholders with their wanted values making sure to use the correct data type:
    // s: String
    // This effectively says to php/sql that the content must be string, making injection less likely.
    $prepped_statement->bind_param("ssssss", $tableNr, $fullName, $telephone, $email, $time, $details);

    // Execute the prepared statement (Same as our query)
    $prepped_statement->execute();

    // Get the result from the query.
    //$result = $prepped_statement->get_result(); // Get Result
    //$result = $result->fetch_assoc(); // Fetch from the result 

    // Close the statement connection since we don't need this connection to our SQL database.
    $prepped_statement->close();

    // Return
    //return array(TRUE,"",array());
    toLanding($retargs,"Order successfully placed!");
}

function validateLoginDetails(array $sqlargs, string $username, string $password) {
    // Basic validation of inputted values
    if (empty($username) || empty($password)) {
        return array(False,"Login failed! (Empty form input)",array());
    }

    // Extracting values from the arg array
    list($sql_host, $sql_uname, $sql_password, $sql_database, $sql_table) = $sqlargs;

    // Connect to SQL server UTF8
    $mysqli = new mysqli($sql_host, $sql_uname, $sql_password, $sql_database);
    $mysqli->set_charset("utf8");

    // Verify connection to database
    if ($mysqli->connect_error) {
        return array(False,"Failed to connect to SQL databse (" . $mysqli->connect_error . ")",array());
    }

    // Here we now use ? as a placeholder for our later values
    $sqlcmd = "SELECT * FROM " . $sql_table . " WHERE Username=? AND Password=?";

    // We also create a stmt (statement) and use the mysqli.prepare method on it to load it as a prepared-statement
    $prepped_statement = $mysqli->prepare($sqlcmd);

    // We use bind_param to bind our placeholders with their wanted values making sure to use the correct data type:
    // s: String
    // This effectively says to php/sql that the content must be string, making injection less likely.
    $prepped_statement->bind_param("ss", $username, $password);

    // Execute the prepared statement (Same as our query)
    $prepped_statement->execute();

    // Get the result from the query.
    $result = $prepped_statement->get_result(); // Get Result
    $result = $result->fetch_assoc(); // Fetch from the result 

    // Close the statement connection since we don't need this connection to our SQL database.
    $prepped_statement->close();

    // Return result
    if(!empty($result)) {
        return array(True,"You are logged in as '$username'! (Valid credentails)",array());
    } else {
        return array(False,"Login failed! (Inncorrect credentails or no result in SQL query)",array());
    }
}

function updUserData(array $sqlargs, string $username, string $password, string $olduname) {
    // Basic validation of inputted values
    if (empty($username) || empty($password) || empty($olduname)) {
        return array(False,"Update failed! (Empty form input)",array());
    }

    // Extracting values from the arg array
    list($sql_host, $sql_uname, $sql_password, $sql_database, $sql_table) = $sqlargs;

    // Connect to SQL server UTF8
    $mysqli = new mysqli($sql_host, $sql_uname, $sql_password, $sql_database);
    $mysqli->set_charset("utf8");

    // Verify connection to database
    if ($mysqli->connect_error) {
        return array(False,"Failed to connect to SQL database (" . $mysqli->connect_error . ")",array());
    }

    // Here we now use ? as a placeholder for our later values
    $sqlcmd = "SELECT * FROM " . $sql_table . ' WHERE Username=?';
                
    // We also create a stmt (statement) and use the mysqli.prepare method on it to load it as a prepared-statement
    $prepped_statement = $mysqli->prepare($sqlcmd);

    // We use bind_param to bind our placeholders with their wanted values making sure to use the correct data type:
    // s: String
    // This effectively says to php/sql that the content must be string, making injection less likely.
    $prepped_statement->bind_param("s", $olduname);

    // Execute the prepared statement (Same as our query)
    $prepped_statement->execute();

    // Get the result from the query.
    $result = $prepped_statement->get_result(); // Get Result
    $result = $result->fetch_assoc(); // Fetch from the result 

    // Close the statement connection since we don't need this connection to our SQL database.
    $prepped_statement->close();

    // Check to ensure user already exists
    if(empty($result)) {
        array(False,"Update failed! (User dosen't exists)");
    } else {
        $usrid = $result["ID"];
    }
    // NOTE! This one should use auto-increment i have set mine to it.
    $sqlcmd = "UPDATE " . $sql_table . " SET Username=?, Password=? WHERE ID=?";
    // Create statement
    $prepped_statement = $mysqli->prepare($sqlcmd);
    // Bind
    $prepped_statement->bind_param("sss", $username, $password, $usrid);
    // Execute
    $prepped_statement->execute();
    // Get result
    $result = $prepped_statement->get_result();
    if (is_bool($result)) {
        $result = array("fbool" => $result);
    } else {
        $result = $result->fetch_assoc();
    }
    // Close
    $prepped_statement->close();
    // RETURN RESULT
    if ($olduname != $username) {
        return array(TRUE,"Successfully changed username from '" . $olduname . "' to '" . $username . "'!",$result);
    } else {
        return array(TRUE,"",$result);
    }
}

function getOrders(array $sqlargs) {
    // Extracting values from the arg array
    list($sql_host, $sql_uname, $sql_password, $sql_database, $sql_table) = $sqlargs;

    // Connect to SQL server UTF8
    $mysqli = new mysqli($sql_host, $sql_uname, $sql_password, $sql_database);
    $mysqli->set_charset("utf8");

    // Verify connection to database
    if ($mysqli->connect_error) {
        return array(False,"Failed to connect to SQL databse (" . $mysqli->connect_error . ")",array());
    }
    $sqlcmd = "SELECT * FROM " . $sql_table;
                
    $result = $mysqli->query($sqlcmd);

    $data = array();
    // Fetch all rows and store them in the $data array
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    return $data;
}
?>