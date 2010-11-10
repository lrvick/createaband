function getNumeric(text)//to convert a string to numeric format(ex:123.32 two decimals)
{
	var str=text;
	var ln=str.length;
	var i;
	var nval;
	nval="";
	if (ln==0){return nval;}
	for(i=0;i<=ln-1;i++)
	{
		if (str.charAt(i)=="." && str.indexOf(".")==i)
		{
			nval=nval + str.charAt(i);
		}
		else if (!isNaN(str.charAt(i)) &&  str.charAt(i)!= " ")
		{
			if(str.indexOf(".")>=0 && i <= str.indexOf(".")+2)
			{
			nval=nval + str.charAt(i);
			}
			else if(str.indexOf(".")<0)
			{
			nval=nval + str.charAt(i);
			}
		}
		else
		{
			break;
		}
	}
	return nval;
}

function Numeric(text)
{
	var str=text;
	var ln=str.length;
	var i;
	var nval;
	nval="";
	if (ln==0){return "";}
	for(i=0;i<=ln-1;i++)
	{
		if (!isNaN(str.charAt(i)) &&  str.charAt(i)!= " ")
		{
			nval=nval + str.charAt(i);
		}
		else
		{
			break;
		}
	}
	if (nval==""){nval="";}
	return nval;
}

function trim(text) // to trim a string
{
	var str=text;
	var ln=str.length;
	if (ln==0){return str;}
	while(str.charAt(0)==" ")
	{
		str=str.substr(1);
	}
	ln=str.length;
	while(str.charAt(ln-1)==" ")
	{
		str=str.substring(0,ln-1);
		ln=str.length;
	}
	return str;
}