<?php

namespace app\collection;

class Collection implements \IteratorAggregate {

	protected $items = [];

	public function __construct(array $items = []) {
		$this->items = $items;
	}

	public function get($key = null) {
		
		if (!is_null($key))
			if (array_key_exists($key, $this->items))
				return $this->items[$key];
			else
				return null;

		return $this->items;
	}

	public function count() {
		return count($this->get());
	}

	public function getIterator() {
		return new \ArrayIterator($this->items);
	}

	public function merge(Collection $collection) {
		return $this->add($collection->get());
	}

	public function add(array $items) {
		$this->items = array_merge($this->items, $items);
	}

	public function push($item) {
		$this->items[] = $item;
	}

	public function toJson() {
		return json_encode($this->items);
	}

	public function sort(\Closure $comparator) {
		usort($this->items, $comparator);
	}

	public function filter(\Closure $comparator) {
		$filtered = [];
		foreach ($this->items as $item) {
			if ($comparator($item)) $filtered[] = $item;
		}

		return new Collection($filtered);
	}
}