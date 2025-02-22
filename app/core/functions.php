<?php

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
    die();
}
