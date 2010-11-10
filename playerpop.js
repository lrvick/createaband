var windowW=300 // wide
var windowH=255 // high

var windowX = (screen.width/2)-(windowW/2);
var windowY = (screen.height/2)-(windowH/2);

var urlPop = "play.php"
var title = "Site Name Player"

// set this to true if the popup should close
// upon leaving the launching page; else, false

var autoclose = true

s = "width="+windowW+",height="+windowH;
var beIE = document.all?true:false

function openFrameless(id,cat,tt)	{
	if (beIE)	{
		NFW = window.open("","popFrameless",s)
		NFW.blur()
		window.focus()
		NFW.resizeTo(windowW,windowH)
		NFW.moveTo(windowX,windowY)
		var frameString=""+"<html>"+"<head>"+"<title>"+title+"</title>"+"</head>"+
		"<frameset rows='*,0' framespacing=0 border=0 frameborder=0>"+
		"<frame name='top' src='"+urlPop+"?play="+id+"&cat="+cat+"&tt="+tt+"' scrolling=auto>"+
		"<frame name='bottom' src='about:blank' scrolling='no'>"+"</frameset>"+"</html>"
		NFW.document.open();
		NFW.document.write(frameString)
		NFW.document.close()
	} else {
		NFW=window.open(urlPop,"popFrameless","scrollbars,"+s)
		NFW.blur()
		window.focus()
		NFW.resizeTo(windowW,windowH)
		NFW.moveTo(windowX,windowY)
	}
	NFW.focus()
	if (autoclose)	{
		window.onunload = function(){NFW.close()}
	}
}