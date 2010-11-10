<?

/**

Fill in the appropriate values into the array below. Each line should end with a comma EXCEPT for the last line, which does not, since it is the end of the array.

ttl => Main chat area titles & labels
opt => Drop-down or option lists
msg => Messages displayed in the text areas
btn => Push-button labels
rbn => Radio-button labels
chk => Checkbox labels

NOTE: <name> and <room> should not be changed. These are variables that will merge with real data during the course of the chat.

*/


$roomListMap = Array ( );

$badWords = Array ( "puta", "marica", "malparido", "malparida", "pirobo", "verga", "coño", "pija" );

$language = Array(

"ttl1" => "Quién está",
"ttl2" => "El chat",
"ttl3" => "Bienvenido(a)",
"ttl4" => "Mensaje:",
"ttl5" => "Tamaño del mensaje",
"ttl6" => "Lisa de usuarios",
"ttl7" => "Quién está donde?",
"ttl8" => "Todos los usuarios",
"ttl9" => "Crear una nueva sala! Los nombres de la sala sólo deben contener caracteres alfanuméricos (A-Z,a-z,0-9). Ingrese el nombre de la sala aquí:",
"ttl10" => "Si esta creando una sala privada, seleccione los usuarios a los que quiere permitir el acceso desde la lista de todos los usuarios. Ellos recibirán una invitación para unirse al chat privado cuando la sala sea creada.",
"ttl11" => "Control individual de sonido",
"ttl12" => "Volumen",
"ttl13" => "Balance",
"ttl17" => "Temas",

"opt4" => "N/A",
"opt6" => "Enviar una invitación a una sala privada a...",
"opt7" => "Enviar menaje privado a...",
"opt8" => "Expulsar al usuario de una sola sala...",
"opt9" => "Expulsar al usuario de todas las salas...",
"opt10" => "Banear la IP del usuario del chat...",
"opt11" => "Sala privada",
"opt12" => "- Selecciones usuario -",
"opt13" => "- Seleccionar acción -",
"opt15" => "- Seleccionar ventana -",
"opt16" => "Ventana principal de chat",
"opt20" => "Opciones de apariencia",
"opt21" => "Control de sonido",
"opt22" => "Salas públicas y privadas",
"opt23" => "Guardar esta converación",
"opt24" => "Obtener ayuda",
"opt25" => "Foro de soporte",
"opt26" => "- Opciones -",
"opt27" => "Salir",

"btn1" => "Pausa",
"btn3" => "Enviar",
"btn4" => "Reestablecer colores",
"btn5" => "Borrar mensajes",
"btn6" => "Crear nueva sala",
"btn7" => "Ejemplo",
"btn8" => "Prueba",
"btn9" => "OK",

"rbn1" => "Metalico",
"rbn2" => "Marfil",
"rbn3" => "Agua",
"rbn4" => "Oliva",
"rbn5" => "Azul",
"rbn6" => "Rosado",
"rbn7" => "Roble",
"rbn8" => "Negro",
"rbn9" => "Texto del contenido",
"rbn10" => "Fondo principal",
"rbn11" => "Fondo del botón",
"rbn12" => "Texto del botón",
"rbn13" => "Texto del campo de texto",
"rbn14" => "Fondo del campo de texto",
"rbn15" => "Texto del chat",
"rbn16" => "Fondo del chat",
"rbn17" => "Mensajes de sistema",
"rbn18" => "Íconos",
"rbn19" => "Notificar ingreso a la sala",
"rbn20" => "Nombre de usuario",
"rbn21" => "Lista de usuarios",
"rbn22" => "Fondo de la lista de usuarios",
"rbn23" => "Hacer pública esta sala",
"rbn24" => "Hacer privada esta sala",

"chk1" => "No mostrar perfil",
"chk2" => "Sonido de entrada a la sala",
"chk3" => "Sonido de abandono de la sala",
"chk4" => "Sonido al recibir un mensaje",
"chk5" => "Sonido al enviar un mensaje",
"chk6" => "Silenciar todos los sonidos",

"msg1" => "Bienvenido al foro de soporte, <name>!",
"msg2" => "Para enviar un mensaje de soporte, escoja el receptor de la lista desplegable.",
"msg3" => "Los espías no pueden activar comandos especiales!",
"msg4" => "Un representante lo atenderá pronto. Si no hay respuesta, por favor toque el timbre para solicitar nuestra atención.",
"msg5" => "No hay respuesta?, toque el timbre...",
"msg6" => "Bienvenido al chat, <name>!",
"msg7" => "No es posible que ingrese a la sala <room> porque se encuentra en su máxima capacidad de usuarios. Por favor espere hasta que uno o más usuarios abandonen la salam.",
"msg8" => "(Escriba su mensaje aquí y presione Enviar)",
"msg9" => "Los espías no pueden enviar nada al chat!",
"msg10" => "Por favor seleccione un receptor!",
"msg11" => "No puede enviarse un mensaje a sí mismo!",
"msg12" => "*** <name> está tocando el timbre de soporte! ***",
"msg13" => "Invitar a chat privado",
"msg14" => "Su invitación al chat privado ha sido enviada. Para ingresar a la sala privada <room>, selecciónela de la lista de salas.",
"msg15" => "Nueva sala pública",
"msg16" => "Ha sido creada una nueva sala pública llamada <room>, y todos los usuarios actuales han sido notificados de este cambio. Para ingresar a la sala, selecciónela de la lista de salas.",
"msg17" => "<name> lo(la) ha invitado a un chat privado en la sala <room>. Para ingresar a la sala privada, selecciónela de su lista de salas.",
"msg18" => "<name> ha creado una nueva sala de chat pública llamada <room>. Esta sala se ha añadido a su lista de salas.",
"msg19" => "Expulsar",
"msg20" => "Banear",
"msg21" => "<name> lo(la) ha expulsado de todas las salas en esta esión de chat. Ahora se encuentra desconectado del chat.",
"msg22" => "<name> ha sido expulsado(a) de todas las salas en esta sesión de chat.",
"msg23" => "<name> lo(la) ha expulsado de la sala <room> por esta sesión de chat.",
"msg24" => "<name> lo(la) ha baneado del chat. su dirección IP (<ip>) ha sido registrada para prevenir futuros reintentos de acceso al chat.",
"msg25" => "<name> ha sido baneado del chat. La IP de <name> (<ip>) ha sido registrada para prevenir futuros reintentos de acceso al chat.",
"msg26" => "Solicitar soporte",
"msg27" => "<name> ha solicitado soporte",
"msg28" => "No puede ingresar al chat en este momento porque todas las salas disponibles se encuentran a su máxima capacidad de usuarios.",
"msg29" => "Los nombres de las salas deben contener unicamente caracteres alfanuméricos.",
"msg30" => "No puede ingresar al chat en este momento porque su dirección IP, <ip>, ha sido baneada del chat.",
"msg31" => "(moderador)",
"msg34" => "Ya existe una sala con ese nombre.",
"msg35" => "Por favor ingrese un nombre para la nueva sala.",
"msg36" => "La sala <room> ha sido añasida exitosamente.",
"msg37" => "(en privado)",
"msg38" => "(moderada)",
"msg40" => "Mensaje privado de <name>",
"msg41" => "Mensaje a <name>",
"msg42" => "Mensaje privado a <name>",
"msg43" => "Lo sentimos, pero el chat no está disponible en este momento. Por favor verifique los horarios de chat e ingrese durante las horras normales de operación.",
"msg50" => "ha ingresado",
"msg51" => "<name> ha sido expulsado de la sala <room> por esta sesión de chat.",
"msg52" => "Timbrando...",
"msg53" => "Usted se ha desconectado del chat."

);

?>