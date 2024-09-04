
<div class="row" style="align-items-center">
    <div class="col-md-12">
        <div class="container mx-auto" style="margin-top:100px">
        <form method="post" action="save_requirements.php" style="max-width:800px;">
            <label for="position" class="form-label">Position:</label>
            <input type="text" class="form-control my-3" name="position" required>

            <label for="question" class="form-label">Question:</label>
            <textarea name="question" class="form-control my-3" required></textarea>

            <label for="weight" class="form-label">Weight (percentage):</label>
            <input type="number" class="form-control my-3" name="weight" required>

            <input type="submit" class="btn btn-warning my-3" value="Save Requirement">
        </form>
        </div>
    </div>
</div>
