# Offline Functionalities

Written in Python3 and Bash.


## Crawler
As datasets we use the two collections: [Musikalisches Wochenblatt](https://de.wikisource.org/wiki/Musikalisches_Wochenblatt_(Leipzig)) and 
 [Neue Zeitschrift für Musik](https://de.wikisource.org/wiki/Neue_Zeitschrift_f%C3%BCr_Musik). Since we use the archive.org links we simply grep them of the HTML-Files:
 
 	$  grep -Eo '(http|https)://www.archive.org[^"]+' input.html 


### mwb_crawler.py
This script collects links to versions of the MWB and saves the content on a local disk. The direct links to the PDFs are saved as an JSON-Array.


## Preprocessing

After downloading, the pdfs are cutted into single pages with the following script.

	$ sudo snap install pdftk
	$ src/split_pdfs.sh
	

### Tesseract
uses pytesseract and wand to use imagick

### Textcleaner


### Ocropy (ocr-d)

(not yet added)



