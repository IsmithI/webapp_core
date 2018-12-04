<?php

namespace app\model;

class Model implements \JsonSerializable {

	public function __construct(array $attributes = []) {
		foreach ($attributes as $key => $value) $this->$key = $value;
	}

	public function __set(string $name, $value) {
		$this->$name = $value;
	}

	public function __get(string $name) {
		return $this->has($name) ? $this->name : null;
	}

	public function has(string $name) {
		return isset($this->$name);
	}
	
	public function toJson() {
		return json_encode(get_object_vars($this));
	}

	public function toArray() {
		return get_object_vars($this);
	}

	public function format(Model $format) {
        foreach ($format as $field => $type) {
            if (!$this->has($field)) continue;

            switch ($type) {
                case "int":
                    $this->$field = (int) $this->$field;
                    break;

                case "json":
                    $this->$field = json_decode($this->$field, true);
                    break;

                case "bool":
                    $this->$field = $this->$field ? true : false;
                    break;
            }
	    }
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}