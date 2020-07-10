<?php

/*
 * This file is part of laravel filtering package.
 *
 * (c) Gether Kestrel B. Medel <gether.medel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
|--------------------------------------------------------------------------
| Auto filtering relationships for laravel models
|--------------------------------------------------------------------------
|
| Here is where all filtering of relationships logic happens.
| Current version supports single or array value of filtering one column
| from a relationship.
|
*/

namespace App\Traits;

trait FilterRelationships
{
    /**
     * Data array that will filter with relationship
     *
     * @var array
     */
    private static $data = [];

    /**
     * Filter relationships.
     *
     * @param  \Illuminate\Database\Eloquent\Model &$query
     * @param  \Illuminate\Http\Request            &$request
     * @return void
     */
    public function filterRelationships(&$query, &$request)
    {
        foreach ($request->all() as $column => $value) {
            if (strpos($column, 'FromModel') ||
                strpos($column, 'Model') ||
                strpos($column, 'from_') ||
                strpos($column, 'from_model_')
            ) {
                if (method_exists($this, self::convertToRelationship($column))) {
                    if ($value !== null && $value !== '') {
                        self::$data[$column] = $value;
                    }
                }
            }
        }

        if (isset(self::$data)) {
            foreach (self::$data as $column => $value) {
                $query->whereHas(self::convertToRelationship($column), function ($query) use ($column, $value) {
                    $query->where(function ($query) use ($column, $value) {
                        if (! is_array($value)) {
                            $query->orWhere($this->convertToColumn($column), 'LIKE', '%' . $value . '%');
                        }

                        if (is_array($value)) {
                            foreach ($value as $arrayValue) {
                                $query->orWhere($this->convertToColumn($column), 'LIKE', '%' . $arrayValue . '%');
                            }
                        }
                    });
                });
            }
        }
    }

    /**
     * Convert key string to model relationship.
     *
     * @param  string $column
     * @return string
     */
    public function convertToRelationship($column)
    {
        $relationship = strtolower(preg_replace('/.+?(?:FromModel)|.+?(?:Model)|.+?(?:_from_)|.+?(?:_from_model_)/', '', $column));

        if (strrpos($relationship, '_') !== false) {
            preg_match('/\_./', $relationship, $matches);

            $match = str_replace('_', '', strtoupper($matches[0]));

            $relationship = preg_replace('/\_./', $match, $relationship);
        }

        return $relationship;
    }
}
