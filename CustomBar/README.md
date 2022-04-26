# Mage2 Module Wdevs CustomBar

    ``wdevs/module-custombar``

- [Main Functionalities](#markdown-header-main-functionalities)
- [Installation](#markdown-header-installation)
- [Configuration](#markdown-header-configuration)
- [Specifications](#markdown-header-specifications)

## Main Functionalities

Create a Magento module that will show a small bar at the top of the page.

## Installation

\* = in production please use the `--keep-generated` option

### Zip file

- Unzip the zip file in `app/code/Wdevs`
- Enable the module by running `php bin/magento module:enable Wdevs_CustomBar`
- Apply database updates by running `php bin/magento setup:upgrade`\*
- Flush the cache by running `php bin/magento cache:flush`

## Configuration

- Enable (topbar/general/enabled)

## Specifications

- Block
    - TopBar > topbar.phtml

- Helper
    - Wdevs\CustomBar\Helper\Data
