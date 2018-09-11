<?php session_start();
if (!isset($_SESSION['user_name'])) {
	$_SESSION['user_name'] = 'guest';
	$_SESSION['user_id'] = 2;
	$_SESSION['user_points'] = 0;
}
?>
<!DOCTYPE html>

<html>

	<head>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<?php
		include ('html_snippets/header.php');
		?>
	</head>

	<body>

<nav class="navbar navbar-inverse navbar-expand-lg 	navbar-dark fixed-top">
      <div class="container" id="my_navbar">
        <a class="navbar-brand" href="http://localhost:8000/index.php">music matcher</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">

            
            <li class="nav-item ">
              <a class="nav-link" href="http://localhost:8000/tag_page.php">tagging</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="http://localhost:8000/php/text_correction.php
              ">ocr correction</a>
            </li>

          </ul>          
              <ul class="nav navbar-nav navbar-right">
              	<?php
          		include ('html_snippets/user_info.php');
				?>
      			<li><a href="http://localhost:8000/php/login.php"><span class="glyphicon glyphicon-user"></span> Sign Up | 
      			<span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      			<li><a href="http://localhost:8000/php/logout.php">
      			<span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    	 </ul>
        </div>
        
      </div>
 
    </nav>

		<div id="introduction" class="container" style="margin-top: 10px">
			<h1>music matcher</h1>
			<p>Das <span class="mark_term">Musikalische Wochenblatt</span>   - Organ für Musiker und Musikfreunde war eine Musik Fachzeitschrift 
			in der Zeit des Deutschen Kaiserreichs. Sie wurde 1870 von Oscar Paul begründet und wurde bis 1910 in
			Leipzig herausgegeben. Danach wurde sie von Ernst Wilhelm Fritsch as Neue Zeitschrift für Musik weitergeführt.
			In dieser Zeitschrift wurden Entwicklungen in der <span class="mark_term">Musik und Konzerte in ganz Deutschland</span>   besprochen.
			Ihr Inhalt gibt also ein sehr gutes Bild über die Entwicklungen während dieser Zeit wieder. 
			Ein Fokus lag dabei auf Leipzig...
			</p>
			<p>
			Die Ausgaben gibt es als eingescannte Dokumente, wir versuchen sie zu digitalisieren und benötigen dabei deine 
			Hilfe! Das können doch <span class="mark_term" title="Texterkennung - Für mehr Informationen klicke auf das Wort!">
				<a target="_blank" href="https://de.wikipedia.org/wiki/Texterkennung">OCR-Programme</a></span>
			 für euch machen, 
			denkst du dir vielleicht. Richtig! Wir verwenden genau so etwas. Während des 19. und Anfang des 20. Jahrhunderts
			veränderten sich die Schriftarten sehr stark, sodass der Text weniger gut erkannt werden kann. 
			
			
			</p>

			<h2>...wie du mitmachen kannst:</h2>
			<p>
			Du kannst uns helfen die erkannten Textabschnitte zu <span class="mark_term">korrigieren</span>
			oder Seiten mit Begriffen <span class="mark_term">taggen</span> - dann können wir noch 
			coolere Sachen machen. <br />
						Wie das geht, siehst du im folgenden Video:

			</p>
			
			<center>
				<video src="res/out.mp4" type="video/mp4" id="tutorial_video" width="420" height="340" controls>
	 				Dein Browser kann dieses Video nicht wiedergeben. Schade.<br/>
				</video>
			</center>


			
			<p>
			Wenn du Lust hast, kannst du das für eine Weile ausprobieren. Dazu klickst du einfach oben auf <span class="mark_term"><a href="http://localhost:8000/tag_page.php">tagging</a></span>
			oder <span class="mark_term"><a href="http://localhost:8000/php/text_correction.php">ocr correction</a></span>. Du musst dich dafür nicht registrieren!
			 Viel mehr Spaß macht
			es aber, wenn wir als Community zusammen arbeiten. Um dich zu registrieren oder 
			einzuloggen, klicke einfach <span class="mark_term"><a href="http://localhost:8000/php/login.php">hier</a></span>!
			</p>

			
			
			
			Hier siehst du eine kleine Übersicht über den Fortschritt des Projekts:
			<center>
				<div id="tagpiechart" style="width: 900px; height: 500px;"></div>
			</center>

			<h2>...noch ein OCR Projekt?</h2>
			 Was uns unterscheidet.
			<span class="mark_term">@todo</span>

			

			<h2>...du willst noch mehr helfen?</h2>
			<p>
				Wir - die Entwickler - freuen uns über ale Anregungen und Tipps. Wenn du möchtest,
				kannst du uns gerne eine <a title="Klicke hier, um eine Mail zu senden!" 
				href="mailto:tobiasw225@gmail.com?subject=Music Matcher Feedback">Mail</a>
				mit allen Ideen schreiben, die dir einfallen.
			</p>
			<p>
				Wir freuen uns auch über jeden, der uns hilft, das Projekt weiterzuführen.
				Wenn du programmieren kannst und Interesse hast, kannst du auf 
				<a href="https://github.com/tobiasw225/musicmatcher">github</a> mitmachen.

			</p>


		</div>

		<?php
		Include ('html_snippets/cc_licence.php');
		?>
	</body>
</html>
