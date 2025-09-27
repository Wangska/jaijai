<?php
session_start();

include 'validation.php';

// Determine current page
$page = $_GET['page'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['form_data'] = $_POST;

    $errors = validate_form_data($_POST);

    $_SESSION['errors'] = $errors;

    $isValidPage = $_POST['isValidPage' . $page] ?? 'true';
    if (!empty($errors) || $isValidPage === 'false') {
        $_SESSION['page_' . $page . '_has_errors'] = true;
    } else {
        unset($_SESSION['page_' . $page . '_has_errors']);
    }

    if ($page < 4) {
        header("Location: ?page=" . ($page + 1));
        exit();
    } else {
        if (empty($errors)) {
            // Include database connection
            include 'db_connector.php';
            
            // Calculate age
            $birthDate = new DateTime($_POST['dob']);
            $today = new DateTime();
            $age = $today->diff($birthDate)->y;
            
            // Prepare data for insertion
            $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
            $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
            $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
            $flast = mysqli_real_escape_string($conn, $_POST['flast']);
            $ffirst = mysqli_real_escape_string($conn, $_POST['ffirst']);
            $fmiddle = mysqli_real_escape_string($conn, $_POST['fmiddle']);
            $mlast = mysqli_real_escape_string($conn, $_POST['mlast']);
            $mfirst = mysqli_real_escape_string($conn, $_POST['mfirst']);
            $mmiddle = mysqli_real_escape_string($conn, $_POST['mmiddle']);
            $dob = mysqli_real_escape_string($conn, $_POST['dob']);
            $gender = mysqli_real_escape_string($conn, $_POST['gender']);
            $civil_status = mysqli_real_escape_string($conn, $_POST['civil_status']);
            $otherStatus = mysqli_real_escape_string($conn, $_POST['otherStatus'] ?? '');
            $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
            $religion = mysqli_real_escape_string($conn, $_POST['religion']);
            $tin = mysqli_real_escape_string($conn, $_POST['tin']);
            $unit = mysqli_real_escape_string($conn, $_POST['unit']);
            $blk = mysqli_real_escape_string($conn, $_POST['blk']);
            $street = mysqli_real_escape_string($conn, $_POST['street']);
            $subdivision = mysqli_real_escape_string($conn, $_POST['subdivision']);
            $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
            $city = mysqli_real_escape_string($conn, $_POST['city']);
            $province = mysqli_real_escape_string($conn, $_POST['province']);
            $country = mysqli_real_escape_string($conn, $_POST['country']);
            $zip = mysqli_real_escape_string($conn, $_POST['zip']);
            $unit2 = mysqli_real_escape_string($conn, $_POST['unit2']);
            $blk2 = mysqli_real_escape_string($conn, $_POST['blk2']);
            $street2 = mysqli_real_escape_string($conn, $_POST['street2']);
            $subdivision2 = mysqli_real_escape_string($conn, $_POST['subdivision2']);
            $barangay2 = mysqli_real_escape_string($conn, $_POST['barangay2']);
            $city2 = mysqli_real_escape_string($conn, $_POST['city2']);
            $province2 = mysqli_real_escape_string($conn, $_POST['province2']);
            $country2 = mysqli_real_escape_string($conn, $_POST['country2']);
            $zip2 = mysqli_real_escape_string($conn, $_POST['zip2']);
            $phone = mysqli_real_escape_string($conn, $_POST['phone']);
            $tele = mysqli_real_escape_string($conn, $_POST['tele']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            
            // SQL INSERT statement
            $sql = "INSERT INTO personal_data (
                last_name, first_name, middle_name, flast, ffirst, fmiddle, 
                mlast, mfirst, mmiddle, dob, gender, civil_status, otherStatus, 
                nationality, religion, tin, unit, blk, street, subdivision, 
                barangay, city, province, country, zip, unit2, blk2, street2, 
                subdivision2, barangay2, city2, province2, country2, zip2, 
                phone, tele, email, age
            ) VALUES (
                '$last_name', '$first_name', '$middle_name', '$flast', '$ffirst', '$fmiddle',
                '$mlast', '$mfirst', '$mmiddle', '$dob', '$gender', '$civil_status', '$otherStatus',
                '$nationality', '$religion', '$tin', '$unit', '$blk', '$street', '$subdivision',
                '$barangay', '$city', '$province', '$country', '$zip', '$unit2', '$blk2', '$street2',
                '$subdivision2', '$barangay2', '$city2', '$province2', '$country2', '$zip2',
                '$phone', '$tele', '$email', '$age'
            )";
            
            if (mysqli_query($conn, $sql)) {
                // Close connection
                mysqli_close($conn);
                // Clear session data after successful insertion
                unset($_SESSION['form_data']);
                unset($_SESSION['errors']);
                header("Location: output.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                mysqli_close($conn);
                exit();
            }
        }
    }
}

// Retrieve errors and form data from session
$errors = $_SESSION['errors'] ?? [];
$form_data = $_SESSION['form_data'] ?? [];

// Form fields values
$last_name = $form_data['last_name'] ?? '';
$first_name = $form_data['first_name'] ?? '';
$middle_name = $form_data['middle_name'] ?? '';
$dob = $form_data['dob'] ?? '';
$gender = $form_data['gender'] ?? '';
$civil_status = $form_data['civil_status'] ?? '';
$nationality = $form_data['nationality'] ?? '';
$religion = $form_data['religion'] ?? '';
$tin = $form_data['tin'] ?? '';
$unit = $form_data['unit'] ?? '';
$blk = $form_data['blk'] ?? '';
$street = $form_data['street'] ?? '';
$phone = $form_data['phone'] ?? '';
$email = $form_data['email'] ?? '';
$flast = $form_data['flast'] ?? '';
$ffirst = $form_data['ffirst'] ?? '';
$fmiddle = $form_data['fmiddle'] ?? '';
$mlast = $form_data['mlast'] ?? '';
$mfirst = $form_data['mfirst'] ?? '';
$mmiddle = $form_data['mmiddle'] ?? '';
$subdivision = $form_data['subdivision'] ?? '';
$barangay = $form_data['barangay'] ?? '';
$city = $form_data['city'] ?? '';
$province = $form_data['province'] ?? '';
$country = $form_data['country'] ?? '';
$country2 = $form_data['country2'] ?? '';
$zip = $form_data['zip'] ?? '';
$zip2 = $form_data['zip2'] ?? '';
$unit2 = $form_data['unit2'] ?? '';
$blk2 = $form_data['blk2'] ?? '';
$street2 = $form_data['street2'] ?? '';
$subdivision2 = $form_data['subdivision2'] ?? '';
$barangay2 = $form_data['barangay2'] ?? '';
$city2 = $form_data['city2'] ?? '';
$province2 = $form_data['province2'] ?? '';
$phone = $form_data['phone'] ?? '';
$email = $form_data['email'] ?? '';
$tele = $form_data['tele'] ?? '';
$otherStatus = $form_data['otherStatus'] ?? '';
?>



<select name="country" class="<?php echo isset($errors['country']) ? 'error' : ''; ?> <?php echo ($page != 3) ? 'hide-country' : ''; ?>" style="display: none;">
    <?php for ($i = 0; $i < count($countries); $i++) { ?>
        <option value="<?php echo $countries[$i]; ?>" <?php echo ($country == $countries[$i]) ? 'selected' : ''; ?>>
            <?php echo $countries[$i]; ?>
        </option>
    <?php } ?>
</select>
<span class="error"><?php echo isset($errors['country']) ? $errors['country'] : ''; ?></span>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <title>Form</title>

</head>

<body>
    <div class="header">
        <img src="pics/F_LOGO.png" class="logo">
        <p class="h_label">Personal Data</p>
    </div>
    <!-- Step Progress Bar -->
    <div class="progress-container">
        <div class="step">
            <div class="progress-step" data-step="1">1</div>
            <p class="progress-title">Personal Details</p>
        </div>
        <div class="step">
            <div class="progress-step" data-step="2">2</div>
            <p class="progress-title">Place of Birth</p>
        </div>
        <div class="step">
            <div class="progress-step" data-step="3">3</div>
            <p class="progress-title">Home Address</p>
        </div>
        <div class="step">
            <div class="progress-step" data-step="4">4</div>
            <p class="progress-title">Parental Information</p>
        </div>
    </div>

    <div class="main-wrapper">
        <section class="main">
            <form id="multiStepForm" method="POST" action="?page=<?php echo $page; ?>">
                <section class="wrapper" id="pageContainer" data-page="<?php echo $page; ?>">
                    <!-- Page 1 -->
                    <div class="page1" style="display: <?php echo ($page == 1) ? 'block' : 'none'; ?>">
                        <p class="sublabel1"> Personal Information </p>

                        <div class="row1">
                            <div>
                                <label for="lastname">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="<?php echo isset($errors['last_name']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($last_name); ?>">
                                <span class="error"><?php echo isset($errors['last_name']) ? $errors['last_name'] : ''; ?></span>
                            </div>

                            <div>
                                <label for="firstname">First Name</label>
                                <input type="text" name="first_name" id="firstname" class="<?php echo isset($errors['first_name']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($first_name); ?>">
                                <span class="error"><?php echo isset($errors['first_name']) ? $errors['first_name'] : ''; ?></span>
                            </div>
                            <div>
                                <label for="middle">Middle Initial</label>
                                <input type="text" name="middle_name" id="middle" class="<?php echo isset($errors['middle_name']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($middle_name); ?>">
                                <span class="error"><?php echo isset($errors['middle_name']) ? $errors['middle_name'] : ''; ?></span>
                            </div>
                        </div>

                        <!-- Date of Birth -->
                        <div class="details-grid">
                            <div>
                                <label>Date of Birth</label>
                                <input type="date" name="dob" class="<?php echo isset($errors['dob']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($dob); ?>">
                                <span class="error"><?php echo isset($errors['dob']) ? $errors['dob'] : ''; ?></span>
                            </div>

                            <!-- Gender -->
                            <div>
                                <label>Sex</label>
                                <div class="sex-options">
                                    <label><input type="radio" name="gender" value="Male" <?php echo $gender === 'Male' ? 'checked' : ''; ?>> Male</label>
                                    <label><input type="radio" name="gender" value="Female" <?php echo $gender === 'Female' ? 'checked' : ''; ?>> Female</label>
                                </div>
                                <span class="error"><?php echo isset($errors['gender']) ? $errors['gender'] : ''; ?></span>
                            </div>

                            <!-- Civil Status -->
                            <div class="status-container">
                                <label id="civilStatusLabel">Civil Status</label>
                                <select id="civilStatus" name="civil_status" class="<?php echo isset($errors['civil_status']) ? 'error' : ''; ?>">
                                    <option value="Single" <?php echo ($civil_status == "Single") ? "selected" : ""; ?>>Single</option>
                                    <option value="Married" <?php echo ($civil_status == "Married") ? "selected" : ""; ?>>Married</option>
                                    <option value="Widowed" <?php echo ($civil_status == "Widowed") ? "selected" : ""; ?>>Widowed</option>
                                    <option value="Legally Separated" <?php echo ($civil_status == "Legally Separated") ? "selected" : ""; ?>>Legally Separated</option>
                                    <option value="Others" <?php echo ($civil_status == "Others") ? "selected" : ""; ?>>Others</option>
                                </select>

                                <!-- Hidden input field for "Others" option -->
                                <input type="text" id="otherStatus" name="otherStatus" class="<?php echo isset($errors['otherStatus']) ? 'error' : ''; ?>" placeholder="Enter your civil status"
                                    value="<?php echo ($civil_status == 'Others') ? htmlspecialchars($otherStatus) : ''; ?>"
                                    style="display: <?php echo ($civil_status == 'Others') ? 'inline-block' : 'none'; ?>;">
                                <span class="error"><?php echo isset($errors['otherStatus']) ? $errors['otherStatus'] : ''; ?></span>

                            </div>

                            <!-- Nationality -->
                            <div>
                                <label for="nationality">Nationality</label>
                                <input type="text" name="nationality" class="<?php echo isset($errors['nationality']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($nationality); ?>">
                                <span class="error"><?php echo isset($errors['nationality']) ? $errors['nationality'] : ''; ?></span>
                            </div>

                            <!-- Religion -->
                            <div>
                                <label for="religion">Religion</label>
                                <input type="text" name="religion" class="<?php echo isset($errors['religion']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($religion); ?>">
                                <span class="error"><?php echo isset($errors['religion']) ? $errors['religion'] : ''; ?></span>
                            </div>

                            <!-- TIN -->
                            <div>
                                <label for="tax">Tax Identification No.</label>
                                <input type="text" name="tin" class="<?php echo isset($errors['tin']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($tin); ?>">
                                <span class="error"><?php echo isset($errors['tin']) ? $errors['tin'] : ''; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Page 2 -->
                    <div class="page2" style="display: <?php echo ($page == 2) ? 'block' : 'none'; ?>">
                        <p class="sublabel2"> Place of Birth </p>
                        <div class="place-grid">
                            <div>
                                <label for="unit">RM/FLR/Unit No. & Bldg. Name</label>
                                <input type="text" name="unit" class="<?php echo isset($errors['unit']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($unit); ?>">
                                <span class="error"><?php echo isset($errors['unit']) ? $errors['unit'] : ''; ?></span>
                            </div>
                            <div>
                                <label for="blk">House/Lot & Blk. No</label>
                                <input type="text" name="blk" class="<?php echo isset($errors['blk']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($blk); ?>">
                                <span class="error"><?php echo isset($errors['blk']) ? $errors['blk'] : ''; ?></span>
                            </div>
                            <div>
                                <label for="street">Street Name</label>
                                <input type="text" name="street" class="<?php echo isset($errors['street']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($street); ?>">
                                <span class="error"><?php echo isset($errors['street']) ? $errors['street'] : ''; ?></span>
                            </div>
                            <div>
                                <label for="subdivision">Subdivision</label>
                                <input type="text" name="subdivision" class="<?php echo isset($errors['subdivision']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($subdivision); ?>">
                                <span class="error"><?php echo isset($errors['subdivision']) ? $errors['subdivision'] : ''; ?></span>
                            </div>

                            <div>
                                <label for="barangay">Barangay/District/Locality</label>
                                <input type="text" name="barangay" class="<?php echo isset($errors['barangay']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($barangay); ?>">
                                <span class="error"><?php echo isset($errors['barangay']) ? $errors['barangay'] : ''; ?></span>
                            </div>

                            <div>
                                <label for="city">City/Municipality</label>
                                <input type="text" name="city" class="<?php echo isset($errors['city']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($city); ?>">
                                <span class="error"><?php echo isset($errors['city']) ? $errors['city'] : ''; ?></span>
                            </div>

                            <div>
                                <label for="province">Province</label>
                                <input type="text" name="province" class="<?php echo isset($errors['province']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($province); ?>">
                                <span class="error"><?php echo isset($errors['province']) ? $errors['province'] : ''; ?></span>
                            </div>

                            <div>
                                <label for="country">Country</label>
                                <select name="country" id="country" class="<?php echo isset($errors['country']) ? 'error' : ''; ?>">
                                    <?php for ($i = 0; $i < count($countries); $i++) { ?>
                                        <option value="<?php echo $countries[$i]; ?>" <?php echo ($country == $countries[$i]) ? 'selected' : ''; ?>>
                                            <?php echo $countries[$i]; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <span class="error"><?php echo isset($errors['country']) ? $errors['country'] : ''; ?></span>
                            </div>

                            <div>
                                <label for="zip">Zip Code</label>
                                <input type="text" name="zip" class="<?php echo isset($errors['zip']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($zip); ?>">
                                <span class="error"><?php echo isset($errors['zip']) ? $errors['zip'] : ''; ?></span>
                            </div>

                        </div>
                    </div>

                    <!-- Page 3 -->
                    <div class="page3" style="display: <?php echo ($page == 3) ? 'block' : 'none'; ?>">
                        <p class="sublabel3"> Home Address </p>
                        <div class="address-grid">
                            <div>
                                <label for="unit">RM/FLR/Unit No. & Bldg. Name</label>
                                <input type="text" name="unit2" class="<?php echo isset($errors['unit2']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($unit2); ?>">
                                <span class="error"><?php echo isset($errors['unit2']) ? $errors['unit2'] : ''; ?></span>
                            </div>
                            <div>
                                <label for="blk2">House/Lot & Blk. No</label>
                                <input type="text" name="blk2" class="<?php echo isset($errors['blk2']) ? 'error' : ''; ?>"
                                    value="<?php echo htmlspecialchars($blk2, ENT_QUOTES, 'UTF-8'); ?>">
                                <span class="error"><?php echo isset($errors['blk2']) ? $errors['blk2'] : ''; ?></span>
                            </div>
                            <div>
                                <label for="street2">Street Name</label>
                                <input type="text" name="street2" class="<?php echo isset($errors['street2']) ? 'error' : ''; ?>"
                                    value="<?php echo htmlspecialchars($street2, ENT_QUOTES, 'UTF-8'); ?>">
                                <span class="error"><?php echo isset($errors['street2']) ? $errors['street2'] : ''; ?></span>
                            </div>
                            <div>
                                <label for="subdivision">Subdivision</label>
                                <input type="text" name="subdivision2" class="<?php echo isset($errors['subdivision2']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($subdivision2); ?>">
                                <span class="error"><?php echo isset($errors['subdivision2']) ? $errors['subdivision2'] : ''; ?></span>
                            </div>

                            <div>
                                <label for="barangay">Barangay/District/Locality</label>
                                <input type="text" name="barangay2" class="<?php echo isset($errors['barangay2']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($barangay2); ?>">
                                <span class="error"><?php echo isset($errors['barangay2']) ? $errors['barangay2'] : ''; ?></span>
                            </div>

                            <div>
                                <label for="city">City/Municipality</label>
                                <input type="text" name="city2" class="<?php echo isset($errors['city2']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($city2); ?>">
                                <span class="error"><?php echo isset($errors['city2']) ? $errors['city2'] : ''; ?></span>
                            </div>

                            <div>
                                <label for="province">Province</label>
                                <input type="text" name="province2" class="<?php echo isset($errors['province2']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($province2); ?>">
                                <span class="error"><?php echo isset($errors['province2']) ? $errors['province2'] : ''; ?></span>
                            </div>

                            <div>
                                <label for="country">Country</label>
                                <select name="country2" class="<?php echo isset($errors['country2']) ? 'error' : ''; ?> <?php echo ($page != 3) ? 'hide-country' : ''; ?>">
                                    <?php for ($i = 0; $i < count($countries); $i++) { ?>
                                        <option value="<?php echo $countries[$i]; ?>" <?php echo ($country2 == $countries[$i]) ? 'selected' : ''; ?>>
                                            <?php echo $countries[$i]; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <span class="error"><?php echo isset($errors['country2']) ? $errors['country2'] : ''; ?></span>
                            </div>

                            <div>
                                <label for="zip">Zip Code</label>
                                <input type="text" name="zip2" class="<?php echo isset($errors['zip2']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($zip2); ?>">
                                <span class="error"><?php echo isset($errors['zip2']) ? $errors['zip2'] : ''; ?></span>
                            </div>

                            <div>
                                <label for="phone">Phone No.</label>
                                <input type="text" name="phone" class="<?php echo isset($errors['phone']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($phone); ?>">
                                <span class="error"><?php echo isset($errors['phone']) ? $errors['phone'] : ''; ?></span>
                            </div>
                            <div>
                                <label for="email">E-mail Address</label>
                                <input type="text" name="email" class="<?php echo isset($errors['email']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($email); ?>">
                                <span class="error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
                            </div>
                            <div>
                                <label for="tele">Telephone</label>
                                <input type="text" name="tele" class="<?php echo isset($errors['tele']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($tele); ?>">
                                <span class="error"><?php echo isset($errors['tele']) ? $errors['tele'] : ''; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Page 4 -->
                    <div class="page4" style="display: <?php echo ($page == 4) ? 'block' : 'none'; ?>">
                        <p class="sublabel4"> Parental Information </p>
                        <div class="parent-grid">
                            <p class="section-label">Father's Name</p>
                            <div>
                                <label for="flast">Last Name</label>
                                <input type="text" name="flast" class="<?php echo isset($errors['flast']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($flast); ?>">
                                <span class="error"><?php echo isset($errors['flast']) ? $errors['flast'] : ''; ?></span>
                            </div>
                            <div>
                                <label for="ffirst">First Name</label>
                                <input type="text" name="ffirst" class="<?php echo isset($errors['ffirst']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($ffirst); ?>">
                                <span class="error"><?php echo isset($errors['ffirst']) ? $errors['ffirst'] : ''; ?></span>
                            </div>
                            <div>
                                <label for="fmiddle">Middle Name</label>
                                <input type="text" name="fmiddle" class="<?php echo isset($errors['fmiddle']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($fmiddle); ?>">
                                <span class="error"><?php echo isset($errors['fmiddle']) ? $errors['fmiddle'] : ''; ?></span>
                            </div>

                            <p class="section-label1">Mother's Maiden Name</p>
                            <div>
                                <label for="mlast">Last Name</label>
                                <input type="text" name="mlast" class="<?php echo isset($errors['mlast']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($mlast); ?>">
                                <span class="error"><?php echo isset($errors['mlast']) ? $errors['mlast'] : ''; ?></span>
                            </div>
                            <div>
                                <label for="mfirst">First Name</label>
                                <input type="text" name="mfirst" class="<?php echo isset($errors['mfirst']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($mfirst); ?>">
                                <span class="error"><?php echo isset($errors['mfirst']) ? $errors['mfirst'] : ''; ?></span>
                            </div>
                            <div>
                                <label for="mmiddle">Middle Name</label>
                                <input type="text" name="mmiddle" class="<?php echo isset($errors['mmiddle']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($mmiddle); ?>">
                                <span class="error"><?php echo isset($errors['mmiddle']) ? $errors['mmiddle'] : ''; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="btn"><button type="submit" class="next">Proceed</button></div>
                    <div class="btn1"><button type="submit" class="done">Submit</button></div>

                </section>
            </form>
        </section>
    </div>

    <section class="OUTPUT_DISPLAY" style="display: none;">
        <?php 'output.php'; ?>
    </section>

    <script src="main.js"></script>

</body>

</html>