<!DOCTYPE html>
<html>
<body>
<!--To  UPLOAD Files to /images and redirects to /show_info.php -->
<form action="show_info.php" method="POST" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>