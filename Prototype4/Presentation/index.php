<?php
include_once '../DB/connect.php';
include_once '../DB/traineesManagment.php';
include_once '../DB/cities.php';

$traineesData = new TraineesManagment();
$traineesInfo = $traineesData->getTraineesData();

$citiesNamesData = new Cities();
$citiesNamesList = $citiesNamesData->getCitiesList();
$countTrainees = new TraineesManagment();
$theCountResult = $countTrainees->countTrainnes();

$dataPoints = [];
foreach ($theCountResult as $city) {
    $dataPoint = array(
        "y" => $city["TrainerCount"],
        "label" => $city["VilleNom"]
    );
    array_push($dataPoints, $dataPoint);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
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
            <form action="../works/controller.php" method="POST">
                <div class="form-group">
                    <input type="hidden" id="person_Id" name="personId">
                    <label for="nom">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="cne">CNE</label>
                    <input type="text" class="form-control" id="cne" name="cne" required>
                </div>
                <div class="form-group">
                    <label for="ville">City</label>
                    <select class="form-control" id="city_selector" name="city" required>
                        <option value="">Select a Ville</option>
                        <?php
                        foreach ($citiesNamesList as $cityName) {
                            ?>
                            <option value="<?php echo $cityName['Id']; ?>">
                                <?php echo $cityName['Nom'] ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <input type="submit" name="confirm_Data" class="btn btn-primary" id="confirm" value="Confirm">
            </form>
        </div>
    </section>

    <?php
    // =============== Pagination settings ==============
    
    $rowsPerPage = 6; // Number of rows to display per page
    $totalRows = count($traineesInfo); // Total number of rows
    $totalPages = ceil($totalRows / $rowsPerPage); // Total number of pages
    
    // Get the current page number from the URL parameter
    $currentpage = isset($_GET['page']) ? $_GET['page'] : 1;
    $currentpage = max(1, min($currentpage, $totalPages)); // Ensure the current page is within the valid range
    
    // Calculate the starting and ending row numbers for the current page
    $startRow = ($currentpage - 1) * $rowsPerPage;
    $endRow = min($startRow + $rowsPerPage - 1, $totalRows - 1);

    // Get the rows for the current page
    $rowsOnPage = array_slice($traineesInfo, $startRow, $rowsPerPage);
    ?>
    <section class="mx-5">
        <div>
            <button class="btn btn-primary" id="view_Table">Table View</button>
            <button class="btn btn-warning" id="view_Chart">Chart View</button>
        </div>
    </section>
    <section class="table__body" id="table_View">
        <table>
            <thead>
                <tr>
                    <th>Id <span class="icon-arrow">&UpArrow;</span></th>
                    <th>Name <span class="icon-arrow">&UpArrow;</span></th>
                    <th>CNE <span class="icon-arrow">&UpArrow;</span></th>
                    <th>City <span class="icon-arrow">&UpArrow;</span></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rowsOnPage as $infoValue) { ?>
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
                            <?= $infoValue->getCity() ? $infoValue->getCity() : "null" ?>
                        </td>
                        <td>
                            <form action="../works/controller.php" method="POST">
                                <input type="button" value="Edit" class="btn btn-primary" name="edit">
                                <input type="button" value="Delete" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#DeleteModal" name="delete">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>

    </section>

    <!-- Pagination links -->

    <nav aria-label="Page navigation example" class="m-5" id="pagination">
        <?php if ($totalPages > 1) { ?>
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <?php if ($currentpage > 1) { ?>
                        <a href="?page=<?= $currentpage - 1 ?>" class="page-link">Prev</a>
                    <?php } ?>
                </li>
                <li class="page-item">
                    <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                        <?php if ($i == $currentpage) { ?>

                        <li class="page-item active"><a class="page-link" href="?page=<?= $i ?>">
                                <?= $i ?>
                            </a></li>
                    <?php } else { ?>

                        <li class="page-item"><a class="page-link" href="?page=<?= $i ?>">
                                <?= $i ?>
                            </a></li>
                    <?php } ?>
                <?php } ?>
                </li>
                <li class="page-item">
                    <?php if ($currentpage < $totalPages) { ?>
                        <a href="?page=<?= $currentpage + 1 ?>" class="page-link">Next</a>
                    <?php } ?>
                </li>
            </ul>
        <?php } ?>
    </nav>

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
                    <form action="../works/controller.php" method="POST">
                        <input type="hidden" name="delete_id" class="id_To_Delete">
                        <div>
                            <h4><i class="fa-sharp fa-solid fa-trash"></i>Are you sure you want to delete this
                                trainner
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

    <!-- ================== Chart View ================== -->
    <div class="hide" id="chartContainer" style="height: 370px; width: 100%;"></div>



    <!-- ===================== Script ================== -->


    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script src="main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>

    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Trainner Cities"
                },
                axisY: {
                    title: "Trainner count"
                },
                data: [{
                    type: "column",
                    yValueFormatString: "#,##0.## Trainner",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

        }
    </script>

</body>

</html>