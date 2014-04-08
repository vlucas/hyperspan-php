Hyperspan
=========

Build a Hypermedia API response once in code and return it in multiple formats

**NOTE:** Currently in heavy active development, and only supports
[Siren](https://github.com/kevinswiber/siren)

Installation
------------
Use the Composer [basic usage guide](http://getcomposer.org/doc/01-basic-usage.md),
or use the following commands:

    curl -s http://getcomposer.org/installer | php
    php composer.phar require vlucas/hyperspan 0.x
    php composer.phar install

Overview
--------

There are two main components of Hyperspan: `Hyperspan\Response`, which is used
to build an API response with specific attributes and types of data, and
`Hyperspan\Formatter`, which is used to output the data in a sepcific
Hypermedia API response format.

Supported Hypermedia Formats
----------------------------

 * [HAL](http://stateless.co/hal_specification.html) (+forms)
 * [Siren](https://github.com/kevinswiber/siren)

HAL JSON Usage
----------------

The following code:
```php
$res = new Hyperspan\Response();
$res->setProperties(array(
        'foo' => 'bar',
        'bar' => 'baz'
    ));
    ->addLink('self', 'http://localhost/foo/bar');
    ->addForm('add-item', array(
        'method' => 'POST',
        'href' => '/items',
        'fields' => array(
            'name' => array('type' => 'string'),
            'body' => array('type' => 'text')
        )
    ))
    ->addItem('item', array(
        'some' => true,
        'something' => 'else',
        'three' => 3
    ));

$format = new Hyperspan\Formatter\Hal($res);

header('Content-Type', 'application/hal+json');
echo $format->toJson();
```

Will output the following JSON structure in [HAL](http://stateless.co/hal_specification.html).
```
{
  "foo": "bar",
  "bar": "baz",
  "_embedded": {
    "item": {
      "some": true,
      "something": "else",
      "three": 3
    }
  ],
  "_forms": [
    "add-item": {
      "method": "POST",
      "href": "/items",
      "fields": [
        "name": { "type": "string" },
        "body": { "type": "text" }
      ]
    }
  ],
  "_links": [
    "self": { "href": "http://localhost/foo/bar" }
  ]
}
```

Siren JSON Usage
----------------

The following code:
```php
$res = new Hyperspan\Response();
$res->title = 'Siren Sample JSON Response with Hyperspan';
$res->setProperties(array(
        'foo' => 'bar',
        'bar' => 'baz'
    ));
    ->addLink('self', 'http://localhost/foo/bar');
    ->addForm('add-item', array(
        'title' => 'Add Item',
        'method' => 'POST',
        'href' => '/items',
        'fields' => array(
            array('name' => 'name', 'type' => 'string'),
            array('name' => 'body', 'type' => 'text')
        )
    ))
    ->addItem('item', array(
        'some' => true,
        'something' => 'else',
        'three' => 3
    ));

$format = new Hyperspan\Formatter\Siren($res);

header('Content-Type', 'application/vnd.siren+json');
echo $format->toJson();
```

Will output the following JSON structure in [Siren](https://github.com/kevinswiber/siren).
```
{
  "title": "Siren Sample JSON Response with Hyperspan",
  "properties": {
    "foo": "bar",
    "bar": "baz"
  },
  "entities": [
    {
      "properties": {
        "some": true,
        "something": "else",
        "three": 3
      }
    }
  ],
  "actions": [
    {
      "name": "add-item",
      "title": "Add Item",
      "method": "POST",
      "href": "/items",
      "fields": [
        { "name": "name", "type": "string" },
        { "name": "body", "type": "text" }
      ]
    }
  ],
  "links": [
    { "rel": [ "self" ], "href": "http://localhost/foo/bar" }
  ]
}
```

