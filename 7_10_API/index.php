<?php

require_once 'Person.php';
require_once 'DataStorage.php';

$name = $_POST['name'] ?? 'Ieva';

$dataStorage = new DataStorage();
$person = $dataStorage->getByName($name);

echo $person->getName() . ' is ';
echo $person->getAge() . ' years old and has ';
echo $person->getCount() . ' sheep.';

?>

<html>
<body>
<form action="/" method="post">
    <input type="text" id="name" name="name"/>
    <label for="name">Name</label>
    <button type="submit">Submit</button>
</body>
</html>
