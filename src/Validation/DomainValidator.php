<?php
namespace App\Validation;

use Cake\Validation\Validator;

class DomainValidator
{
    public static function buildValidator(): Validator
    {
        $validator = new Validator();
        $validator->add('domain', 'validDomain', [
            'rule' => function ($value, $context) {
                // RegEx per un dominio senza "www"
                $regex = '/^(?!-)[A-Za-z0-9-]{1,63}(?<!-)\.(?!-)[A-Za-z0-9-]{1,63}(?<!-)$/';

                if (stripos($value, 'www.') === 0) {
                    // Restituisce falso per domini che iniziano con "www."
                    return 'il dominio non deve includere il www';
                }

                // Valida il dominio con la regEx
                if (!preg_match($regex, $value)) {
                    return 'dominio non valido';
                }

                // Dominio valido
                return true;
            },
        ]);

        return $validator;
    }
}
