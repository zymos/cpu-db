
#!/usr/bin/env python 
#(c) Thomas Guettler www.thomas-guettler.de
#This script is in the public domain
#
#Make a simple html page of a csv (Comma Seperated Values) file

### Ende Benutzer Konfiguration

import re
import cgi
import sys
import string


file=open(sys.argv[1]);
zeile=file.readline()
print """
<html>
 <head>
  <title>csv2html</title>
 </head>
 <body>
 <table border="1">
"""

zeilen=file.readlines()

for zeile in zeilen:
	zeile=string.strip(zeile); # Newline Zeichen entfernen
	spalten=re.split("[,;]", zeile)
	print "	  <tr>"
	for spalte in spalten:
		if spalte.startswith('"'):
			spalte=spalte[1:]
		if spalte.endswith('"'):
			spalte=spalte[:-1]
		spalte=spalte.strip()
		spalte=cgi.escape(spalte)
		spalte=re.sub(r'\\n', '<br>', spalte)
		if not spalte:
			spalte="&nbsp;"
		print "	  <td>" + spalte + "</td>"
	print "	 </tr>"

print """
  </table>
 </body>
</html>
"""
