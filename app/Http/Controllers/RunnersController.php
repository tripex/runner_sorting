<?php

namespace App\Http\Controllers;

use App\Runner;
use Illuminate\Support\Facades\View;

class RunnersController extends Controller {


	/**
	 * Collect the data that is needed for the view.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showRunningTeams() {
		$fastestTeamByYear  = $this->getBestTeamByYear();
		$fastestTeamOverall = $this->getBestTeamOverall();

		return ( view( 'welcome', compact( 'fastestTeamByYear', 'fastestTeamOverall' ) ) );
	}

	/**
	 * Return the fastest team divided by year
	 *
	 * @return mixed
	 */
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

	/**
	 * Return the best team overall.
	 *
	 * @return mixed
	 */
	private function getBestTeamOverall() {
		$fastestFirstLeg = Runner::orderBy( 'firstLeg', 'asc' )
		                         ->first();

		$fastestSecondLeg = Runner::where( 'id', '<>', $fastestFirstLeg->id )
		                          ->orderBy( 'secondLeg', 'asc' )
		                          ->take( 3 )
		                          ->get();

		// Put all the runners into one collection
		$fastestTeamOverall = $fastestSecondLeg->prepend( $fastestFirstLeg );

		return ( $fastestTeamOverall );
	}
}
