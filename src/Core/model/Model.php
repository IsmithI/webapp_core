<?php

namespace Core\model;

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

                case "to_json":
                    $this->$field = json_encode($this->$field);
                    break;

                case "bool":
                    $this->$field = $this->$field ? true : false;
                    break;

                case "properties":
                    $data = json_decode($this->$field, true);
                    foreach ($data as $key => $value)
                        $this->$key = $value;
                    unset($this->$field);
                    break;
            }

            if ($type instanceof Model) {
                if (is_array($this->$field)) {
                    $this->$field = (new Model($this->$field))->format($type);
                }
                elseif (is_string($this->$field)) {
                    $data = json_decode($this->$field, true);
                    if (json_last_error() == JSON_ERROR_NONE) $this->$field = (new Model($data))->format($type);
                }
            }
	    }

	    if ($format->has("class") && class_exists($format->class)) {
            return new $format->class($this->toArray());
        }

	    return $this;
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

    public static function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}