<?php

require 'header.php';

if (isset($_GET['action']) && isset($_GET['action']) != '') {
    $action = $_GET['action'];

    if ($action == 'delete') {
        $id = $_GET['id'];
        $delete = "DELETE FROM contactus WHERE id = $id";
        mysqli_query($conn, $delete);
    }
}

?>

<div class="main">

    <div class="main-head">
        <h2>Categories</h2>
        <a class="btn btn-dark btn-position" href="partials/add_category.php">Add Category</a>
    </div>
    <div class="table-container">

        <table>
            <thead>
                <tr>
                    <th class="id">Sr.no.</th>
                    <th class="title">Name</th>
                    <th class="title">Email</th>
                    <th class="title">Phone No.</th>
                    <th class="title">Subject</th>
                    <th class="title">Date</th>
                    <th class="actions">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php

                $sql = 'SELECT * FROM contactus  ORDER BY `date` DESC';
                $result = mysqli_query($conn, $sql);
                $sno = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $sno = $sno + 1;

                    echo '<tr>
                            <td>' . $sno . '</td>
                            <td>' . $row['name'] . '</td>
                            <td>' . $row['email'] . '</td>
                            <td>' . $row['phone_no'] . '</td>
                            <td>' . $row['subject'] . '</td>
                            <td>' . $row['date'] . '</td>
                            <td>
                            <a id="delete" class="btn btn-primary btn-sm" href="contact_details.php?id=' . $row['id'] . '" role="button">Show Mesaage</a>
                            <a id="delete" class="btn btn-danger btn-sm" href="?type=delete&id=' . $row['id'] . '" role="button">Delete</a>
                            <td>
                        </tr>';
                }

                ?>
            </tbody>
        </table>

    </div>

</div>

<?php

require 'footer.php';

?>