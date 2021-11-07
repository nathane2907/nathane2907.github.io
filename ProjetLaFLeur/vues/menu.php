
<?php
$est=!estConnecte();
?>
  <!-- Navbar
    ================================================== -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="./indexzz.php">Accueil</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active">
                <a href="./indexzz.php">Accueil</a>
              </li>
              <li class="nav">
                <a href="lister.php">Lister</a>
              </li>
              <li class="nav">
                <a href="rechercher.php">Rechercher</a>
              </li>
                        
  <?php

// Si session visiteur
if (estVisiteurConnecte())
{

  ?>
              <li class="nav"> 
                <a href="gererPanier.php" >Panier </a>  
              </li>
              <li class="nav">
                 <a href="deconnecter.php" >Deconnecter</a> 
              </li>
 
  <?php
}

// Si session administrateur
if (estAdministrateurConnecte())
{

  ?>
              <li class="nav"> 
                <a href="ajouter.php" >Ajouter</a>  
              </li>
              <li class="nav">
                 <a href="supprimer.php" >Supprimer</a> 
              </li>
              <li class="nav"> 
                <a href="modifier.php" >Modifier</a>  
              </li>
              <li class="nav">
                 <a href="deconnecter.php" >Deconnecter</a> 
              </li>
 
  <?php
}


// Si aucune connection n'est en cours, proposer l'inscription et l'identification
if (!estConnecte())
{
?>
              <li class="nav">
                <a href="inscription.php" >Inscription</a> 
              </li>
              <li class="nav"> 
                <a href="connecter.php" >Se connecter</a> 
              </li>   
<?php
}   
?>                                   
            </ul>
          </div>
        </div>
      </div>
    </div>
</div>

