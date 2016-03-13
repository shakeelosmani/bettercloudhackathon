<?php
 
/**
 * Class to handle all db operations
 * This class will have CRUD methods for database tables
 *
 * @author Shakeel Osmani
 */
 
 class DbHandler {
 
    private $conn;
 
    function __construct() {
        require_once dirname(__FILE__) . './DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
	
	/* ------------- `users` table method ------------------ */
	
	/**
     * Creating new user
	 * @param String $email User login email id
	 * @param String $password User login password
     * @param String $name User full name
     * @param String $deviceToken
	 * @param String $deviceType
	 * @param String $profileImage
     */
	 
	 public function selectCompanyData() {
		$response = array();
		$tmp=array();
		
			$result = $this->conn->query("SELECT company_name,employee_count,company_latitude,company_longitude FROM companies");
			
			if($result){
				while($row = $result->fetch_assoc()){
					$tmp["company_name"] = $row["company_name"];
					$tmp["employee_count"] = $row["employee_count"];
					$tmp["company_lattitude"] = $row["company_latitude"];
					$tmp["company_longitude"]=$row["company_longitude"];
					array_push($response,$tmp);
					
				}
			}
           return $response;
        } 
	public function getAllEmployees() {
		$response = array();
		$tmp=array();
		$arr=array();
			$result = $this->conn->query("SELECT employee_name, company_id FROM employees");
			
			if($result){
				while($row = $result->fetch_assoc()){
					$tmp["employee_name"] = $row["employee_name"];
					$arr["company_id"] = $row["company_id"];
					switch($arr["company_id"]){
						case "70d6cfca-b64d-4c1f-b50a-7299d820daf8":{
							$tmp["company_name"] = "BetterCloud";
							break;
						}
						case "642047bc-2a9b-46f7-8e55-98ed612216e7":{
							$tmp["company_name"] = "LinkedIn";
							break;
						}
						case "95d1f2f3-977b-4949-a75e-c10f7f73408f":{
							$tmp["company_name"] = "Google";
							break;
						}
						case "61064995-6e15-4f18-b0b3-4547b4829d0a":{
							$tmp["company_name"] = "Apple";
							break;
						}
						
					}
					array_push($response,$tmp);
					
				}
			}
           return $response;
    }
        
	
	public function getEmployeesByCompany($company) {
		$response = array();
		$arr=array();
			$stmt = $this->conn->prepare("SELECT employee_name FROM employees WHERE company_id = ?");
			$stmt->bind_param("s",$company);
			$stmt->execute();
			$result = $stmt->get_result();
				while($row = $result->fetch_assoc()){
					$arr["employee_name"] = $row["employee_name"];
					array_push($response,$arr);
				}
           return $response;
        }
    

	public function getEventLocationByCompanyID($companyID) {
            $response = array();
            $arr = array();
            $stmt = $this->conn->prepare("SELECT event_id,event_latitude,event_longitude FROM employee_events WHERE company_id= ?");
            $stmt->bind_param("s", $companyID);
            $stmt->execute();
            $result   = $stmt->get_result();
            while($row = $result->fetch_assoc()) {
                            $arr["event_id"]  = $row["event_id"];
                            $arr["Latitude"]  = $row["event_latitude"];
                            $arr["Longitude"] = $row["event_longitude"];
                            array_push($response, $arr);
            }
            return $response;
	}
	
	public function getEventSuspiciousInformation($value) {
		$response = array();
		$arr      = array();
		$stmt = $this->conn->prepare("SELECT event_id,event_latitude,event_longitude FROM employee_events WHERE is_suspicious=?");
		$stmt->bind_param("s",$value);
		$stmt->execute();
		
		$result   = $stmt->get_result();
		
		while($row = $result->fetch_assoc()) {
				$arr["event_id"]  = $row["event_id"];
				$arr["Latitude"]  = $row["event_latitude"];
				$arr["Longitude"] = $row["event_longitude"];
				array_push($response, $arr);
		}
		
		return $response;
	}
        
        
        
        public function getSuspiciousEventLocation() {
		$response = array();
		$arr      = array();
		$stmt = $this->conn->prepare("SELECT event_latitude,event_longitude FROM employee_events WHERE is_suspicious='true'");
		$stmt->execute();
		
		$result   = $stmt->get_result();
		
		while($row = $result->fetch_assoc()) {
				$arr["Latitude"]  = $row["event_latitude"];
				$arr["Longitude"] = $row["event_longitude"];
				array_push($response, $arr);
		}
		
		return $response;
	}
        
        public function getSuspiciousEventEmployee(){
            $response = array();
		$arr      = array();
		$stmt = $this->conn->prepare("SELECT employee_events.employee_id, employee_events.company_id, employee_events.event_time, companies.company_name, employees.employee_name FROM employee_events INNER JOIN employees ON employees.employee_id = employee_events.employee_id INNER JOIN companies ON companies.company_id = employee_events.company_id WHERE is_suspicious='true'");
		$stmt->execute();
		
		$result   = $stmt->get_result();
		
		while($row = $result->fetch_assoc()) {
                    $arr["employee_name"]  = $row["employee_name"];
                    $arr["company_name"] = $row["company_name"];
                    $tempDate = new DateTime($row["event_time"]);
                    $arr["event_time"] = date_format($tempDate,"l jS \of F Y h:i:s A");
                    array_push($response, $arr);
		}
		
		return $response;
        }
        
        public function getLocationOfAllEvents() {
            $response = array();
            $arr = array();
            $stmt = $this->conn->prepare("SELECT event_latitude,event_longitude FROM employee_events");
            $stmt->execute();
            $result   = $stmt->get_result();
            while($row = $result->fetch_assoc()) {
                $arr["Latitude"]  = $row["event_latitude"];
                $arr["Longitude"] = $row["event_longitude"];
                array_push($response, $arr);
            }
            return $response;
	}
}
