# Tree.php
Simple class to work with multidimensional arrays.
## Installation
Just download the source file and include it to your project.
## Usage
### Create a tree
Let's make a simple tree.
```PHP
$array = [
  'path' => [
    'to' => [
      'tree' => 'Hello World!'
    ]
  ]
];

$tree = new Tree($array);
```
It's so easy, let's try to work with it.
### Get tree items
To get the tree element, use the ```get``` method
```PHP
echo $tree->get(['path','to','tree']);
// Equal
echo $tree->get('path.to.tree');
```
Result:
```
Hello World!
```
### Get the full tree
To get the full tree, use the ```getTree``` method
```PHP
print_r($tree->getTree());
```
Result:
```PHP
Array (
  [path] => Array (
    [to] => Array (
      [tree] => Hello World!
    )
  )
)
```
### Set tree items
To set the tree item, use ```set``` method
*Warning:* this method replaces the previously created element to the new.
Example:
```PHP
$tree->set('test','Set test item');
$tree->set('test.to','Previous test item will be replaced by this');

print_r($tree->getTree());
```
Result:
```PHP
Array (
  [path] => Array (
    [to] => Array (
      [tree] => Hello World!
    )
  )
  [test] => Array (
    [to] => Previous test item will be replaced by this
  )
)
```
### Add tree items
This ```add``` method is similar to the previous one, but it does not replace an existing element of the new, but combines them
Example:
```PHP
$tree->add('foo','Add');
$tree->add('foo','Add 2');
$tree->add('foo.bar','Add nested');
$tree->add('foo.bar','Add nested 2');

print_r($tree->getTree());
```
Result:
```PHP
Array (
  [path] => Array (
    [to] => Array (
      [tree] => Hello World!
    )
  )
  [foo] => Array (
    [0] => Add
    [1] => Add 2
    [bar] => Array (
      [0] => Add nested
      [1] => Add nested 2
    )
  )
)
```
### Set/add many items
You can use methods ```addList``` and ```setList``` to set/add more than 1 item simpler. 
Example:
```PHP
$tree->setList([
  ['path.to.tree','value'],
  ['another.path','another value']
]);
// This equals to
$tree
  ->set('path.to.tree','value')
  ->set('another.path','another value');
```
### Check tree item
If you need to verify the existence of an element in the tree, you can use ```has``` method.
Example:
```PHP
var_dump($tree->has('undefinedElement'));
var_dump($tree->has('foo.bar'));
var_dump($tree->has('foo.bar.anotherUndefinedElement'));
```
Result:
```PHP
boolean false
boolean true
boolean false
```
### Remove tree item
You can remove tree items using ```remove``` method.
Example:
```PHP
echo 'Before:';
var_dump($tree->getTree());
$tree->remove('foo');
echo 'After:';
var_dump($tree->getTree());
```
Result:
```PHP
Before:

Array (
  [path] => Array (
    [to] => Array (
      [tree] => Hello World!
    )
  )
  [foo] => Array (
    [0] => Add
    [1] => Add 2
    [bar] => Array (
      [0] => Add nested
      [1] => Add nested 2
    )
  )
)

After: 

Array (
  [path] => Array (
    [to] => Array (
      [tree] => Hello World!
    )
  )
)
```
**UPD:** You can remove more than 1 tree item using this method.
Example:
```
$tree->remove('first.item','second.item','and.so.on');
```
## Contact info
If you have some questions, you can create an issue or write to webmaster.kelin@yandex.ru
