# wp-react-kit
A simple starter kit to work in WordPress with WP-script, React, React Router, Tailwind CSS, PostCSS, Eslint, i18n, PHP OOP plugin architecture easily in a minute.

----

### Quick Start
```sh
# Clone the Git repository
git clone https://github.com/dearvn/wp-react-example.git

# Install node module packages
npm i

# Install PHP-composer dependencies [It's empty]
composer install

# Start development mode
npm start

# Start development with hot reload (Frontend components will be updated automatically if any changes are made)
npm run start:hot

# To run in production
npm run build
```

After running `start`, or `build` command, there will be a folder called `/build` will be generated at the root directory.

### Browse Plugin
**using https://github.com/dearvn/wp-deployment to deploy in local enviroment

http://wordpress.local:8080/wp/wp-admin/admin.php?page=jobplace#/

Where, `/wpex` is the project root folder inside `/htdocs`.

Or, it could be your custom processed URL.

### Version & Changelogs
**v0.0.1 - 02/08/2022**

1. Necessary traits to handle - sanitization, query.
1. Advanced setup for migration, seeder, REST API.
1. Jobs, Job Types REST API developed.

### PHP Coding Standards - PHPCS

**Get all errors of the project:**
```sh
vendor/bin/phpcs .
```

**Fix all errors of the project:**
```sh
vendor/bin/phpcbf .
```

<details>
    <summary>Options for specific files:</summary>

**Get specific file errors of the project:**
```sh
vendor/bin/phpcs job-place.php
```


**Fix specific file errors of the project:**
```sh
vendor/bin/phpcbf job-place.php
```
</details>

### Check coding convention
<details>
    <summary>Fixing errors for input data</summary>

https://github.com/WordPress/WordPress-Coding-Standards/wiki/Fixing-errors-for-input-data#nonces
</details>

<details>
    <summary>Yoda Conditions: To Yoda or Not to Yoda</summary>

https://knowthecode.io/yoda-conditions-yoda-not-yoda
</details>


