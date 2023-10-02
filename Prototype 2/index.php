<?php
include_once './gestions/gestions.php';
$stagiaireData = new GestionStagiaire($dbh);
$stagiaireDataArray = $stagiaireData->getStagiaireInfo();

if (isset($_POST['confirm_Data'])) {

    $manage = new Stagiaires();
    $manage->setName($_POST['name']);
    $manage->setCNE($_POST['cne']);
    $stagiaireData->addStagiaire($manage);
    header("Location: index.php");
}
if (isset($_POST['confirm_Update'])) {

    $update = new Stagiaires();
    $update->setId($_POST['personId']);
    $update->setName($_POST['name']);
    $update->setCNE($_POST['cne']);
    $stagiaireData->updateTrainner($update);
    header("Location: index.php");
}
if(isset($_POST['confirm_delete'])){
    $delete = new Stagiaires();
    $delete->setId($_POST['delete_id']);
    $stagiaireData->deleteTrainner($delete);
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/style.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <title>Add Person</title>
</head>

<body>
    <div class="container mt-5">
        <div class="text-center">
            <button type="button" class="btn btn-primary mb-5 add_new">Add New Trainer</button>
        </div>
    </div>
    <section class="mb-5 hide" id="hide">
        <div class="container mt-5">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="form-group">
                    <input type="hidden" id="person_Id" name="personId">
                    <label for="nom">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="cne">CNE</label>
                    <input type="text" class="form-control" id="cne" name="cne" required>
                </div>
                <input type="submit" name="confirm_Data" class="btn btn-primary" id="confirm" value="Confirm">
            </form>
        </div>
    </section>

    <table>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>CNE</th>
            <th>Action</th>
        </tr>
        <?php
        foreach ($stagiaireDataArray as $infoValue) {
            ?>
            <tr>
                <td>
                    <?= $infoValue->getId() ? $infoValue->getId() : "null" ?>
                </td>
                <td>
                    <?= $infoValue->getName() ? $infoValue->getName() : "null" ?>
                </td>
                <td>
                    <?= $infoValue->getCNE() ? $infoValue->getCNE() : "null" ?>
                </td>
                <td>
                    
                        <input type="button" value="Edit" class="btn btn-primary" name="edit">
                        <input type="button" value="Delete" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#DeleteModal" name="delete">
                    
                </td>
            </tr>
            <?php
        }
        ?>
        <?php
        ?>
    </table>

    <!-- =========================================== -->
    <!-- The Start Delete Modal -->
    <!-- =========================================== -->

    <div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Delete Announce
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <input type="hidden" name="delete_id" class="id_To_Delete">
                        <div>
                            <h4><i class="fa-sharp fa-solid fa-trash"></i>Are you sure you want to delete this trainner
                                ?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <input type="submit" class="btn btn-danger" name="confirm_delete" value="Delete">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- =========================================== -->
    <!-- The End Delete Modal -->
    <!-- =========================================== -->
    <script src="./assets/main.js"></script>
</body>

</html>