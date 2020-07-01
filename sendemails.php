<?php // written by Adam Lloyd - https://adam-lloyd.net - and copyright to his employers
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once("PHPMailer/src/Exception.php");
require_once("PHPMailer/src/PHPMailer.php");
require_once("PHPMailer/src/SMTP.php");

outputMessage("Loaded PHPMailer.");

const domain = ".sch.uk"; // your email domain
const resultslocation = '\\\uncpath\c$\tofiles'; // path (accessible by this script) to the folder location containing XML and exported PDFs from SIMS
const xmlname = "\studentdata.xml"; // name of file exported from SIMS report
const resultsfileformat = "-DUMMY GCSE Exam Results Summer 2019.pdf"; // LASTNAME-Firstname-6digitadmissionnumber...

// import XML
if(file_get_contents(resultslocation.xmlname) === false) {
	outputMessage("Could not find XML document: ".resultslocation.xmlname.".");exit;
}
$dom = new DomDocument();
$dom->load(resultslocation.xmlname);
outputMessage("Loaded XML.");
$students = $dom->documentElement->GetElementsByTagName("Record");
foreach($students as $student) {
	$legalSurname = $student->getElementsByTagName('LegalSurname')->item(0)->textContent;
	$forename = $student->getElementsByTagName('Forename')->item(0)->textContent;
	$admissionNumber = sprintf("%06s", $student->getElementsByTagName('AdmissionNumber')->item(0)->textContent);
	$primaryEmail = $student->getElementsByTagName('PrimaryEmail')->item(0)->textContent;
	$chosenName = $student->getElementsByTagName('ChosenName')->item(0)->textContent;
	
	// find document
	if(file_exists(resultslocation."\\".$legalSurname."-".$forename."-".$admissionNumber.resultsfileformat)) {
		// check email
		if($primaryEmail == "" || !(strpos($primaryEmail,domain))) {
			outputMessage("Warning: no internal email address available for ".$forename." ".$legalSurname.".");
		} else {
			// send email
			$mail = new PHPMailer(true);
			try {
				//Server settings

				//Recipients
				$mail->setFrom('exams@'.domain, 'Exams Office'); // replace with your Exams Office's email address
				$mail->addAddress($primaryEmail);

				// Attachments
				$mail->addAttachment(resultslocation."\\".$legalSurname."-".$forename."-".$admissionNumber.resultsfileformat,"Statement of Results.pdf");

				// Content
				$mail->isHTML(true);                                  // Set email format to HTML
				$mail->Subject = 'Examination Results';
				$mail->Body    = 'Dear '.$chosenName.",<br><br>Please find attached your examination results.<br><br>With kind regards,<br><b>Exams Office</b><br><br>01249 650693<br><img src=\"linktoschoollogo.png\" width=\"50\" height=\"50\" alt=\"School Logo\">";

				$mail->send();
				outputMessage("Sent to ".$primaryEmail);
			} catch (Exception $e) {
				outputMessage("Message could not be sent to ".$forename." ".$legalSurname." (".$primaryEmail."). Mailer Error: {$mail->ErrorInfo}");
			}
		}
	}
}
outputMessage("Finished.");

function outputMessage($msg) {
	echo "[". date("Y-m-d H:i:s")."] ".$msg."<br>";
} ?>
