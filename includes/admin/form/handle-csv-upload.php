<?php
if (!defined('ABSPATH')) exit;

// Include the script responsible for inserting CSV data into the database table
require_once laspad_plugin_path('includes/admin/form/insert-data-csv-to-table.php');

// Check if the CSV upload form has been submitted
if (isset($_POST['upload_csv'])) {

    // 1.1. Check user permissions
    if (!current_user_can('manage_options')) {
        return; // Stop execution if the user doesn’t have the required capability
    }

    // 1.2. Verify the Nonce (protection against CSRF attacks)
    // You must add a nonce field in your form (see section 2)
    if (!isset($_POST['_wpnonce_laspad']) || !wp_verify_nonce($_POST['_wpnonce_laspad'], 'laspad_csv_import')) {
        wp_die('Security error. Please try again.');
    }

    // 1.3. Retrieve the uploaded file
    $file = $_FILES['csv_file'];

    // 1.4. Validate the upload and check MIME type
    if ($file['error'] !== UPLOAD_ERR_OK || $file['type'] !== 'text/csv') {

        echo '<div class="alert alert-danger mt-2 container d-flex align-items-center justify-content-center">
                Error during upload or invalid file type. Please use a valid CSV file.
              </div>';

    } else {
        // If everything is valid, proceed to read and insert data into the table
        laspad_article_insert_data_csv_to_table($file['tmp_name']);
    }
}
?>
