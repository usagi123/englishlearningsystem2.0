Student ID: s3618861 
Deployed link: https://maiphamquanghuy.com/
Credentials: 
    - Admin user: admin - admin
    - Normal user: user - user
    When register, new user will be listed into normal user

- Login (/login.php): to prevent unauthorized users from access data and perform actions 

For admin account:
- Home - index.php: to prevent unauthorized users from access data and perform actions 
- Learning - randomword.php: I allow admin to see this page for admin to tweak their page. This page will display a single word take randomly from database. There will be a place for user to practice their pronounciation. User press record and allow website to use their microphone, then talk. After a bit, user will submit their result by pressing submit button.
- Listing - listing.php: list all words out
- Add new - addnew.php: use the same form to handle both add new and update entity, based on the situation the title and navlink will change 
- Logout - logout.php: logout

For user account:
- Home - index.php: to prevent unauthorized users from access data and perform actions 
- Learning - randomword.php: this page will display a single word take randomly from database. There will be a place for user to practice their pronounciation. User press record and allow website to use their microphone, then talk. After a bit, user will submit their result by pressing submit button.
- Logout - logout.php: logout

What I had done:
- Register system with password stored on database was salted 12.
- Login system that can prevent sql injection
- CRUD words
- A voice regconition for users to practice their pronounciation
- SSL by adding my ELB to CNAME on CloudFlare. I choose CF as I already added their name servers on my registar.

