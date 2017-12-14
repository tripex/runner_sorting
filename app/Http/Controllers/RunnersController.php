<?php

namespace App\Http\Controllers;

use App\Runner;
use Illuminate\Support\Facades\View;

class RunnersController extends Controller {

	public function showRunningTeams() {
		$fastestTeamByYear  = $this->getBestTeamByYear();
		$fastestTeamOverAll = $this->getBestTeamOverAll();

		return ( view( 'welcome', compact( 'fastestTeamByYear', 'fastestTeamOverAll' ) ) );
	}

	private function getBestTeamByYear() {
		$years = Runner::distinct()
		               ->orderBy( 'year', 'asc' )
		               ->get( [ 'year' ] );

		foreach ( $years as $year ) {
			$year            = $year->year;
			$fastestFirstLeg = Runner::where( 'year', '=', $year )
			                         ->orderBy( 'firstLeg', 'asc' )
			                         ->first();

			$fastestSecondLeg = Runner::where( 'year', '=', $year )
			                          ->where( 'id', '<>', $fastestFirstLeg->id )
			                          ->orderBy( 'secondLeg', 'asc' )
			                          ->take( 3 )
			                          ->get();

			// Put all the runners into one collection
			$fastestTeamByYear[ $year ] = $fastestSecondLeg->prepend( $fastestFirstLeg );

		}

		return ( $fastestTeamByYear );
	}

	private function getBestTeamOverAll() {
		$fastestFirstLeg = Runner::orderBy( 'firstLeg', 'asc' )
		                         ->first();

		$fastestSecondLeg = Runner::where( 'id', '<>', $fastestFirstLeg->id )
		                          ->orderBy( 'secondLeg', 'asc' )
		                          ->take( 3 )
		                          ->get();

		// Put all the runners into one collection
		$fastestTeamOverAll = $fastestSecondLeg->prepend( $fastestFirstLeg );

		return ( $fastestTeamOverAll );
	}
}
