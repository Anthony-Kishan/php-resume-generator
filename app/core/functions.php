<?php
// Helper class for validation

/**
 * Checks if a field is empty.
 * 
 * @param mixed $field The field to check.
 * @param string $fieldName The name of the field.
 * @return string|null Error message if the field is empty, otherwise null.
 */
function checkFieldEmpty($field, $fieldName)
{
    if (empty($field)) {
        return "$fieldName is required.";
    }
    return null;
}

/**
 * Validates the email format.
 * 
 * @param string $email The email to validate.
 * @return string|null Error message if the email format is invalid, otherwise null.
 */
function validateEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format.";
    }
    return null;
}

/**
 * Checks if the password is strong enough.
 * 
 * @param string $password The password to check.
 * @return string|null Error message if the password is not strong enough, otherwise null.
 */
function checkPassword($password)
{
    if (strlen($password) < 6) {
        return "Password must be at least 6 characters long.";
    }
    return null;
}

/**
 * Checks if the email already exists in the database.
 * 
 * @param string $email The email to check.
 * @return string|null Error message if the email exists, otherwise null.
 */
function checkEmailExists($email)
{
    $user = new User();
    if ($user->emailExists($email)) {
        return "Email is already taken.";
    }
    return null;
}

/**
 * Checks if the username already exists in the database.
 * 
 * @param string $username The username to check.
 * @return string|null Error message if the username exists, otherwise null.
 */
function checkUsernameExists($username)
{
    $user = new User();
    if ($user->usernameExists($username)) {
        return "Username is already taken.";
    }
    return null;
}


/**
 * Displays a variable in a readable format for debugging.
 *
 * This function wraps `print_r()` in a `<pre>` tag to output the contents
 * of a variable in a more human-readable, formatted style. This is useful
 * for debugging purposes, as it provides a clear and indented view of the
 * contents of arrays, objects, or other complex data types.
 *
 * @param mixed $stuff The variable to be printed. This can be any type,
 *                     including arrays, objects, or strings.
 *
 * @return void This function does not return anything. It outputs the data directly to the browser.
 */
function show($stuff)
{
    echo "<pre>";
    print_r($stuff);
    echo "</pre>";
}


/**
 * Escapes a string for safe HTML output.
 *
 * This function uses `htmlspecialchars()` to convert special characters
 * (such as <, >, &, etc.) in the provided string to their HTML entity equivalents.
 * This is useful for preventing XSS (Cross-Site Scripting) attacks by escaping
 * potentially dangerous characters before displaying user-generated content in HTML.
 *
 * @param string $str The string to be escaped.
 *
 * @return string The escaped string with special characters converted to HTML entities.
 */
function esc($str)
{
    return htmlspecialchars($str);
}


/**
 * Redirects the user to a specified path.
 *
 * This function sends an HTTP header to the browser to redirect the user
 * to a new URL. The URL is constructed using the constant `ROOT` and the
 * provided path. After sending the redirect header, the script is terminated
 * with `die()` to ensure no further code is executed.
 *
 * @param string $path The relative path to which the user should be redirected.
 *                     This will be appended to the base URL defined by the `ROOT` constant.
 *
 * @return void This function does not return anything. It terminates the script after redirecting.
 */
function redirect($path)
{
    header("Location: " . ROOT . "/" . $path);
    exit;
}



/**
 * Converts a camelCase or mixed-case string into a human-readable format with spaces and capitalized words.
 *
 * This function takes a string in camelCase or a similar format and converts it into a format where
 * each word is separated by a space, and the first letter of each word is capitalized. 
 * It helps transform field names like 'fullName' into 'Full Name' or 'phoneNumber' into 'Phone Number'.
 *
 * @param string $field The field name in camelCase or similar format.
 * @return string The formatted field name with spaces and capitalized words.
 */
function formatFieldName($field)
{
    // Add spaces before uppercase letters and capitalize the first letter of each word
    $formatted = preg_replace('/([a-z0-9])([A-Z])/', '$1 $2', $field);
    return ucfirst($formatted);
}