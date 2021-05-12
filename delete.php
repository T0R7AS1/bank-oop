<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<div class="alert alert-danger">
    <h5>Neimanoma istrinti saskaitoje yra lesu</h5>
</div>
<?php
include './JsonConfig.php';
$saskaitos = new Operations;

if (!isset($_POST['id'])) {
    include 'layouts/errors.php';
    exit;
}
$saskaitosId = $_POST['id'];
$saskaitos->delete($saskaitosId);
?>