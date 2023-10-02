<?php

class InternBLL
{

    private $internDAL;
    private $citiesNamesList;
    public $errorMessage;

    public function __construct()
    {
        $this->internDAL = new InternDAL();
        $this->citiesNamesList = new CitiesDAL();

    }

    public function GetAllInterns()
    {
        return $this->internDAL->GetAllInterns();
    }

    public function getAllCitiesInfo()
    {
        return $this->citiesNamesList->getAllCities();
    }

    public function GenerateHtmlForAllInterns()
    {
        $all_interns_html = '
<div class="container mt-5">
    <div class="text-center">
        <button type="button" class="btn btn-primary mb-5 add_new">Add New Intern</button>
    </div>
</div>
<section class="mb-5 hide" id="hide">
    <div class="container mt-5">
        <form action="index.php" method="POST">
            <div class="form-group">
                <input type="hidden" id="person_Id" name="personId">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="cne">CNE</label>
                <input type="text" class="form-control" id="cne" name="cne" required>
            </div>
            <div class="form-group">
                <label for="ville">Ville</label>
                <select class="form-control" id="city_selector" name="city" required>
                    <option value="">Select Your City</option>';
        $citiesNamesListData = $this->citiesNamesList->getAllCities();
        foreach ($citiesNamesListData as $cityName) {
            $all_interns_html .= '
                        <option value="' . $cityName->GetId() . '">
                            ' . $cityName->GetCity() . '
                        </option>';
        }
        $all_interns_html .= '
                </select>
            </div>
            <input type="submit" name="confirm_Data" class="btn btn-primary" id="confirm" value="Confirmer">
        </form>
    </div>
</section>';
        $allInterns = $this->internDAL->GetAllInterns();
        // =============== Pagination settings ==============

        $rowsPerPage = 6; // Number of rows to display per page
        $totalRows = count($allInterns); // Total number of rows
        $totalPages = ceil($totalRows / $rowsPerPage); // Total number of pages

        // Get the current page number from the URL parameter
        $currentpage = isset($_GET['page']) ? $_GET['page'] : 1;
        $currentpage = max(1, min($currentpage, $totalPages)); // Ensure the current page is within the valid range

        // Calculate the starting and ending row numbers for the current page
        $startRow = ($currentpage - 1) * $rowsPerPage;
        $endRow = min($startRow + $rowsPerPage - 1, $totalRows - 1);

        // Get the rows for the current page
        $rowsOnPage = array_slice($allInterns, $startRow, $rowsPerPage);


        if (count($allInterns) > 0) {

            $all_interns_html .= '<section class="mx-5">
            <div>
                <button class="btn btn-primary" id="view_Table">Table View</button>
                <button class="btn btn-warning" id="view_Chart">Chart View</button>
            </div>
        </section><section class="table__body" id="table_View">';

            $all_interns_html .= '<table><thead><tr>';
            $all_interns_html .= '<th>Id <span class="icon-arrow">&UpArrow;<span/></th>';
            $all_interns_html .= '<th>Name  <span class="icon-arrow">&UpArrow;</span</th>';
            $all_interns_html .= '<th>CNE  <span class="icon-arrow">&UpArrow;</span></th>';
            $all_interns_html .= '<th>City <span class="icon-arrow">&UpArrow;</span></th>';
            $all_interns_html .= '<th class="center" colspan="2">Action</th>';
            $all_interns_html .= '</tr></thead>';
            $all_interns_html .= '<tbody>';

            foreach ($rowsOnPage as $intern) {
                $all_interns_html .= '<tr>';
                $all_interns_html .= '<td>' . $intern->GetId() . '</td>';
                $all_interns_html .= '<td>' . $intern->GetName() . '</td>';
                $all_interns_html .= '<td>' . $intern->GetCNE() . '</td>';
                $all_interns_html .= '<td>' . $intern->GetCity() . '</td>';
                $all_interns_html .= '<td class="center"><form action="edit.php" method="POST">
                <input type="button" value="Edit" class="btn btn-primary" name="edit">
                <input type="button" value="Delete" class="btn btn-danger" data-bs-toggle="modal"
                    data-bs-target="#DeleteModal" name="delete">
            </form></td>';
                $all_interns_html .= '</tr>';
            }
            $all_interns_html .= '</tbody>';

            $all_interns_html .= '</table></section>';

        } else {
            $all_interns_html = '<div class="alert alert-warning" role="alert">No student found. Try <a href="add.php">add</a> some.</div>';
        }
        $pagination_html = '<nav aria-label="Page navigation example" class="m-5" id="pagination">';
        if ($totalPages > 1) {
            $pagination_html .= '<ul class="pagination justify-content-center">
        <li class="page-item">';
            if ($currentpage > 1) {
                $pagination_html .= '<a href="?page=' . ($currentpage - 1) . '" class="page-link">Prev</a>';
            }
            $pagination_html .= '</li>
        <li class="page-item">';
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i == $currentpage) {
                    $pagination_html .= '<li class="page-item active"><a class="page-link" href="?page=' . $i . '">'
                        . $i .
                        '</a></li>';
                } else {
                    $pagination_html .= '<li class="page-item"><a class="page-link" href="?page=' . $i . '">'
                        . $i .
                        '</a></li>';
                }
            }
            $pagination_html .= '</li>
        <li class="page-item">';
            if ($currentpage < $totalPages) {
                $pagination_html .= '<a href="?page=' . ($currentpage + 1) . '" class="page-link">Next</a>';
            }
            $pagination_html .= '</li>
    </ul>
    </nav>';
        }
        $all_interns_html .= $pagination_html;

        $all_interns_html .= ' <!-- =========================================== -->
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
                        <form action="index.php" method="POST">
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
        <!-- =========================================== -->';

        return $all_interns_html;
    }



    public function AddIntern($internDto)
    {

        $insertedId = 0;

        if ($internDto->GetName() == '' || $internDto->GetCNE() == '' || $internDto->GetCity() == '') {
            $this->errorMessage = 'Student Name, CNE and City is required.';
            return $insertedId;
        }

        if ($this->IsValidIntern($internDto)) {
            $insertedId = (int) $this->internDAL->AddIntern($internDto);
        }

        return $insertedId;
    }

    public function UpdateIntern($internDto)
    {

        $affectedRows = 0;

        if ($internDto->GetName() == '' || $internDto->GetCNE() == '' || $internDto->GetCity() == '') {
            $this->errorMessage = 'Student Name, CNE and City is required.';
            return $affectedRows;
        }


        $affectedRows = (int) $this->internDAL->UpdateIntern($internDto);


        return $affectedRows;
    }

    public function DeleteIntern($internId)
    {

        $affectedRows = 0;
        if ($internId > 0) {
            if ($this->IsIdExists($internId)) {
                $affectedRows = (int) $this->internDAL->DeleteIntern($internId);
            } else {
                $this->errorMessage = 'Record not found.';
            }
        } else {
            $this->errorMessage = 'Invalid Id.';
        }

        return $affectedRows;
    }

    public function IsValidIntern($internDto)
    {
        if ($this->IsCNEExists($internDto->GetCNE(), $internDto->GetId())) {
            $this->errorMessage = 'CNE ' . $internDto->GetCNE() . ' already exists. Try a different one.';
            return false;
        } else {
            return true;
        }
    }

    public function IsIdExists($id)
    {
        return $this->internDAL->IsIdExists($id);
    }

    public function IsCNEExists($cne, $id)
    {
        return $this->internDAL->IsCNEExists($cne, $id);
    }
}