LimeSoda LiveGuard
=====================
Helps you to protect your live environment (and others) by checking that all settings are what they should be.

Build Status
---
**Latest Release**

[![Build Status](https://travis-ci.org/LimeSoda/LimeSoda_LiveGuard.svg?branch=master)](https://travis-ci.org/LimeSoda/LimeSoda_LiveGuard) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/LimeSoda/LimeSoda_LiveGuard/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/LimeSoda/LimeSoda_LiveGuard/?branch=master)

**Development Branch**

[![Build Status](https://travis-ci.org/LimeSoda/LimeSoda_LiveGuard.svg?branch=dev)](https://travis-ci.org/LimeSoda/LimeSoda_LiveGuard) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/LimeSoda/LimeSoda_LiveGuard/badges/quality-score.png?b=dev)](https://scrutinizer-ci.com/g/LimeSoda/LimeSoda_LiveGuard/?branch=dev)

Facts
-----
- version: 1.0.1
- extension key: LimeSoda_LiveGuard
- GitHub URL: [https://github.com/LimeSoda/LimeSoda_LiveGuard](https://github.com/LimeSoda/LimeSoda_LiveGuard)

Description
-----------
You can use LimeSoda_LiveGuard to define "guards" that check if settings are what you expect them to be in the given environment.

A typical use case is to make sure that no production settings are used in non-production environments.

Requirements
------------
- [LimeSoda_EnvironmentConfiguration](https://github.com/LimeSoda/LimeSoda_EnvironmentConfiguration)
- PHP >= 5.2.0
- Mage_Core

Compatibility
-------------
- Tested with these Magento versions:
    - Magento CE 1.5.0.1 - 1.9.0.1
    - Magento EE 1.13.0.2 - 1.14.1.0

  Other versions may work too.

Installation Instructions
-------------------------
1. Set an environment in your configuration XML (e.g. local.xml). See "Usage" for more information.
2. Install the extension via modman.

Usage
-----

### Set an environment name

**Very important: set a name for your environment before you install the extension!**

Your shop won't run if this extension is installed and you didn't define an environment.

This happens to make sure that everything is configured properly and no guard is missed because of a misconfiguration.

Configure the environment in your XML. Normally you already should have defined the environment when you installed `LimeSoda_EnvironmentConfiguration`.
Most of the time you will want to put this in local.xml as this file doesn't get shared between copies of the shop in most setups.

    <config>
        <global>
            <limesoda>
                <environment>
                    <name>dev</name>
                </environment>
            </limesoda>
        </global>
    </config>

### Add guards

Add guards by creating a new extension (or using an existing one) and adding new guards under the `global > limesoda_liveguard > guards` node in `config.xml`:

As with the environment setting this extension follows a defensive approach for the guards configuration. This means that you have to set `active` to `false` explicitly and add an
environment to `environments_to_omit` if the guard should **not** be running in the specified environment.

    <config>
        <global>
            <limesoda>
                <guards>
                    <m2epro_guard>
                        <active>true</active>
                        <environments_to_omit>live</environments_to_omit>
                        <class>yourextension/yourclass</class>
                    </m2epro_guard>
                </guards>
            </limesoda>
        </global>
    </config>

What you define:

* `active`:
  If the value is any other value than `false` the guard will be active.

* `environments_to_omit`:
  The environments in which the guard should **not** be active. You can separate several environments with a comma.
* `class`:
  A string identifying the guard class. You define this like you would define any other class (e.g. when defining an observer). This class has to implement the `LimeSoda_LiveGuard_Model_GuardInterface` interface.
  
### Implementing a guard

A guard can be any class implementing the `LimeSoda_LiveGuard_Model_GuardInterface` interface.

The class only has to implement the method `process`.

Check what ever you want to check in this method and throw an Exception if the check fails (that is: a production environment is in danger).

Uninstallation
--------------
1. Remove the extension like any modman extension.

Support
-------
If you have any issues with this extension, open an issue on [GitHub](https://github.com/company/LimeSoda_LiveGuard/issues).

Contribution
------------
Any contribution is highly appreciated. The best way to contribute code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Developers
----------
* Matthias Zeis ([@mzeis](https://twitter.com/mzeis))
* Andreas Penz ([@dopamedia](https://twitter.com/dopamedia))

License
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)

Copyright
---------
(c) 2013-2015 LimeSoda Interactive Marketing GmbH
