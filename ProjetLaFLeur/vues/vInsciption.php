

<script type="text/javascript">
//<![CDATA[

function valider(){
 frm=document.forms['formInscrire'];
  // si le prix est positif
  if(frm.elements['id'].value >0) {
    // les données sont ok, on peut envoyer le formulaire    
    return true;
  }
  else {
    // sinon on affiche un message
    alert("L'id doit être positif !");
    // et on indique de ne pas envoyer le formulaire
    return false;
  }
}
//]]>
</script>

<!--Saisie des informations dans un formulaire!-->
<div class="container">

<form name="formInscrire" action="" method="post" onSubmit="return valider()">
  <fieldset>
    <legend>Inscrivez vous </legend>
    <label>ID : </label> <input type="text" placeholder="Entrer l'id"name="id" size="10" /><br />
    <label>Nom :</label> <input type="text" name="nom" size="20" /><br />
    <label>Mot de passe :</label> <input type="text" name="mdp" size="20" /><br/>
    <label>Confirmer :</label> <input type="text" name="mdpVerif" size="20" /><br/>
    <label>Catégorie :</label>
    <select name="cat">
       <option selected value = "adm">Client</option>
    </select>
  </fieldset>
  <button type="submit" class="btn btn-primary">Enregistrer</button>
  <button type="reset" class="btn">Annuler</button>
  <p>
</form>
</div>