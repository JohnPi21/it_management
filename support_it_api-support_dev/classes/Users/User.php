<?php

declare(strict_types=1);

namespace Support\Users;

class User
{
        public ?array $user = null;

        //Create a new user from authenitifcation
        public function create_user($data): self
        {
                global $crud;
                $user =
                        [
                                'nume' => $data['nume'],
                                'email' => $data['email'],
                                'nivel' => 1,
                                'id_extern' => $data['id_extern']
                        ];
                $crud->createEntry('useri', $user);

                return $this;
        }


        //Update the user from an admin pannel
        public function update_user(int $id, $data): self
        {
                global $crud;
                $crud->updateEntry('useri', $data, $id);

                return $this;
        }


        //Get user based on specified value
        public function get_user($key, $value): self
        {
                global $crud;
                $this->user = $crud->getOne('useri', $key, $value);

                return $this;
        }
}
