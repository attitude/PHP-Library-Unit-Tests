PHP Library Unit Tests
======================

> Unit tests for PHP Library

## Setup

1. Install [PHP Unit](http://phpunit.de/manual/3.8/en/installation.html#installation.phar)
2. Add `alias phpunit='php /usr/local/bin/phpunit --colors'` to `~/.bash_profile`
3. Run `phpunit -v -c config.xml`

### Directory Structure

    / .
      |- [src]
      |  |- [attitude] (git clone <PHP Lib URL> .)
      |     |+ [Abstracts]
      |     |+ [Implementations]
      |     |+ [Interfaces]
      |     |-  autoload.php
      |     `-  README.md
      |
      `- [tests] (git clone <PHP Lib Tests URL> .)
         |+ [storage.columns]
         |+ [storage.database]
         |- config.xml         |- LICENSE         `- README.md
Author: [Martin Adamko](http://twitter.com/martin_adamko)
