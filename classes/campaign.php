<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace classes;

require_once 'DbConnector.php';

use PDO;
use PDOException;
use classes\DbConnector;

class campaign {
   
    
    private $campaignId;
    private $Title;
    private $address;
    private $startDate;
    private $endDate;
    private $review;
    private $status;
    private $districtId;

    private $bloodBankId;
    
    public function __construct($campaignId, $Title, $address, $startDate, $endDate, $review, $status, $districtId, $bloodBankId) {
        $this->campaignId = $campaignId;
        $this->Title = $Title;
        $this->address = $address;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->review = $review;
        $this->status = $status;
        $this->districtId = $districtId;
       
        $this->bloodBankId = $bloodBankId;
    }
    
    public function getCampaignId() {
        return $this->campaignId;
    }

    public function getTitle() {
        return $this->Title;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function getReview() {
        return $this->review;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getDistrictId() {
        return $this->districtId;
    }

    

    public function getBloodBankId() {
        return $this->bloodBankId;
    }


    public function setCampaignId($campaignId): void {
        $this->campaignId = $campaignId;
    }

    public function setTitle($Title): void {
        $this->Title = $Title;
    }

    public function setAddress($address): void {
        $this->address = $address;
    }

    public function setStartDate($startDate): void {
        $this->startDate = $startDate;
    }

    public function setEndDate($endDate): void {
        $this->endDate = $endDate;
    }

    public function setReview($review): void {
        $this->review = $review;
    }

    public function setStatus($status): void {
        $this->status = $status;
    }

    public function setDistrictId($districtId): void {
        $this->districtId = $districtId;
    }

    

    public function setBloodBankId($bloodBankId): void {
        $this->bloodBankId = $bloodBankId;
    }



public function AddCampaign() {
    try {
        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();

        $query = "INSERT INTO `campaigntable` (`campaignId`, `Title`, `address`, `startDate`, `endDate`, `review`, `status`, `districtId`, `bloodBankId`) 
        VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?);";

        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->Title, PDO::PARAM_STR);
        $pstmt->bindValue(2, $this->address, PDO::PARAM_STR);
        $pstmt->bindValue(3, $this->startDate, PDO::PARAM_STR);
        $pstmt->bindValue(4, $this->endDate, PDO::PARAM_STR);
        $pstmt->bindValue(5, $this->review, PDO::PARAM_STR);
        $pstmt->bindValue(6, $this->status, PDO::PARAM_STR);
       $pstmt->bindValue(7, $this->districtId, PDO::PARAM_INT);
       $pstmt->bindValue(8, $this->bloodBankId, PDO::PARAM_INT);

        $pstmt->execute();

       return $pstmt->rowCount() > 0;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
           


function is_valid_age($age) {
    if (is_numeric($age)) {
        $age = (int)$age;
        if ($age >= 0 && $age <= 150) {  // Assuming a valid age range between 0 and 150
            return true;
        }
    }
    return false;
}








static function getAllCampaign($bloodBankId){
    try {
        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();

        $query = "SELECT campaigntable.*, district.district,bloodbank.ContactNo 
        FROM campaigntable JOIN district ON campaigntable.districtId = district.districtId 
        join bloodbank on campaigntable.bloodBankId = bloodbank.bloodBankId 
        where campaigntable.bloodBankId = ?";

        $stmt = $con->prepare($query);
        $stmt->bindValue(1, $bloodBankId, PDO::PARAM_INT);
        $stmt->execute();

        $dataArray = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dataArray[] = $row;
        }

        return $dataArray;
    } catch (PDOException $e) {
        echo "Database Connection Error: " . $e->getMessage();
    }
    
}



public function EditCampaign() {
    try {
        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();


 $query = "UPDATE `campaigntable` SET `Title` = ?, `address` = ?, `startDate` = ?, `endDate` = ?, `review` = ?, `status` = ?, `districtId` = ?, `bloodBankId` = ? WHERE `campaignId` = ?";


        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->Title, PDO::PARAM_STR);
        $pstmt->bindValue(2, $this->address, PDO::PARAM_STR);
        $pstmt->bindValue(3, $this->startDate, PDO::PARAM_STR);
        $pstmt->bindValue(4, $this->endDate, PDO::PARAM_STR);
        $pstmt->bindValue(5, $this->review, PDO::PARAM_STR);
        $pstmt->bindValue(6, $this->status, PDO::PARAM_STR);
       $pstmt->bindValue(7, $this->districtId, PDO::PARAM_INT);
       $pstmt->bindValue(8, $this->bloodBankId, PDO::PARAM_INT);

       if ($pstmt->execute()) {
        return true; // Successful update
    } else {
        return false; // Update failed
    }
} catch (PDOException $e) {
    error_log("Error: " . $e->getMessage());
    return false;
    }
}

/*

// Create a function to fetch campaign details
function getCampaignDetails() {
    try {
        $dbcon = new DbConnector(); // Replace with your database connection code
        $con = $dbcon->getConnection();

        // Prepare a SQL query to select campaign details by campaignId
        $query = "SELECT Title, startDate, endDate, status FROM campaigntable WHERE campaignId = :campaignId";

        $pstmt = $con->prepare($query);
       // $pstmt->bindValue(':campaignId', $campaignId, PDO::PARAM_INT);
        $pstmt->bindValue(1, $this->Title, PDO::PARAM_STR);
        $pstmt->bindValue(2, $this->address, PDO::PARAM_STR);
        $pstmt->bindValue(3, $this->startDate, PDO::PARAM_STR);
        $pstmt->bindValue(4, $this->endDate, PDO::PARAM_STR);
        $pstmt->bindValue(5, $this->review, PDO::PARAM_STR);
        $pstmt->bindValue(6, $this->status, PDO::PARAM_STR);
       $pstmt->bindValue(7, $this->districtId, PDO::PARAM_INT);
       $pstmt->bindValue(8, $this->bloodBankId, PDO::PARAM_INT);
        $pstmt->execute();

        // Fetch the campaign details
        $campaignDetails = $pstmt->fetch(PDO::FETCH_ASSOC);

        return $campaignDetails;
    } catch (PDOException $e) {
        // Handle database connection or query errors here
        error_log("Error: " . $e->getMessage());
        return false;
    }
}*/ 



// Create a function to fetch campaign details
public function getCampaignDetails() {
    try {
        $dbcon = new DbConnector(); // Replace with your database connection code
        $con = $dbcon->getConnection();

        // Prepare a SQL query to select campaign details by campaignId
        $query = "SELECT Title, startDate, endDate, status FROM campaigntable WHERE campaignId = :campaignId";

        $pstmt = $con->prepare($query);
     //$pstmt->bindValue(':campaignId', PDO::PARAM_INT);
        $pstmt->bindValue(1, $this->Title, PDO::PARAM_STR);
        $pstmt->bindValue(2, $this->address, PDO::PARAM_STR);
        $pstmt->bindValue(3, $this->startDate, PDO::PARAM_STR);
        $pstmt->bindValue(4, $this->endDate, PDO::PARAM_STR);
        $pstmt->bindValue(5, $this->review, PDO::PARAM_STR);
        $pstmt->bindValue(6, $this->status, PDO::PARAM_STR);
       $pstmt->bindValue(7, $this->districtId, PDO::PARAM_INT);
       $pstmt->bindValue(8, $this->bloodBankId, PDO::PARAM_INT);
        $pstmt->execute();

        // Fetch the campaign details
        $campaignDetails = $pstmt->fetch(PDO::FETCH_ASSOC);

        return $campaignDetails;
    } catch (PDOException $e) {
        // Handle database connection or query errors here
        error_log("Error: " . $e->getMessage());
        return false;
    }
}


/*
public function UpdateCampaign() {
    try {
        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();

        $query = "UPDATE `campaigntable` SET `Title` = ?, `startDate` = ?, `endDate` = ?, `status` = ? WHERE `campaignId` = ?";

        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->Title, PDO::PARAM_STR);
        $pstmt->bindValue(2, $this->startDate, PDO::PARAM_STR);
        $pstmt->bindValue(3, $this->endDate, PDO::PARAM_STR);
        $pstmt->bindValue(4, $this->status, PDO::PARAM_STR);
        $pstmt->bindValue(5, $this->campaignId, PDO::PARAM_INT);

        if ($pstmt->execute()) {
            return true; // Successful update
        } else {
            return false; // Update failed
        }
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage());
        return false;
    }
}

*/


public function UpdateCampaign() {
    try {
        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();

        $query = "UPDATE `campaigntable` SET `Title` = ?, `address` = ?, `startDate` = ?, `endDate` = ?, `review` = ?, `status` = ?, `districtId` = ?, `bloodBankId` = ? WHERE `campaignId` = ?";

        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->Title, PDO::PARAM_STR);
        $pstmt->bindValue(2, $this->address, PDO::PARAM_STR);
        $pstmt->bindValue(3, $this->startDate, PDO::PARAM_STR);
        $pstmt->bindValue(4, $this->endDate, PDO::PARAM_STR);
        $pstmt->bindValue(5, $this->review, PDO::PARAM_STR);
        $pstmt->bindValue(6, $this->status, PDO::PARAM_STR);
        $pstmt->bindValue(7, $this->districtId, PDO::PARAM_INT);
        $pstmt->bindValue(8, $this->bloodBankId, PDO::PARAM_INT);
        $pstmt->bindValue(9, $this->campaignId, PDO::PARAM_INT); // Assuming you have a campaignId property in your class

        if ($pstmt->execute()) {
            return true; // Successful update
        } else {
            return false; // Update failed
        }
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage());
        return false;
    }
}






}










