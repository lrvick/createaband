#!/usr/bin/perl
use strict;

my $VERSION = '1.0.0.0002';

$| = 1;

my %FORM = ();

print "Content-Type: text/html\015\012\015\012";

my $err_msg = '';
Err: {

	&WebForm( \%FORM );

	my $server = $FORM{'server'} || 'www.yahoo.com';
	my $port = $FORM{'port'} || 80;
	my $read = $FORM{'read'} || 256;


	my $hserver = &html_encode($server);
	my $hport = &html_encode($port);
	my $hread = &html_encode($read);


	my $hsystem = $ENV{'HTTP_HOST'} || 'localhost';
	$hsystem = &html_encode($hsystem);

print <<"EOM";


<HTML>
<HEAD>
	<TITLE>Fluid Dynamics: Socket Test Script</TITLE>

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

<P><B><A HREF="$ENV{'SCRIPT_NAME'}">Sockets Test</A></B></P>

<P>This test is being run on Perl version $].

<P>In order for the Fluid Dynamics Search Engine crawler to work, all Socket.pm tests must succeed.</P>

<FORM METHOD="get" ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE="hidden" NAME="runtests" VALUE=1>

<TABLE BORDER=0 CELLPADDING=4 CELLSPACING=1 BGCOLOR="#000000">
<TR BGCOLOR=#9eb3c7>
	<TH COLSPAN=2>Web Server to Test</TH>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right><B>Host:</B></TD>
	<TD><TT><INPUT NAME="server" VALUE="$hserver"></TT></TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right><B>Port:</B></TD>
	<TD><TT><INPUT NAME="port" VALUE="$hport"></TT></TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=right><B>Read depth:</B></TD>
	<TD><TT><INPUT NAME="read" VALUE="$hread"></TT></TD>
</TR>
<TR BGCOLOR=#d5d2bb>
	<TD ALIGN=center COLSPAN=2><INPUT TYPE=submit CLASS=submit VALUE="Run Tests"></TD>
</TR>
</TABLE>


<P>Read depth is the number of bytes to retreive from the remote server during the test.</P>

</FORM>

EOM

	unless ($FORM{'runtests'}) {

print <<"EOM";

	<P>To test full functionality, <A HREF="$ENV{'SCRIPT_NAME'}?runtests=1&server=www.yahoo.com">test Yahoo!</A> at "www.yahoo.com" on port 80.</P>
	<P>If that fails, try the more limited <A HREF="$ENV{'SCRIPT_NAME'}?runtests=1&server=$hsystem">test against this system</A>, "$hsystem" on port 80.</P>

EOM
		last Err;
		}

	my $quest = '';
	my $s_ok = "<P CLASS=small><B>Q.</B> %s<BR><B>A.</B> success - %s.</P>\n";
	my $s_fail = "<P><B>Q.</B> %s<BR><B>A.</B> failed - %s.</P>\n";

	Test: {
		print "<HR SIZE=1>";
		print "<P>Beginning a series of tests that use Perl's raw sockets functions.</P>\n";

		$quest = "can we do a DNS lookup on '$server' using gethostbyname?";
		my $hexip = (gethostbyname($server))[4];
		if ($hexip) {
			my @d = unpack('C4',$hexip);
			printf( $s_ok, $quest, "hostname '$server' maps to IP $d[0].$d[1].$d[2].$d[3]" );
			}
		else {
			printf( $s_fail, $quest, "unable to lookup - $! - $^E" );
			next Test;
			}

		print "<P><B>Success:</B> raw Perl functionality confirmed.</P>\n";
		last Test;
		}
	continue {
		print "<P><B>Warning:</B> raw Perl functionality not confirmed.</P>\n";
		}


	Test: {
		print "<HR SIZE=1>";
		print "<P>Beginning a series of tests that use Perl's Socket.pm library functions, with stdio.</P>\n";


		$quest = "can we include Socket.pm?";
		my $code = 'use Socket';
		undef($@);
		eval $code;
		if ($@) {
			printf( $s_fail, $quest, "'$code' returned: $@" );
			next Test;
			}
		else {
			printf( $s_ok, $quest, "'$code' returned okay" );
			}


		$quest = "can we do a DNS lookup on '$server' using inet_aton from Socket.pm?";
		my $hexip = inet_aton($server);
		if ($hexip) {
			my @d = unpack('C4',$hexip);
			printf( $s_ok, $quest, "hostname '$server' maps to IP $d[0].$d[1].$d[2].$d[3]" );
			}
		else {
			printf( $s_fail, $quest, "unable to lookup - $! - $^E" );
			next Test;
			}


		$quest = "can we create a TCP/IP socket?";
		if (socket(SOCK, PF_INET(), SOCK_STREAM(), getprotobyname('tcp'))) {
			printf( $s_ok, $quest, "socket created" );
			}
		else {
			printf( $s_fail, $quest, "unable to create socket - $! - $^E" );
			next Test;
			}


		$quest = "can we connect to '$server:$port' with our new TCP/IP socket?";
		if (connect(SOCK, sockaddr_in($port, $hexip))) {
			printf( $s_ok, $quest, "socket connected" );
			}
		else {
			printf( $s_fail, $quest, "unable to connect - $! - $^E" );
			next Test;
			}


		$quest = "can we send an HTTP request over this socket using send()?";
		my $rq = "GET / HTTP/1.0\015\012Host: $server:$port\015\012\015\012";
		if (send(SOCK, $rq, 0)) {
			printf( $s_ok, $quest, "sent data" );
			}
		else {
			printf( $s_fail, $quest, "unable to send - $! - $^E" );
			next Test;
			}


		$quest = "can we read an HTTP response over this socket using read()?";
		my $response = '';
		if (read(SOCK, $response, $read, 0)) {
			printf( $s_ok, $quest, "read data:" );
			print "<P CLASS=small><TT>" . &html_encode($response) . "</TT></P>\n";
			}
		else {
			printf( $s_fail, $quest, "unable to read - $! - $^E" );
			next Test;
			}


		$quest = "can we close this socket?";
		if (close(SOCK)) {
			printf( $s_ok, $quest, "closed socket" );
			}
		else {
			printf( $s_fail, $quest, "unable to close - $! - $^E" );
			next Test;
			}


		print "<P><B>Success:</B> Socket.pm functionality with stdio confirmed.</P>\n";
		last Test;
		}
	continue {
		print "<P><B>Warning:</B> Socket.pm functionality with stdio not confirmed.</P>\n";
		}



	Test: {
		print "<HR SIZE=1>";
		print "<P>Beginning a series of tests that use Perl's Socket.pm library functions, without stdio.</P>\n";


		$quest = "can we include Socket.pm?";
		my $code = 'use Socket';
		undef($@);
		eval $code;
		if ($@) {
			printf( $s_fail, $quest, "'$code' returned: $@" );
			next Test;
			}
		else {
			printf( $s_ok, $quest, "'$code' returned okay" );
			}


		$quest = "can we do a DNS lookup on '$server' using inet_aton from Socket.pm?";
		my $hexip = inet_aton($server);
		if ($hexip) {
			my @d = unpack('C4',$hexip);
			printf( $s_ok, $quest, "hostname '$server' maps to IP $d[0].$d[1].$d[2].$d[3]" );
			}
		else {
			printf( $s_fail, $quest, "unable to lookup - $! - $^E" );
			next Test;
			}


		$quest = "can we create a TCP/IP socket?";
		if (socket(SOCK, PF_INET(), SOCK_STREAM(), getprotobyname('tcp'))) {
			printf( $s_ok, $quest, "socket created" );
			}
		else {
			printf( $s_fail, $quest, "unable to create socket - $! - $^E" );
			next Test;
			}


		$quest = "can we connect to '$server:$port' with our new TCP/IP socket?";
		if (connect(SOCK, sockaddr_in($port, $hexip))) {
			printf( $s_ok, $quest, "socket connected" );
			}
		else {
			printf( $s_fail, $quest, "unable to connect - $! - $^E" );
			next Test;
			}


		$quest = "can we send an HTTP request over this socket using syswrite()?";
		my $rq = "GET / HTTP/1.0\015\012Host: $server:$port\015\012\015\012";
		my $datalen = length($rq);
		if ($datalen == syswrite(SOCK, $rq, $datalen)) {
			printf( $s_ok, $quest, "sent data" );
			}
		else {
			printf( $s_fail, $quest, "unable to send - $! - $^E" );
			next Test;
			}


		$quest = "can we read an HTTP response over this socket using sysread()?";
		my $response = '';
		if (sysread(SOCK, $response, $read, 0)) {
			printf( $s_ok, $quest, "read data:" );
			print "<P CLASS=small><TT>" . &html_encode($response) . "</TT></P>\n";
			}
		else {
			printf( $s_fail, $quest, "unable to read - $! - $^E" );
			next Test;
			}


		$quest = "can we close this socket?";
		if (close(SOCK)) {
			printf( $s_ok, $quest, "closed socket" );
			}
		else {
			printf( $s_fail, $quest, "unable to close - $! - $^E" );
			next Test;
			}


		print "<P><B>Success:</B> Socket.pm functionality without stdio confirmed.</P>\n";
		last Test;
		}
	continue {
		print "<P><B>Warning:</B> Socket.pm functionality without stdio not confirmed.</P>\n";
		}










	Test: {


		print "<HR SIZE=1>";
		print "<P>Beginning a series of tests that use Perl's IO::Socket library functions.</P>\n";
		print "<P><B>Note:</B> FDSE does not use this library by default, but if this library succeeds where Socket.pm has failed, the product can be modified to use this interface.</P>\n";

		$quest = "can we include IO::Socket?";
		my $code = 'use IO::Socket';
		undef($@);
		eval $code;
		if ($@) {
			printf( $s_fail, $quest, "'$code' returned: $@" );
			next Test;
			}
		else {
			printf( $s_ok, $quest, "'$code' returned okay" );
			}


		$quest = "can we connect to '$server:$port' with IO::Socket?";
		my $sock = ();
		($err_msg, $sock) = &mk_socket( $server, $port, 5 );
		if ($err_msg) {
			printf( $s_fail, $quest, "$err_msg" );
			next Test;
			}
		else {
			printf( $s_ok, $quest, "socket connected okay" );
			}


		$quest = "can we send an HTTP request over this socket?";
		my $rq = "GET / HTTP/1.0\015\012Host: $server:$port\015\012\015\012";
		if (send($$sock, $rq, 0)) {
			printf( $s_ok, $quest, "sent data" );
			}
		else {
			printf( $s_fail, $quest, "unable to send - $! - $^E" );
			next Test;
			}


		$quest = "can we read an HTTP response over this socket?";
		my $response = '';
		if (read($$sock, $response, $read)) {
			printf( $s_ok, $quest, "read data:" );
			print "<P CLASS=small><TT>" . &html_encode($response) . "</TT></P>\n";
			}
		else {
			printf( $s_fail, $quest, "unable to read - $! - $^E" );
			next Test;
			}


		$quest = "can we close this socket?";
		if ($sock->close()) {
			printf( $s_ok, $quest, "closed socket" );
			}
		else {
			printf( $s_fail, $quest, "unable to close - $! - $^E" );
			next Test;
			}


		print "<P><B>Success:</B> IO::Socket functionality confirmed.</P>\n";
		last Test;
		}
	continue {
		print "<P><B>Warning:</B> IO::Socket functionality not confirmed.</P>\n";
		}



	Test: {

		print "<HR SIZE=1>";
		print "<P>Beginning a series of tests that use the LWP library functions.</P>\n";

		print "<P><B>Note:</B> FDSE does not use this library by default, but if this library succeeds where Socket.pm has failed, the product can be modified to use this interface.</P>\n";


		my $module = '';
		foreach $module ('LWP', 'LWP::UserAgent', 'HTTP::Request') {

			$quest = "can we include $module?";
			my $code = "use $module";
			undef($@);
			eval $code;
			if ($@) {
				printf( $s_fail, $quest, "'$code' returned: $@" );
				next Test;
				}
			else {
				printf( $s_ok, $quest, "'$code' returned okay" );
				}

			}

		print "<P CLASS=small>Hey! This is libwww-perl-$LWP::VERSION. Excellent choice!</P>\n";


		$quest = "can we build user-agent and request objects?";
		# create an agent:
		my $ua = new LWP::UserAgent;
		$ua->agent("AgentName/0.1 " . $ua->agent);
		# create a request
		my $req = new HTTP::Request(
			'GET' => "http://$server:$port/",
			);
		if (($ua) and ($req)) {
			printf( $s_ok, $quest, "object initialized" );
			}
		else {
			printf( $s_fail, $quest, "objects undefined" );
			next Test;
			}



		$quest = "can we request a web page from '$server:$port'?";
		# Pass request to the user agent and get a response back
		my $res = $ua->request($req);
		# Check the outcome of the response
		if ($res->is_success) {
			printf( $s_ok, $quest, "content returned:" );
			print "<P CLASS=small><TT>" . &html_encode(substr($res->content(),0,$read)) . "</TT></P>\n";
			}
		else {
			printf( $s_fail, $quest, "failed:" );
			print "<P CLASS=small><TT>" . &html_encode($res->error_as_HTML()) . "</TT></P>\n";
			next Test;
			}


		print "<P><B>Success:</B> LWP functionality confirmed.</P>\n";
		last Test;
		}
	continue {
		print "<P><B>Warning:</B> LWP functionality not confirmed.</P>\n";
		}



	last Err;
	}
continue {
	print "<P><B>Error:</B> $err_msg.</P>\n";
	}

print <<"EOM";

<P><BR></P>

<HR SIZE=1>

<P ALIGN=center CLASS=small><A HREF="http://www.xav.com/scripts/testpak/">Test CGI Package</A> v$VERSION - &copy; 2001 by Zoltan Milosevic</P>

</DIV></CENTER>

</BODY>
</HTML>

EOM







=item mk_socket($$$)

Usage:
	my ($err_msg, $sock) = &mk_socket( $host, $port, $timeout );

Taken, with thanks, from Test/Protocol/http.pm.

Returns a connected, unbuffered TCP/IP socket, or an error message.

Selects STDOUT in the process.

Dependencies:
	require IO::Socket

=cut

sub mk_socket {
    my ($host, $port, $timeout) = @_;
	my $sock = ();
	my $err_msg = '';
	Err: {
		local($^W) = 0;  # IO::Socket::INET can be noisy

		undef($@);
		eval 'require IO::Socket;';
		if ($@) {
			$err_msg = "unable to load IO::Socket - $@";
			next Err;
			}

		$sock = IO::Socket::INET->new(
			PeerAddr => $host,
			PeerPort => $port,
			Proto    => 'tcp',
			Timeout  => $timeout,
			);
		unless ($sock) {
			$err_msg = "unable to connect to $host:$port - $@";
			next Err;
			}

		select($sock);
		$| = 1;
		select(STDOUT);

		unless (binmode($sock)) {
			$err_msg = "unable to set binmode on socket - $!";
			next Err;
			}

		last Err;
		}
	return ($err_msg, $sock);
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
