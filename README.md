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

4. Browse the issue-api directory and run the following command to create issue:

  php create-issue.php "github-username" "github-password" "https://github.com/librianrahul/git-issue" "Test Title" "Test Description"

  php create-issue.php "bitbucket-username" "bitbucket-username"  "https://bitbucket.org/librianrahul/git-issue" "Test Title" "Test Description"

output:

stdClass Object
(
    [url] => https://api.github.com/repos/librianrahul/git-issue/issues/2
    [labels_url] => https://api.github.com/repos/librianrahul/git-issue/issues/2/labels{/name}
    [comments_url] => https://api.github.com/repos/librianrahul/git-issue/issues/2/comments
    [events_url] => https://api.github.com/repos/librianrahul/git-issue/issues/2/events
    [html_url] => https://github.com/librianrahul/git-issue/issues/2
    [id] => 56160673
    [number] => 2
    [title] => Test Title
    [user] => stdClass Object
        (
            [login] => librianrahul
            [id] => 10253347
            [avatar_url] => https://avatars.githubusercontent.com/u/10253347?v=3
            [gravatar_id] =>
            [url] => https://api.github.com/users/librianrahul
            [html_url] => https://github.com/librianrahul
            [followers_url] => https://api.github.com/users/librianrahul/followers
            [following_url] => https://api.github.com/users/librianrahul/following{/other_user}
            [gists_url] => https://api.github.com/users/librianrahul/gists{/gist_id}
            [starred_url] => https://api.github.com/users/librianrahul/starred{/owner}{/repo}
            [subscriptions_url] => https://api.github.com/users/librianrahul/subscriptions
            [organizations_url] => https://api.github.com/users/librianrahul/orgs
            [repos_url] => https://api.github.com/users/librianrahul/repos
            [events_url] => https://api.github.com/users/librianrahul/events{/privacy}
            [received_events_url] => https://api.github.com/users/librianrahul/received_events
            [type] => User
            [site_admin] =>
        )

    [labels] => Array
        (
        )

    [state] => open
    [locked] =>
    [assignee] =>
    [milestone] =>
    [comments] => 0
    [created_at] => 2015-02-01T11:30:04Z
    [updated_at] => 2015-02-01T11:30:04Z
    [closed_at] =>
    [body] =>
    [closed_by] =>
)

Issue created successfully.
