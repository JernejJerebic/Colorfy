<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
    <link rel="stylesheet" href="style.css?<?php echo time(); ?>"> <!-- Add the query string with the timestamp -->
</head>
<body>
    <div class="container">
        <h1>Upload an Image</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="image" accept="image/*" required>
            <input type="submit" value="Upload Image" name="submit">
        </form>

        <?php if (isset($_SESSION['uploaded_image'])): ?>
            <h2>Uploaded Image:</h2>
            <img id="uploaded-image" src="<?php echo htmlspecialchars($_SESSION['uploaded_image']); ?>" alt="Uploaded Image">
            <form action="delete_image.php" method="post">
                <input type="submit" value="Remove Image" name="remove_image" style="margin-top: 10px;">
            </form><br>
            <form id="color-form">
                <input type="submit" id="identify-colors" value="Identify Colors"> <!-- Change button to input type="submit" -->
            </form>
            <ul id="color-list"></ul>
        <?php endif; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
    <script>
       document.getElementById('color-form').addEventListener('submit', (event) => {
            event.preventDefault();
            
            const image = document.getElementById('uploaded-image');
            const colorThief = new ColorThief();
            const colors = colorThief.getPalette(image, 10);
            const colorList = document.getElementById('color-list');
            colorList.innerHTML = '';
        
            colors.forEach(color => {
                const [r, g, b] = color;
                const hexColor = rgbToHex(r, g, b);
            
                const listItem = document.createElement('li');
                const colorDiv = document.createElement('div');
                colorDiv.style.backgroundColor = hexColor;
                colorDiv.classList.add('color-block');
                
                const hexText = document.createElement('span');
                hexText.innerText = hexColor;
                hexText.classList.add('hex-text');
                colorDiv.appendChild(hexText);
                
                colorDiv.addEventListener('click', () => {
                    // Alternative method to copy text to the clipboard
                    const tempTextarea = document.createElement('textarea');
                    tempTextarea.value = hexColor;
                    document.body.appendChild(tempTextarea);
                    tempTextarea.select();
                    document.execCommand('copy');
                    document.body.removeChild(tempTextarea);
                });
            
                listItem.appendChild(colorDiv);
                colorList.appendChild(listItem);
            });
        });

        function rgbToHex(r, g, b) {
            return '#' + [r, g, b].map(x => x.toString(16).padStart(2, '0')).join('');
        }
    </script>
</body>
</html>
