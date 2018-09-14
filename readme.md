# Music Matcher


use 

	$ git clone git@github.com:tobiasw225/musicmatcher.git
to clone the repository to the folder of your choice.	

## Our Motivation
We started as a group of three people developing ideas in June/ July 2018 and began the implementation in late July 2018. The project team consists out of Pavlo Brodyansky and Tobias Wenzel. 

During the last decade numerous projects were started involving unprofessional workers in areas like image tagging, text-correction or audio classification. If the people are paid or the work is done with the benefits solely lying on the providers side, it can be considered crowdsourcing. In this course we looked at projects in citizen science, which can be defined as “the scientific activities in which non-professional scientists volunteer to participate in data collection, analysis and dissemination of a scientific project”[1]. A growing number of people are interested in participating in these projects in their time off work. The motivation differ from personal connections and the will to connect and learn with other interested people to participating in the process of making data which wasn’t available before more accessible [3].

We are especially interested in project of data recognition and correction, in which we see a great potential: There is a growing market of software for automated character recognition, which is mainly interested in common characters for digitizing documents of daily use, because there is a lot of data which can be used to train the underlying neural nets. Documents with less common signs or signs of less interest, like ancient greek, sheet music or especially handwritten music often rely on proofreading and correction. 
The lack of quality is often due to a very small amount of training data. The main task of citizen scientists in this field is thus creating correct data by correction or direct input of a given document. This data can be used for training a more specialised recognition software. 



The “Musikalisches Wochenblatt - Organ für Musiker und Musikfreunde”, was a music journal in the time of the German Empire. It was founded in 1870 by Oscal Paul and published until 1910 in Leipzig. Henceforward it was published by Ernst Wilhelm Fritsch as the Neue Zeitschrift für Musik. It discusses developments in music, concerts and features critics from all over Germany with a focus led on Leipzig. It also covers sheet music, which we hoped to extract with OMR. We decided to use a collection as linked in the corresponding Wikipedia-articles for MWB and NZFM [5a, 5b]. Table B.1 shows an overview of the corpus-size. The average page number revolves around 580 per edition. 
There were text files which already had been OCR-detected by an unknown tesseract model. The quality of these files is generally really bad and the files don’t contain information about the original position of the detected characters. The quality was assessed by running a test whether the words had spelling mistakes or not. In MWB 49% of the words had spelling mistakes or could not be identified as words, in NZFM this number went up to 76%. We found the poor quality one major motivation for improvement.

<table style="width: 100%"> 
    <caption><b>Approximate overview of corpus-size</b>. Every journal is saved as the original PDF, PNG and a HOCR File. Additionally the existing metadata files were saved. </caption>
	<tr><td>Source</td><td>Pages</td></tr>
	<tr><td>MWB</td><td>37 568</td></tr>
	<tr><td>NZFM</td><td>77 546</td></tr>
		<tr><td>Total</td><td>115 114</td></tr>
</table>





These journals are especially interesting because they provide a very detailed view on the time of the second half of the 19th and the beginning of the 20th century. With the corrected data, we hope to learn more about the connections, biases and disputes of people and institutions of this time. We also hope to learn why some composers became famous and others disappeared. The data could be saved in a graph database to visualise these connections and linked with existing citizen science projects.





## Installation
### Set up Docker-Container

The recommended way to set up the system is through docker and docker-compose, since it enables easy crossplattform development. To learn more about how to set up the docker container have a look at our [this page](docker/readme.md).



# Documentation

For further documentation have a look at the [documenation](doku/readme.md)-page.
