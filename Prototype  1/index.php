<?php
include_once './stagiaire.php';
$dbh = new Dbh();
$stagiaireData = new Gestion($dbh);
$stagiareInfo = $stagiaireData->getStagaireInfo();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/style.css">
    <title>Document</title>
</head>
<body>
    <table>
        <tr>
            <th>Id</th>
            <th>Name</th>
        </tr>
            <?php
            foreach($stagiareInfo as $infoValue){
                ?>
                <tr>
                    <td>
                    <?= $infoValue->getId() ? $infoValue->getId() : "null" ?>
                    </td>
                    <td>
                    <?= $infoValue->getName() ? $infoValue->getName() : "null" ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        <?php
        ?>
    </table>
</body>
</html>