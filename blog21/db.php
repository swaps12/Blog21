<?php

// Database wrapper class. 

class DBWrapper {

	protected static $connection;

	/**
	 * This method is used for creating connection object to be used internally by this class. 
	 * 
	 * @return false if connection is not established.
	 */
	public function connect() {
		if (!isset(self::$connection)) {
			$config = parse_ini_file('..//config.ini');
			self::$connection = new mysqli($config['DB_HOST'], $config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_NAME']);

			if (self::$connection->connect_errno) {
				return false;
			}
			return true;
		}

		if (self::$connection == false) {
			return false;
		}
	}

	/**
	 * This method is used to retrieve connection error. 
	 * 
	 * @return connection error.
	 */
	public function connectionError() {
		return self::$connection->connect_errno;
	}

	/**
	 * This method is used for insert queries. 
	 * 
	 * @param $query - Insert query to be executed.
	 * @param $data - First value in the data array is an string with the type of each parameter 
	 * (Types: s = string, i = integer, d = double, b = blob). Next n is the parameters you want to bind
	 * eg ["s", 'This is test String'] or ["si", 'This is test String', 9]
	 * @return The auto generated id used in the last query if successful, false otherwise.
	 */
	public function insert($query, $data) {
		if (self::$connection) {
			if ($stmt = self::$connection->prepare($query)) {

				// This block is used for dynamically binding parameters
				$a_params = array();
				foreach ($data as $key => $value) {
		            $a_params[$key] = &$data[$key];
		        }
				call_user_func_array(array($stmt, 'bind_param'), $a_params);
				// Block for binnding parameters ends.

				$stmt->execute();
				// This statement will work in our case cos all the tables in db have
				// an auto-increment id. If this is not the case, need to take special care 
				// of this value cos it will return 0 in case the auto increment column is 
				// missing.
				$id = $stmt->insert_id;
				if ($id == 0) {
					return -1;
				}
				$stmt->close();
				return $id;
			}
			return false;
		}
		return false;
	}


	/**
	 * This method is used for non binding queries. 
	 * 
	 * @param $query - Query to be executed.
	 * @return The result of the mysqli::query() function or false in case of error.
	 */
	public function query($query) {
		if (self::$connection) {

			$result = self::$connection->query($query);
			if ($result == false) {
				return false;
			} else if ($result->num_rows == 0) {
				// This can occur due to number of reason.
				// 1. Select query with no rows.
				// 2. Delete query.
				return -1;
			} 

			$data = array();
			foreach ($result as $row) {
				$data[] = $row;
			}

			$result->close();
			return $data;
		}
	}


	/**
	 * This method is used for binding queries. 
	 * 
	 * @param $query - Query to be executed.
	 * @param $data - First value in the data array is an string with the type of each parameter 
	 * (Types: s = string, i = integer, d = double, b = blob). Next n is the parameters you want to bind
	 * eg ["s", 'This is test String'] or ["si", 'This is test String', 9]
	 * @return The result of the mysqli::query() function or false in case of error.
	 */
	public function bindingQuery($query, $data) {
		if (self::$connection) {
			if ($stmt = self::$connection->prepare($query)) {
				
				// This block is used for dynamically binding parameters
				$a_params = array();

				foreach ($data as $key => $value) {
		            $a_params[$key] = &$data[$key];
		        }

				call_user_func_array(array($stmt, 'bind_param'), $a_params);
				// Block for binnding parameters ends.

				$stmt->execute();

				$result = $stmt->get_result();

				$data = array();

				foreach ($result as $row) {
					$data[] = $row;
				}

				$result->close();
				$stmt->close();

				return $data;
			}

			return false;
		}

		return false;
	}

	/**
	 * Fetch the last error from the database
	 * 
	 * @return string Database error message
	 */
	public function error() {
		if (self::$connection) {
			return self::$connection->errno;
		}
	}

	/**
	 * Quote and escape value for use in a database query
	 *
	 * @param string $value The value to be quoted and escaped
	 * @return string The quoted and escaped string
	 */
	public function quote($value) {
		if (self::$connection) {
			return "" . self::$connection -> real_escape_string($value) . "";
		}
	}

	/**
	 * Closes database connection
	 */
	public function disconnect() {
		if (self::$connection) {
			self::$connection->close();
		}
	}

}

?>