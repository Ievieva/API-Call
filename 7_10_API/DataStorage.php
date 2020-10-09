<?php

class DataStorage
{
    private $resource;
    private array $persons;

    public function __construct()
    {
        $this->resource = fopen('file.csv', 'rw+');
        $this->loadPersons();
    }

    private function loadPersons(): void
    {
        while (!feof($this->resource)) {
            $personData = (array)fgetcsv($this->resource);

            $this->persons[] = new Person(
                (string)$personData[0],
                (int)$personData[1],
                (int)$personData[2]
            );
        }
    }

    public function getByName(string $name): Person
    {
        foreach ($this->persons as $person) {
            /** @var Person $person */
            if ($name === $person->getName()) {
                return $person;
            }
        }
        return $this->getPersonFromAPI($name);
    }

    private function getPersonFromAPI(string $name): Person
    {
        $response = file_get_contents('https://api.agify.io/?name=' . $name);
        $person = json_decode($response, true); //true izveido masivu

        fputcsv($this->resource, $person); // nevajag toArray metodi, jo jau ir masivs

        return new Person(
            $person['name'],
            $person['age'],
            $person['count']
        );
    }
}
