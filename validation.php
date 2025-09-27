<?php


$fields = [
    'last_name',
    'first_name',
    'middle_name',
    'dob',
    'gender',
    'civil_status',
    'nationality',
    'religion',
    'tin',
    'unit',
    'unit2',
    'blk',
    'blk2',
    'street',
    'street2',
    'phone',
    'tele',
    'email',
    'flast',
    'ffirst',
    'fmiddle',
    'mlast',
    'mfirst',
    'mmiddle',
    'subdivision',
    'barangay',
    'city',
    'subdivision2',
    'barangay2',
    'city2',
    'province',
    'country',
    'zip',
    'province2',
    'country2',
    'zip2',
    'otherStatus'
];

$countries = [
    "United States",
    "Canada",
    "United Kingdom",
    "Australia",
    "Germany",
    "France",
    "India",
    "Japan",
    "China",
    "Philippines",
    "Brazil",
    "Mexico",
    "Italy",
    "Spain",
    "Russia",
    "South Korea",
    "South Africa",
    "Netherlands",
    "Sweden",
    "Switzerland",
    "New Zealand",
    "Argentina",
    "Colombia",
    "Thailand",
    "Vietnam",
    "Saudi Arabia",
    "United Arab Emirates",
    "Singapore",
    "Malaysia",
    "Indonesia",
    "Egypt",
    "Turkey",
    "Pakistan",
    "Bangladesh",
    "Nigeria",
    "Poland",
    "Ukraine",
    "Chile",
    "Portugal",
    "Greece",
    "Belgium",
    "Norway",
    "Denmark",
    "Finland",
    "Ireland",
    "Austria",
    "Israel",
    "Hong Kong",
    "Taiwan",
    "Romania",
    "Hungary"
];

// Function to validate form data
function validate_form_data($data)
{
    $errors = [];
    $otherStatus = $data['otherStatus'] ?? '';

    $required_fields = ['last_name', 'first_name', 'dob', 'gender', 'civil_status', 'nationality', 'religion', 'tin', 'unit', 'blk', 'street', 'subdivision', 'barangay', 'city', 'province', 'country', 'zip', 'unit2', 'blk2', 'street2', 'subdivision2', 'barangay2', 'city2', 'province2', 'country2', 'zip2', 'phone', 'email', 'flast', 'ffirst', 'fmiddle', 'mlast', 'mfirst', 'mmiddle'];

    foreach ($required_fields as $field) {
        if (empty($data[$field])) {
            $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . " is required.";
        }
    }

    // Validate Middle Name (Middle Initial)
    if (!empty($data['middle_name'])) {
        if (!preg_match("/^[a-zA-Z\.']+$/", $data['middle_name'])) {
            $errors['middle_name'] = "Middle Name must contain only letters, periods, or apostrophes.";
        }
    }

    // Validate Name Fields (Except Middle Name)
    $name_fields = ['last_name', 'first_name',  'flast', 'ffirst', 'fmiddle', 'mlast', 'mfirst', 'mmiddle'];
    foreach ($name_fields as $field) {
        if (empty($data[$field]) || preg_match("/^\s+$/", $data[$field])) {
            $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . " is required and cannot contain only spaces.";
        } elseif (!preg_match("/^[a-zA-Z\s']+$/", $data[$field])) {
            $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . " must contain only letters, spaces, or apostrophes.";
        }
    }

    // Last Name Validation
    if (empty($data['last_name']) || preg_match("/^\s+$/", $data['last_name'])) {
        $errors['last_name'] = "Last Name is required and cannot contain only spaces.";
    } elseif (!preg_match("/^[a-zA-Z\s\']+$/", $data['last_name'])) {
        $errors['last_name'] = "Last Name must contain only letters, spaces, or apostrophes.";
    }

    // First Name Validation
    if (empty($data['first_name']) || preg_match("/^\s+$/", $data['first_name'])) {
        $errors['first_name'] = "First Name is required and cannot contain only spaces.";
    } elseif (!preg_match("/^[a-zA-Z\s\']+$/", $data['first_name'])) {
        $errors['first_name'] = "First Name must contain only letters, spaces, or apostrophes.";
    }

    // Middle Name Validation
    if (!empty($data['middle_name']) && !preg_match("/^[a-zA-Z\s\']+$/", $data['middle_name'])) {
        $errors['middle_name'] = "Middle Name must contain only letters, spaces, or apostrophes.";
    }

    // Date of Birth Validation
    if (empty($data['dob'])) {
        $errors['dob'] = "Date of Birth is required.";
    } else {
        $birthDate = new DateTime($data['dob']);
        $today = new DateTime();
        $age = $today->diff($birthDate)->y;
        if ($age < 18) {
            $errors['dob'] = "You must be at least 18 years old.";
        }
    }

    // RELIGION AND NATIONALTY
    $inputNames = ['nationality', 'religion'];
    for ($j = 0; $j < count($inputNames); $j++) {
        if (!empty($data[$inputNames[$j]])) {
            $value = trim($data[$inputNames[$j]]);
            $isValid = true;

            for ($k = 0; $k < strlen($value); $k++) {
                if (is_numeric($value[$k])) {
                    $isValid = false;
                    break;
                }
            }

            if (!$isValid || ctype_space($value)) {
                $errors[$inputNames[$j]] = ucfirst($inputNames[$j]) . " must contain only letters.";
            }
        }
    }

    // Gender Validation
    if (empty($data['gender'])) {
        $errors['gender'] = "Gender is required.";
    }

    // Civil Status Validation
    if (empty($data['civil_status'])) {
        $errors['civil_status'] = "Civil Status is required.";
    }

    // If 'Others' is selected
    if ($data['civil_status'] == 'Others') {
        if (empty($otherStatus)) {
            $errors['otherStatus'] = "Please specify your civil status.";
        } elseif (!preg_match("/^[a-zA-Z\s]+$/", $otherStatus)) {
            $errors['otherStatus'] = "Civil status must contain only letters.";
        }
    }

    // TIN Validation
    if (empty($data['tin']) || preg_match("/^\s+$/", $data['tin'])) {
        $errors['tin'] = "Tax Identification No. is required and cannot contain only spaces.";
    } elseif (!preg_match("/^[0-9]{9,15}$/", $data['tin'])) {
        $errors['tin'] = "Tax Identification No. must contain only numbers (9-15 digits).";
    }
    if (!preg_match('/^[0-9]+$/', $data['tin'])) {
        $errors['tin'] = "TIN must contain only numbers.";
    }

    // Zip Code Validation
    if (empty($data['zip']) || preg_match("/^\s+$/", $data['zip'])) {
        $errors['zip'] = "Zip Code is required and cannot contain only spaces.";
    } elseif (!preg_match("/^[0-9]{4,6}$/", $data['zip'])) {
        $errors['zip'] = "Zip Code must contain only 4-6 digits.";
    }
    if (empty($data['zip2']) || preg_match("/^\s+$/", $data['zip2'])) {
        $errors['zip2'] = "Zip Code is required and cannot contain only spaces.";
    } elseif (!preg_match("/^[0-9]{4,6}$/", $data['zip2'])) {
        $errors['zip2'] = "Zip Code must contain only 4-6 digits.";
    }
    if (!preg_match('/^[0-9]+$/', $data['zip'])) {
        $errors['zip'] = "ZIP code must contain only numbers.";
    }
    if (!preg_match('/^[0-9]+$/', $data['zip2'])) {
        $errors['zip2'] = "ZIP code must contain only numbers.";
    }

    // Phone Validation
    if (empty($data['phone']) || preg_match("/^\s+$/", $data['phone'])) {
        $errors['phone'] = "Phone no. is required and cannot contain only spaces.";
    } elseif (!preg_match("/^[0-9]{11}$/", $data['phone'])) {
        $errors['phone'] = "Phone no. must contain only 11 digits.";
    }
    if (!preg_match('/^[0-9]+$/', $data['phone'])) {
        $errors['phone'] = "Phone no. must contain only numbers.";
    }

    // Telephone Validation
    if (empty($data['tele']) || preg_match("/^\s+$/", $data['tele'])) {
        $errors['tele'] = "Telephone no. is required and cannot contain only spaces.";
    } elseif (!preg_match('/^[0-9]+$/', $data['tele'])) {
        $errors['tele'] = "Telephone no. must contain only numbers.";
    } elseif (!preg_match("/^[0-9]{7,15}$/", $data['tele'])) {
        $errors['tele'] = "Telephone no. must contain  7-15 digits.";
    }

    // Email Validation
    if (empty($data['email']) || preg_match("/^\s+$/", $data['email'])) {
        $errors['email'] = "E-mail Address is required and cannot contain only spaces.";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    // OTHER STATUS
    if (!empty($otherStatus) && !preg_match("/^[a-zA-Z ]+$/", $otherStatus)) {
        $errors['otherStatus'] = "Must contain only letters.";
    }

    return $errors;
}

// Function to calculate age
function calculateAge($dob)
{
    $birthDate = new DateTime($dob);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;
    return $age;
}
