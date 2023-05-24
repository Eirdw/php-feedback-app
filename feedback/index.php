<?php include 'inc/header.php'; ?>

<?php
// Set vars to empty values
$Name = $email = $body = '';
$NameErr = $emailErr = $bodyErr = '';

// Form submit
if (isset($_POST['submit'])) {
  // Validate Name
  if (empty($_POST['name'])) {
    $NameErr = 'name is required';
  } else {
    // $Name = filter_var($_POST['Name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $Name = filter_input(
      INPUT_POST,
      'name',
      FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
  }

  // Validate email
  if (empty($_POST['email'])) {
    $emailErr = 'Email is required';
  } else {
    // $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  }

  // Validate body
  if (empty($_POST['body'])) {
    $bodyErr = 'Body is required';
  } else {
    // $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_input(
      INPUT_POST,
      'body',
      FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
  }

  if (empty($NameErr) && empty($emailErr) && empty($bodyErr)) {
    // add to database
    $sql = "INSERT INTO feedback (Name, email, body) VALUES ('$Name', '$email', '$body')";
    if (mysqli_query($conn, $sql)) {
      // success
      header('Location: feedback.php');
    } else {
      // error
      echo 'Error: ' . mysqli_error($conn);
    }
  }
}
?>

    <img src="/feedback/img/logo.png" class="w-25 mb-3" alt="">
    <h2>Feedback</h2>
    <?php echo isset($Name) ? $Name : ''; ?>
    <p class="lead text-center">Leave feedback for Ay exchange</p>

    <form method="POST" action="<?php echo htmlspecialchars(
      $_SERVER['PHP_SELF']
    ); ?>" class="mt-4 w-75">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control <?php echo !$NameErr ?:
          'is-invalid' ; ?>" id="name" name="name" placeholder="Enter your Name" value="<?php echo $Name; ?>">
        <div id="validationServerFeedback" class="invalid-feedback">
          Name is required
        </div>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control <?php echo !$emailErr ?:
          'is-invalid'; ?>" id="email" name="email" placeholder="Enter your email" value="<?php echo $email; ?>">
       <div id="validationServerFeedback" class="invalid-feedback">
          Email is required
        </div>
      </div>
      <div class="mb-3">
        <label for="body" class="form-label">Feedback</label>
        <textarea class="form-control <?php echo !$bodyErr ?:
          'is-invalid'; ?>" id="body" name="body" placeholder="Enter your feedback"><?php echo $body; ?></textarea>
       <div id="validationServerFeedback" class="invalid-feedback">
       Feedback is required
        </div>
      </div>
      <div class="mb-3">
        <input type="submit" name="submit" value="Send" class="btn btn-dark w-100">
      </div>
    </form>
<?php include 'inc/footer.php'; ?>