# AyrelSeoBundle

With this bundle you can configure html meta tag and title tag in a config file : /app/config/seo.yml or just by adding an seo annotation.

You can write meta tags with Twig patterns. The available variables are those in the Request attributes.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/00b944d1-d197-42ae-8319-27bccebe6006/big.png)](https://insight.sensiolabs.com/projects/00b944d1-d197-42ae-8319-27bccebe6006)

## Install

###Step 1 : Download

use composer...

```sh
composer require ayrel/seo-bundle dev-master
```


###Step 2 : Enable The Bundle
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

## Configure Your first Route

```php
use Ayrel\SeoBundle\Annotation\SeoAnnotation as Seo;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Seo({
     *     "title": "my Website | {{_route}}",
     *     "description": "this is the route {{_route}} of my website"
     * })
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
    
    /*....*/
}
```

## Use with The ParamConverter Component

The ParamConverter Component register the params attributes of your Controller in the Request attributes.

With this Bundle you can access these Object to write amazing templates.

```php
use Ayrel\SeoBundle\Annotation\SeoAnnotation as Seo;

use AppBundle\Entity\Product;

class DefaultController extends Controller
{
    /**
     * @Route("/product/{id}", name="product")
     * @Seo({
     *     "title": "{{product.title}} : {{product.price}} €",
     *     "description": "{{product.desc}}"
     * })
     */
    public function productAction(Product $product)
    {
        /*.....*/
    }
    
    /*....*/
}
```

## Configure all your routes in one file

You can set your metaTag Templates by annotation. But you can also write a yml file to configure all you routes.

Just create a app/config/seo.yml file

and configure your templates :
```yaml
homepage:
    title: 'my beautifull title'
    description: 'this is a description'
    og_title: 'you can share this'
    og_description: 'this is a so interesting webpage....'

product:
    title: '{{product.title}} : {{product.price}} €'
    description: '{{product.desc}}'
```


## Configure default meta

you can add default value to the meta.

Just write you're app/config/config.yml file

```yaml
ayrel_seo:
    default:
        title: 'my webisite | {_route}'
```

if you want to use the default meta value, configure the route meta with a NULL value.

```yaml
homepage:
    title: ~
```

##Resources
[Twig Strategy](Resources/doc/twig_render_strategy.md)
