<?
declare(strict_types=1);

namespace App;

class BadlyWrittenLegacyClassYouCantRefactor
{

    public function __construct()
    {
        $this->{"getPi"} = function() {
            return 3.14;
        };
    }

    public function __call($method, $args)
    {
         if (isset($this->$method)) {
            return call_user_func_array($this->{$method}, $args);
        }
    }

    public function setVariable(int $variable): self
    {
        $this->variable = $variable;
        return $this;
    }
}
