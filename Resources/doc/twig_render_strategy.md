# Twig Render Strategy

By default, an event kernel response event is catch by the SeoListener. The head tag of the Response is replace by the remastered head with the Seo Meta Tags.

But you can change this strategy.

## Configure a twig strategy

```yaml
ayrel_seo:
    strategy: 'twig'
```

## configure your layout

update your layout.html.twig

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

Now it's done !!