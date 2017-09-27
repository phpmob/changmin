# PhpMobMediaBundle

## Phpcr Filesystem

```yaml
# composer
    "doctrine/phpcr-bundle": "^1.3",
    "jackalope/jackalope-doctrine-dbal": "^1.3",
    "league/flysystem-phpcr": "dev-master",

# enable DoctrinePHPCRBundle in appKernel.php
new \Doctrine\Bundle\PHPCRBundle\DoctrinePHPCRBundle(),

# app/config/config.yml
imports:
    ...
    - { resource: "@PhpMobMediaBundle/Resources/config/app/main.yml" }
    - { resource: "@PhpMobMediaBundle/Resources/config/app/phpcr.yml" }

# override connection -- MUST be after `imports` phpcr.yml
parameters:
    phpmob.flysystem.phpcr.connection: media

```

## Setup Phpcr

```bash
sf doctrine:phpcr:repository:init 
```
