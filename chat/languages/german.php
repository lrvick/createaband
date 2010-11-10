<?

/**

Geben Sie die entsprechenden Werte in die unteren Arrays. Jede Zeile sollte mit eimen Komma enden, ausser der letzten Zeile, da diese den Array schliesst.

ttl => Hauptchatbereich Titel & Beschriftungen
opt => Drop-down-Listen oder Optionenlisten
msg => Im Textbereich angezeigte Nachrichten
btn => Drück-Buttonbeschriftungen
rbn => Radio-Buttonbeschriftungen
chk => Checkboxbescriftungen

WICHTIG: <name> und <room> sollten nicht geändert werden. Diese Variablen werden in anderen Dateien mit Daten verbunden.
*/


$roomListMap = Array ( );

$badWords = Array ( "fick", "fickt", "ficken", "Fotze", "Scheisse", "Schlampe", "Asch", "Arschloch", "Arschlöcher" );

$language = Array(

"ttl1" => "Wer ist hier",
"ttl2" => "Der Chat",
"ttl3" => "Willkommen",
"ttl4" => "Nachricht:",
"ttl5" => "Nachrichtgrösse",
"ttl6" => "Userlistegrösse",
"ttl7" => "Wer ist wo",
"ttl8" => "Alle User",
"ttl9" => "Einen neuen Raum erstellen! Raumnamen dürfen nur alpha-numerische Zeichen (A-Z,a-z,0-9) enthalten. Raumnamen hie eingeben:",
"ttl10" => "Wenn Sie einen privaten Raum erstellen, wählen Sie aus der Liste Aller User jene, denen Sie Zutritt gewähren. Den Usern wird eine Einladung geschickt, sobald der Raum erstellt ist.",
"ttl11" => "Individuelle Sound Einstellung",
"ttl12" => "Lautstärke",
"ttl13" => "Balance",
"ttl17" => "Skins", 

"opt4" => "Keine",
"opt6" => "Private Einladung zum Chat senden zu...",
"opt7" => "Private Nachricht senden zu...",
"opt8" => "User von einem Raum ausschliessen......",
"opt9" => "User von allen Räumen ausschliessen...",
"opt10" => "User IP von allen Chataktivitäten ausschliessen...",
"opt11" => "Privater Raum",
"opt12" => "- User wählen -",
"opt13" => "- Aktion wählen -",
"opt15" => "- Fenster wählen -",
"opt16" => "Chathauptfenster",
"opt20" => "Anzeigeoptionen",
"opt21" => "Soundoptionen",
"opt22" => "Öffentliche und Private Räume",
"opt23" => "Diesen Chat Speichern",
"opt24" => "Hilfe Bekommen",
"opt25" => "Supportforum",
"opt26" => "- Optionen -",
"opt27" => "Logout",

"btn1" => "Pause",
"btn3" => "Senden",
"btn4" => "Farben Wiederherstellen",
"btn5" => "Nachrichten Löschen",
"btn6" => "Neuen Raum Erstelen",
"btn7" => "Beispiel",
"btn8" => "Test",
"btn9" => "OK",

"rbn1" => "Metallic",
"rbn2" => "Elfenbein",
"rbn3" => "Aqua",
"rbn4" => "Olive",
"rbn5" => "Navy",
"rbn6" => "Pink",
"rbn7" => "Eiche",
"rbn8" => "Schwarz",
"rbn9" => "Bodytext",
"rbn10" => "Haupthintergrund",
"rbn11" => "Buttonhintergrund",
"rbn12" => "Buttontext",
"rbn13" => "Eingabetext",
"rbn14" => "Eingabehintergrund",
"rbn15" => "Chattext",
"rbn16" => "Chathintergrund",
"rbn17" => "Systemnachrichen",
"rbn18" => "Smilies",
"rbn19" => "Raumeintrittbenachrichtigung",
"rbn20" => "Username",
"rbn21" => "Userliste",
"rbn22" => "Userlistenhintergrund",
"rbn23" => "Raum als öffentlich deklarieren",
"rbn24" => "Raum als privat deklarieren",

"chk1" => "Profil Verstecken",
"chk2" => "Raum Betreten - Sound",
"chk3" => "Raum Verlassen - Sound",
"chk4" => "Nachricht Empfangen - Sound",
"chk5" => "Nachricht Senden - Sound",
"chk6" => "Alle Sounds aus",

"msg1" => "Willkommen im Supportforum, <name>!",
"msg2" => "Um eine Supportnachricht zu senden, wählen Sie den Empfänger aus dem Drop-Down-Menü.",
"msg3" => "Spione haben keinen Zugriff auf Spezialbefehle!",
"msg4" => "Ein Repräsentant wird sich Ihnen bald widmen. Sollte dies nicht geschehen, bitte klingeln Sie an der Glocke, um uns auf Sie aufmersam zu machen.",
"msg5" => "Keine antwort? Klingle an der Glocke...",
"msg6" => "Willkommen zum Chat, <name>!",
"msg7" => "Sie können den Raum <room> nicht betretten, das dessen Userkapazitäten ausgelastet ist. Bitte warten Sie bis ein oder mehrere User den Raum verlassen haben.",
"msg8" => "(Geben Sie hier Ihre Nachricht ein und klicken Sie auf Senden)",
"msg9" => "Spione können sich nicht zum Chat anmelden!",
"msg10" => "Bitte, wählen Sie den Empfänger!",
"msg11" => "Sie können keine Nachricht an sich selbst senden!",
"msg12" => "*** <name> klingelt an der Glocke für Support! ***",
"msg13" => "Einladung zum Privatchat",
"msg14" => "Ihre private Einladung wurde versendet. Um den privaten Chatraum <room> zu betreten, wählen Sie diesen aus der Raumliste.",
"msg15" => "Neuer öffenlicher Raum",
"msg16" => "Ein neuer öffentlicher Raum mit dem Namen <room> wurde erstellt, und alle derzeitigen User wurden benachrichtigt. Um den Raum zu betreten, wählen Sie diesen aus der Raumliste.",
"msg17" => "<name> hat Sie zu einem Privatchat im <room>-Raum eingeladen. Um den privaten Chatraum zu betreten, wählen Sie diesen aus der Raumliste.",
"msg18" => "<name> hat einen neuen öffentlichen Raum mit dem Namen <room> erstellt. Dieser Raum wurde in die Raumliste eingetragen.",
"msg19" => "Ausschluss",
"msg20" => "Rauswurf",
"msg21" => "<name> hat Sie für diese Chatsession aus allen Räumen ausgeschlossen. Sie sind jetzt ausgeloggt.",
"msg22" => "<name> wurde für diese Chatsession aus allen Räumen ausgeschlossen.",
"msg23" => "<name> hat Sie für diese Chatsession aus dem Raum <room> ausgeschlossen.",
"msg24" => "<name> wurde vom Chat ausgeschlossen. Ihre IP-Adresse (<ip>) wurde gespeichert, um zukünftiges Wiederbetretten zu verhindern.",
"msg25" => "<name> wurde vom Chat ausgeschlossen. Die IP-Adresse von <name> (<ip>) wurde gespeichert, um zukünftiges Wiederbetretten zu verhindern.",
"msg26" => "Supportanfrage",
"msg27" => "<name> bittet um Support",
"msg28" => "Sie können den Chat zur Zeit nicht beretten, da die Kapazitäten aller verfügbaren Räume maximal ausgelastet sind.",
"msg29" => "Der Name des Raums darf nur alpha-numerische Zeichen enthalten.",
"msg30" => "Sie können den Chat zur Zeit nicht beretten, da Ihre IP-Adresse (<ip>) vom Chat ausgeschlossen wurde.",
"msg31" => "(Moderator)",
"msg34" => "Ein Raum mit diesem Namen existiert bereits.",
"msg35" => "Bitte einen Namen für den neuen Raum eingeben.",
"msg36" => "Raum <room> ist erfolgreich hinzugefügt worden.",
"msg37" => "(in privat)",
"msg38" => "(moderated)",
"msg40" => "Privat von <name>",
"msg41" => "Nachricht zu <name>",
"msg42" => "Privat zu <name>",
"msg43" => "Es tut uns leid, aber der Chat ist zu dieser Zeit nicht verfügbar. Bitte, prüfen Sie die Chatöffnungszeiten und loggen Sie zur regulären Betriebszeit ein.",
"msg50" => "hat den Raum betreten",
"msg51" => "<name> wurde  für diese Chatsession aus dem Raum <room> ausgeschlossen.",
"msg52" => "Rufe an...",
"msg53" => "Sie sind jetzt ausgeloggt."

);

?>