# AyrelSeoBundle

With this bundle you can configure html meta tag and title tag in a config file : /app/config/seo.yml or just by adding an seo annotation.

You can write meta tags with Twig patterns. The available variables are those in the Request attributes.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/00b944d1-d197-42ae-8319-27bccebe6006/big.png)](https://insight.sensiolabs.com/projects/00b944d1-d197-42ae-8319-27bccebe6006)

## Install

this bundle is not STABLE, it's not publish on packagist...

if you want to install the package please add a custom repository to your composer.json file

```sh
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/laurentosp/AyrelSeoBundle"
        }
    ]
```

after that you can do 

```sh
composer require ayrel/seo-bundle dev-master
```

add the Bundle to your application kernel

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

it's done... you can enjoy!!!

## Configure Your first route

First you have to update your layout.html.twig

```jinja
....
//app/Resources/views/base.html.twig
<!DOCTYPE html>
<html>
    <head>
{{ ayrel_seo() }}
    <meta charset="UTF-8" />
....
```

Then you can add some meta tags...

Create a app/config/seo.yml file

```yaml
homepage:
    title: 'my beautifull title'
    description: 'this is a description'
    og_title: 'you can share this'
    og_description: 'this is a so interesting webpage....'
```

Now run your app.... this is so amazing!!!

## go on with complex pattern

The goal of this bundle is to create dynamic meta tags for a given route. To achieve this goal, the previous config is made with twig template string.

Let's do more dynamics....

please create some request attributes

```php
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $request->attributes->set('product', [
            'title' => 'dvd palmashow',
            'price' => 44.30,
            'desc' => 'lorem ipsus.... '
        ]);

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
```


now update your app/config/seo.yml file

```yaml
homepage:
    title: '{{product.title}} : {{product.price}} €'
    description: '{{product.desc}}'
    og_title: 'you can share this'
    og_description: 'this is a so interesting webpage....'
```


## try the annotation

you can configure route with app/config/seo.yml file or via annotation...

please remove the app/config/seo.yml file

configure a route like this 

```php
use Ayrel\SeoBundle\Annotation\SeoAnnotation as Seo;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Seo({
     *     "title": "{{product.title}} : {{product.price}} €",
     *     "description": "{{product.desc}}"
     * })
     */
    public function indexAction(Request $request)
    {
        $request->attributes->set('product', [
            'title' => 'dvd palmashow',
            'price' => 44.30,
            'desc' => 'lorem ipsus.... '
        ]);
    }
```


