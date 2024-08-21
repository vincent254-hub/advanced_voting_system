<?php
require('connection.php');
if(empty($_SESSION['member_id'])){
    header("location:access-denied.php");
   }

$position = $_GET['position'];
$candidates = mysqli_query($conn, "SELECT * FROM candidatestable WHERE candidate_position='$position'");
?>

<div class="container mt-4">
    <h3>Candidates for <?php echo $position; ?></h3>
    <form id="voteForm-<?php echo $position; ?>" class="vote-form">
        <?php while ($candidate = mysqli_fetch_assoc($candidates)): ?>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="candidate-<?php echo $position; ?>" value="<?php echo $candidate['candidate_name']; ?>" id="candidate-<?php echo $candidate['candidate_id']; ?>">
                <label class="form-check-label" for="candidate-<?php echo $candidate['candidate_id']; ?>">
                    <?php echo $candidate['candidate_name']; ?>
                </label>
            </div>
        <?php endwhile; ?>
        <button type="button" class="btn btn-primary mt-3 submit-vote" data-position="<?php echo $position; ?>">Vote</button>
    </form>
</div>
