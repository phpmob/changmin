# PhpMobMediaBundle

## Phpcr Filesystem

```yaml
# composer
    "doctrine/doctrine-cache-bundle": "^1.3",
    "doctrine/phpcr-bundle": "^1.3",
    "jackalope/jackalope-doctrine-dbal": "^1.3",
    "league/flysystem-phpcr": "^1.0",

# enable DoctrinePHPCRBundle in appKernel.php
new \Doctrine\Bundle\PHPCRBundle\DoctrinePHPCRBundle(),

# app/config/config.yml
imports:
    ...
    - { resource: "@PhpMobMediaBundle/Resources/config/app/main.yml" }
    - { resource: "@PhpMobMediaBundle/Resources/config/app/phpcr.yml" }

# override connection -- MUST be after `imports` phpcr.yml
# phpcr need to be utf8 connection
parameters:
    phpmob.flysystem.phpcr.connection: media

```
