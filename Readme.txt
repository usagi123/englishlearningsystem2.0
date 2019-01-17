Student ID: s3618861 && s3480522
Deployed link: https://maiphamquanghuy.com/
Credentials:
    - Admin user: admin - admin
    - Normal user: user - user 
    When register, new user will be listed into normal user
- Login (/login.php): to prevent unauthorized users from access data and perform actions

For admin account: 
- Home - index.php: to prevent unauthorized users from access data and perform actions 
- Learning 
    - randomword.php: I allow admin to see this page for admin to tweak their page. This page will display a single word take randomly from database.
        - quiz: php: After press next to learn next word, user will have to do the quiz to test what they have learned. 
    - sequence.php: I allow admin to see this page for admin to tweak their page. This page will display a single word take from start to the end list of word from database.
        - sequencequiz.php: After press next to learn next word, user will have to do the quiz to test what they have learned. 
- Listing - listing.php: list all words out 
- Add new - addnew.php: use the same form to handle both add new and update entity, based on the situation the title and navlink will change 
- Logout - logout.php: logout 

For user account: 
- Home - index.php: to prevent unauthorized users from access data and perform actions 
- Learning 
    - randomword.php: I allow admin to see this page for admin to tweak their page. This page will display a single word take randomly from database.
        - quiz: php: After press next to learn next word, user will have to do the quiz to test what they have learned. 
    - sequence.php: I allow admin to see this page for admin to tweak their page. This page will display a single word take from start to the end list of word from database.
        - sequencequiz.php: After press next to learn next word, user will have to do the quiz to test what they have learned. 
- Learner record - learner_record.php: Display data users when they access learning (random and sequence). It will display user id, word id, time started, time ended.
- Logout - logout.php: logout 

AWS Lambda: 
- Rest API link to expose words: https://9kj8sijy6e.execute-api.ap-southeast-1.amazonaws.com/dev/words 
- Rest API link to expose learner records: https://9kj8sijy6e.execute-api.ap-southeast-1.amazonaws.com/dev/learner_records 

What I had done: 
- Register system with password stored on database was salted 12 
- Login system that can prevent sql injection 
- CRUD words 