<?php

// Function to create a mysqli connection, returning the object in format array(<bool:success>,<str:message>,<mysqli:instance-object>)
function connectDB(array $sqlargs) {
    // Extracting values from the arg array
    list($sql_host, $sql_uname, $sql_password, $sql_database, $sql_table) = $sqlargs;

    // Connect to SQL server UTF8
    try {
        $mysqli = new mysqli($sql_host, $sql_uname, $sql_password, $sql_database);
        $mysqli->set_charset("utf8");
    } catch (Exception $e) {
        // Handle exceptions and return message
        return array(False,"Failed to connect to SQL database (" . $e->getMessage() . ")",NULL);
    }

    // Verify connection to database
    if ($mysqli->connect_error) {
        return array(False,"Failed to connect to SQL database (" . $mysqli->connect_error . ")",NULL);
    } else {
        return array(True,"Successfully connected to database",$mysqli);
    }
}

// Function used to return to the landing page, with or without a message
function toLanding($loc=["index.php","."],$msg=NULL) {
    if ($msg != NULL && !empty($msg)) {
        header("Location:" . $loc[0] . "?ret-msg=$msg");
    } else {
        header("Location:" . $loc[1]);
    }
    exit(); // Exit to end the php execution-chain
}
function toLanding2($loc=["index.php","."],$msg=NULL) {
    if ($msg != NULL && !empty($msg)) {
        echo '<script>window.location.href = "'.$loc[0]."?ret-msg=$msg".'";</script>';
    } else {
        echo '<script>window.location.href = "'.$loc[1].'";</script>';
    }
exit(); // Exit to end the php execution-chain
}

// Function to get avaliable tables
function getTables(array $sqlargs) {
    // Extracting values from the arg array
    list($sql_host, $sql_uname, $sql_password, $sql_database, $sql_table) = $sqlargs;

    // Connect to SQL server UTF8
    try {
        $mysqli = new mysqli($sql_host, $sql_uname, $sql_password, $sql_database);
        $mysqli->set_charset("utf8");
    } catch (Exception $e) {
        // Handle exceptions and return message
        return array(False,"Failed to connect to SQL database (" . $e->getMessage() . ")",array());
    }

    // Verify connection to database
    if ($mysqli->connect_error) {
        return array(False,"Failed to connect to SQL database (" . $mysqli->connect_error . ")",array());
    }
    $sqlcmd = "SELECT TableNr FROM " . $sql_table;
                
    $result = $mysqli->query($sqlcmd);

    $result = mysqli_fetch_assoc($result);

    return $result;
}

// Function to place a table order into the database taking the information
function addTbOrder(array $sqlargs, array $retargs, int $tableNr, string $fullName, string $telephone, string $email, string $time, string $details, bool $phoneOrMail=true) {
    // Validate telephone or email requirement (if $phoneOrMail is true either phone or mail is required but not both, if set to false both are needed)
    $contactValid = false;
    if ($phoneOrMail == true) {
        if (!empty($telephone) || !empty($email)) {
            $contactValid = true;
        }
    } else {
        if (!empty($telephone) && !empty($email)) {
            $contactValid = true;
        }
    }
    // Basic validation of inputted values
    if (empty($tableNr) || empty($fullName) || $contactValid != true || empty($time)) {
        //return array(False,"Order placement failed! (Empty form input)",array());
        toLanding($retargs,"KeepTab:cb2:Order placement failed! (Empty form input)");
    }

    // Extracting values from the arg array
    list($sql_host, $sql_uname, $sql_password, $sql_database, $sql_table) = $sqlargs;

    // Connect to SQL server UTF8
    try {
        $mysqli = new mysqli($sql_host, $sql_uname, $sql_password, $sql_database);
        $mysqli->set_charset("utf8");
    } catch (Exception $e) {
        // Handle exceptions and return message
        toLanding($retargs,"KeepTab:cb2:Failed to connect to SQL database (" . $e->getMessage() . ")");
    }

    // Verify connection to database
    if ($mysqli->connect_error) {
        toLanding($retargs,"KeepTab:cb2:Failed to connect to SQL database (" . $mysqli->connect_error . ")");
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
    toLanding($retargs,"KeepTab:cb2:Order successfully placed!");
}

// Function to validate login-details (username and password) to check if they match a database
function validateLoginDetails(array $sqlargs, string $username, string $password) {
    // Basic validation of inputted values
    if (empty($username) || empty($password)) {
        return array(False,"Login failed! (Empty form input)",array());
    }

    // Extracting values from the arg array
    list($sql_host, $sql_uname, $sql_password, $sql_database, $sql_table) = $sqlargs;

    // Connect to SQL server UTF8
    try {
        $mysqli = new mysqli($sql_host, $sql_uname, $sql_password, $sql_database);
        $mysqli->set_charset("utf8");
    } catch (Exception $e) {
        // Handle exceptions and return message
        return array(False,"Failed to connect to SQL database (" . $e->getMessage() . ")",array());
    }

    // Verify connection to database
    if ($mysqli->connect_error) {
        return array(False,"Failed to connect to SQL database (" . $mysqli->connect_error . ")",array());
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

// Function to update user data (In this case to update the login-details of a user account)
function updUserData(array $sqlargs, string $username, string $password, string $olduname) {
    // Basic validation of inputted values
    if (empty($username) || empty($password) || empty($olduname)) {
        return array(False,"Update failed! (Empty form input)",array());
    }

    // Extracting values from the arg array
    list($sql_host, $sql_uname, $sql_password, $sql_database, $sql_table) = $sqlargs;

    // Connect to SQL server UTF8
    try {
        $mysqli = new mysqli($sql_host, $sql_uname, $sql_password, $sql_database);
        $mysqli->set_charset("utf8");
    } catch (Exception $e) {
        // Handle exceptions and return message
        return array(False,"Failed to connect to SQL database (" . $e->getMessage() . ")",array());
    }

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

// Function to get the orders from the SQL-order database and return them as an array.
function getOrders(array $sqlargs) {
    // Extracting values from the arg array
    list($sql_host, $sql_uname, $sql_password, $sql_database, $sql_table) = $sqlargs;

    // Connect to SQL server UTF8
    try {
        $mysqli = new mysqli($sql_host, $sql_uname, $sql_password, $sql_database);
        $mysqli->set_charset("utf8");
    } catch (Exception $e) {
        // Handle exceptions and return message
        return array(False,"Failed to connect to SQL database (" . $e->getMessage() . ")",array());
    }

    // Verify connection to database
    if ($mysqli->connect_error) {
        return array(False,"Failed to connect to SQL database (" . $mysqli->connect_error . ")",array());
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

// Function to clear the orders in the SQL-order database
function clearOrders(array $sqlargs) {
    // Extracting values from the arg array
    list($sql_host, $sql_uname, $sql_password, $sql_database, $sql_table) = $sqlargs;

    // Connect to SQL server UTF8
    try {
        $mysqli = new mysqli($sql_host, $sql_uname, $sql_password, $sql_database);
        $mysqli->set_charset("utf8");
    } catch (Exception $e) {
        // Handle exceptions and return message
        return array(False,"Failed to connect to SQL database (" . $e->getMessage() . ")",array());
    }

    // Verify connection to database
    if ($mysqli->connect_error) {
        return array(False,"Failed to connect to SQL database (" . $mysqli->connect_error . ")",array());
    }
    $sqlcmd = "TRUNCATE TABLE " . $sql_table;
                
    $result = $mysqli->query($sqlcmd);

    return $result;
}

// Function to parse a food-order string to its components
function parseOrderStr(string $unparsed) {
    $split = explode("§",$unparsed);
    $foods = array();
    $price = "";
    $tableNr = "";
    foreach ($split as $segment) {
        $segment = strval($segment);
        if (str_contains($segment,"price:")) {
            $subsegments = explode(":",$segment);
            $price = strval($subsegments[1]);
        } else if (str_contains($segment,"tablenr:")) {
            $subsegments = explode(":",$segment);
            $tableNr = strval($subsegments[1]);
        } else {
            $foods[] = $segment;
        }
    }
    // Make it to a amount-assoicated array
    $amntFoods = array_count_values($foods);
    return array($amntFoods,$price,trim($tableNr,'"}'));
}

function checkOrderCode(string $ordercode, array $sqlargs) {
    // Basic validation of inputted values
    if (strlen($ordercode) != 6) {
        return "FAILED: Order placement failed! (Invalid order code length)";
    }

    // Extracting values from the arg array
    list($sql_host, $sql_uname, $sql_password, $sql_database, $sql_table) = $sqlargs;

    // Connect to SQL server UTF8
    try {
        $mysqli = new mysqli($sql_host, $sql_uname, $sql_password, $sql_database);
        $mysqli->set_charset("utf8");
    } catch (Exception $e) {
        // Handle exceptions and return message
        return array(False,"Failed to connect to SQL database (" . $e->getMessage() . ")",array());
    }

    // Verify connection to database
    if ($mysqli->connect_error) {
        return array(False,"Failed to connect to SQL database (" . $mysqli->connect_error . ")",array());
    }

    // We also create a stmt (statement) and use the mysqli.prepare method on it to load it as a prepared-statement
    $prepped_statement = $mysqli->prepare("SELECT TableNr FROM " . $sql_table . " WHERE OrderCode=?");

    // We use bind_param to bind our placeholders with their wanted values making sure to use the correct data type:
    // s: String
    // This effectively says to php/sql that the content must be string, making injection less likely.
    $prepped_statement->bind_param("s", $ordercode);

    // Execute the prepared statement (Same as our query)
    $prepped_statement->execute();

    // Get result
    $result = $prepped_statement->get_result();

    $result = $result->fetch_assoc();
    // Close the statement connection since we don't need this connection to our SQL database.
    $prepped_statement->close();

    if(!empty($result["TableNr"])) {
        return "SUCCESS:" . $result["TableNr"];
    } else {
        return "FAILED: Order code " . $ordercode . " dosen't match any order in the database";
    }
}

// Function to save a given food-order to SQL
function saveFoodOrder(array $sqlargs, array $amntFoods, string $price, string $tableNr) {
    // Basic validation of inputted values
    if (empty($amntFoods) || empty($price) || empty($tableNr)) {
        //return array(False,"Order placement failed! (Empty form input)",array());
        return "FAILED:Order placement failed! (Empty form input)";
    }

    // Extracting values from the arg array
    list($sql_host, $sql_uname, $sql_password, $sql_database, $sql_table) = $sqlargs;

    // Connect to SQL server UTF8
    try {
        $mysqli = new mysqli($sql_host, $sql_uname, $sql_password, $sql_database);
        $mysqli->set_charset("utf8");
    } catch (Exception $e) {
        // Handle exceptions and return message
        return "FAILED:Failed to connect to SQL database (" . $e->getMessage() . ")";
    }

    // Verify connection to database
    if ($mysqli->connect_error) {
        return "FAILED:Failed to connect to SQL database (" . $mysqli->connect_error . ")";
    }
    
    // Parse foods into string
    $foods = '';
    foreach ($amntFoods as $key => $value) {
        $foods .= $key . ':' . $value . ',';
    }
    $foods = rtrim($foods, ',');

    // Generate timestamp
    $timestamp = time(); // Get the current timestamp

    // Format the timestamp as "Y-m-d\TH:i" (Ex 2024-01-17T21:27) HTML/Web format
    $timestamp = date("Y-m-d\TH:i", $timestamp);

    // Add order to SQL ? as placeholders
    $sqlcmd = "INSERT INTO " . $sql_table . " (TableNr, Price, Time, Food) VALUES (?, ?, ?, ?)";

    // We also create a stmt (statement) and use the mysqli.prepare method on it to load it as a prepared-statement
    $prepped_statement = $mysqli->prepare($sqlcmd);

    // We use bind_param to bind our placeholders with their wanted values making sure to use the correct data type:
    // s: String
    // This effectively says to php/sql that the content must be string, making injection less likely.
    $prepped_statement->bind_param("ssss", $tableNr, $price, $timestamp, $foods);

    // Execute the prepared statement (Same as our query)
    $prepped_statement->execute();

    // Close the statement connection since we don't need this connection to our SQL database.
    $prepped_statement->close();

    // Return
    return "SUCCESS:Order successfully placed at table number " . $tableNr . "!";
}

// Function to clear the orders in the SQL-order database with a given id
function clearOrdersId(array $sqlargs, int $id) {
    // Extracting values from the arg array
    list($sql_host, $sql_uname, $sql_password, $sql_database, $sql_table) = $sqlargs;

    // Connect to SQL server UTF8
    try {
        $mysqli = new mysqli($sql_host, $sql_uname, $sql_password, $sql_database);
        $mysqli->set_charset("utf8");
    } catch (Exception $e) {
        // Handle exceptions and return message
        return array(False,"Failed to connect to SQL database (" . $e->getMessage() . ")",array());
    }

    // Verify connection to database
    if ($mysqli->connect_error) {
        return array(False,"Failed to connect to SQL database (" . $mysqli->connect_error . ")",array());
    }
    $sqlcmd = 'DELETE FROM ' . $sql_table . ' WHERE id = ?';
    // We also create a stmt (statement) and use the mysqli.prepare method on it to load it as a prepared-statement
    $prepped_statement = $mysqli->prepare($sqlcmd);
    // We use bind_param to bind our placeholders with their wanted values making sure to use the correct data type:
    // i: int
    // This effectively says to php/sql that the content must be an int, making injection less likely.
    $prepped_statement->bind_param("i", $id);
                
    // Execute the prepared statement (Same as our query)
    $prepped_statement->execute();

    // Close the statement connection since we don't need this connection to our SQL database.
    $prepped_statement->close();
}
?>