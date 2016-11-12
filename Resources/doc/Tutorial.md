## Step 1: create a new symfony application

```sh
symfony new myapp
```

if you doesn't have symfony installer, [install it !!](http://symfony.com/doc/current/setup.html)

## Step 2: add AyrelSeoBundle

First Download :
```sh
cd myapp
composer require ayrel/seo-bundle dev-master
```

Next enable the bundle

```php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new Ayrel\SeoBundle\AyrelSeoBundle(),
        // ...
    );
}
```


