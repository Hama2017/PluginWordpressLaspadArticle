<?php
if (!defined('ABSPATH')) exit;

?>
    <form method="post" enctype="multipart/form-data" class="mb-5">
        <?php wp_nonce_field('laspad_csv_import', '_wpnonce_laspad'); ?>
        
        <div class="mb-3">
            <label for="csv_file" class="form-label">Choisissez un fichier CSV</label>
            <input type="file" name="csv_file" id="csv_file" accept=".csv" class="form-control" required>
        </div>
        
        <button type="submit" name="upload_csv" class="laspad-btn laspad-btn-link">Téléverser le fichier CSV</button>
    </form> 
    
<?php
?>