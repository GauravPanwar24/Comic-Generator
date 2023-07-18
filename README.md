# Email a random XKCD challenge Solution

## Problem Statement:

Please create a simple PHP application that accepts a visitor’s email address and emails them random XKCD comics every five minutes.
- Your app should include email verification to avoid people using others’ email addresses.
- XKCD image should go as an email attachment as well as inline image content.
- You can visit https://c.xkcd.com/random/comic/ programmatically to return a random comic URL and then use JSON API for details https://xkcd.com/json.html
- Please make sure your emails contain an unsubscribe link so a user can stop getting emails.
- Since this is a simple project it must be done in core PHP including API calls, recurring emails, including attachments should happen in core PHP. Please do not use any libraries.

## Live Demo Link:

https://xkcd-randomcomics.herokuapp.com

## Services Used:
- Web hosting: Heroku
- Email sending service: SendinBlue
- Cron Job Scheduler: Cron To Go (Note: I have used a 7 day free trial, starting from 9/01/2022)
 
 ## Screenshots: 

 ### Home Page: 
 User can register himself to recieve comic mail regularly.
 !['Home Page'](./images/home.jpg)
 !['Home Page Registration'](./images/registeration.jpg)
 !['Home Page Registration Success'](./images/link_sent.jpg)

 ### Account Verification
 Email is sent to the registered mail with email verification link.
 !['Email verification mail'](./images/verify_mail.jpg)
 !['Email verification success'](./images/verify_success.jpg)

 ### Cron Job Setup
 Cron To Go Add-on is used to seng the active registered user random comic mail every 5-minutes.
 !['Cron To Go Dashboard'](./images/cronjob_success.jpg)

 ### Random Comic Mail
Registered active user recieves random comic updates with comic image as an attatchment file every 5-minutes.
!['Comic update email'](./images/comicmail.jpg)
!['Update every 5 minutes'](./images/mail_success.jpg)

### Unsubscribe 
To unsubscribe the service user has to click the link at the end of every comic update.
!['Unsubscribe success'](./images/unsubscribe.jpg)