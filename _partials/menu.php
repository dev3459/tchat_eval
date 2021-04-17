<!-- button management : Registration / Connection / Disconnection  -->
<?php if(!isset($_SESSION['user'])){ ?>
    <div id="registration">
        <a href="connect.php" title="Connectez-vous pour pouvoir envoyé un message">Inscription / Connexion</a>
    </div>
<?php }elseif(isset($_SESSION['user'])){ ?>
    <div id="registration">
        <?php
            if($_SESSION['user']['pseudo'] === "Admin"){ ?>
                <a href="./connect.php?deconnexion=0604" title="Déconnectez-vous">Déconnexion</a>
            <?php }else{ ?>
                <a href="../Tchat.php?task=deconnexion" title="Déconnectez-vous">Déconnexion</a>
            <?php }
        ?>
    </div>
<?php } ?>