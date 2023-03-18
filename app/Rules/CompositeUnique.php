<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CompositeUnique implements Rule
{
    private string $tableName;
    private array $compositeColsKeyValue = [];
    private $rowId;

    public $customMessage = "";

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $tableName, array $compositeColsKeyValue, $rowId = null)
    {
        $this->tableName = $tableName;
        $this->compositeColsKeyValue = $compositeColsKeyValue;
        $this->rowId = $rowId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $passes = true;

        if ($this->rowId) {
            $record = DB::table($this->tableName)->where($this->compositeColsKeyValue)->first();
            $passes = !$record || ($record && $record->id == $this->rowId);
        } else {
            $passes = !DB::table($this->tableName)->where($this->compositeColsKeyValue)->exists();
        }

        return $passes;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->customMessage) {
            return $this->customMessage;
        }

        $ids = "";
        foreach ($this->compositeColsKeyValue as $key => $value) {
            $ids .= "'" . $key . "': " . $value . " ";
        }
        return 'Already have a record in the database with the ids ' . $ids;
    }
}
