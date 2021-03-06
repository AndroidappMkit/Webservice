<?php

/**
 * @author ben khssib khouloud
 * @MKIT e_learning
 */

class DB_Functions {

    private $conn;

    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }

    // destructor
    function __destruct() {
        
    }

    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $email, $password, $profil, $unique_id) {
        
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt

        $stmt = $this->conn->prepare("INSERT INTO users(unique_id, name, email, encrypted_password, profil, salt, created_at) VALUES(?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssss", $unique_id, $name, $email, $encrypted_password,$profil, $salt);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $user;
        } else {
            return false;
        }
    }

    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($email, $password) {

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");

        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            // verifying user password
            $salt = $user['salt'];
            $encrypted_password = $user['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $user;
            }
        } else {
            return NULL;
        }
    }

    /**
     * Get user by unique_id
    **/
    public function getUserByID($unique_id) {

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE unique_id = ?");

        $stmt->bind_param("s", $unique_id);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }
    

    /**
     * Check user email is existed or not
     */
    public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT email from users WHERE email = ?");

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }

    /**
     * Check id is existed or not
     */
    public function isIdUserExisted($unique_id) {
        $stmt = $this->conn->prepare("SELECT unique_id from users WHERE unique_id = ?");

        $stmt->bind_param("s", $unique_id);

        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }

    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }
	
	 public function getAllCourses($id) {

        $stmt = $this->conn->prepare("SELECT * FROM cour where id = ?");
		 $stmt->bind_param("s", $id);
		    $result= $stmt->execute();
			
			if ($result) {
            $cour = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			
                return $cour;
            }
         else {
            return NULL;
        }
    }
	public function getAllchapitres($id_cour) {

        $stmt = $this->conn->prepare("SELECT * FROM chapitre where id_cour  = ?");
	    $stmt->bind_param("s", $id_cour);
		 $result = $stmt->execute();
           if ($result) {
           $chapitre = $stmt->get_result()->fetch_assoc();
           $stmt->close();
                return $chapitre;
            }
         else {
            return NULL;
        }
    }
	public function getAlllessons($id_chap) {

        $stmt = $this->conn->prepare("SELECT * FROM lecon where id_chap  = ?");
	     $stmt->bind_param("s", $id_chap);
            $result = $stmt->execute();
           if ($result) {
           $lecon = $stmt->get_result()->fetch_assoc();
           $stmt->close();
                return $lecon;
            }
         else {
            return NULL;
        }
		
		
    }
	
	
		public function getAllquiz($id_lec) {

        $stmt = $this->conn->prepare("SELECT * FROM quiz where id_lec  = ?");
	     $stmt->bind_param("s", $id_lec);
            $result = $stmt->execute();
           if ($result) {
           $quiz = $stmt->get_result()->fetch_assoc();
           $stmt->close();
                return $quiz;
            }
         else {
            return NULL;
        }
		
		
    }
	
	   public function storereplyofquiz($rep, $question) {
        $stmt = $this->conn->prepare("INSERT INTO quiz(rep) VALUES(?) where question = ?");
        $stmt->bind_param("ss", $rep, $question);
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {

            return true;
        } else {
            return false;
        }
    }

}

?>
