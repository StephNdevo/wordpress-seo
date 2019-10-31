<?php

namespace Yoast\WP\Free\Tests\Presentations\Indexable_Date_Archive_Presentation;

use Yoast\WP\Free\Tests\TestCase;

/**
 * Class Rel_Next_Test.
 *
 * @group presentations
 * @group adjacent
 *
 * @coversDefaultClass \Yoast\WP\Free\Presentations\Indexable_Date_Archive_Presentation
 */
class Rel_Next_Test extends TestCase {
	use Presentation_Instance_Builder;

	/**
	 * Sets up the test class.
	 */
	public function setUp() {
		parent::setUp();

		$this->setInstance();
	}

	/**
	 * Tests the situation where the rel adjacent is disabled.
	 *
	 * @covers ::generate_rel_next
	 */
	public function test_generate_rel_next_is_disabled() {
		$this->pagination
			->expects( 'is_rel_adjacent_disabled' )
			->once()
			->andReturn( true );

		$this->assertEmpty( $this->instance->generate_rel_next() );
	}

	/**
	 * Tests the situation where the current page is the last page.
	 *
	 * @covers ::generate_rel_next
	 */
	public function test_generate_rel_prev_is_last_page() {
		$this->pagination
			->expects( 'is_rel_adjacent_disabled' )
			->once()
			->andReturn( false );

		$this->pagination
			->expects( 'get_current_archive_page_number' )
			->once()
			->andReturn( 6 );

		$this->pagination
			->expects( 'get_number_of_archive_pages' )
			->once()
			->andReturn( 6 );

		$this->assertEmpty( $this->instance->generate_rel_next() );
	}

	/**
	 * Tests the situation where the current page is not the last page.
	 *
	 * @covers ::generate_rel_next
	 */
	public function test_generate_rel_prev_is_not_the_last_page() {
		$this->instance->canonical = 'https://example.com/canonical/';

		$this->pagination
			->expects( 'is_rel_adjacent_disabled' )
			->once()
			->andReturn( false );

		$this->pagination
			->expects( 'get_current_archive_page_number' )
			->once()
			->andReturn( 5 );

		$this->pagination
			->expects( 'get_number_of_archive_pages' )
			->once()
			->andReturn( 6 );

		$this->pagination
			->expects( 'get_paginated_url' )
			->with( 'https://example.com/canonical/', 6 )
			->once()
			->andReturn( 'https://example.com/canonical/page/6/' );

		$this->assertEquals( 'https://example.com/canonical/page/6/', $this->instance->generate_rel_next() );
	}
}
