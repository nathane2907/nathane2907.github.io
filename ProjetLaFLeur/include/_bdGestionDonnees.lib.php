<?php

// FONCTIONs POUR L'ACCES A LA BASE DE DONNEES
// Ajouter en têtes 
// Voir : jeu de caractères à la connection

/** 
 * Se connecte au serveur de donnees                     
 * Se connecte au serveur de donnees e partir de valeurs
 * predefinies de connexion (hete, compte utilisateur et mot de passe). 
 * Retourne l'identifiant de connexion si succes obtenu, le booleen false 
 * si probleme de connexion.
 * @return resource identifiant de connexion
 */
function connecterServeurBD() 
{
    $PARAM_hote='localhost'; // le chemin vers le serveur
    $PARAM_port='3306';
    $PARAM_nom_bd='baseLafleur1'; // le nom de votre base de donnees
    $PARAM_utilisateur='root'; // nom d'utilisateur pour se connecter
    $PARAM_mot_passe='root'; // mot de passe de l'utilisateur pour se connecter

    $connect = new PDO('mysql:host='.$PARAM_hote.';port='.$PARAM_port.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
 
    return $connect;
}

function lister()
{
    $connexion = connecterServeurBD();
   
    $requete="select * from produit";
    
    $jeuResultat=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant
  
    $i = 0;
    $ligne = $jeuResultat->fetch();
    while($ligne)
    {
        $fleur[$i]['image']=$ligne['pdt_image'];
        $fleur[$i]['ref']=$ligne['pdt_ref'];
        $fleur[$i]['designation']=$ligne['pdt_designation'];
        $fleur[$i]['prix']=$ligne['pdt_prix'];
        $ligne=$jeuResultat->fetch();
        $i = $i + 1;
    }
    $jeuResultat->closeCursor();   // fermer le jeu de resultat
  
  return $fleur;
}


function ajouter($ref, $des, $prix, $image, $cat,&$tabErr)
{
  // Ouvrir une connexion au serveur mysql en s'identifiant
  $connexion = connecterServeurBD();
    
  // Creer la requete d'ajout 
  $requete="insert into produit"
  ."(pdt_ref,pdt_designation,pdt_prix,pdt_image, pdt_categorie) values ('"
  .$ref."','"
  .$des."',"
  .$prix.",'"
  .$image."','"
  .$cat."');";
  
  // Lancer la requete d'ajout 
  $ok=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant
  
  // Si la requete a reussi
  if ($ok)
  {
    $message = "La fleur a ete correctement ajoutee";
    ajouterErreur($tabErr, $message);
    }
  else
  {
    $message = "Attention, l'ajout de la fleur a echoue !!!";
    ajouterErreur($tabErr, $message);
  } 

}

function rechercher($des)
{
    $connexion = connecterServeurBD();
    
    $fleur = array();
   
    $requete="select * from produit";
      $requete=$requete." where pdt_designation='".$des."';";
    
    $jeuResultat=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant
  
    $i = 0;
    $ligne = $jeuResultat->fetch();
    while($ligne)
    {
        $fleur[$i]['image']=$ligne['pdt_image'];
        $fleur[$i]['ref']=$ligne['pdt_ref'];
        $fleur[$i]['designation']=$ligne['pdt_designation'];
        $fleur[$i]['prix']=$ligne['pdt_prix'];
        $ligne=$jeuResultat->fetch();
        $i = $i + 1;
    }
    $jeuResultat->closeCursor();   // fermer le jeu de résultat
  
  return $fleur;
}

function supprimer($ref, &$tabErr)
{
    $connexion = connecterServeurBD();
    
    $fleur = array();
          
    $requete="delete from produit";
    $requete=$requete." where pdt_ref='".$ref."';";
    
    // Lancer la requete supprimer
    $ok=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant
      
    // Si la requete a reussi
    if ($ok)
    {
      $message = "La fleur a été correctement supprimée";
      ajouterErreur($tabErr, $message);
    }
    else
    {
      $message = "Attention, la suppression de la fleur a échoué !!!";
      ajouterErreur($tabErr, $message);
    }      
}


function modifier($ref, $des, $prix, $image, $cat,&$tabErr)
{
  
    // Ouvrir une connexion au serveur mysql en s'identifiant
    $connexion = connecterServeurBD();
    
    // Vérifier que la référence saisie n'existe pas déja
    $requete="select * from produit";
    $requete=$requete." where pdt_ref = '".$ref."';";              
   
    $jeuResultat=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant
  
    //$jeuResultat->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le resultat soit recuperable sous forme d'objet     
    
    $ligne = $jeuResultat->fetch();
    // Creer la requete de modification 
  
    $requete= "UPDATE `baselafleur1`.`produit` SET `pdt_designation` = '$des',
    `pdt_prix` = '$prix',
    `pdt_image` = '$image',
    `pdt_categorie` = '$cat' WHERE `produit`.`pdt_ref`='$ref';";
         
    // Lancer la requete d'ajout 
    $ok=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant
      
    // Si la requete a reussi
    if ($ok)
    {
      $message = "La fleur a ete correctement modifie";
      ajouterErreur($tabErr, $message);
    }
    else
    {
      $message = "Attention, la modification de la fleur a echoue !!!";
      ajouterErreur($tabErr, $message);
    } 
}


function rechercherUtilisateur($log, $psw, &$tabErr)
{
    $connexion = connecterServeurBD();
      
    $requete="select * from utilisateur";
      $requete=$requete." where nom='".$log."' and mdp ='".$psw."';";
    $jeuResultat=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant
  
    // Initialisationd de la categorie trouvee e : "aucune"
    $cat = "nulle";
    
    $ligne = $jeuResultat->fetch();
    
    // Si un utilisateur est trouve, on initialise une variable cat avec la categorie de cet utilisateur trouvee dans la table utilisateur
    if ($ligne)
    {
        $cat = $ligne['cat'];
    }
    $jeuResultat->closeCursor();   // fermer le jeu de resultat
  
  return $cat;
}

function ajouterClient($unNom,$unMdp,$unMdpVerif,$unCat,&$tabErr)
{

    // Ouvrir une connexion au serveur mysql en s'identifiant
  $connexion = connecterServeurBD();
  
  // Si la connexion au SGBD e reussi
  if (TRUE) 
  {
    if ($unMdpVerif==$unMdp)
    {
              $requete="select * from utilisateur";
            $requete=$requete." where nom = '".$unNom."';"; 
            $jeuResultat=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant

            $jeuResultat->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le resultat soit recuperable sous forme d'objet     
            
            $ligne = $jeuResultat->fetch();
            if($ligne)
            {
              $message="Echec de l'ajout : LE NOM  existe déja !";
              ajouterErreur($tabErr, $message);
            }
            else
            {
              // Creer la requete d'ajout 
              $requete="insert into utilisateur"
              ."(id,nom,mdp,cat) values ('"
              // .$unId."','"
              .$unNom."',"
              .$unMdp.",'"
              .$unCat."');";
              
                // Lancer la requète d'ajout 
                $ok=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant
              
                // Si la requete a reussi
                if ($ok)
                {
                  $message = "L'inscription à été validé";
                  ajouterErreur($tabErr, $message);
                }
                else
                {
                  $message = "L'inscription à échoué !!!";
                  ajouterErreur($tabErr, $message);
                } 

            }
            // fermer la connexion
            // deconnecterServeurBD($idConnexion);
          }
          else
    {
      $message = "les mdp sont diferents !!!!!! <br />";
    ajouterErreur($tabErr, $message);
    }
        }
    }

?>
