<?php

declare(strict_types=1);

namespace Support\Users;

class Actions extends Auth
{
    function __construct(?int $nivel = null)
    {
        parent::__construct('SP_token', true, false);

        if ($nivel) {
            $this->min_level($nivel);
        }
    }

    public function min_level($nivel): void
    {
        global $app;

        if ($this->user['nivel'] < $nivel) {
            $app->error('Userul nu are autorizatie!');
        }
    }

    public function action_log($table, $id, $action): self
    {
        global $crud, $db;

        $old_value = $crud->getOne($table, 'id', $id);

        $data =
            [
                'id_field'      => $id,
                'tabel'         => $table,
                'old_value'     => json_encode($old_value),
                'data_actiune'  => $db->now(),
                'id_user'       => $this->user['id'],
                'actiune'       => $action
            ];

        $crud->createEntry('istoric_tabele', $data);

        return $this;
    }
}
