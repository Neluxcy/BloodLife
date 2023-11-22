<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<?php


require_once '../classes/bloodBank.php';
require_once '../classes/district.php';

use classes\bloodBank;
use classes\district;
?>

<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        .buttoncolor {
            background-color: #f44336;
        }

        /* Red */

        /* CSS to set a consistent width for input elements */
        input[type="text"],
        input[type="tel"],
        input[type="email"],

        select {
            width: 100%;
            /* Set the width to 100% */
            box-sizing: border-box;
            /* Include padding and border in the total width */
        }

        .valid {
            color: green;
        }

        .not-valid {
            color: red;
        }
    </style>
</head>

<body>

    <!-- nav bar start -->
    <div class="sticky-top bg-white shadownav" style="height: 50px;">
        <div class="row m-0 d-flex">
            <div class="col-8">

            </div>


            <div class="col-4">
                <div class="row align-items-center">
                    <div class="col-2 mb-2">

                    </div>
                    <div class="col-2 mb-2">

                    </div>
                    <div class="col-2 mb-2">

                    </div>
                    <div class="col-6 mt-2 	d-none d-xl-block">
                        <b>Jaffna Blood Bank</b>
                        <p style="font-size: 10px;">Blood Bank</p>
                    </div>
                </div>

            </div>


        </div>
    </div>
    <!-- nav bar end -->

    <!-- body start -->
    <div class="mt-5 m-3 mb-1" style="color:gray;">

        <h5>Admin - Blood Bank Management</h5>
    </div>


    <!-- Table -->

    <div class="p-5 pt-3">


        <div class="rounded-top-4 p-0 ">
            <div class="row align-items-center">
                <div class="col-3">
                    <div class="input-group rounded p-3">
                        <input type="search" id="search" class="form-control rounded" placeholder="Search Name" aria-label="Search" aria-describedby="search-addon" oninput="teeest(this.value)">



                    </div>
                </div>


                <div class="col-3">
                    <select class="form-select" aria-label="Default select example" oninput="teest(this.value)">
                        <option selected>District</option>
                        <?php
                        $dataArray = district::getAllDistrict(); // Retrieve district data using the "getAllDistrict()" method

                        foreach ($dataArray as $district) {
                        ?>

                            <option value="<?php echo $district['district']; ?>"><?php echo $district['district']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-3">
                </div>
                <div class="col-3">
                    <button type="button" class="btn btn-outline-primary " onclick="AddBloodbank()"><strong>Add Blood Bank</strong></button>

                </div>


            </div>

        </div>
        <!-- Table body -->
        <div class="container bg-white m-0 p-0" style=" max-height: 500px; overflow: scroll;">
            <table class="table table-hover p-0">
                <thead>
                    <!-- Table row -->
                    <tr class="sticky-top">


                        <th class="col-2 bgcol p-2" style="text-align: center;">BloodBank ID</th>
                        <th class="col-2 bgcol p-2" style="text-align: center;">BloodBank Name</th>
                        <th class="col-2 bgcol p-2" style="text-align: center;">Address</th>
                        <th class="col-2 bgcol p-2" style="text-align: center;">Contact Number</th>
                        <th class="col-1 bgcol p-2" style="text-align: center;">District</th>
                        <th class="col-1 bgcol p-2" style="text-align: center;">Division</th>

                        <th class="col-1 bgcol p-2" style="text-align: center;">View</th>
                        <th class="col-1 bgcol p-2" style="text-align: center;">Edit</th>

                    </tr>
                </thead>

               

                <tbody id="output">

                    <?php
                    $bloodbankdetailsArray = bloodBank::showAllBloodbank();
                    ?>

                    <script>
                        let array = <?php echo json_encode($bloodbankdetailsArray) ?>;
                        let filterArray;
                        showall(array);

                        function showall(array) {
                            const detailsList = document.getElementById("output");
                            detailsList.innerHTML = "";
                            if (array === null || array.length === 0) {
                                var htmlCode = `<tr><td colspan="12" style="text-align: center;color: red;" >No Results Found</td></tr>`;
                                detailsList.innerHTML = htmlCode;
                            } else {
                                array.forEach((item) => {

                                    var htmlCode = ` <tr>

                        <td class="col-2" style="text-align: center;">${item.bloodBankId}</td>
                        <td class="col-2" style="text-align: center;">${item.bloodBankName}</td>
                        <td class="col-2" style="text-align: center;">${item.Address}</td>
                        <td class="col-2" style="text-align: center;">${item.ContactNo}</td>                    
                        <td class="col-1" style="text-align: center;">${item.district}</td>
                        <td class="col-1" style="text-align: center;">${item.division}</td>
                        <td class="col-1" style="text-align: center;"><i class="fas fa-eye fa-lg" style="color: #007BFF;" data-bs-toggle="modal" data-bs-target="#veiwBloodbank" onclick="VeiwBloodbank(${item.bloodBankId})"></i></td>

                        <td class="col-1" style="text-align: center;"><i class="fas fa-edit fa-lg" style="color: #007BFF;" data-bs-toggle="modal" data-bs-target="#editBloodbank" onclick="editBloodbank(${item.bloodBankId})"></i></td>

                    </tr>`;


                                    var divElement = document.createElement("tr");


                                    divElement.innerHTML = htmlCode;


                                    detailsList.appendChild(divElement);
                                });
                            };

                        }

                        function teest1(test) {
                            if (test === "") {
                                array = <?php echo json_encode($bloodbankdetailsArray) ?>;
                                showall(array);
                            } else {
                                array = <?php echo json_encode($bloodbankdetailsArray) ?>;
                                var testValue = test.toLowerCase();
                                array = array.filter((item) => item.district.toLowerCase().includes(testValue));
                                showall(array);
                            }

                        }

                        function teeest1(test) {

                            var id = parseInt(test, 10);

                            var testValue = test.toLowerCase();

                            filterArray = array.filter((item) => item.bloodBankId === id || item.name.toLowerCase().includes(testValue));


                            const detailsList = document.getElementById("output");
                            detailsList.innerHTML = "";
                            if (filterArray === null || filterArray.length === 0) {
                                var htmlCode = `<tr><td colspan="12" style="text-align: center;color: red;">No Results Found</td></tr>`;
                                detailsList.innerHTML = htmlCode;
                            } else {
                                filterArray.forEach((item) => {

                                    var htmlCode = ` 
                            <tr>

                                <td class="col-2" style="text-align: center;">${item.bloodBankId}</td>
                                <td class="col-2" style="text-align: center;">${item.bloodBankName}</td>
                                <td class="col-2" style="text-align: center;">${item.Address}</td>
                                <td class="col-2" style="text-align: center;">${item.ContactNo}</td>
                                <td class="col-1" style="text-align: center;">${item.district}</td>
                                <td class="col-1" style="text-align: center;">${item.division}</td>
                                <td class="col-1" style="text-align: center;"><i class="fas fa-eye fa-lg" style="color: #007BFF;" data-bs-toggle="modal" data-bs-target="#veiwBloodbank" onclick="VeiwBloodbank(${item.bloodBankId})"></i></td>
                                <td class="col-1" style="text-align: center;"><i class="fas fa-edit fa-lg" style="color: #007BFF;" data-bs-toggle="modal" data-bs-target="#editBloodbank" onclick="editBloodbank(${item.bloodBankId})"></i></td>

                    </tr>`;


                                    var divElement = document.createElement("tr");


                                    divElement.innerHTML = htmlCode;


                                    detailsList.appendChild(divElement);

                                });
                            }


                        }
                    </script>


                </tbody>
            </table>
        </div>
        <br>
    </div>

   

    <!--add blood bank-->
    <!-- Modal -->
    <form action="../services/bloodbankservices.php" method="POST" enctype="multipart/form-data">
        <div class="modal fade" id="addBloodbank">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addBloodbank">Add Blood bank</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        
                            <div class="row align-items-center pb-3">
                                <div class="col-3">
                                    <h6>Blood Bank Name</h6>
                                </div>
                                <div class="col-9">
                                    <input type="text" name="bloodBankName" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
                                </div>
                            </div>
                            <div class="row align-items-center pb-3">
                                <div class="col-3">
                                    <h6>Address</h6>
                                </div>
                                <div class="col-9">
                                    <input type="text" name="Address" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
                                </div>
                            </div>
                            <div class="row align-items-center pb-3">
                                <div class="col-3">
                                    <h6>District</h6>
                                </div>
                                <div class="col-9">
                                    <select name="district" class="form-control-sm form-control-sm" id="district" onchange="functionTest(this.value)">
                                        <option>Select District</option>
                                        <?php
                                        $dataArray = district::getAllDistrict(); // Retrieve district data using the "getAllDistrict()" method

                                        foreach ($dataArray as $district) {
                                        ?>

                                            <option value="<?php echo $district['district']; ?>"><?php echo $district['district']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row align-items-center pb-3">
                                <div class="col-3">
                                    <h6>DS Division</h6>
                                </div>
                                <div class="col-9">
                                    <select name="division" class="form-control-sm form-control-sm" id="divisionDropDown" onchange="getBloodBank(this.value)">
                                        <option>Select Division</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row align-items-center pb-3">
                                <div class="col-3">
                                    <h6>Contact No</h6>
                                </div>
                                <div class="col-9">
                                    <input type="text" name="ContactNo" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required id="contactNumberInput" oninput="validateMobileNumber(this.value)">
                                    <p id="validationResult"></p>
                                </div>
                            </div>
                            <div class="row align-items-center pb-3">
                                <div class="col-3">
                                    <h6>Email</h6>
                                </div>
                                <div class="col-9">
                                    <input type="email" name="email" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
                                </div>
                            </div>
                            <input type="hidden" name="token" value="<?php echo $token; ?>" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>

                            <!-- <input type="hidden" name="bloodBankId" value="<?php echo $bloodBankId; ?> " aria-label="Sizing example input" aria-discribedby="inputGroup-sizing-sm" required> -->

                        </div>

                        <div class="modal-footer">

                            <button type="submit" class="btn btn-outline-primary"><strong>Save</strong> </button>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><strong>Cancel</strong></button>

                        </div>
                    </div>
                </div>
            </div>

    </form>




<!--editBloodbankDetails-->
    <!-- Modal -->
    
    <form action="../services/editBloodbankservices.php" method="POST" enctype="multipart/form-data">
    <div class="modal fade" id="editBloodbank">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editBloodbank">Edit Blood bank</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" >
                    <div id ="bloodbankEdit"></div>
                    <input type="hidden" name="token" value="<?php echo $token; ?>" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>

                </div>

                <div class="modal-footer">


                    <button type="submit" class="btn btn-outline-primary"><strong>Save </strong></button>
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deletePopup3"><strong>Delete</strong></button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><strong>Cancel</strong></button>
                </div>
            </div>
        </div>
    </div>
    </form>

    <!-- Modal View Blood bank Details-->
    <!-- Modal -->
    <div class="modal fade" id="veiwBloodbank">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="veiwBloodbank">View Blood bank Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="bloodbankVeiw">

                <input type="hidden" name="token" value="<?php echo $token; ?>" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>

                </div>

                <div class="modal-footer">
                   <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><strong>Cancel</strong></button>

                </div>
            </div>
        </div>
    </div>



    <?php
    // put your code here
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="../JS/Admindash.js"></script>
    <script src="../JS/DashboardJS.js"></script>
</body>

</html>