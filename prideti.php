<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
include 'layouts/header.php';
include './JsonConfig.php';
$saskaitos = new Operations;

if (!isset($_GET['id'])) {
    include 'layouts/errors.php';
    exit;
}

$saskaitosId = $_GET['id'];

$saskaita = $saskaitos->getId($saskaitosId);
if (!$saskaita) {
    include 'layouts/errors.php';
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $saskaitos->addToSum($_POST, $saskaitosId);
}
?>
<div class="container">
    <div class="row">
        <table class="table">
        <a href="index.php" class="btn btn-info">Atgal</a>
            <thead>
                <th>Vardas</th>
                <th>Pavarde</th>
                <th>Saskaitos likutis</th>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $saskaita['vardas']?></td>
                    <td><?php echo $saskaita['pavarde']?></td>
                    <td><?php echo $saskaita['likutis']?>Eur</td>
                </tr>
            </tbody>
        </table>
        <form method="POST">
            <div class="input-group-sm">
                <input type="text" class="input-group-text" name="likuti" >
                <button type="submit" class="btn btn-success btn-block mt-4">
                    Prideti Lesu
                </button>
            </div>
        </form>
    </div>
</div>
<?php include 'layouts/footer.php';?>
