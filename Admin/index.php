<?php

require_once __DIR__.'/../src/index.html';

?> 

<!DOCTYPE html>
<html>
    <head>
        <title> Admin Panel - Login</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/style.css" type="text/css" />
    </head>
    <body>
 <div class="col-sm-5 text-center panel panel-success">
                   
                    <h3> Zaloguj się adminie</h3>
                    <form action=# method="POST">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="email">
                        </div>
                        <div class="form-group">
                            <label for="password">Hasło:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="hasło">
                        </div>

                        <button type="submit" class="bnt btn-group-vertical">Zaloguj</button>
                    </form>
                </div>

            </div>
        </div>

    </body> 
    
</html>