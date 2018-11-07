<?php

use \PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase {

	/**
	 * @test 
	 */
	public function empty_collection_returns_no_items() {
		$collection = new \app\collection\Collection;

		$this->assertEmpty($collection->get());
	}

	/** @test */
	public function count_is_correct_for_items_passed_in() {
		$collection = new \app\collection\Collection([
			'one', 'two', 'three'
		]);
		
		$this->assertEquals(3, $collection->count());
	}

	/** @test */
	public function items_returned_match_items_passed_in() {
		$collection = new \app\collection\Collection([
			'one', 'two'
		]);

		$this->assertCount(2, $collection->get());
		$this->assertEquals($collection->get()[0], 'one');
		$this->assertEquals($collection->get()[1], 'two');
	}

	/** @test */
	public function collection_is_instance_of_iterator() {
		$collection = new \app\collection\Collection;

		$this->assertInstanceOf(IteratorAggregate::class, $collection);
	}

	/** @test */
	public function collection_can_be_ietrated() {
		$collection = new \app\collection\Collection([
			'one', 'two'
		]);

		$items = [];
		foreach($collection as $item) {
			$items[] = $item;
		}

		$this->assertCount(2, $items);
		$this->assertInstanceOf(ArrayIterator::class, $collection->getIterator());
	}

	/** @test */
	public function collection_can_be_merged_with_another_collection() {
		$collection1 = new \app\collection\Collection([
			'one', 'two'
		]);
		$collection2 = new \app\collection\Collection([
			'three', 'four', 'five'
		]);

		$collection1->merge($collection2);

		$this->assertCount(5, $collection1->get());
	}

	/** @test */
	public function can_add_to_existing_collection() {
		$collection = new \app\collection\Collection([
			'one', 'two'
		]);

		$collection->add(['three']);

		$this->assertCount(3, $collection->get());
		$this->assertEquals(3, $collection->count());
	}

	/** @test */
	public function returns_json_encoded_items() {
		$collection = new \app\collection\Collection([
			['username' => 'Alex'],
			['username' => 'Billy']
		]);

		$this->assertEquals('[{"username":"Alex"},{"username":"Billy"}]', $collection->toJson());
	}

	/** @test */
	public function we_can_sort_collection_by_some_value() {
		$collection = new \app\collection\Collection([
			['username' => 'Alex'],
			['username' => 'Owen'],
			['username' => 'Billy'],
			['username' => 'Freddy']
		]);

		$collection->sort(function ($a, $b) {
			return $a['username'] > $b['username'];
		});

		$this->assertEquals([
			['username' => 'Alex'],
			['username' => 'Billy'],			
			['username' => 'Freddy'],
			['username' => 'Owen']
		],  $collection->get());
	}

}