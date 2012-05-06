<?php
class Mailer ### Globale Funktionen
{
	public static function resetPassword($code, $resetEmail){
		
		$empfaenger = $resetEmail;
		
		$betreff = "Digital-Library - Passworthilfe";
		
		$mailtext = "<p>Wir haben eine Anfrage erhalten, das zu dieser E-Mail-Adresse geh&ouml;rende Passwort zu &auml;ndern. Falls Sie diese Anfrage gemacht haben, folgen Sie bitte den Anweisungen unten. </p>\n
					<p>Klicken Sie auf den nachstehenden Link, um Ihr Passwort innerhalb von <strong> zwei </strong> Tagen auf unserem Sicherheitsserver zur&uuml;ckzusetzen: </p>\n
					<p><a href=\" http://" . $_SERVER['HTTP_HOST'] . BASE_URL . "?page=confirmPassword&code=" . $code . "\">http://" . $_SERVER['HTTP_HOST'] . BASE_URL . "?page=confirm&code=" . $code . "</a></p>\n
					<p>Falls die Anfrage auf &Auml;nderung des Passworts nicht von Ihnen stammt, k&ouml;nnen Sie diese E-Mail gefahrlos ignorieren. Ihr Kundenkonto bleibt unber&uuml;hrt. </p>\n
					<p>Falls Sie durch Klicken auf den Link nicht weitergeleitet werden, k&ouml;nnen Sie den Link kopieren und in das Adressfenster Ihres Browsers einf&uuml;gen oder den Link selbst dort eingeben. Zur&uuml;ck bei Digital-Library.de werden wir Ihnen Anweisungen geben, wie Sie Ihr Passwort &auml;ndern k&ouml;nnen. </p>\n
					<p>Digital-Library.de bittet Sie in E-Mails niemals darum, Ihr Digital-Library.de-Passwort, Ihre Kreditkarten- oder Bankkontonummer preiszugeben oder zu best&auml;tigen. Falls Sie eine verd&auml;chtige E-Mail mit einem Link zur Aktualisierung Ihrer Kontoinformationen erhalten, klicken Sie nicht darauf. Melden Sie diese E-Mail Digital-Library.de, damit Nachforschungen angestellt werden k&ouml;nnen.</p>\n
					<p>Danke, dass Sie Digital-Library.de besucht haben!</p>";
					
		$headers = "From: <info@digital_library.de>\n"
				. "Content-Type: text/html; charset=utf-8; format=flowed\n"
				. "MIME-Version: 1.0\n"
				. "Content-Transfer-Encoding: 8bit\n"
				. "X-Mailer: PHP\n";
		if(mail($empfaenger, $betreff, $mailtext, $headers) == true) {
			return true;
		}
		else return false; 
	}
	
	public static function activateAccount($activateCode, $email){
		
		$empfaenger = $email;
		
		$betreff = "Herzlich Willkommen im Digital-Library.";
		
		$mailtext = "<p>Um Ihren neuen Account zu aktivieren klicken Sie bitte innerhalb von <strong> zwei </strong> Tagen auf diesen Best&aum;ltigungslink: </p>\n
					<p><a href=\" http://" . $_SERVER['HTTP_HOST'] . BASE_URL . "?page=activateAccount&activateCode=" . $activateCode . "\">http://" . $_SERVER['HTTP_HOST'] . BASE_URL . "?page=activateAccount&activateCode=" . $activateCode . "</a></p>\n
					<p>In unserer Bibliothek unter Digital-Library.de finden Sie ein gro&szlig;es Sortiment der neuesten B&uuml;cher zu unschlagbaren Preisen. </p>\n
					<p>Wir w&uuml;nschen viel Vergn&uuml;gen beim St&ouml;bern in unserer Bibliothek. Bei Fragen oder Anmerkungen k&ouml;nnen Sie sich gerne an unser Serviceteam wenden.</p>\n
					<p>Digital-Library.de bittet Sie in E-Mails niemals darum, Ihr Digital-Library.de-Passwort, Ihre Kreditkarten- oder Bankkontonummer preiszugeben oder zu best&auml;tigen. Falls Sie eine verd&auml;chtige E-Mail mit einem Link zur Aktualisierung Ihrer Kontoinformationen erhalten, klicken Sie nicht darauf. Melden Sie diese E-Mail Digital-Library.de, damit Nachforschungen angestellt werden k&ouml;nnen.</p>\n
					<p>Mit freundlichen Gr&uuml;&szlig;en,\n
					das Team von Digital-Library!</p>";
					
		$headers = "From: <info@digital_library.de>\n"
				. "Content-Type: text/html; charset=utf-8; format=flowed\n"
				. "MIME-Version: 1.0\n"
				. "Content-Transfer-Encoding: 8bit\n"
				. "X-Mailer: PHP\n";
		
		if(mail($empfaenger, $betreff, $mailtext, $headers) == true) {
			return true;
		}
		else return false; 
	}
}
?>