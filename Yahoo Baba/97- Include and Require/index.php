<!DOCTYPE html>
<html>

<head>
    <title>Basic Layout</title>
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <div id="wrapper">
       <?php require 'header.php'; ?>
        <div id="content">
            <h2>Sub Heading</h2>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's
                standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it
                to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
                typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker
                including versions of Lorem Ipsum. It was popularised in the 1960s with the release of Letraset sheets containing
                Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions
                of Lorem Ipsum. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five
                centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
            </p>
            <ul class="list">
                <li>Lorem Ipsum dolor sit amet.</li>
                <li>Modi nihil in animi necessitatatibus.</li>
                <li>consectetur adipiscing elit.</li>
                <li>Lorem Ipsum dolor sit amet.</li>
                <li>Sed at sagittis lorem, vitae egestas nulla.</li>
            </ul>
        </div>
        <?php include 'sidebar.php'; ?>
        <?php include 'footer.php'; ?>
    </div>
</body>

</html>