
<?php 
if (isset($_GET['edit'])) {
	$blog_id = $_GET['edit'];
	$result2= mysqli_query($conn, "SELECT * FROM blog WHERE b_id = $blog_id ");

	if (mysqli_num_rows($result2)>0) {
		while ($row2 = mysqli_fetch_assoc($result2)) {
			$albumcover = $row2['b_image'];
			?>

			<div class="container-fluid aform">
				<?php 
				if (isset($_POST['edit'])) {
					$artist = $_POST['artist'];
					$album = $_POST['album'];
					$year = $_POST['year'];
					$genre = $_POST['genre'];
					$price = $_POST['price'];

					if ($artist == '' || $album == '' || $year == '' || $genre == '' || $price == '') {
						echo "Please Fill data";
					}
					else {
						include"image_upload_foredit.php";
								// Check if $uploadOk is set to 0 by an error
						if ($uploadOk == 0) {
							echo "Sorry, your file was not uploaded.";
						}

						elseif ($uploadOk == 2) {
									mysqli_query($conn, "UPDATE blog SET v_artist = '$artist', v_album = '$album', v_releasedate = '$year', v_genre = '$genre', v_price = '$price' WHERE b_id = '$blog_id' "); // insert data to database
									header("location:index.php");
									$msg = "<div class='alert alert-success'>Success Editing</div>";
								}
								// if everthing is ok, try to upload file
								else {
									if (file_exists($albumcover)) {
										unlink($albumcover);
										move_uploaded_file($_FILES["albumcover"]["tmp_name"], $target_file); // upload image to folder
										mysqli_query($conn,  "UPDATE blog SET v_artist = '$artist', v_album = '$album', v_releasedate = '$year', v_genre = '$genre', b_image = '$target_file', v_price = '$price' WHERE b_id = '$blog_id' "); // insert data to database
										header("location:post_manage.php");
										$msg = "<div class='alert alert-success'>Success Editing</div>";
									}
								}
							}
						}
						?>
						<div class="row mt-4" style="margin-bottom: 15px;"></div>
						<?php error_reporting(0); echo $msg; ?>
						<form class="col-md-8 bg-secondary p-4 m-auto" method="post" action="" enctype="multipart/form-data">
							<div class="form-row"></div>
							<h3>Edit Album</h3>
							
							<div class="mb-3 input-group">
								<span class="p-2" style="background-color: skyblue;">
									<i class="fa-solid fa-palette"></i>
								</span>
								<input type="text" class="form-control"  placeholder="Artist" name="artist" value="<?php echo $row2['v_artist']; ?>" autocomplete="off">
							</div>
							<div class="mb-3 input-group">
								<span class="p-2" style="background-color: skyblue;">
									<i class="fa-solid fa-image"></i>
								</span>
								<input type="text" class="form-control" placeholder="Album" name="album" value="<?php echo $row2['v_album']; ?>" autocomplete = "off">
							</div>

							<div class="mb-3 input-group">
								<span class="p-2" style="background-color: skyblue;">
									<i class="fa-solid fa-calendar-days"></i>
								</span>
								<input type="text" class="form-control" placeholder="Release Year" name="year" value="<?php echo $row2['v_releasedate']; ?>" autocomplete = "off">
							</div>

							<div class="mb-3 input-group">
								<span class="p-2" style="background-color: skyblue;">
									<i class="fa-solid fa-music"></i>
								</span>
								<input type="text" class="form-control" placeholder="Genre" name="genre" value="<?php echo $row2['v_genre']; ?>" autocomplete = "off">
							</div>

							<div class="mb-3 input-group">
								<span class="p-2" style="background-color: skyblue;">
									<i class="fa-solid fa-sack-dollar"></i>
								</span>
								<input type="text" class="form-control" placeholder="Price" name="price" value="<?php echo $row2['v_price']; ?>" autocomplete = "off">
							</div>

							<div class="mb-3 input-group">             
								<input class="form-control" type="file" id="formFile" name="albumcover">
							</div>

							<div class="container" style="text-align: center;">
								<button type="submit" class="btn btn-primary" name="edit">Edit</button>
							</div>
						</form> 
					</div>
	<?php
				}
			}
		}
	?>