<?php
function fileUpload($photo)
{

    if ($photo["error"] == 4) { // checking if a file has been selected, it will return 0 if you choose a file, and 4 if you didn't
        $photoName = "dog.jpg"; // the file name will be product.png (default photo for a product)
        $message = "<div class='alert alert-warning alert-dismissible fade show mx-auto' role='alert'>
  <strong>Whoops! It seems no photo was chosen. No worries—you can always upload a captivating image later to complete your masterpiece!</strong> <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
    } else {
        $checkIfImage = getimagesize($photo["tmp_name"]); // checking if you selected an image, return false if you didn't select an image
        $message = $checkIfImage ? "Ok" : "Not an image";
    }

    if ($message == "Ok") {
        $ext = strtolower(pathinfo($photo["name"], PATHINFO_EXTENSION)); // taking the extension data from the image
        $photoName = uniqid("") . "." . $ext; // changing the name of the photo to random string and numbers
        $destination = "../photos/{$photoName}"; // where the file will be saved
        move_uploaded_file($photo["tmp_name"], $destination); // moving the file to the photos folder
    }

    return [$photoName, $message]; // returning the name of the photo and the message
}
