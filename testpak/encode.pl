#!/usr/bin/perl
use strict;

my %FORM = ();
&WebForm( \%FORM );

my $input = &html_encode( $FORM{'input'} );
my $html_encoded = &html_encode( $input );
my $url_encoded = &url_encode( $FORM{'input'} );


print "Content-Type: text/html\015\012\015\012";
print <<"EOM";

<HTML>
<HEAD>
	<TITLE>Web Encoding Utility</TITLE>

<STYLE TYPE="text/css"><!--
BODY {
	margin-top:20px;
	margin-bottom:20px;
	}
INPUT.submit,SPAN,BODY, TH, TD, UL, LI, P {
	font-family:verdana;
	font-size:10pt;
	}
A:hover {
	color:#ce0000;
	}
.small {
	font-size:8pt;
	}
IMG {
	border-color:#000000;
	}
TEXTAREA,INPUT,PRE {
	font-family:monospace;
	}
INPUT.submit {
	cursor:hand;
	background-color:#ffffff;
	}

//--></STYLE>
</HEAD>
<BODY>
<CENTER><DIV STYLE="width:638px;align:center;text-align:left">


EOM

	&TestPak_h();

print <<"EOM";

<P><B><A HREF="$ENV{'SCRIPT_NAME'}">Encoding Test</A></B></P>




<TABLE BORDER=0>
<TR VALIGN=top>
	<TD>

<P><B>Character Reference</B></P>

<TABLE BORDER=0 CELLPADDING=4 CELLSPACING=1 BGCOLOR="#000000">
<TR BGCOLOR=#9eb3c7>
	<TH COLSPAN=2>Character</TH>
	<TH>HTML</TH>
	<TH>URL</TH>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>1</TD>
	<TD>&#1;</TD>
	<TD>&amp;#1;</TD>
	<TD>%01</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>2</TD>
	<TD>&#2;</TD>
	<TD>&amp;#2;</TD>
	<TD>%02</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>3</TD>
	<TD>&#3;</TD>
	<TD>&amp;#3;</TD>
	<TD>%03</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>4</TD>
	<TD>&#4;</TD>
	<TD>&amp;#4;</TD>
	<TD>%04</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>5</TD>
	<TD>&#5;</TD>
	<TD>&amp;#5;</TD>
	<TD>%05</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>6</TD>
	<TD>&#6;</TD>
	<TD>&amp;#6;</TD>
	<TD>%06</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>7</TD>
	<TD>&#7;</TD>
	<TD>&amp;#7;</TD>
	<TD>%07</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>8</TD>
	<TD>&#8;</TD>
	<TD>&amp;#8;</TD>
	<TD>%08</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>9</TD>
	<TD>&#9;</TD>
	<TD>&amp;#9;</TD>
	<TD>%09</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>10</TD>
	<TD>&#10;</TD>
	<TD>&amp;#10;</TD>
	<TD>%0A</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>11</TD>
	<TD>&#11;</TD>
	<TD>&amp;#11;</TD>
	<TD>%0B</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>12</TD>
	<TD>&#12;</TD>
	<TD>&amp;#12;</TD>
	<TD>%0C</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>13</TD>
	<TD>&#13;</TD>
	<TD>&amp;#13;</TD>
	<TD>%0D</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>14</TD>
	<TD>&#14;</TD>
	<TD>&amp;#14;</TD>
	<TD>%0E</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>15</TD>
	<TD>&#15;</TD>
	<TD>&amp;#15;</TD>
	<TD>%0F</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>16</TD>
	<TD>&#16;</TD>
	<TD>&amp;#16;</TD>
	<TD>%10</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>17</TD>
	<TD>&#17;</TD>
	<TD>&amp;#17;</TD>
	<TD>%11</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>18</TD>
	<TD>&#18;</TD>
	<TD>&amp;#18;</TD>
	<TD>%12</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>19</TD>
	<TD>&#19;</TD>
	<TD>&amp;#19;</TD>
	<TD>%13</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>20</TD>
	<TD>&#20;</TD>
	<TD>&amp;#20;</TD>
	<TD>%14</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>21</TD>
	<TD>&#21;</TD>
	<TD>&amp;#21;</TD>
	<TD>%15</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>22</TD>
	<TD>&#22;</TD>
	<TD>&amp;#22;</TD>
	<TD>%16</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>23</TD>
	<TD>&#23;</TD>
	<TD>&amp;#23;</TD>
	<TD>%17</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>24</TD>
	<TD>&#24;</TD>
	<TD>&amp;#24;</TD>
	<TD>%18</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>25</TD>
	<TD>&#25;</TD>
	<TD>&amp;#25;</TD>
	<TD>%19</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>26</TD>
	<TD>&#26;</TD>
	<TD>&amp;#26;</TD>
	<TD>%1A</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>27</TD>
	<TD>&#27;</TD>
	<TD>&amp;#27;</TD>
	<TD>%1B</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>28</TD>
	<TD>&#28;</TD>
	<TD>&amp;#28;</TD>
	<TD>%1C</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>29</TD>
	<TD>&#29;</TD>
	<TD>&amp;#29;</TD>
	<TD>%1D</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>30</TD>
	<TD>&#30;</TD>
	<TD>&amp;#30;</TD>
	<TD>%1E</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>31</TD>
	<TD>&#31;</TD>
	<TD>&amp;#31;</TD>
	<TD>%1F</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>32</TD>
	<TD>&#32;</TD>
	<TD>&amp;#32;</TD>
	<TD>%20</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>33</TD>
	<TD>&#33;</TD>
	<TD>&amp;#33;</TD>
	<TD>%21</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>34</TD>
	<TD>&#34;</TD>
	<TD>&amp;#34;</TD>
	<TD>%22</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>35</TD>
	<TD>&#35;</TD>
	<TD>&amp;#35;</TD>
	<TD>%23</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>36</TD>
	<TD>&#36;</TD>
	<TD>&amp;#36;</TD>
	<TD>%24</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>37</TD>
	<TD>&#37;</TD>
	<TD>&amp;#37;</TD>
	<TD>%25</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>38</TD>
	<TD>&#38;</TD>
	<TD>&amp;#38;</TD>
	<TD>%26</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>39</TD>
	<TD>&#39;</TD>
	<TD>&amp;#39;</TD>
	<TD>%27</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>40</TD>
	<TD>&#40;</TD>
	<TD>&amp;#40;</TD>
	<TD>%28</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>41</TD>
	<TD>&#41;</TD>
	<TD>&amp;#41;</TD>
	<TD>%29</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>42</TD>
	<TD>&#42;</TD>
	<TD>&amp;#42;</TD>
	<TD>%2A</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>43</TD>
	<TD>&#43;</TD>
	<TD>&amp;#43;</TD>
	<TD>%2B</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>44</TD>
	<TD>&#44;</TD>
	<TD>&amp;#44;</TD>
	<TD>%2C</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>45</TD>
	<TD>&#45;</TD>
	<TD>&amp;#45;</TD>
	<TD>%2D</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>46</TD>
	<TD>&#46;</TD>
	<TD>&amp;#46;</TD>
	<TD>%2E</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>47</TD>
	<TD>&#47;</TD>
	<TD>&amp;#47;</TD>
	<TD>%2F</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>48</TD>
	<TD>&#48;</TD>
	<TD>&amp;#48;</TD>
	<TD>%30</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>49</TD>
	<TD>&#49;</TD>
	<TD>&amp;#49;</TD>
	<TD>%31</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>50</TD>
	<TD>&#50;</TD>
	<TD>&amp;#50;</TD>
	<TD>%32</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>51</TD>
	<TD>&#51;</TD>
	<TD>&amp;#51;</TD>
	<TD>%33</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>52</TD>
	<TD>&#52;</TD>
	<TD>&amp;#52;</TD>
	<TD>%34</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>53</TD>
	<TD>&#53;</TD>
	<TD>&amp;#53;</TD>
	<TD>%35</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>54</TD>
	<TD>&#54;</TD>
	<TD>&amp;#54;</TD>
	<TD>%36</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>55</TD>
	<TD>&#55;</TD>
	<TD>&amp;#55;</TD>
	<TD>%37</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>56</TD>
	<TD>&#56;</TD>
	<TD>&amp;#56;</TD>
	<TD>%38</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>57</TD>
	<TD>&#57;</TD>
	<TD>&amp;#57;</TD>
	<TD>%39</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>58</TD>
	<TD>&#58;</TD>
	<TD>&amp;#58;</TD>
	<TD>%3A</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>59</TD>
	<TD>&#59;</TD>
	<TD>&amp;#59;</TD>
	<TD>%3B</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>60</TD>
	<TD>&#60;</TD>
	<TD>&amp;#60;</TD>
	<TD>%3C</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>61</TD>
	<TD>&#61;</TD>
	<TD>&amp;#61;</TD>
	<TD>%3D</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>62</TD>
	<TD>&#62;</TD>
	<TD>&amp;#62;</TD>
	<TD>%3E</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>63</TD>
	<TD>&#63;</TD>
	<TD>&amp;#63;</TD>
	<TD>%3F</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>64</TD>
	<TD>&#64;</TD>
	<TD>&amp;#64;</TD>
	<TD>%40</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>65</TD>
	<TD>&#65;</TD>
	<TD>&amp;#65;</TD>
	<TD>%41</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>66</TD>
	<TD>&#66;</TD>
	<TD>&amp;#66;</TD>
	<TD>%42</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>67</TD>
	<TD>&#67;</TD>
	<TD>&amp;#67;</TD>
	<TD>%43</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>68</TD>
	<TD>&#68;</TD>
	<TD>&amp;#68;</TD>
	<TD>%44</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>69</TD>
	<TD>&#69;</TD>
	<TD>&amp;#69;</TD>
	<TD>%45</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>70</TD>
	<TD>&#70;</TD>
	<TD>&amp;#70;</TD>
	<TD>%46</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>71</TD>
	<TD>&#71;</TD>
	<TD>&amp;#71;</TD>
	<TD>%47</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>72</TD>
	<TD>&#72;</TD>
	<TD>&amp;#72;</TD>
	<TD>%48</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>73</TD>
	<TD>&#73;</TD>
	<TD>&amp;#73;</TD>
	<TD>%49</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>74</TD>
	<TD>&#74;</TD>
	<TD>&amp;#74;</TD>
	<TD>%4A</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>75</TD>
	<TD>&#75;</TD>
	<TD>&amp;#75;</TD>
	<TD>%4B</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>76</TD>
	<TD>&#76;</TD>
	<TD>&amp;#76;</TD>
	<TD>%4C</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>77</TD>
	<TD>&#77;</TD>
	<TD>&amp;#77;</TD>
	<TD>%4D</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>78</TD>
	<TD>&#78;</TD>
	<TD>&amp;#78;</TD>
	<TD>%4E</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>79</TD>
	<TD>&#79;</TD>
	<TD>&amp;#79;</TD>
	<TD>%4F</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>80</TD>
	<TD>&#80;</TD>
	<TD>&amp;#80;</TD>
	<TD>%50</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>81</TD>
	<TD>&#81;</TD>
	<TD>&amp;#81;</TD>
	<TD>%51</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>82</TD>
	<TD>&#82;</TD>
	<TD>&amp;#82;</TD>
	<TD>%52</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>83</TD>
	<TD>&#83;</TD>
	<TD>&amp;#83;</TD>
	<TD>%53</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>84</TD>
	<TD>&#84;</TD>
	<TD>&amp;#84;</TD>
	<TD>%54</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>85</TD>
	<TD>&#85;</TD>
	<TD>&amp;#85;</TD>
	<TD>%55</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>86</TD>
	<TD>&#86;</TD>
	<TD>&amp;#86;</TD>
	<TD>%56</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>87</TD>
	<TD>&#87;</TD>
	<TD>&amp;#87;</TD>
	<TD>%57</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>88</TD>
	<TD>&#88;</TD>
	<TD>&amp;#88;</TD>
	<TD>%58</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>89</TD>
	<TD>&#89;</TD>
	<TD>&amp;#89;</TD>
	<TD>%59</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>90</TD>
	<TD>&#90;</TD>
	<TD>&amp;#90;</TD>
	<TD>%5A</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>91</TD>
	<TD>&#91;</TD>
	<TD>&amp;#91;</TD>
	<TD>%5B</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>92</TD>
	<TD>&#92;</TD>
	<TD>&amp;#92;</TD>
	<TD>%5C</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>93</TD>
	<TD>&#93;</TD>
	<TD>&amp;#93;</TD>
	<TD>%5D</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>94</TD>
	<TD>&#94;</TD>
	<TD>&amp;#94;</TD>
	<TD>%5E</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>95</TD>
	<TD>&#95;</TD>
	<TD>&amp;#95;</TD>
	<TD>%5F</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>96</TD>
	<TD>&#96;</TD>
	<TD>&amp;#96;</TD>
	<TD>%60</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>97</TD>
	<TD>&#97;</TD>
	<TD>&amp;#97;</TD>
	<TD>%61</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>98</TD>
	<TD>&#98;</TD>
	<TD>&amp;#98;</TD>
	<TD>%62</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>99</TD>
	<TD>&#99;</TD>
	<TD>&amp;#99;</TD>
	<TD>%63</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>100</TD>
	<TD>&#100;</TD>
	<TD>&amp;#100;</TD>
	<TD>%64</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>101</TD>
	<TD>&#101;</TD>
	<TD>&amp;#101;</TD>
	<TD>%65</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>102</TD>
	<TD>&#102;</TD>
	<TD>&amp;#102;</TD>
	<TD>%66</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>103</TD>
	<TD>&#103;</TD>
	<TD>&amp;#103;</TD>
	<TD>%67</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>104</TD>
	<TD>&#104;</TD>
	<TD>&amp;#104;</TD>
	<TD>%68</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>105</TD>
	<TD>&#105;</TD>
	<TD>&amp;#105;</TD>
	<TD>%69</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>106</TD>
	<TD>&#106;</TD>
	<TD>&amp;#106;</TD>
	<TD>%6A</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>107</TD>
	<TD>&#107;</TD>
	<TD>&amp;#107;</TD>
	<TD>%6B</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>108</TD>
	<TD>&#108;</TD>
	<TD>&amp;#108;</TD>
	<TD>%6C</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>109</TD>
	<TD>&#109;</TD>
	<TD>&amp;#109;</TD>
	<TD>%6D</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>110</TD>
	<TD>&#110;</TD>
	<TD>&amp;#110;</TD>
	<TD>%6E</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>111</TD>
	<TD>&#111;</TD>
	<TD>&amp;#111;</TD>
	<TD>%6F</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>112</TD>
	<TD>&#112;</TD>
	<TD>&amp;#112;</TD>
	<TD>%70</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>113</TD>
	<TD>&#113;</TD>
	<TD>&amp;#113;</TD>
	<TD>%71</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>114</TD>
	<TD>&#114;</TD>
	<TD>&amp;#114;</TD>
	<TD>%72</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>115</TD>
	<TD>&#115;</TD>
	<TD>&amp;#115;</TD>
	<TD>%73</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>116</TD>
	<TD>&#116;</TD>
	<TD>&amp;#116;</TD>
	<TD>%74</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>117</TD>
	<TD>&#117;</TD>
	<TD>&amp;#117;</TD>
	<TD>%75</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>118</TD>
	<TD>&#118;</TD>
	<TD>&amp;#118;</TD>
	<TD>%76</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>119</TD>
	<TD>&#119;</TD>
	<TD>&amp;#119;</TD>
	<TD>%77</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>120</TD>
	<TD>&#120;</TD>
	<TD>&amp;#120;</TD>
	<TD>%78</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>121</TD>
	<TD>&#121;</TD>
	<TD>&amp;#121;</TD>
	<TD>%79</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>122</TD>
	<TD>&#122;</TD>
	<TD>&amp;#122;</TD>
	<TD>%7A</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>123</TD>
	<TD>&#123;</TD>
	<TD>&amp;#123;</TD>
	<TD>%7B</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>124</TD>
	<TD>&#124;</TD>
	<TD>&amp;#124;</TD>
	<TD>%7C</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>125</TD>
	<TD>&#125;</TD>
	<TD>&amp;#125;</TD>
	<TD>%7D</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>126</TD>
	<TD>&#126;</TD>
	<TD>&amp;#126;</TD>
	<TD>%7E</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>127</TD>
	<TD>&#127;</TD>
	<TD>&amp;#127;</TD>
	<TD>%7F</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>128</TD>
	<TD>&#128;</TD>
	<TD>&amp;#128;</TD>
	<TD>%80</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>129</TD>
	<TD>&#129;</TD>
	<TD>&amp;#129;</TD>
	<TD>%81</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>130</TD>
	<TD>&#130;</TD>
	<TD>&amp;#130;</TD>
	<TD>%82</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>131</TD>
	<TD>&#131;</TD>
	<TD>&amp;#131;</TD>
	<TD>%83</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>132</TD>
	<TD>&#132;</TD>
	<TD>&amp;#132;</TD>
	<TD>%84</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>133</TD>
	<TD>&#133;</TD>
	<TD>&amp;#133;</TD>
	<TD>%85</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>134</TD>
	<TD>&#134;</TD>
	<TD>&amp;#134;</TD>
	<TD>%86</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>135</TD>
	<TD>&#135;</TD>
	<TD>&amp;#135;</TD>
	<TD>%87</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>136</TD>
	<TD>&#136;</TD>
	<TD>&amp;#136;</TD>
	<TD>%88</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>137</TD>
	<TD>&#137;</TD>
	<TD>&amp;#137;</TD>
	<TD>%89</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>138</TD>
	<TD>&#138;</TD>
	<TD>&amp;#138;</TD>
	<TD>%8A</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>139</TD>
	<TD>&#139;</TD>
	<TD>&amp;#139;</TD>
	<TD>%8B</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>140</TD>
	<TD>&#140;</TD>
	<TD>&amp;#140;</TD>
	<TD>%8C</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>141</TD>
	<TD>&#141;</TD>
	<TD>&amp;#141;</TD>
	<TD>%8D</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>142</TD>
	<TD>&#142;</TD>
	<TD>&amp;#142;</TD>
	<TD>%8E</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>143</TD>
	<TD>&#143;</TD>
	<TD>&amp;#143;</TD>
	<TD>%8F</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>144</TD>
	<TD>&#144;</TD>
	<TD>&amp;#144;</TD>
	<TD>%90</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>145</TD>
	<TD>&#145;</TD>
	<TD>&amp;#145;</TD>
	<TD>%91</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>146</TD>
	<TD>&#146;</TD>
	<TD>&amp;#146;</TD>
	<TD>%92</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>147</TD>
	<TD>&#147;</TD>
	<TD>&amp;#147;</TD>
	<TD>%93</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>148</TD>
	<TD>&#148;</TD>
	<TD>&amp;#148;</TD>
	<TD>%94</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>149</TD>
	<TD>&#149;</TD>
	<TD>&amp;#149;</TD>
	<TD>%95</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>150</TD>
	<TD>&#150;</TD>
	<TD>&amp;#150;</TD>
	<TD>%96</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>151</TD>
	<TD>&#151;</TD>
	<TD>&amp;#151;</TD>
	<TD>%97</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>152</TD>
	<TD>&#152;</TD>
	<TD>&amp;#152;</TD>
	<TD>%98</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>153</TD>
	<TD>&#153;</TD>
	<TD>&amp;#153;</TD>
	<TD>%99</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>154</TD>
	<TD>&#154;</TD>
	<TD>&amp;#154;</TD>
	<TD>%9A</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>155</TD>
	<TD>&#155;</TD>
	<TD>&amp;#155;</TD>
	<TD>%9B</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>156</TD>
	<TD>&#156;</TD>
	<TD>&amp;#156;</TD>
	<TD>%9C</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>157</TD>
	<TD>&#157;</TD>
	<TD>&amp;#157;</TD>
	<TD>%9D</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>158</TD>
	<TD>&#158;</TD>
	<TD>&amp;#158;</TD>
	<TD>%9E</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>159</TD>
	<TD>&#159;</TD>
	<TD>&amp;#159;</TD>
	<TD>%9F</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>160</TD>
	<TD>&#160;</TD>
	<TD>&amp;#160;</TD>
	<TD>%A0</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>161</TD>
	<TD>&#161;</TD>
	<TD>&amp;#161;</TD>
	<TD>%A1</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>162</TD>
	<TD>&#162;</TD>
	<TD>&amp;#162;</TD>
	<TD>%A2</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>163</TD>
	<TD>&#163;</TD>
	<TD>&amp;#163;</TD>
	<TD>%A3</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>164</TD>
	<TD>&#164;</TD>
	<TD>&amp;#164;</TD>
	<TD>%A4</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>165</TD>
	<TD>&#165;</TD>
	<TD>&amp;#165;</TD>
	<TD>%A5</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>166</TD>
	<TD>&#166;</TD>
	<TD>&amp;#166;</TD>
	<TD>%A6</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>167</TD>
	<TD>&#167;</TD>
	<TD>&amp;#167;</TD>
	<TD>%A7</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>168</TD>
	<TD>&#168;</TD>
	<TD>&amp;#168;</TD>
	<TD>%A8</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>169</TD>
	<TD>&#169;</TD>
	<TD>&amp;#169;</TD>
	<TD>%A9</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>170</TD>
	<TD>&#170;</TD>
	<TD>&amp;#170;</TD>
	<TD>%AA</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>171</TD>
	<TD>&#171;</TD>
	<TD>&amp;#171;</TD>
	<TD>%AB</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>172</TD>
	<TD>&#172;</TD>
	<TD>&amp;#172;</TD>
	<TD>%AC</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>173</TD>
	<TD>&#173;</TD>
	<TD>&amp;#173;</TD>
	<TD>%AD</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>174</TD>
	<TD>&#174;</TD>
	<TD>&amp;#174;</TD>
	<TD>%AE</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>175</TD>
	<TD>&#175;</TD>
	<TD>&amp;#175;</TD>
	<TD>%AF</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>176</TD>
	<TD>&#176;</TD>
	<TD>&amp;#176;</TD>
	<TD>%B0</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>177</TD>
	<TD>&#177;</TD>
	<TD>&amp;#177;</TD>
	<TD>%B1</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>178</TD>
	<TD>&#178;</TD>
	<TD>&amp;#178;</TD>
	<TD>%B2</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>179</TD>
	<TD>&#179;</TD>
	<TD>&amp;#179;</TD>
	<TD>%B3</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>180</TD>
	<TD>&#180;</TD>
	<TD>&amp;#180;</TD>
	<TD>%B4</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>181</TD>
	<TD>&#181;</TD>
	<TD>&amp;#181;</TD>
	<TD>%B5</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>182</TD>
	<TD>&#182;</TD>
	<TD>&amp;#182;</TD>
	<TD>%B6</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>183</TD>
	<TD>&#183;</TD>
	<TD>&amp;#183;</TD>
	<TD>%B7</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>184</TD>
	<TD>&#184;</TD>
	<TD>&amp;#184;</TD>
	<TD>%B8</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>185</TD>
	<TD>&#185;</TD>
	<TD>&amp;#185;</TD>
	<TD>%B9</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>186</TD>
	<TD>&#186;</TD>
	<TD>&amp;#186;</TD>
	<TD>%BA</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>187</TD>
	<TD>&#187;</TD>
	<TD>&amp;#187;</TD>
	<TD>%BB</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>188</TD>
	<TD>&#188;</TD>
	<TD>&amp;#188;</TD>
	<TD>%BC</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>189</TD>
	<TD>&#189;</TD>
	<TD>&amp;#189;</TD>
	<TD>%BD</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>190</TD>
	<TD>&#190;</TD>
	<TD>&amp;#190;</TD>
	<TD>%BE</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>191</TD>
	<TD>&#191;</TD>
	<TD>&amp;#191;</TD>
	<TD>%BF</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>192</TD>
	<TD>&#192;</TD>
	<TD>&amp;#192;</TD>
	<TD>%C0</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>193</TD>
	<TD>&#193;</TD>
	<TD>&amp;#193;</TD>
	<TD>%C1</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>194</TD>
	<TD>&#194;</TD>
	<TD>&amp;#194;</TD>
	<TD>%C2</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>195</TD>
	<TD>&#195;</TD>
	<TD>&amp;#195;</TD>
	<TD>%C3</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>196</TD>
	<TD>&#196;</TD>
	<TD>&amp;#196;</TD>
	<TD>%C4</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>197</TD>
	<TD>&#197;</TD>
	<TD>&amp;#197;</TD>
	<TD>%C5</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>198</TD>
	<TD>&#198;</TD>
	<TD>&amp;#198;</TD>
	<TD>%C6</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>199</TD>
	<TD>&#199;</TD>
	<TD>&amp;#199;</TD>
	<TD>%C7</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>200</TD>
	<TD>&#200;</TD>
	<TD>&amp;#200;</TD>
	<TD>%C8</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>201</TD>
	<TD>&#201;</TD>
	<TD>&amp;#201;</TD>
	<TD>%C9</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>202</TD>
	<TD>&#202;</TD>
	<TD>&amp;#202;</TD>
	<TD>%CA</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>203</TD>
	<TD>&#203;</TD>
	<TD>&amp;#203;</TD>
	<TD>%CB</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>204</TD>
	<TD>&#204;</TD>
	<TD>&amp;#204;</TD>
	<TD>%CC</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>205</TD>
	<TD>&#205;</TD>
	<TD>&amp;#205;</TD>
	<TD>%CD</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>206</TD>
	<TD>&#206;</TD>
	<TD>&amp;#206;</TD>
	<TD>%CE</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>207</TD>
	<TD>&#207;</TD>
	<TD>&amp;#207;</TD>
	<TD>%CF</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>208</TD>
	<TD>&#208;</TD>
	<TD>&amp;#208;</TD>
	<TD>%D0</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>209</TD>
	<TD>&#209;</TD>
	<TD>&amp;#209;</TD>
	<TD>%D1</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>210</TD>
	<TD>&#210;</TD>
	<TD>&amp;#210;</TD>
	<TD>%D2</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>211</TD>
	<TD>&#211;</TD>
	<TD>&amp;#211;</TD>
	<TD>%D3</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>212</TD>
	<TD>&#212;</TD>
	<TD>&amp;#212;</TD>
	<TD>%D4</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>213</TD>
	<TD>&#213;</TD>
	<TD>&amp;#213;</TD>
	<TD>%D5</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>214</TD>
	<TD>&#214;</TD>
	<TD>&amp;#214;</TD>
	<TD>%D6</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>215</TD>
	<TD>&#215;</TD>
	<TD>&amp;#215;</TD>
	<TD>%D7</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>216</TD>
	<TD>&#216;</TD>
	<TD>&amp;#216;</TD>
	<TD>%D8</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>217</TD>
	<TD>&#217;</TD>
	<TD>&amp;#217;</TD>
	<TD>%D9</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>218</TD>
	<TD>&#218;</TD>
	<TD>&amp;#218;</TD>
	<TD>%DA</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>219</TD>
	<TD>&#219;</TD>
	<TD>&amp;#219;</TD>
	<TD>%DB</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>220</TD>
	<TD>&#220;</TD>
	<TD>&amp;#220;</TD>
	<TD>%DC</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>221</TD>
	<TD>&#221;</TD>
	<TD>&amp;#221;</TD>
	<TD>%DD</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>222</TD>
	<TD>&#222;</TD>
	<TD>&amp;#222;</TD>
	<TD>%DE</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>223</TD>
	<TD>&#223;</TD>
	<TD>&amp;#223;</TD>
	<TD>%DF</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>224</TD>
	<TD>&#224;</TD>
	<TD>&amp;#224;</TD>
	<TD>%E0</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>225</TD>
	<TD>&#225;</TD>
	<TD>&amp;#225;</TD>
	<TD>%E1</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>226</TD>
	<TD>&#226;</TD>
	<TD>&amp;#226;</TD>
	<TD>%E2</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>227</TD>
	<TD>&#227;</TD>
	<TD>&amp;#227;</TD>
	<TD>%E3</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>228</TD>
	<TD>&#228;</TD>
	<TD>&amp;#228;</TD>
	<TD>%E4</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>229</TD>
	<TD>&#229;</TD>
	<TD>&amp;#229;</TD>
	<TD>%E5</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>230</TD>
	<TD>&#230;</TD>
	<TD>&amp;#230;</TD>
	<TD>%E6</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>231</TD>
	<TD>&#231;</TD>
	<TD>&amp;#231;</TD>
	<TD>%E7</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>232</TD>
	<TD>&#232;</TD>
	<TD>&amp;#232;</TD>
	<TD>%E8</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>233</TD>
	<TD>&#233;</TD>
	<TD>&amp;#233;</TD>
	<TD>%E9</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>234</TD>
	<TD>&#234;</TD>
	<TD>&amp;#234;</TD>
	<TD>%EA</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>235</TD>
	<TD>&#235;</TD>
	<TD>&amp;#235;</TD>
	<TD>%EB</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>236</TD>
	<TD>&#236;</TD>
	<TD>&amp;#236;</TD>
	<TD>%EC</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>237</TD>
	<TD>&#237;</TD>
	<TD>&amp;#237;</TD>
	<TD>%ED</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>238</TD>
	<TD>&#238;</TD>
	<TD>&amp;#238;</TD>
	<TD>%EE</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>239</TD>
	<TD>&#239;</TD>
	<TD>&amp;#239;</TD>
	<TD>%EF</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>240</TD>
	<TD>&#240;</TD>
	<TD>&amp;#240;</TD>
	<TD>%F0</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>241</TD>
	<TD>&#241;</TD>
	<TD>&amp;#241;</TD>
	<TD>%F1</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>242</TD>
	<TD>&#242;</TD>
	<TD>&amp;#242;</TD>
	<TD>%F2</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>243</TD>
	<TD>&#243;</TD>
	<TD>&amp;#243;</TD>
	<TD>%F3</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>244</TD>
	<TD>&#244;</TD>
	<TD>&amp;#244;</TD>
	<TD>%F4</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>245</TD>
	<TD>&#245;</TD>
	<TD>&amp;#245;</TD>
	<TD>%F5</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>246</TD>
	<TD>&#246;</TD>
	<TD>&amp;#246;</TD>
	<TD>%F6</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>247</TD>
	<TD>&#247;</TD>
	<TD>&amp;#247;</TD>
	<TD>%F7</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>248</TD>
	<TD>&#248;</TD>
	<TD>&amp;#248;</TD>
	<TD>%F8</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>249</TD>
	<TD>&#249;</TD>
	<TD>&amp;#249;</TD>
	<TD>%F9</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>250</TD>
	<TD>&#250;</TD>
	<TD>&amp;#250;</TD>
	<TD>%FA</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>251</TD>
	<TD>&#251;</TD>
	<TD>&amp;#251;</TD>
	<TD>%FB</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>252</TD>
	<TD>&#252;</TD>
	<TD>&amp;#252;</TD>
	<TD>%FC</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>253</TD>
	<TD>&#253;</TD>
	<TD>&amp;#253;</TD>
	<TD>%FD</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>254</TD>
	<TD>&#254;</TD>
	<TD>&amp;#254;</TD>
	<TD>%FE</TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>255</TD>
	<TD>&#255;</TD>
	<TD>&amp;#255;</TD>
	<TD>%FF</TD>
</TR>
</TABLE>

</TD><TD>



<SCRIPT>
<!--//

function Foo() {
	if (document && document.F1 && document.F1.input) {
		document.F1.HO.value = html_encode(document.F1.input.value);
		document.F1.UO.value = escape(document.F1.input.value);
		return false;
		}
	}

function html_encode(in_str) {
	var str_obj = new String(in_str);
	str_obj = str_obj.replace( /&/g, '&amp;' );
	str_obj = str_obj.replace( /"/g, '&quot;' );
	str_obj = str_obj.replace( />/g, '&gt;' );
	str_obj = str_obj.replace( /</g, '&lt;' );
	return str_obj.toString();
	}

//-->
</SCRIPT>

<P><B>Web-Encoding Tool</B></P>

<FORM METHOD="POST" ACTION="$ENV{'SCRIPT_NAME'}" NAME=F1 ONSUBMIT="return Foo();">


<TABLE BORDER=0 CELLPADDING=4 CELLSPACING=1 BGCOLOR="#000000">
<TR BGCOLOR=#9eb3c7>
	<TH>Input: Enter text here:</TH>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD><TEXTAREA NAME=input ROWS=12 COLS=40>$input</TEXTAREA></TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=center><INPUT TYPE=submit CLASS=submit VALUE="Translate">

<SCRIPT>
<!--//

function ShowEx() {
	if (document && document.F1 && document.F1.input) {
		document.F1.input.value = "<B>Hello World!</B>";
		Foo();
		}
	}

document.write(' - <A HREF=javascript:ShowEx();>show example</A>');

//-->
</SCRIPT></TD>
</TR>
</TABLE>

<P><BR></P>

<TABLE BORDER=0 CELLPADDING=4 CELLSPACING=1 BGCOLOR="#000000">
<TR BGCOLOR=#9eb3c7>
	<TH>Output: HTML-Encoded Text:</TH>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD><TEXTAREA NAME=HO ROWS=8 COLS=40>$html_encoded</TEXTAREA></TD>
</TR>
</TABLE>

<P><BR></P>

<TABLE BORDER=0 CELLPADDING=4 CELLSPACING=1 BGCOLOR="#000000">
<TR BGCOLOR=#9eb3c7>
	<TH>Output: URL-Encoded Text:</TH>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD><TEXTAREA NAME=UO ROWS=8 COLS=40>$url_encoded</TEXTAREA></TD>
</TR>
</TABLE>

</TD></TR></TABLE>


<P><BR></P>

<P ALIGN="right" STYLE="font-size:8pt;color:#888888">&copy; 1997-2001 by Zoltan Milosevic</P>

</DIV></CENTER>

</BODY>
</HTML>


EOM



=item html_encode

Usage:
	my $html_str = &html_encode($str);

Formats string consistent with embedding in an HTML document.  Escapes the
"><& characters.

=cut

sub html_encode {
	local $_ = defined($_[0]) ? $_[0] : '';
	s!\&!\&amp;!g;
	s!\>!\&gt;!g;
	s!\<!\&lt;!g;
	s!\"!\&quot;!g;
	return $_;
	}



sub WebForm {
	local $_;
	my ($p_hash, $p_upload_files, $temp_dir) = @_;

	my $err_msg = '';
	Err: {
		unless ('HASH' eq ref($p_hash)) {
			$err_msg = "invalid argument - p_hash is not a HASH reference";
			next Err;
			}

		if ($p_upload_files) {
			unless ('HASH' eq ref($p_upload_files)) {
				$err_msg = "invalid argument - p_upload_files is not a HASH reference";
				next Err;
				}
			}

		my $global_unique_id = time() + int( 1000000 * rand() );

		my @Pairs = ();
		if (($ENV{'REQUEST_METHOD'}) and ($ENV{'REQUEST_METHOD'} eq 'POST')) {

			my $ctype = $ENV{'CONTENT_TYPE'} || '';

			if ($ctype =~ m!multipart/form-data; boundary=(.*)!) {

				# okay, we have a multipart FILE UPLOAD in progress:

				my $boundary = $1;
				my $buffer = '';
				my $len = $ENV{'CONTENT_LENGTH'} || 0;
				my $bytes_read = read(main::STDIN, $buffer, $len, 0);
				unless ($bytes_read == $len) {
					$err_msg = "unable to read $len bytes from input - only read $bytes_read - $!";
					next Err;
					}

				foreach (split(m!$boundary!, $buffer)) {
					s!--$!!so;
					#print "<P><XMP>'$_'</XMP></P>";
					my ($name, $is_file, $filename, $value) = ('', 0, '', '');
					if (m!Content-Disposition: form-data; name="(.*?)"; filename="(.*?)"!is) {
						($name, $filename) = ($1, $2);
						$is_file = 1;
						}
					elsif (m!Content-Disposition: form-data; name="(.*?)"!is) {
						($name) = ($1);
						}
					else {
						next;
						}

					if (m!Content-Disposition: form-data; name="$name".*?\015\012\015\012(.*)$!is) {
						$value = $1;
						$value =~ s!\015\012$!!so;
						}
					else {
						next;
						}

					if (($is_file) and ($p_upload_files)) {
						my $contenttype = '';
						if (m!Content-Type:\s*(\S+)!is) {
							$contenttype = $1;
							}

						my %filedata = (
							'client file name' => $filename,
							'size' => length($value),
							'content' => "'$value'",
							'content-type' => $contenttype,
							);

						my $sf_err = '';
						SaveFile: {

							unless ($temp_dir) {
								$sf_err = "unable to save file - temp_dir parameter not defined";
								next SaveFile;
								}

							unless ((-e $temp_dir) and (-d $temp_dir)) {
								$sf_err = "unable to save file - temp_dir '$temp_dir' does not exist or is not a directory";
								next SaveFile;
								}

							$global_unique_id = 0 unless ($global_unique_id);
							$global_unique_id++;

							# create a temp file:
							my $file_num = $global_unique_id;
							for (;;) {
								last unless (-e "$temp_dir/fd_webformex_$file_num.tmp");
								$file_num++;
								}
							my $TempFile = "$temp_dir/fd_webformex_$file_num.tmp";

							unless (open(FILE, ">$TempFile")) {
								$sf_err = "unable to write to temp file '$TempFile' - $!";
								next SaveFile;
								}

							unless (binmode(FILE)) {
								$sf_err = "unable to set binmode on temp file '$TempFile' - $!";
								close(FILE);
								next SaveFile;
								}

							print FILE $value;
							close(FILE);

							$filedata{'temp file'} = $TempFile;
							delete $filedata{'content'};

							eval "END { unlink('$TempFile'); }\n";

							}
						$filedata{'err_msg'} = $sf_err if ($sf_err);

						$$p_upload_files{$name} = \%filedata;
						next;
						}
					$$p_hash{$name} = $value;
					}

				# Done with multipart form
				last Err;
				}

			my $buffer = '';
			my $len = $ENV{'CONTENT_LENGTH'};
			read(STDIN, $buffer, $len);
			@Pairs = split(m!\&!, $buffer);
			}
		elsif ($ENV{'QUERY_STRING'}) {
			@Pairs = split(m!\&!, $ENV{'QUERY_STRING'});
			}
		else {
			@Pairs = @ARGV;
			}

		foreach (@Pairs) {
			next unless (m!^(.*?)=(.*)$!);
			my ($name, $value) = (&url_decode($1), &url_decode($2));
			if ($$p_hash{$name}) {
				$$p_hash{$name} .= ",$value";
				}
			else {
				$$p_hash{$name} = $value;
				}
			}
		}
	return $err_msg;
	}

sub standard_binmode {
	my $err_msg = '';
	Err: {

		my $OS = $^O;
		if (($OS) and ($OS =~ m!(win|dos|os2)!i)) {

			unless (binmode(main::STDIN)) {
				$err_msg = "unable to set binmode on STDIN - $!";
				next Err;
				}
			unless (binmode(main::STDOUT)) {
				$err_msg = "unable to set binmode on STDOUT - $!";
				next Err;
				}
			unless (binmode(main::STDERR)) {
				$err_msg = "unable to set binmode on STDERR - $!";
				next Err;
				}
			}
		}
	return $err_msg;
	}


sub url_decode {
	local $_ = defined($_[0]) ? $_[0] : '';
	tr!+! !;
	s!\%([a-fA-F0-9][a-fA-F0-9])!pack('C', hex($1))!eg;
	return $_;
	}

sub url_encode {
	local $_ = defined($_[0]) ? $_[0] : '';
	s!([^a-zA-Z0-9_.-])!uc(sprintf("%%%02x", ord($1)))!eg;
	return $_;
	}


sub TestPak_h {
	# force cwd
	chdir($1) if ($0 =~ m!^(.*)(\\|/).*?$!);
	my %family = (
		'basic_forms' => 'HTML Forms',
		'env' => 'Environment Vars',
		'socket' => 'Sockets',
		'file_upload' => 'File Upload',
		'encode' => 'Encoding',
		);
	print "<P>[ Tests: ";
	my $name = '';
	foreach $name (sort keys %family) {
		my $ext = '';
		foreach ('pl','cgi') {
			if (-e "$name.$_") {
				$ext = $_;
				last;
				}
			}
		next unless (-e "$name.$ext");
		print "<A HREF=\"$name.$ext\">$family{$name}</A> -";
		}
	print "<A HREF=\"ssi/\">Includes</A> ]</P>\n";
	}

