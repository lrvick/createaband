#!/usr/bin/perl
use strict;

my $err_msg = '';
Err: {
	$| = 1;

	print "Content-Type: text/html\015\012\015\012";

	my (%FORM, %files) = ();

	$err_msg = &standard_binmode();
	next Err if ($err_msg);

	$err_msg = &WebForm( \%FORM );
	next Err if ($err_msg);

print <<"EOM";

<HTML>
<HEAD>
	<TITLE>Fluid Dynamics: Test Script</TITLE>

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

<P><B><A HREF="$ENV{'SCRIPT_NAME'}">Environment Variables</A></B></P>



<P>This script displays all environment variables and all form variables associated with the request.</P>

<P>Environment variables beginning with "HTTP_" are the initial request headers sent by your browser. The "REMOTE_" headers are mostly based on your network status (port, hostname, and IP address). Other variables are mostly server-dependent.</P>

<HR SIZE=1>
<P><B>Environment Variables:</B></P>

<TABLE BORDER=0 CELLPADDING=4 CELLSPACING=1 BGCOLOR="#000000">
<TR BGCOLOR=#9eb3c7>
	<TH WIDTH=120>Name</TH>
	<TH>Value</TH>
</TR>

EOM

foreach (sort keys %ENV) {
	my ($name, $value) = (&html_encode($_), &html_encode($ENV{$_}));
print <<"EOM";

<TR BGCOLOR=#d5d2bb VALIGN=top>
	<TD ALIGN=right>$name</TD>
	<TD>$value<BR></TD>
</TR>

EOM
	}
print <<"EOM";
</TABLE>

<P><BR></P>

<P><B>Form Variables</B></P>

EOM

my $count = scalar (keys %FORM);

if ($count) {

print <<"EOM";

<P>There were $count name-value pairs detected.</P>

<TABLE BORDER=0 CELLPADDING=4 CELLSPACING=1 BGCOLOR="#000000">
<TR BGCOLOR=#9eb3c7>
	<TH WIDTH=120>Name</TH>
	<TH>Value</TH>
</TR>

EOM
foreach (sort keys %FORM) {
	my ($name, $value) = (&html_encode($_), &html_encode($FORM{$_}));
print <<"EOM";

<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right>$name</TD>
	<TD>$value<BR></TD>
</TR>

EOM
	}

print <<"EOM";

</TABLE>

EOM

	}
else {
	print "<P>No name-value pairs were detected.</P>\n";
	}

print <<"EOM";

<P><BR></P>

<P>You can try to set some form variables. This is a GET form:</P>

<FORM METHOD="GET" ACTION="$ENV{'SCRIPT_NAME'}">

<TABLE BORDER=0 CELLPADDING=4 CELLSPACING=1 BGCOLOR="#000000">
<TR BGCOLOR=#9eb3c7>
	<TH WIDTH=120>Name</TH>
	<TH>Value</TH>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right><B>My Name:</B></TD>
	<TD><INPUT NAME="name"></TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right><B>Color:</B></TD>
	<TD><INPUT NAME="color"></TD>
</TR>
</TABLE>
<TABLE BORDER=0 CELLPADDING=4 CELLSPACING=1>
<TR>
	<TD WIDTH=120><BR></TD>
	<TD><INPUT TYPE=submit CLASS=submit></TD>
</TR>
</TABLE>
</FORM>

<P><BR></P>

<P>You can try to set some form variables. This is a POST form:</P>

<FORM METHOD="POST" ACTION="$ENV{'SCRIPT_NAME'}">

<TABLE BORDER=0 CELLPADDING=4 CELLSPACING=1 BGCOLOR="#000000">
<TR BGCOLOR=#9eb3c7>
	<TH WIDTH=120>Name</TH>
	<TH>Value</TH>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right><B>My Name:</B></TD>
	<TD><INPUT NAME="name"></TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right><B>Color:</B></TD>
	<TD><INPUT NAME="color"></TD>
</TR>
</TABLE>
<TABLE BORDER=0 CELLPADDING=4 CELLSPACING=1>
<TR>
	<TD WIDTH=120><BR></TD>
	<TD><INPUT TYPE=submit CLASS=submit></TD>
</TR>
</TABLE>
</FORM>

<P><BR></P>

<P>You can try to set some form variables. This is an ISINDEX tag:</P>

<ISINDEX>

<P><BR></P>

<P ALIGN="right" STYLE="font-size:8pt;color:#888888">&copy; 1997-2001 by Zoltan Milosevic</P>

</DIV></CENTER>

</BODY>
</HTML>


EOM

	last Err;
	}
continue {
	print "<P><B>Error:</B> $err_msg.</P>\n";
	}





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
	my ($p_hash, $p_upload_files, $temp_dir, $b_persist_files) = @_;

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

				#print "<P><XMP>$boundary\n$buffer</XMP></P>";

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

							eval "END { unlink('$TempFile'); }\n" unless ($b_persist_files);

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



