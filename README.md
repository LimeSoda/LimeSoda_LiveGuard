LimeSoda LiveGuard
=====================
Helps you to protect your live environment (and others) by checking that all settings are what they should be.

Facts
-----
- version: 0.0.1
- extension key: LimeSoda_LiveGuard
- [extension on GitHub](https://github.com/company/LimeSoda_LiveGuard)

Description
-----------
You can use LimeSoda_LiveGuard to define "guards" that check if settings are what you expect them to be in the given environment.

A typical use case is to make sure that no production settings are used in non-production environments.

Requirements
------------
- PHP >= 5.2.0
- Mage_Core
- ...

Compatibility
-------------
- Magento >= EE 1.13.0.2 (should also work in older and CE versions but was not tested)

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

Configure the environment in your XML. Most of the time you will want to put this in local.xml as this file doesn't get shared between copies of the shop in most setups.

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
            <limesoda_liveguard>
                <guards>
                    <m2epro_guard>
                        <active>true</active>
                        <environments_to_omit>live</environments_to_omit>
                        <class>yourextension/yourclass</class>
                    </m2epro_guard>
                </guards>
            </limesoda_liveguard>
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

Developer
---------
Matthias Zeis
[http://www.limesoda.com](http://www.limesoda.com)  
[@mzeis](https://twitter.com/mzeis)

License
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)

Copyright
---------
(c) 2013 LimeSoda Interactive Marketing GmbH
