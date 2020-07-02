# emailexamresults
A quick PHP script that utilises PHPMailer to pull in XML and PDFs exported from SIMS reports to email pupils' exam results to them. Originally coded to support my school during the COVID-19 pandemic, but feel free to adapt and reuse as you like! You can grab the latest PHPMailer to include in the directory here: https://github.com/PHPMailer/PHPMailer/releases
# How to set up
You'll need a web server running PHP. We're using a Windows one for this because it makes it nice and easy to put in a UNC path to the files, but the code will work elsewhere too.
We export the XML from the SIMS report (report definition included here so just choose Reports > Import in SIMS) into a folder on our server that isn't in inetpub, since we don't want to publish all our pupil data on the web! The PDFs our Exams Officer exports (.docx file explains how to do this) also go in this folder with a specific naming format, which by default is "[LASTNAME]-[Firstname]-[6digitadmissionnumber]-DUMMY GCSE Exam Results Summer 2019.pdf" .
I'd recommend setting up some security on the directory to prevent anyone from running the script when they shouldn't!
Add the latest PHPMailer to the directory: https://github.com/PHPMailer/PHPMailer/releases
We also add our school logo into the directory so we can include it at the bottom of the emails.

# What the code does
The code requires you to set a domain for your email addresses - it does this to check that it's not accidentally sending the results somewhere it shouldn't. The pupil's school email address will need to be their primary email in SIMS. If you're using any services like Satchel One (Show My Homework) with Single Sign On this will already be the case!
If it can find the results file and marry that up to a pupil from your SIMS XML, it'll send an email with their results attached to them. It'll output a status when it has finished running.
It was thrown together in an afternoon and isn't very sophisticated so you'll have to wait until it finishes to see a list of which emails sent and which had errors.

# Support
This code is provided "as-is": you're responsible for the security of your systems when implementing it. If you need support with it you can contact adam [at] adam-lloyd.net but I'm afraid I can't guarantee that I'll have time to get back to you! You are welcome to use and adapt as you wish though.
