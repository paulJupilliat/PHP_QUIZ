<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="css/admin.css">


</head>

<body>
    <header>
        <?php
        include "menu.php";
        ?>
    </header>
    <main>
        <div id="adminQuestion">
            <button class="button-toggle-popup" onclick="togglePopupAddQuest()">Ajouter une question</button>
            <form id="importFic" action="index.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="admin" />
                <label for="fileToUpload">Sélectionnez un fichier :</label>
                <input type="file" id="fileToUpload" name="fileToUpload">
                <input type="submit" value="Importer depuis .json" name="submit">
            </form>
            <form id="ExportFic" method="get" action="index.php">
                <input type="hidden" name="action" value="admin" />
                <input type="hidden" name="export" value="true" />
                <button type="submit">Exporter</button>
            </form>
            <form id="findQuest" method="get" action="index.php?action=admin">
                <input type="hidden" name="action" value="admin" />
                <input type="text" name="recherche" placeholder="Recherche...">
                <button type="submit">Rechercher</button>
            </form>

            <div class="popUp" id="popupAddQuest">
                <?php echo $popUpAddQuest; ?>
            </div>
            <div class="allQuestions">
                <?php
                foreach ($allQuestion as $question) {
                    echo $question->displayPreview();
                } ?>

            </div>

        </div>
        <div id="adminUser">
            <?php foreach ($allUsers as $user) {
                echo $user->displayPreview();
            } ?>
            <!-- <form id="importFic" action="index.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="admin" />
                <label for="fileToUploadUser">Sélectionnez un fichier :</label>
                <input type="file" id="fileToUploadUser" name="fileToUploadUser">
                <input type="submit" value="Importer depuis .json" name="submit">
            </form> -->
            <form id="ExportFic" method="get" action="index.php">
                <input type="hidden" name="action" value="admin" />
                <input type="hidden" name="exportUser" value="true" />
                <button type="submit">Exporter</button>
            </form>

        </div>

    </main>
    <svg xmlns=" http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#8eb864" fill-opacity="1" d="M0,288L21.8,282.7C43.6,277,87,267,131,250.7C174.5,235,218,213,262,186.7C305.5,160,349,128,393,106.7C436.4,85,480,75,524,80C567.3,85,611,107,655,122.7C698.2,139,742,149,785,170.7C829.1,192,873,224,916,234.7C960,245,1004,235,1047,218.7C1090.9,203,1135,181,1178,170.7C1221.8,160,1265,160,1309,176C1352.7,192,1396,224,1418,240L1440,256L1440,320L1418.2,320C1396.4,320,1353,320,1309,320C1265.5,320,1222,320,1178,320C1134.5,320,1091,320,1047,320C1003.6,320,960,320,916,320C872.7,320,829,320,785,320C741.8,320,698,320,655,320C610.9,320,567,320,524,320C480,320,436,320,393,320C349.1,320,305,320,262,320C218.2,320,175,320,131,320C87.3,320,44,320,22,320L0,320Z"></path>
    </svg>
    <script src="../js/admin.js"></script>
</body>

</html>