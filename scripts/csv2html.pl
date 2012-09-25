#!/usr/bin/perl
# csv2html.pl--turn a csv file into a simple HTML table

# $Id: csv2html.pl 1006 2005-10-07 22:38:29Z jp $
# $URL$

$ver = '$Version: 2.3 $'; # JP Vossen <jp@jpsdomain.org>
##########################################################################
(($myname = $0) =~ s/^.*(\/|\\)//ig); # remove up to last "\" or "/"
$Greeting =  ("$myname $ver Copyright 2002-2003 JP Vossen (http://www.jpsdomain.org/)\n");
$Greeting .= ("    Licensed under the GNU GENERAL PUBLIC LICENSE:\n");
$Greeting .= ("    See http://www.gnu.org/copyleft/gpl.html for full text and details.\n");

if (("@ARGV" =~ /\?/) || ("@ARGV" =~ /-h/) || "@ARGV" =~ /--help/) {
    print STDERR ("\n$Greeting\n");
    print STDERR <<"EoN";    # Various usage notes
	Usage: $myname (-i {infile}) (-o {outfile}) (options)

   -i {infile}  = Use infile as the input file, otherwise use STDIN.
   -o {outfile} = Use outfile as the output file, otherwise use STDOUT.
   -D {delimit} = Use {delimiter} instead of CSV.
   -s           = Keep Same name, except replace .csv with .html for new file.
   -t {title}   = Use title as the Title and Header1 of the output file.
   -b           = Bold and center the first line of the table.
   -e           = Print 'empty' cells.
   -d           = Add a date/time stamp to the file.
   -T           = Table code only, omit HTML, HEAD, BODY code.
   -q           = Be quiet about it.

Convert a CSV file to a very *simple* HTML table (unlike the complex
crap you get when saving Excel as HTML). A blank line in the input starts
a new table.

EoN
    die ("\n");
}

use Getopt::Std;            # Use Perl5 built-in program argument handler
getopts('i:o:t:TbeD:sdq');  # Define possible args.

if ((defined ($opt_o)) and (defined ($opt_s))) { die ("$myname: can't use -o and -s at the same time!\n"); }

# If we're keeping same name, either replace .csv with .html, or add .html
# to the end of the file name if it's not .csv.
if ($opt_s) {
    $opt_o = $opt_i;
    $opt_o =~ s/\.csv/\.html/ or $opt_o .= ".html";
}

if (! $opt_i) { $opt_i = "-"; } # If no input file specified, use STDIN
if (! $opt_o) { $opt_o = "-"; } # If no output file specified, use STDOUT

open (INFILE,   "$opt_i") or die ("$myname: error opening $opt_i for input: $!\n");
open (OUTFILE, ">$opt_o") or die ("$myname: error opening $opt_o for output: $!\n");

if (! $opt_q) {
    print STDERR ("\n$Greeting\n");
    print STDERR ("Converting $opt_i into $opt_o...\n");
} # end of if printing banner

# Set the HTML title, one way or another
$title = $myname;                     # Set a default
$title = $opt_t if (defined($opt_t)); # Try to use the title option
$title = $opt_i if ($opt_i ne "-");   # Then try the input file (if not STDIN)

# Maybe use a date/time stamp
$datetime = "<p>" . scalar localtime(time) . "</p>" if defined($opt_d);

$firstline = 1;  # Set a flag for use with bold/center header

&print_html_header unless $opt_T;
print OUTFILE ("<table border=1>\n");  # Open the first table

while ($aline = <INFILE>) {       # While we have input
    chomp($aline);                # Remove trailing line breaks

    if ($aline =~ m/^\s*$/) {   # If the line is blank or has only white space
        print OUTFILE ("</table>\n");         # End the previous table
        print OUTFILE ("\n<br>\n\n");         # Line break
        print OUTFILE ("<table border=1>\n"); # Start the next table
        $firstline = 1;  # Set a flag for use with bold/center header
        next;  # Skip to next record
    } # end of new table?


    if ($opt_D) {   # We're using a delimiter
        @arecord = split(/$opt_D/, $aline);  # Parse the delimited input
    } else {        # We're doing CSV
        @arecord = &parse_csv_mre2 ($aline); # Parse the CSV input
    } # end of if we're using a delimiter or CSV

    print OUTFILE ("  <tr>\n");   # Start an HTML table row

    foreach $field (@arecord) {   # For each output field
        # Inset a non-breaking space if needed to force the cell to print
        $field = "&nbsp;" if (($opt_e) and ($field eq ""));

        if ($opt_b) {             # If we're doing bold/center
            if ($firstline) {     # And it's the first line
                # Make it bold and centered
                print OUTFILE ("    <td align=\"center\"><b>$field</b></td>\n");
            } else {              # Otherwise, make it normal
                print OUTFILE ("    <td>$field</td>\n");
            } # end of if firstline
        } else {                  # Otherwise, make it normal
            print OUTFILE ("    <td>$field</td>\n");
        } # end of if bold/center
    } # end of foreach field

    print OUTFILE ("  </tr>\n");  # End the HTML table row
    $firstline = 0;               # It's not the first table row anymore

} # end of while we have input

print OUTFILE ("</table>\n");   # End the last table
&print_html_footer unless $opt_T;

if (! $opt_q) { print STDERR ("\n\a$myname finished in ",time()-$^T," seconds.\n"); }
#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
sub parse_csv_mre2 {

# Called like: @arecord = &parse_csv_mre2 ($aline);

# Regex to parse CSV from _Mastering_Regular_Expressions,_Second_Edition_;
# page 271. See http://regex.info/ esp. http://regex.info/dlisting.cgi?id=1253)

    #if (@_[0] eq undef()) { warn ("$myname: empty variable passed to parse_csv_mre2!\n"); }
    if (@_[0] eq undef()) { return(); }
    my $line = @_[0];
    my @parsedline = ();
    my $field = '';

    # See top for details about the regex
    while ($line =~ m{
              \G(?:^|,)
              (?:
                 # Either a double-quoted field (with "" for each ")...
                 " # field's opening quote
                  ( (?> [^"]* ) (?> "" [^"]* )*  )
                 " # field's closing quote
               # ..or...         
               |
                 # ... some non-quote/non-comma text....
                 ( [^",]* )
              )
          }gx)
    {                         # OK, done with regex, NOW what...
       if (defined $2) {      # Got some non-quote/non-comma text
           $field = $2;
       } else {               # Got escaped quotes and stuff
           $field = $1;
           $field =~ s/""/"/g;
       }
    push (@parsedline, $field);
    } # end of while block

    return (@parsedline);
} # end of sub parse_csv_mre2

#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
sub print_html_header {

# HTML Header Code
print OUTFILE <<"EOT";
<html>
<head>
<title>$title</title>
</head>
<body>
<h1>$title</h1>
$datetime

EOT

} # end of sub html_header

#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
sub print_html_footer {

# HTML Footer Code
print OUTFILE <<"EOT";

</body>
</html>
EOT

} # end of sub html_footer
