<html>
    <head>
        <title>Text manager</title>
        <link rel="stylesheet" href="https://unpkg.com/mustard-ui@latest/dist/css/mustard-ui.min.css">
        <style>
            .highlight {
                background: yellow;
            }
        </style>
    </head>
    <body>
    <?php
        $textUrl = $searchQuery = $action = "";
        if (isset($_POST["action"])) {
            $textUrl = $_POST["textUrl"];
            $searchQuery = $_POST["searchQuery"];
            $action = $_POST["action"];
        }
    ?>            

        <header style="height: 200px;">
        <h1>Text manager</h1>
        </header>
        <br>
        <div class="row">
            <div class="col col-sm-5">
                <div class="panel">
                    <div class="panel-body">
                        <form action="index.php" method="post">   
                        <h2 class="panel-title">1. Get text</h2>
                            <input type="text" placeholder="Enter the poem url" name="textUrl" value="<?php echo $textUrl ?>"><br >
                            <button type="submit" name="action" value="fetch" class="button-primary align-center">Fetch text</button>
                        <h2 class="panel-title">2. Find keywords</h2>
                            <input type="text" placeholder="Enter text to be highlighted" name="searchQuery" value=<?php echo $searchQuery ?>><br >
                            <button type="submit" name="action" value="search" class="button-primary">Search text</button>
                        </form>
                        <?php
                            if ($action == "search" ){
                                echo'<h2 class="panel-title">3. Check results</h2>';
                                $file = fopen($textUrl, "rb" );
                                while (!feof($file)) {
                                    $ligne = fgets($file, 1024);
                                    if (preg_match('|\b' . preg_quote($searchQuery) . '\b|i', $ligne)) {
                                        $resultats[] = $ligne;
                                    }
                                }
                                fclose($file);
                                $nb = count($resultats);
                                if ($nb > 0) {
                                    echo "'$searchQuery' find $nb times :";
                                    echo '<ul>';
                                    foreach ($resultats as $v) {
                                        echo "<li>$v</li>";
                                    }
                                    echo '</ul>';
                                } else {
                                    echo("This word is not in the text !");
                                }
                            }
                            
                        ?>
                    </div>
                </div>
            </div>

            <div class="col col-sm-7" style="padding-left: 25px;">
            <pre><code>
                    <?php                
                    if ($action == "fetch" || $action="search"){
                        $file = fopen($textUrl, "rb" );
                        while(!feof($file)){
                            $ligne = fgets($file);
                            echo $ligne;
                        }
                    }
                ?>
            </pre></code>
            </div>
        </div>

    </body>
</html>
