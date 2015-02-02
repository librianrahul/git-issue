# git-issue
This code is used to post issue on github/bitbucket repository via Command Line Interface. Here is the step to run this code with server requirements


A) System Requirements:

1. OS: Mac/Linux/Windows
2. Apache/Nginx Server
3. php-fpm (in case of Nginx)
4. PHP 5.5+
5. Enable curl extension
6. Enable register_argc_argv


B) How to Install:

1. Download the source code from 'https://github.com/librianrahul/git-issue.git'

2. Upload the source code on server. path=/var/home/html/

4. Browse the git-issue directory and run the following command to create issue:

  php create-issue.php "github-username" "github-password" "https://github.com/librianrahul/git-issue" "Test Title" "Test Description"

  php create-issue.php "bitbucket-username" "bitbucket-username"  "https://bitbucket.org/librianrahul/git-issue" "Test Title" "Test Description"
