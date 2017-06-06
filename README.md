### Extension of Kohana framework with simple multisite support

This extension allows using common code for multiple sites in one project.
Each of sites must have its own index.php, bootstrap.php, etc., but they also could use common code base:

* common classes (models, helpers)
* configuration files (database, etc.)
* other project-wide files, like migrations

Common files located in common/ directory, that is linked with `COMPATH` constant by analogy with `APPPATH`, `SYSPATH`, and `MODPATH`.

#### Installation

> composer create-project illusorium/kohana-multisite:dev-master

#### Creating new site structure from command-line

Kohana minion module is required to use this feature. Enable it in bootstrap.php.

> php minion multisite:create --site=new_host [--docRoot=www]

`new_host` - new site's name,

`www` - name of documentRoot directory: www, public_html, htdocs, etc.

Site will be created in `sites/new_host`.
You may also need to add new virtual host into web server configuration.