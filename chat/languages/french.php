<?

/**

Replissez vous les valeur appropri� dans le tableau sous.  Chaque ligne finirait avec une virgule SAUF pour la dernier ligne, qui ne pas, parce qu'il est la fin de tableau.

ttl => Les titres & �tiquettes pour la principale zone de tchatche
opt => Les menus d�roulants ou listes des options
msg => Les messages qui sont affich� dans les zones de texte
btn => Les �tiquettes pour les boutons de fonction
rbn => Les �tiquettes pour les boutons d'option
chk => Les �tiquettes pour les cases � cocher

NOTE: Vous ne changeriez pas <name> et <room>.  Ces sont variables qui fusionnont avec les donn�es r�el pendant le cours du tchatche.

Special thanks to Holly Tomren for her contributions to this language module!

*/

$roomListMap = Array (

// la gauche doit �galer un salon dans le fichier config.php $rooms variable

"The Lounge" => "Le Salon",
"Current Events" => "l'Actualit�"

);

$badWords = Array ( );  // please see english.php to show how this array is set up

$language = Array (

"ttl1" => "Qui Est Ici",
"ttl2" => "Tchatche",
"ttl3" => "Bienvenu",
"ttl4" => "Message:",
"ttl5" => "la Taille du Message",
"ttl6" => "la Taille de la Liste",
"ttl7" => "Qui Est O�",
"ttl8" => "Tous Utilisateurs",
"ttl9" => "Cr�ez un nouveau salon! Les noms de salon contiendraient seulement A-Z,a-z,0-9. Entrez le nom de salon ici:",
"ttl10" => "Si cr�ant un salon priv�, choisissez les utilisateurs pour permettre l'acc�s de la liste. Ils seront envoy� une invitation pour joindre le tchatche priv� quand le salon est cr��.",
"ttl11" => "le Contr�le de Son Individuel",
"ttl12" => "le Volume",
"ttl13" => "le Equilibre",
"ttl17" => "les Skins",

"opt4" => "N/A",
"opt6" => "Envoyez invitation de tchatche priv� �..",
"opt7" => "Envoyez un message priv� �..",
"opt8" => "Bottez l'utilisateur de le salon seule..",
"opt9" => "Bottez l'utilisateur de tous salons..",
"opt10" => "Bannez le IP d'utilis. de toute activit�..",
"opt11" => "la Salle Priv�e",
"opt12" => "- Choisissez l'Utilisateur -",
"opt13" => "- Choisissez l'Action -",
"opt15" => "- Choisissez la Fen�tre ",
"opt16" => "Fen�tre Principale du Tchatche",
"opt20" => "les Couleurs",
"opt21" => "les Options d'Affichage",
"opt22" => "les Salons Publics et Priv�s",
"opt23" => "Sauvegardez ce Tchatche",
"opt24" => "Recevez l'Aide",
"opt25" => "le Forum de Soutien",
"opt26" => "- les Options -",
"opt27" => "D�connectez",

"btn1" => "Pause",
"btn3" => "Soumettez",
"btn4" => "R�initialisez Couleurs",
"btn5" => "Effacez les Messages",
"btn6" => "Cr�ez le Nouveau Salon",
"btn7" => "l'�chantillon",
"btn8" => "le Test",
"btn9" => "OK",

"rbn1" => "M�tallique",
"rbn2" => "Ivoire",
"rbn3" => "Bleu-vert",
"rbn4" => "Olive",
"rbn5" => "Bleu fonc�",
"rbn6" => "Rose",
"rbn7" => "� le Ch�ne",
"rbn8" => "Noir",
"rbn9" => "le Texte de Corps",
"rbn10" => "le Fond Principal",
"rbn11" => "le Fond de Bouton",
"rbn12" => "le Texte de Bouton",
"rbn13" => "le Texte d'Entr�e",
"rbn14" => "le Fond d'Entr�e",
"rbn15" => "le Texte de Dialogue",
"rbn16" => "le Fond de Dialogue",
"rbn17" => "les Messages de Syst�me",
"rbn18" => "�motic�nes",
"rbn19" => "Notifiez d'Entrer Salon",
"rbn20" => "le Nom d'Utilisateur",
"rbn21" => "la Liste des Utilisateurs",
"rbn22" => "le Fond du Liste Utilis.",
"rbn23" => "Faites ce salon public",
"rbn24" => "Faites ce salon priv�",

"chk1" => "Cachez le Profil",
"chk2" => "le Son d'Entrer le Salon",
"chk3" => "le Son de Partir le Salon",
"chk4" => "Recevez le Son de Message",
"chk5" => "Envoyez le Son de Message",
"chk6" => "Assourdenez Tous Sons",

"msg1" => "Bienvenu au forum de soutien, <name>!",
"msg2" => "Envoyer un message de soutien, choisissez le destinataire du menu d�roulant.",
"msg3" => "Les espions ne peuvent pas activer des commandes sp�ciaux!",
"msg4" => "Un repr�sentant sera avec vous bient�t. S'il n'y a pas de r�ponse, s'il vous pla�t sonner la cloche pour recevoir notre attention.",
"msg5" => "Aucune R�ponse? Sonnez la cloche..",
"msg6" => "Bienvenu au tchatche, <name>!",
"msg7" => "Vous ne pouvez pas entrer <room> parce que c'est � sa capacit� d'utilisateur. S'il vous pla�t attendez jusqu'� ce qu'un ou plus des utilisateurs part le salon.",
"msg8" => "(Saisez votre message ici et cliquez Soumettez)",
"msg9" => "Les espions ne peuvent pas soumettre au tchatche!",
"msg10" => "Choisissez s'il vous pla�t un destinataire!",
"msg11" => "Vous ne pouvez pas envoyer un message � vous!",
"msg12" => "*** <name> sonne la cloche de soutien! ***",
"msg13" => "Tchatche priv� invite",
"msg14" => "Votre invitation de tchatche priv� a �t� envoy�e. Pour entrer la salon priv� <room>, choisissez de la liste des salons.",
"msg15" => "le Nouveau Salon Public",
"msg16" => "Un nouveau salon public nomm�e <room> a �t� cr��, et tous utilisateurs actuels ont �t� notifi�s de ce changement. Pour entrer le salon, choisissez de la liste des salons.",
"msg17" => "<name> a vous invit� � un tchatche priv�e dans le <room> salon. Pour entrer le salon priv�, choisissez de votre liste des salons.",
"msg18" => "<name> a cr�� un nouveau salon public de tchatche appel�e <room>. Ce salon a �t� ajout�e � votre liste des salons.",
"msg19" => "Bottez",
"msg20" => "Bannez",
"msg21" => "<name> a vous bott� de tous salons dans cette session de tchatche. Vous �tes maintenant d�connect�.",
"msg22" => "<name> a �t� bott� de tous salons dans cette session de tchatche.",
"msg23" => "<name> a vous bott� de <room> pour cette session de tchatche.",
"msg24" => "<name> a vous banni de tchatche. Votre adresse de IP (<ip>) a �t� not� pour emp�cher le tchatche d'avenir re-entrer.",
"msg25" => "<name> a �t� banni de tchatche. Le IP de <name> (<ip>) a �t� not� pour emp�cher le tchatche d'avenir re-entrer.",
"msg26" => "la Demande pour le Soutien",
"msg27" => "<name> a demand� le soutien",
"msg28" => "Vous ne pouvez pas entrer le tchatche en ce moment parce que chaque salon disponible est � sa capacit� maximum.",
"msg29" => "Les noms de Salon peuvent contenir caract�res seulement des alphanum�riques.",
"msg30" => "Vous ne pouvez pas entrer le tchatche en ce moment parce que votre adresse de IP, <ip>, a �t� interdit de le tchatche.",
"msg31" => "(le mod�rateur)",
"msg34" => "Un salon avec ce nom existe d�j�.",
"msg35" => "Entrez s'il vous pla�t un nom pour ce nouveau salon.",
"msg36" => "<room> a �t� ajout� avec succ�s.",
"msg37" => "(dans priv�)",
"msg38" => "(mod�r�)",
"msg40" => "Priv� de <name>",
"msg41" => "le Message � <name>",
"msg42" => "Priv� � <name>",
"msg43" => "Nous sommes d�sol�s, mais le tchatche n'est pas disponible en ce moment. S'il vous pla�t v�rifiez le plan de tchatche et login pendant les heures normales d'op�ration.",
"msg50" => "est entr�",
"msg51" => "<name> a �t� bott� de <room> pour cette session de tchatche.",
"msg52" => "Sonnant...",
"msg53" => "Vous �tes d�connect� ."

);


?>
