<?php

declare(strict_types=1);

namespace Support\Picking;

class Picking
{
    public ?array $data = null;
    public ?array $currentEntry = null;

    function __construct(?array $data = null)
    {
        $this->data = $data;
        return $this;
    }

    //Verifica baza de date daca statusul device ului este cel dat in input
    public function statusMustBe(string $table, $id, array $status): self
    {
        global $crud, $app;

        if (isset($id) && $id !== 'NECUNOSCUT') {
            $q = $crud->getOne($table, 'id', $id);

            foreach ($status as $stat) {
                if ($q["status"] != $stat) {
                    $app->error("Problema status device! " . $stat);
                }
            }
        }
        return $this;
    }

    //Verifica baza de date daca statusul device ului e diferit de cele impuse
    public function statusMustNot(string $table, $id, array $status): self
    {
        global $crud, $app;

        if (isset($id) && $id !== 'NECUNOSCUT') {
            $q = $crud->getOne($table, 'id', $id);

            foreach ($status as $stat) {
                if ($q["status"] == $stat) {
                    $app->error("Problema status device! " . $stat);
                }
            }
        }
        return $this;
    }

    //Filtreaza intrarile care au valorile null in array
    public function filterNull(): self
    {
        $this->data = array_filter($this->data, fn ($value) => !is_null($value));
        return $this;
    }

    //Insereaza valorile in tabel
    public function createEntry(string $table): int
    {
        global $crud;

        $q = $crud->createEntry($table, $this->data);

        return $q;
    }

    //Updateaza statusul
    public function updateStatus(string $table, $id, string $status): self
    {
        global $crud;

        if (isset($id) && gettype($id) == 'integer') {
            $crud->updateEntry($table, ['status' => $status], $id);
        }
        return $this;
    }

    //Update table with the new data
    public function updateData(string $table, ?int $id): self
    {
        global $crud, $app;

        if (!$this->data) {
            $app->message('Nu exista schimbari!');
        }
        $crud->updateEntry($table, $this->data, $id);

        return $this;
    }

    //Get current devices
    public function getCurrent(string $table, int $id): self
    {
        global $crud;

        $q = $crud->getOne($table, 'id', $id);

        $this->currentEntry = $q;

        return $this;
    }

    //Update current devices if it changes
    public function updateCurrent(string $table, string $device, ?string $status): self
    {
        global $crud;

        $id_device = $this->currentEntry['id_' . $device];

        if (isset($status) && !empty($id_device)) {
            $crud->updateEntry($table, ['status' => $status], $id_device);
        }
        $this->createService($device, $status);

        return $this;
    }

    //Set the columns null after filter null if they must be null
    public function setUnknown(array $unknowns): self
    {
        foreach ($unknowns as $key => $value) {
            if ($value == 'NECUNOSCUT') {
                $this->data[$key] = null;
            }
        }
        return $this;
    }

    //Create service entry from table update PENDING
    public function createService(string $device, ?string $status): self
    {
        global $crud;

        if (isset($status) && $status === 'SERVICE' && !empty($this->currentEntry['id_' . $device])) {
            $data =
                [
                    'id_depozit'    => $this->currentEntry['id_depozit'],
                    'id_device'     => $this->currentEntry['id_' . $device],
                    'status'        => 'PENDING'
                ];
            $q = $crud->createEntry('picking_service', $data);
        }
        return $this;
    }

    //Update device status for service
    public function updateService(?string $status): self
    {
        global $crud;
        if (isset($status) && $status === 'REPARAT') {
            $crud->updateEntry('picking_devices', ['status' => 'STOC'], $this->currentEntry['id_device']);
        }
        if (isset($status) && $status != 'REPARAT') {
            $crud->updateEntry('picking_devices', ['status' =>  $status], $this->currentEntry['id_device']);
        }
        return $this;
    }

    //Delete a row in a table in database
    public function deleteEntry(string $table, int $id): self
    {
        global $crud;

        $crud->deleteEntry($table, $id);

        return $this;
    }

    //Delete data from an entry
    public function deleteData(string $table, ?int $id, ?string $column, array $allowed): self
    {
        global $app;
        if (!in_array($column, $allowed)) {
            $app->error('Campul ' . $column . ' nu se poate sterge!');
        }
        $data = [$column => null];
        $this->data = $data;

        $this->updateData($table, $id);

        return $this;
    }

    //Check an entry in table
    public function check($table, $id)
    {
        global $crud, $app;

        if ($this->currentEntry['checked'] === null) {
            $crud->updateEntry($table, ['checked' => 1], $id);
            $app->message('Verificat!');
        } else {
            $crud->updateEntry($table, ['checked' => null], $id);
            $app->message('Verificare anulata!');
        }
    }
}
