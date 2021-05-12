<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'layouts/header.php';
include ('./JsonConfig.php');
$saskaitos = new JsonConfig;
$saskaitos->connect();
$sort = $saskaitos->connect();
usort($sort, function ($a, $b) {
    return $a['pavarde'] <=> $b['pavarde'];
});
$url = new Operations;
$url->messages("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");

?>
<table class="table">
    <thead>
        <th>Vardas</th>
        <th>Pavarde</th>
        <th>Saskaita</th>
        <th>Asmens kodas</th>
        <th>Likutis</th>
        <th style="text-align:right; width: 30%" >Actions</th>
    </thead>
    <tbody>
        <?php foreach ($saskaitos->connect() as $val): ?>
            <tr>
                <td><?php echo $val['vardas']?></td>
                <td><?php echo $val['pavarde']?></td>
                <td><?php echo $val['saskaita']?></td>
                <td><?php echo $val['asmens_kodas']?></td>
                <td><?php echo $val['likutis']?>Eur</td>
                <td style="text-align:right;">
                <a href="prideti.php?id=<?php echo $val['id']?>" class="btn btn-success">Prideti Lesu</a>
                <a href="nuimti.php?id=<?php echo $val['id']?>" class="btn btn-warning">Nuskaiciuoti Lesu</a>
                <form action="delete.php" method="POST" class="d-inline-block">
                    <input type="hidden" name="id" value="<?php echo $val['id']?>" >
                    <button class="btn btn-danger">Istrinti</button>
                </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include 'layouts/footer.php';?>