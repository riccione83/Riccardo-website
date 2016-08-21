<?php
// load the login class
//require_once("classes/Login.php");

require_once("config/db.php");
session_start();

if(isset($_GET['logout']))
{
        // delete the session of the user
    session_start();
    session_unset();
    $_SESSION['FBID'] = NULL;
    $_SESSION['FULLNAME'] = NULL;
    $_SESSION['EMAIL'] =  NULL;
    $_SESSION['FIRST_NAME'] = NULL;
    $_SESSION['LAST_NAME'] = NULL; 
}
else 
{
    if (isset($_SESSION['FBID'])) 
    {
        $fbId = $_SESSION['FBID'];
        $fbEmail = $_SESSION['EMAIL'];
        dologinWithFacebook($fbEmail,$fbId);
    }
    else 
    {
       if(isset($_POST['user_name']) && isset($_POST['user_password']))
       {
	      dologinWithPostData();
       }
       else
       {
        echo '{"error":"No command found"}';
       }

    }
}

function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        // default return
        return false;
    }

function dologinWithFacebook($user_email,$user_id)
    {
            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$db_connection->set_charset("utf8")) 
            {
                $errors[] = $db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$db_connection->connect_errno) 
            {

                // escape the POST stuff
                $user_name = $user_email;

                // database query, getting all the info of the selected user (allows login via email address in the
                // username field)
                $sql = "SELECT user_id, user_name, user_email, user_password_hash, user_city
                        FROM Users
                        WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_name . "';";

                $result_of_login_check = $db_connection->query($sql);

                // if this user exists
                if ($result_of_login_check->num_rows == 1) 
                {
                    // get result row (as an object)
                    $result_row = $result_of_login_check->fetch_object();
                    // using PHP 5.5's password_verify() function to check if the provided password fits
                    // the hash of that user's password
                    if (password_verify($user_id, $result_row->user_password_hash)) 
                    {
                        // write user data into PHP SESSION (a file on your server)
                        $_SESSION['user_name'] = $result_row->user_name;
                        $_SESSION['user_email'] = $result_row->user_email;
                        $_SESSION['user_id'] = $result_row->user_id;
                        //$_SESSION['FIRST_NAME'] = $result_row->Name;
                        //$_SESSION['LAST_NAME'] = $result_row->Surname;
                        $_SESSION['user_login_status'] = 1;
                    } 
                    else 
                    {
                            $errors[] = "Wrong password. Try again.";
                            returnJSONError($errors);
                    }
                } 
                else 
                {
                    registerNewUserWithFacebook($user_email,$user_id);
                    if($prova == 0) 
                    {
                        $prova=1;
                        dologinWithFacebook();
                    }

                }
            } 
            else 
            {
                    $errors[] = "Database connection problem.";
                    returnJSONError($errors);
            }
    }

function dologinWithPostData()
    {
        // check login form contents
        if (empty($_POST['user_name'])) 
        {
            $errors[] = "Username field was empty.";
            returnJSONError($errors);
        } elseif (empty($_POST['user_password'])) 
        {
            $errors[] = "Password field was empty.";
            returnJSONError($errors);
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) 
        {
            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$db_connection->set_charset("utf8")) 
            {
                $errors[] = $db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$db_connection->connect_errno) 
            {

                // escape the POST stuff
                $user_name = $db_connection->real_escape_string($_POST['user_name']);

                // database query, getting all the info of the selected user (allows login via email address in the
                // username field)
                $sql = "SELECT user_id, user_name, user_email, user_password_hash, Name, Surname
                        FROM users
                        WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_name . "';";
                $result_of_login_check = $db_connection->query($sql);

                // if this user exists
                if ($result_of_login_check->num_rows == 1) 
                {

                    // get result row (as an object)
                    $result_row = $result_of_login_check->fetch_object();

                    // using PHP 5.5's password_verify() function to check if the provided password fits
                    // the hash of that user's password
                    if (password_verify($_POST['user_password'], $result_row->user_password_hash)) 
                    {
                        // write user data into PHP SESSION (a file on your server)
                        $_SESSION['user_name'] = $result_row->user_name;
                        $_SESSION['user_email'] = $result_row->user_email;
                        $_SESSION['user_id'] = $result_row->user_id;
                        $_SESSION['FULLNAME'] = $result_row->Name." ".$result_row->Surname;
                        $_SESSION['FIRST_NAME'] = $result_row->Name;
                        $_SESSION['LAST_NAME'] = $result_row->Surname;
                        $_SESSION['user_login_status'] = 1;
                        
                        echo '{"success":'.$_SESSION['user_id'].'}';

                    } 
                    else 
                    {
                        echo '{"error":"Wrong password. Try again"}';
                    }    
                }
                else 
                {
					echo '{"error":"This user does not exist"}';
                }
            }
            else 
            {
            	echo '{"error":"Database connection problem."}';
            }
        }
    }

function sendWelcomeEmail($username,$useremail) {
    // costruiamo alcune intestazioni generali
    $header = "From: no-reply@riccardorizzo.eu\n";
    //$header .= “CC: Altro Ricevente <altroricevente@dominio.net>\n”;
    //$header .= “X-Mailer: Il nostro Php\n”;

    // costruiamo le intestazioni specifiche per il formato HTML
    $header .= "MIME-Version: 1.0\n";
    $header .= "Content-Type: text/html; charset='iso-8859-1'\n";
    $header .= "Content-Transfer-Encoding: 7bit\n\n";

    $messaggio = "<html><body><p>Welcome $username. You have created an account on Multifiles website.<br></p><p>Please click <a href='http://www.riccardorizzo.eu/dev/login.php'>here</a> to login.</p></body></html>";

    mail($useremail,"Welcome to Multifiles",$messaggio,$header);

}

function registerNewUserWithFacebook($user_email,$user_id)
{
            // create a database connection
            $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$db_connection->set_charset("utf8")) {
                $errors[] = $db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$db_connection->connect_errno) 
            {

                // escaping, additionally removing everything that could be (html/javascript-) code
                $user_name = $user_email;
                $user_email = $user_email;

                $user_password = $user_id;

                // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
                // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
                // PHP 5.3/5.4, by the password hashing compatibility library
                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

                // check if user or email address already exists
                $sql = "SELECT * FROM users WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_email . "';";
                $query_check_user_name = $db_connection->query($sql);

                if ($query_check_user_name->num_rows == 1) 
                {
                    echo '{"error":"Sorry, that username / email address is already taken."}';
                } 
                else 
                {
                    sendWelcomeEmail($user_name,$user_email);
                    // write new user's data into database
                    $sql = "INSERT INTO users (user_name, user_password_hash, user_email)
                            VALUES('" . $user_name . "', '" . $user_password_hash . "', '" . $user_email . "');";
                    $query_new_user_insert = $db_connection->query($sql);

                    // if user has been added successfully
                    if ($query_new_user_insert) 
                    {
                            echo '{"message":"Your account has been created successfully. You can now log in."}';
                    } 
                    else 
                    {
                        echo '{"error":"Sorry, your registration failed. Please go back and try again."}';
                    }
                }
            } 
            else 
            {
                echo '{"error":"Sorry, no database connection."}';
            }
    }



function returnJSONError($errors= '') 
{
	if($errors) 
    {
            print('{"error":"'.$errors[0].'"}');
    }
}

?>