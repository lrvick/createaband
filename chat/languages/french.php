<?

/**

Replissez vous les valeur approprié dans le tableau sous.  Chaque ligne finirait avec une virgule SAUF pour la dernier ligne, qui ne pas, parce qu'il est la fin de tableau.

ttl => Les titres & étiquettes pour la principale zone de tchatche
opt => Les menus déroulants ou listes des options
msg => Les messages qui sont affiché dans les zones de texte
btn => Les étiquettes pour les boutons de fonction
rbn => Les étiquettes pour les boutons d'option
chk => Les étiquettes pour les cases à cocher

NOTE: Vous ne changeriez pas <name> et <room>.  Ces sont variables qui fusionnont avec les données réel pendant le cours du tchatche.

Special thanks to Holly Tomren for her contributions to this language module!

*/

$roomListMap = Array (

// la gauche doit égaler un salon dans le fichier config.php $rooms variable

"The Lounge" => "Le Salon",
"Current Events" => "l'Actualité"

);

$badWords = Array ( );  // please see english.php to show how this array is set up

$language = Array (

"ttl1" => "Qui Est Ici",
"ttl2" => "Tchatche",
"ttl3" => "Bienvenu",
"ttl4" => "Message:",
"ttl5" => "la Taille du Message",
"ttl6" => "la Taille de la Liste",
"ttl7" => "Qui Est Où",
"ttl8" => "Tous Utilisateurs",
"ttl9" => "Créez un nouveau salon! Les noms de salon contiendraient seulement A-Z,a-z,0-9. Entrez le nom de salon ici:",
"ttl10" => "Si créant un salon privé, choisissez les utilisateurs pour permettre l'accès de la liste. Ils seront envoyé une invitation pour joindre le tchatche privé quand le salon est créé.",
"ttl11" => "le Contrôle de Son Individuel",
"ttl12" => "le Volume",
"ttl13" => "le Equilibre",
"ttl17" => "les Skins",

"opt4" => "N/A",
"opt6" => "Envoyez invitation de tchatche privé à..",
"opt7" => "Envoyez un message privé à..",
"opt8" => "Bottez l'utilisateur de le salon seule..",
"opt9" => "Bottez l'utilisateur de tous salons..",
"opt10" => "Bannez le IP d'utilis. de toute activité..",
"opt11" => "la Salle Privée",
"opt12" => "- Choisissez l'Utilisateur -",
"opt13" => "- Choisissez l'Action -",
"opt15" => "- Choisissez la Fenêtre ",
"opt16" => "Fenêtre Principale du Tchatche",
"opt20" => "les Couleurs",
"opt21" => "les Options d'Affichage",
"opt22" => "les Salons Publics et Privés",
"opt23" => "Sauvegardez ce Tchatche",
"opt24" => "Recevez l'Aide",
"opt25" => "le Forum de Soutien",
"opt26" => "- les Options -",
"opt27" => "Déconnectez",

"btn1" => "Pause",
"btn3" => "Soumettez",
"btn4" => "Réinitialisez Couleurs",
"btn5" => "Effacez les Messages",
"btn6" => "Créez le Nouveau Salon",
"btn7" => "l'Échantillon",
"btn8" => "le Test",
"btn9" => "OK",

"rbn1" => "Métallique",
"rbn2" => "Ivoire",
"rbn3" => "Bleu-vert",
"rbn4" => "Olive",
"rbn5" => "Bleu foncé",
"rbn6" => "Rose",
"rbn7" => "à le Chêne",
"rbn8" => "Noir",
"rbn9" => "le Texte de Corps",
"rbn10" => "le Fond Principal",
"rbn11" => "le Fond de Bouton",
"rbn12" => "le Texte de Bouton",
"rbn13" => "le Texte d'Entrée",
"rbn14" => "le Fond d'Entrée",
"rbn15" => "le Texte de Dialogue",
"rbn16" => "le Fond de Dialogue",
"rbn17" => "les Messages de Système",
"rbn18" => "Émoticônes",
"rbn19" => "Notifiez d'Entrer Salon",
"rbn20" => "le Nom d'Utilisateur",
"rbn21" => "la Liste des Utilisateurs",
"rbn22" => "le Fond du Liste Utilis.",
"rbn23" => "Faites ce salon public",
"rbn24" => "Faites ce salon privé",

"chk1" => "Cachez le Profil",
"chk2" => "le Son d'Entrer le Salon",
"chk3" => "le Son de Partir le Salon",
"chk4" => "Recevez le Son de Message",
"chk5" => "Envoyez le Son de Message",
"chk6" => "Assourdenez Tous Sons",

"msg1" => "Bienvenu au forum de soutien, <name>!",
"msg2" => "Envoyer un message de soutien, choisissez le destinataire du menu déroulant.",
"msg3" => "Les espions ne peuvent pas activer des commandes spéciaux!",
"msg4" => "Un représentant sera avec vous bientôt. S'il n'y a pas de réponse, s'il vous plaît sonner la cloche pour recevoir notre attention.",
"msg5" => "Aucune Réponse? Sonnez la cloche..",
"msg6" => "Bienvenu au tchatche, <name>!",
"msg7" => "Vous ne pouvez pas entrer <room> parce que c'est à sa capacité d'utilisateur. S'il vous plaît attendez jusqu'à ce qu'un ou plus des utilisateurs part le salon.",
"msg8" => "(Saisez votre message ici et cliquez Soumettez)",
"msg9" => "Les espions ne peuvent pas soumettre au tchatche!",
"msg10" => "Choisissez s'il vous plaît un destinataire!",
"msg11" => "Vous ne pouvez pas envoyer un message à vous!",
"msg12" => "*** <name> sonne la cloche de soutien! ***",
"msg13" => "Tchatche privé invite",
"msg14" => "Votre invitation de tchatche privé a été envoyée. Pour entrer la salon privé <room>, choisissez de la liste des salons.",
"msg15" => "le Nouveau Salon Public",
"msg16" => "Un nouveau salon public nommée <room> a été créé, et tous utilisateurs actuels ont été notifiés de ce changement. Pour entrer le salon, choisissez de la liste des salons.",
"msg17" => "<name> a vous invité à un tchatche privée dans le <room> salon. Pour entrer le salon privé, choisissez de votre liste des salons.",
"msg18" => "<name> a créé un nouveau salon public de tchatche appelée <room>. Ce salon a été ajoutée à votre liste des salons.",
"msg19" => "Bottez",
"msg20" => "Bannez",
"msg21" => "<name> a vous botté de tous salons dans cette session de tchatche. Vous êtes maintenant déconnecté.",
"msg22" => "<name> a été botté de tous salons dans cette session de tchatche.",
"msg23" => "<name> a vous botté de <room> pour cette session de tchatche.",
"msg24" => "<name> a vous banni de tchatche. Votre adresse de IP (<ip>) a été noté pour empêcher le tchatche d'avenir re-entrer.",
"msg25" => "<name> a été banni de tchatche. Le IP de <name> (<ip>) a été noté pour empêcher le tchatche d'avenir re-entrer.",
"msg26" => "la Demande pour le Soutien",
"msg27" => "<name> a demandé le soutien",
"msg28" => "Vous ne pouvez pas entrer le tchatche en ce moment parce que chaque salon disponible est à sa capacité maximum.",
"msg29" => "Les noms de Salon peuvent contenir caractères seulement des alphanumériques.",
"msg30" => "Vous ne pouvez pas entrer le tchatche en ce moment parce que votre adresse de IP, <ip>, a été interdit de le tchatche.",
"msg31" => "(le modérateur)",
"msg34" => "Un salon avec ce nom existe déjà.",
"msg35" => "Entrez s'il vous plaît un nom pour ce nouveau salon.",
"msg36" => "<room> a été ajouté avec succès.",
"msg37" => "(dans privé)",
"msg38" => "(modéré)",
"msg40" => "Privé de <name>",
"msg41" => "le Message à <name>",
"msg42" => "Privé à <name>",
"msg43" => "Nous sommes désolés, mais le tchatche n'est pas disponible en ce moment. S'il vous plaît vérifiez le plan de tchatche et login pendant les heures normales d'opération.",
"msg50" => "est entré",
"msg51" => "<name> a été botté de <room> pour cette session de tchatche.",
"msg52" => "Sonnant...",
"msg53" => "Vous êtes déconnecté ."

);


?>
