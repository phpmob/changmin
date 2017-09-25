# PhpMobMediaBundle

## Phpcr Filesystem

```yaml
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
