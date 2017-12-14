<?php

use Illuminate\Database\Seeder;
use App\Runner;

class RunnerTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table( 'runners' )->delete();
		$json = File::get( "database/data/runners.json" );
		$data = json_decode( $json,true );
		foreach ( $data as $obj ) {
			Runner::create( $obj );
		}
	}
}
