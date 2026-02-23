<?php
require '../../db/dbconn.php';

$billing_schedule_id = $_POST['billing_schedule_id'] ?? 0;

$query = "
    SELECT rs.*, zb.zonebook
    FROM reading_schedule_per_zone rs
    LEFT JOIN zonebook_settings zb 
        ON zb.zonebook_id = rs.zonebook_id
    WHERE rs.billing_schedule_id = '$billing_schedule_id'
    AND rs.deleted = 0
";

$result = mysqli_query($con, $query) or die(mysqli_error($con));

while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
    <td><?= date("M d, Y", strtotime($row['reading_date'])) ?></td>
    <td><?= date("M d, Y", strtotime($row['date_covered_from'])) ?></td>
    <td><?= date("M d, Y", strtotime($row['date_covered_to'])) ?></td>
    <td>
        <?= ($row['zonebook_id'] == 0) 
            ? 'Accounts with no Zone/Book Assigned' 
            : $row['zonebook']; ?>
    </td>
    <td>
        <button class="btn btn-primary btn-sm editRow"
                data-id="<?= $row['reading_schedule_id']; ?>"
                data-reading="<?= $row['reading_date']; ?>"
                data-from="<?= $row['date_covered_from']; ?>"
                data-to="<?= $row['date_covered_to']; ?>"
                data-zone="<?= $row['zonebook_id']; ?>">
            Edit    
        </button>
        <a class="btn btn-danger btn-sm deleteRow"
                data-id="<?= $row['billing_schedule_id']; ?>">
            Delete
        </a>
    </td>
</tr>
<?php } ?>